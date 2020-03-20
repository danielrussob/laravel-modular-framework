<?php

if (!function_exists('str_extract')) {
    function str_extract($string, $format = "[text {EXT}]")
    {
        $format = str_replace("{EXT}", "XxXxXxXxXxXxXxXxXxXx", $format);
        $format = preg_quote($format);
        $format = str_replace("XxXxXxXxXxXxXxXxXxXx", "(.*?)", $format);

        $regex = "/" . $format . "/";

        $matches = [];
        preg_match($regex, $string, $matches);

        if (count($matches) >= 2) {
            return $matches[1];
        }

        return false;
    }
}
