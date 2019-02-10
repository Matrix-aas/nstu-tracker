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

if (!function_exists("generate_api_token")) {
    function generate_api_token()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 24; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}