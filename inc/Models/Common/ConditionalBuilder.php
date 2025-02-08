<?php
namespace VillaCapriani\Models\Common;

class ConditionalBuilder
{
    public static function equals($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '==',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function notEquals($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '!=',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function contains($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '~=',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function greaterThan($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '>',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function lessThan($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '<',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function greaterOrEqual($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '>=',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function lessOrEqual($field, $value)
    {
        return [
            [
                [
                    'field' => $field,
                    'operator' => '<=',
                    'value' => $value,
                ],
            ],
        ];
    }

    public static function  and (...$conditions)
    {
        $andConditions = [];
        foreach ($conditions as $condition) {
            if (isset($condition[0][0])) {
                $andConditions[] = $condition[0][0];
            }
        }
        return [
            $andConditions,
        ];
    }

    public static function  or (...$conditions)
    {
        $orConditions = [];
        foreach ($conditions as $condition) {
            if (isset($condition[0][0])) {
                $orConditions[] = [$condition[0][0]];
            }
        }
        return $orConditions;
    }
}
