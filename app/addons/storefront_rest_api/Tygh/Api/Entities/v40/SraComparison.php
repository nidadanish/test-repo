<?php
/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

namespace Tygh\Api\Entities;

use Tygh\Addons\StorefrontRestApi\ASraEntity;
use Tygh\Api\Response;

class SraComparison extends ASraEntity
{
    /**
     * @var int[] Default icon sizes
     */
    protected $icon_size_small = [500, 500];

    /**
     * @var int[] Default detailed image sizes
     */
    protected $icon_size_big = [1000, 1000];

    /**
     * @var string Session user type
     */
    protected $user_type = 'R';

    /**
     * @var string Wish list cart type
     */
    protected $cart_type = 'T';

    /** @inheritdoc */
    public function index($id = '', $params = [])
    {
        $lang_code = $this->getLanguageCode($params);

        $wishlist = [];
        fn_extract_cart_content($wishlist, $this->auth['user_id'], $this->cart_type, $this->user_type, $lang_code);
        $products = empty($wishlist['products'])
            ? []
            : $wishlist['products'];

        $params['icon_sizes'] = $this->safeGet(
            $params,
            'icon_sizes',
            [
                'main_pair'   => [$this->icon_size_big, $this->icon_size_small],
                'image_pairs' => [$this->icon_size_small],
            ]
        );

        list($products,) = $this->fn_compare_gather_product_data($products, [], $this->auth, $lang_code);

        $products = fn_storefront_rest_api_format_products_prices(
            $products,
            $this->getCurrencyCode($params)
        );

        $products = $this->normalizeAmount($products);

        $products = fn_storefront_rest_api_set_products_icons($products, $params['icon_sizes']);

        return [
            'status' => Response::STATUS_OK,
            'data'   => [
                'products' => $products,
            ],
        ];
    }

    /** @inheritdoc */
    public function create($params)
    {
        $products = $this->safeGet($params, 'products', []);
        if (!$products) {
            return [
                'status' => Response::STATUS_BAD_REQUEST,
                'data'   => [
                    'errors' => [
                        __(
                            'api_required_field',
                            [
                                '[field]' => 'products',
                            ]
                        ),
                    ],
                ],
            ];
        }

        $lang_code = $this->getLanguageCode($params);

        $wishlist = [];
        $existing_wishlist_ids = [];
        fn_extract_cart_content($wishlist, $this->auth['user_id'], $this->cart_type, $this->user_type, $lang_code);
        if (isset($wishlist['products'])) {
            $existing_wishlist_ids = array_keys($wishlist['products']);
        }

        $wishlist_ids = $this->fn_add_product_to_compare($products, $wishlist, $this->auth);
        if ($wishlist_ids === false) {
            return [
                'status' => Response::STATUS_BAD_REQUEST,
            ];
        }

        if ($wishlist_ids === array_intersect($wishlist_ids, $existing_wishlist_ids)) {
            return [
                'status' => Response::STATUS_CONFLICT,
                'data'   => [
                    'errors' => [
                        __('product_in_wishlist'),
                    ],
                ],
            ];
        }

        fn_save_cart_content($wishlist, $this->auth['user_id'], $this->cart_type, $this->user_type);

        return [
            'status' => Response::STATUS_CREATED,
            'data'   => [
                'cart_ids' => $wishlist_ids,
            ],
        ];
    }

    /** @inheritdoc */
    public function update($id, $params)
    {
        return [
            'status' => Response::STATUS_FORBIDDEN,
        ];
    }

    /** @inheritdoc */
    public function delete($id = 0)
    {
        $wishlist = [];
        fn_extract_cart_content($wishlist, $this->auth['user_id'], $this->cart_type, $this->user_type);
        if (empty($wishlist['products'])) {
            return [
                'status' => Response::STATUS_NO_CONTENT,
            ];
        }

        if ($id) {
            $wishlist_ids = [$id];
        } else {
            $wishlist_ids = array_keys($wishlist['products']);
        }
        foreach ($wishlist_ids as $wishlist_id) {
            unset($wishlist['products'][$wishlist_id]);
            // fn_delete_wishlist_product($wishlist, $wishlist_id);
        }
        fn_save_cart_content($wishlist, $this->auth['user_id'], $this->cart_type, $this->user_type);

        return [
            'status' => Response::STATUS_NO_CONTENT,
        ];
    }

    /** @inheritdoc */
    public function privilegesCustomer()
    {
        return [
            'index'  => $this->auth['is_token_auth'],
            'create' => $this->auth['is_token_auth'],
            'update' => false,
            'delete' => $this->auth['is_token_auth'],
        ];
    }

    /**
     * Normalizes product amount for API response.
     *
     * FIXME: `amount` holds total product amount.
     * FIXME: API clients should use the `display_amount` property to display amount of product in the wish list.
     *
     * @param array $products Wishlist products
     *
     * @return array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    private function normalizeAmount(array $products)
    {
        array_walk($products, static function (&$product) {
            $product['amount'] = $product['display_amount'] = 1;
        });

        return $products;
    }


    /**
 * Gathers information for products in wish list.
 *
 * @param array  $products       Products in wishlist
 * @param array  $extra_products Products don't directly added into wish list, but provided externally
 * @param array  $auth           Authentication data
 * @param string $lang_code      Two-letter language code for descriptions
 *
 * @return array[] Products and extra products with loaded data
 *
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
 */
private function fn_compare_gather_product_data(array $products, array $extra_products, array $auth, $lang_code = CART_LANGUAGE)
{
    foreach ($products as $k => $v) {
        $_options = [];
        $extra = $v['extra'];
        if (!empty($v['product_options'])) {
            $_options = $v['product_options'];
        }
        $products[$k] = fn_get_product_data(
            $v['product_id'],
            $auth,
            $lang_code,
            '',
            true,
            true,
            true,
            false,
            false,
            true,
            true,
            true
        );

        if (empty($products[$k])) {
            unset($products[$k]);
            continue;
        }

        $products[$k]['extra'] = empty($products[$k]['extra'])
            ? []
            : $products[$k]['extra'];
        $products[$k]['extra'] = array_merge($products[$k]['extra'], $extra);

        if (isset($products[$k]['extra']['product_options']) || $_options) {
            $products[$k]['selected_options'] = empty($products[$k]['extra']['product_options'])
                ? $_options
                : $products[$k]['extra']['product_options'];
        }

        if (!empty($products[$k]['selected_options'])) {
            $options = fn_get_selected_product_options($v['product_id'], $v['product_options'], $lang_code);
            foreach ($products[$k]['selected_options'] as $option_id => $variant_id) {
                foreach ($options as $option) {
                    if (
                        (int) $option['option_id'] === (int) $option_id
                        && !ProductOptionTypes::isSelectable($option['option_type'])
                        && empty($variant_id)
                    ) {
                        $products[$k]['changed_option'] = $option_id;
                        break 2;
                    }
                }
            }

            if (isset($products[$k]['selected_options'])) {
                $products[$k]['combination'] = fn_get_options_combination($products[$k]['selected_options']);
            }
        }
        $products[$k]['display_subtotal'] = $products[$k]['price'] * $v['amount'];
        $products[$k]['display_amount'] = $v['amount'];
        $products[$k]['cart_id'] = $k;

        if (!empty($products[$k]['extra']['parent'])) {
            $extra_products[$k] = $products[$k];
            unset($products[$k]);
            continue;
        }
    }

    fn_gather_additional_products_data(
        $products,
        ['get_icon' => true, 'get_detailed' => true, 'get_options' => true, 'get_discounts' => true],
        $lang_code
    );

    return [$products, $extra_products];
}

/**
 * Adds product to wishlist.
 *
 * @param array $product_data Product to add data
 * @param array $wishlist     Wishlist data storage
 * @param array $auth         User session data
 *
 * @return array<int>|false Wishlist IDs for the added products, false otherwise
 *
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
 */
function fn_add_product_to_compare(array $product_data, array &$wishlist, array &$auth)
{
    // Check if products have custom images
    list($product_data, $wishlist) = fn_add_product_options_files($product_data, $wishlist, $auth, false, 'wishlist');

    // fn_set_hook('pre_add_to_wishlist', $product_data, $wishlist, $auth);

    if (empty($product_data) || !is_array($product_data)) {
        return false;
    }

    $wishlist_ids = [];
    foreach ($product_data as $product_id => $data) {
        if (empty($data['amount'])) {
            $data['amount'] = 1;
        }
        if (!empty($data['product_id'])) {
            $product_id = $data['product_id'];
        }

        if (empty($data['extra'])) {
            $data['extra'] = [];
        }

        // Add one product
        if (!isset($data['product_options'])) {
            $data['product_options'] = fn_get_default_product_options($product_id);
        }

        // Generate wishlist id
        $data['extra']['product_options'] = $data['product_options'];
        $_id = fn_generate_cart_id($product_id, $data['extra']);

        $_data = db_get_row('SELECT is_edp, options_type, tracking FROM ?:products WHERE product_id = ?i', $product_id);
        $_data = fn_normalize_product_overridable_fields($_data);

        $data['is_edp'] = $_data['is_edp'];
        $data['options_type'] = $_data['options_type'];
        $data['tracking'] = $_data['tracking'];

        $wishlist_ids[] = $_id;
        $wishlist['products'][$_id]['product_id'] = $product_id;
        $wishlist['products'][$_id]['product_options'] = $data['product_options'];
        $wishlist['products'][$_id]['extra'] = $data['extra'];
        $wishlist['products'][$_id]['amount'] = $data['amount'];
    }

    return $wishlist_ids;
}
}
