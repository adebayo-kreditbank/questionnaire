<?php
namespace App\Helper;

class ArrayHelper {

    public static function extractWantedFromUnwanted(array|null $wantedList, array|null $unwatedList): array
    {
        if (empty($wantedList) && empty($unwatedList)) return [];
        $wantedList ??= [];
        $unwatedList ??= [];

        // Extract elements of $wantedList not present in $unwatedList
        $wantedElements = array_filter($wantedList, function ($wantedItem) use ($unwatedList) {
            return !in_array($wantedItem, $unwatedList);
        });

        return static::removeDuplicate($wantedElements);
    }

    /**
     * Remove duplicates. To do so,
     * array_unique is okay if elements are not array|object
     * e.g $a = [1,2,3,5,6]; $b = [2,5,7]; but since they may be multidimensional
     * e.g $a = [['cat'=>3],['cat'=>6],['cat'=>9]]; $b = [['cat'=>1],['cat'=>6],['cat'=>2]];
     * convert array|object elements to JSON strings, remove duplicate and convert back
     */
    public static function removeDuplicate(array $array): array
    {
        $jsonElements = array_unique(array_map('json_encode', $array));
        return array_map('json_decode', $jsonElements, array_fill(0, count($jsonElements), true));
    }

    /**
     * flatten an array
     * @param array $array
     */
    public static function flattenArray(array $array, bool $recursive = false)
    {
        $result = [];

        if ($recursive) {
            array_walk_recursive($array, function ($value) use (&$result) {
                $result[] = is_object($value) ? (array) $value : $value;
            });
        } else {
            foreach ($array as $item) {
                if (is_array($item)) $result = array_merge($result, $item);
                else $result[] = $item;
            }
        }

        return $result;
    }
}