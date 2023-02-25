<?php


namespace Tygh\Tests\Unit\Addons\ProductVariations\Service;


use Tygh\Addons\ProductVariations\Product\CombinationsGenerator;
use Tygh\Addons\ProductVariations\Product\FeaturePurposes;
use Tygh\Addons\ProductVariations\Product\Group\Group;
use Tygh\Addons\ProductVariations\Product\Group\GroupCodeGenerator;
use Tygh\Addons\ProductVariations\Product\Group\GroupFeatureCollection;
use Tygh\Addons\ProductVariations\Product\Group\GroupProductCollection;
use Tygh\Addons\ProductVariations\Product\Group\Repository as GroupRepository;
use Tygh\Addons\ProductVariations\Product\ProductIdMap;
use Tygh\Addons\ProductVariations\Product\Repository as ProductRepository;
use Tygh\Addons\ProductVariations\Product\Sync\ProductDataIdentityMapRepository;
use Tygh\Addons\ProductVariations\Service;
use Tygh\Addons\ProductVariations\SyncService;
use Tygh\Tests\Unit\ATestCase;

class RemoveGroupTest extends ATestCase
{
    /** @var Service */
    protected $service;

    /** @var \Tygh\Addons\ProductVariations\Product\Group\Repository|\PHPUnit_Framework_MockObject_MockObject */
    protected $group_repository;

    /** @var \Tygh\Addons\ProductVariations\Product\Group\GroupCodeGenerator|\PHPUnit_Framework_MockObject_MockObject */
    protected $group_code_generator;

    /** @var \Tygh\Addons\ProductVariations\Product\Repository|\PHPUnit_Framework_MockObject_MockObject */
    protected $product_repository;

    /** @var \Tygh\Addons\ProductVariations\Product\Sync\ProductDataIdentityMapRepository|\PHPUnit_Framework_MockObject_MockObject */
    protected $identity_map_repository;

    /** @var \Tygh\Addons\ProductVariations\SyncService|\PHPUnit_Framework_MockObject_MockObject */
    protected $sync_service;

    /** @var \Tygh\Addons\ProductVariations\Product\ProductIdMap|\PHPUnit_Framework_MockObject_MockObject */
    protected $product_id_map;

    /** @var \Tygh\Addons\ProductVariations\Product\CombinationsGenerator|\PHPUnit_Framework_MockObject_MockObject */
    protected $combination_generator;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->group_repository = $this->getMockBuilder(GroupRepository::class)
            ->setMethods(['save', 'delete', 'findGroupById', 'findGroupByProductId', 'remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->group_code_generator = $this->getMockBuilder(GroupCodeGenerator::class)
            ->setMethods(['next'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->product_repository = $this->getMockBuilder(ProductRepository::class)
            ->setMethods([
                'findProduct',
                'changeProductTypeToSimple',
                'changeProductTypeToChild',
                'findAvailableFeatures',
                'findProducts',
                'loadProductsFeatures',
                'updateProductFeaturesValues',
                'loadProductFeatures'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $this->identity_map_repository = $this->getMockBuilder(ProductDataIdentityMapRepository::class)
            ->setMethods(['deleteByProductId', 'changeParentProductId', 'deleteByProductIds'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->sync_service = $this->getMockBuilder(SyncService::class)
            ->setMethods(['syncAll'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->product_id_map = $this->getMockBuilder(ProductIdMap::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->combination_generator = $this->getMockBuilder(CombinationsGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new Service(
            $this->group_repository,
            $this->group_code_generator,
            $this->product_repository,
            $this->identity_map_repository,
            $this->sync_service,
            $this->product_id_map,
            $this->combination_generator,
            false, false, false
        );

        $this->requireMockFunction('fn_set_hook');
        $this->requireMockFunction('__');
    }

    public function testRemoveGroup()
    {
        $features = GroupFeatureCollection::createFromFeatureList([
            ['feature_id' => 100, 'purpose' => FeaturePurposes::CREATE_CATALOG_ITEM],
            ['feature_id' => 200, 'purpose' => FeaturePurposes::CREATE_VARIATION_OF_CATALOG_ITEM],
        ]);
        $products = GroupProductCollection::createFromProducts([
            [
                'product_id'         => 1000,
                'parent_product_id'  => 0,
                'company_id'         => 1,
                'variation_features' => [
                    100 => ['variant_id' => 10, 'feature_id' => 100, 'purpose' => FeaturePurposes::CREATE_CATALOG_ITEM],
                    200 => [
                        'variant_id' => 20,
                        'feature_id' => 200,
                        'purpose'    => FeaturePurposes::CREATE_VARIATION_OF_CATALOG_ITEM
                    ],
                ]
            ],
            [
                'product_id'         => 2000,
                'parent_product_id'  => 0,
                'company_id'         => 1,
                'variation_features' => [
                    100 => ['variant_id' => 11, 'feature_id' => 100, 'purpose' => FeaturePurposes::CREATE_CATALOG_ITEM],
                    200 => [
                        'variant_id' => 21,
                        'feature_id' => 200,
                        'purpose'    => FeaturePurposes::CREATE_VARIATION_OF_CATALOG_ITEM
                    ],
                ]
            ],
            [
                'product_id'         => 3000,
                'parent_product_id'  => 0,
                'company_id'         => 1,
                'variation_features' => [
                    100 => ['variant_id' => 11, 'feature_id' => 100, 'purpose' => FeaturePurposes::CREATE_CATALOG_ITEM],
                    200 => [
                        'variant_id' => 22,
                        'feature_id' => 200,
                        'purpose'    => FeaturePurposes::CREATE_VARIATION_OF_CATALOG_ITEM
                    ],
                ]
            ],
        ]);

        $group = Group::createFromArray([
            'features' => $features,
            'products' => $products
        ]);

        $this->group_repository->expects($this->once())
            ->method('findGroupById')
            ->with(10)
            ->willReturn($group);

        $this->group_repository->expects($this->once())
            ->method('remove')
            ->with($group);

        $result = $this->service->removeGroup(10);

        $this->assertTrue($group->isEmpty());
    }

}