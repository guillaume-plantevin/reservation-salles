<?php
    function print_r_pre($array, $name) {
        echo '<pre>' . $name . ':<br />';
        print_r($array);
        echo '</pre>';
    }
    function var_dump_pre($array, $name) {
        echo '<pre>' . $name . ':<br />';
        var_dump($array);
        echo '</pre>';
    }