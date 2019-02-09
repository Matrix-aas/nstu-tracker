<?php
if (!function_exists("array_remap")) {
    function array_remap(array $array, array $mappings)
    {
        if (!$array)
            return null;
        if (!$mappings || count($mappings) < 1)
            return $array;
        $res = [];
        foreach ($array as $key => $value) {
            if (isset($mappings[$key]))
                $res[$mappings[$key]] = $value;
            else
                $res[$key] = $value;
        }
        return $res;
    }
}