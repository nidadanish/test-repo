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

namespace Tygh\Addons\EcCustomApi\ProfileFields;

use Tygh\Common\OperationResult;
use Tygh\Enum\ProfileFieldTypes;

/**
 * Class Validator validate data against profile fields schema.
 *
 * @package Tygh\Addons\EcCustomApi\ProfileFields
 */
class Validator
{
    /**
     * Validates schema fields population.
     *
     * @param array $schema
     * @param array $data
     *
     * @return \Tygh\Common\OperationResult
     */
    public function validate(array $schema, array $data)
    {
        $result = new OperationResult(true);

        $error_fields = [
            'required' => [],
            'invalid'  => [],
        ];

        if (!isset($data['fields'])) {
            $data['fields'] = [];
        }   

        // fn_print_die($schema);
        foreach ($schema as $section_id => $section) {
            foreach ($section['fields'] as $field) {
                $field_id = $field['field_id'];
                if ($field['is_default']) {
                    $value_container = $data;
                } else {
                    $value_container = $data['fields'];
                }

                if ($field['required'] && !isset($value_container[$field_id])) {
                    $result->setSuccess(false);
                    $error_fields['required'][$field_id] = [
                        'is_default' => $field['is_default'],
                        'field_id'   => $field_id,
                    ];
                }

                if (!isset($value_container[$field_id])) {
                    continue;
                }

                if ($field['field_type'] === ProfileFieldTypes::CHECKBOX && !$this->isBool($value_container[$field_id])) {
                    $result->setSuccess(false);
                    $error_fields['invalid'][] = [
                        'is_default' => $field['is_default'],
                        'field_id'   => $field_id,
                        'value'      => $value_container[$field_id],
                        'values'     => ['true' => 'Y', 'false' => 'N'],
                    ];
                } elseif ($field['field_type'] === ProfileFieldTypes::STATE) {
                    $country_code_field_id = $this->getCountryCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    if ($country_code_field_id !== null && !isset($value_container[$country_code_field_id])) {
                        $result->setSuccess(false);
                        $error_fields['required'][$country_code_field_id] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $country_code_field_id,
                        ];
                        continue;
                    }
                    list($is_valid, $values) = $this->validateState($field, $value_container[$field_id], $value_container[$country_code_field_id]);
                    if (!$is_valid) {
                        $result->setSuccess(false);
                        $error_fields['invalid'][] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $field_id,
                            'value'      => $value_container[$field_id],
                            'values'     => $values,
                        ];
                    }
                }elseif ($field['field_type'] === EC_CITY) {
                    $country_code_field_id = $this->getCountryCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    $state_code_field_id = $this->getStateCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    if ($state_code_field_id !== null && !isset($value_container[$state_code_field_id])) {
                        $result->setSuccess(false);
                        $error_fields['required'][$state_code_field_id] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $state_code_field_id,
                        ];
                        continue;
                    }
                    list($is_valid, $values) = $this->validateCity($field, $value_container[$field_id], $value_container[$state_code_field_id], $value_container[$country_code_field_id]);
                    if (!$is_valid) {
                        $result->setSuccess(false);
                        $error_fields['invalid'][] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $field_id,
                            'value'      => $value_container[$field_id],
                            'values'     => $values,
                        ];
                    }
                }elseif ($field['field_type'] === EC_DISTRICT) {
                    $country_code_field_id = $this->getCountryCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    $state_code_field_id = $this->getStateCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    $city_code_field_id = $this->getCityCodeFieldId($section['fields'], $field['is_default'], $field_id);
                    if ($city_code_field_id !== null && !isset($value_container[$city_code_field_id])) {
                        $result->setSuccess(false);
                        $error_fields['required'][$city_code_field_id] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $city_code_field_id,
                        ];
                        continue;
                    }
                    list($is_valid, $values) = $this->validateDistrict($field, $value_container[$field_id], $value_container[$city_code_field_id], $value_container[$state_code_field_id], $value_container[$country_code_field_id]);
                    if (!$is_valid) {
                        $result->setSuccess(false);
                        $error_fields['invalid'][] = [
                            'is_default' => $field['is_default'],
                            'field_id'   => $field_id,
                            'value'      => $value_container[$field_id],
                            'values'     => $values,
                        ];
                    }
                } elseif (isset($field['values']) && !isset($field['values'][$value_container[$field_id]])) {
                    if ($section['fields'])
                    $result->setSuccess(false);
                    $error_fields['invalid'][] = [
                        'is_default' => $field['is_default'],
                        'field_id'   => $field_id,
                        'value'      => $value_container[$field_id],
                        'values'     => $field['values'],
                    ];
                }
            }
        }

        $result->setData($error_fields);

        return $result;
    }

    /**
     * Validates state value.
     *
     * @param array  $field
     * @param string $state_code
     * @param string $city_code
     *
     * @return array Validation result and the list of available states
     */
    protected function validateState(array $field, $state_code, $country_code)
    {
        if (!$field['values']) {
            return [true, []];
        }

        if (!isset($field['values'][$country_code])) {
            return [true, []];
        }

        $is_valid = isset($field['values'][$country_code][$state_code]);
        $valid_values = array_keys($field['values'][$country_code]);

        return [$is_valid, $valid_values];
    }
    
    /**
     * Validates city value.
     *
     * @param array  $field
     * @param string $city_code
     * @param string $state_code
     * @param string $city_code
     *
     * @return array Validation result and the list of available states
     */
    protected function validateCity(array $field, $city_code, $state_code, $country_code)
    {
        if (!$field['values']) {
            return [true, []];
        }

        if (!isset($field['values'][$country_code])) {
            return [true, []];
        }
        if (!isset($field['values'][$country_code][$state_code])) {
            return [true, []];
        }

        $is_valid = isset($field['values'][$country_code][$state_code][$city_code]);

        $valid_values = array_keys($field['values'][$country_code][$state_code]);

        return [$is_valid, $valid_values];
    }
    /**
     * Validates state value.
     *
     * @param array  $field
     * @param string $discrict_code
     * @param string $city_code
     * @param string $state_code
     * @param string $city_code
     *
     * @return array Validation result and the list of available states
     */
    protected function validateDistrict(array $field, $discrict_code, $city_code, $state_code, $country_code)
    {
        if (!$field['values']) {
            return [true, []];
        }

        if (!isset($field['values'][$country_code])) {
            return [true, []];
        }
        if (!isset($field['values'][$country_code][$state_code])) {
            return [true, []];
        }
        if (!isset($field['values'][$country_code][$state_code][$city_code])) {
            return [true, []];
        }

        $is_valid = isset($field['values'][$country_code][$state_code][$city_code][$discrict_code]);

        $valid_values = array_keys($field['values'][$country_code][$state_code][$city_code]);

        return [$is_valid, $valid_values];
    }

    protected function isBool($value)
    {
        return in_array(
            $value,
            ['N', 'Y', false, true],
            true
        );
    }

    /**
     * @param array  $schema_section_fields
     * @param bool   $is_default
     * @param string $state_code_field_id
     *
     * @return int|string|null
     */
    protected function getCountryCodeFieldId(array $schema_section_fields, $is_default, $state_code_field_id)
    {
        if ($is_default) {
            list($prefix, ) = explode('_', $state_code_field_id);
            return $prefix . '_country';
        } else {
            foreach ($schema_section_fields as $field_id => $field) {
                if ($field['field_type'] === ProfileFieldTypes::COUNTRY) {
                    return $field_id;
                }
            }
        }

        return null;
    }
     /**
     * @param array  $schema_section_fields
     * @param bool   $is_default
     * @param string $state_code_field_id
     *
     * @return int|string|null
     */
    protected function getStateCodeFieldId(array $schema_section_fields, $is_default, $city_code_field_id)
    {
        if ($is_default) {
            list($prefix, ) = explode('_', $city_code_field_id);
            return $prefix . '_state';
        } else {
            foreach ($schema_section_fields as $field_id => $field) {
                if ($field['field_type'] === ProfileFieldTypes::STATE) {
                    return $field_id;
                }
            }
        }

        return null;
    }
     /**
     * @param array  $schema_section_fields
     * @param bool   $is_default
     * @param string $state_code_field_id
     *
     * @return int|string|null
     */
    protected function getCityCodeFieldId(array $schema_section_fields, $is_default, $district_code_field_id)
    {
        if ($is_default) {
            list($prefix, ) = explode('_', $district_code_field_id);
            return $prefix . '_city';
        } else {
            foreach ($schema_section_fields as $field_id => $field) {
                if ($field['field_type'] === EC_CITY) {
                    return $field_id;
                }
            }
        }

        return null;
    }
}
