<?php


namespace Moota\Moota\Helper;


class Helper
{
    static function replace_uri_with_id($url, $str_replace, $str_target)
    {
        return str_replace($str_target, $str_replace, $url, $str_target);
    }

}