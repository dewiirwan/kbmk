<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('pre')) {
    /**
     * prettify array
     *
     * @param array $data
     * @param string $type (var_dump, var_export) default = print_r
     *
     * @return string prettified array
    */
    function pre($data = '', $type = 'print_r')
    {
        echo '<pre>';
        $type($data);
        echo '</pre>';
        die;
    }
}