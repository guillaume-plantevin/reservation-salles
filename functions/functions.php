<?php
    function print_r_pre($input, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        print_r($input);
        echo '</pre>', "\n";
    }

    function var_dump_pre($input, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        var_dump($input);
        echo '</pre>', "\n";
    }

    function dump($input) {
        echo '<pre>';
        var_dump($input);
        echo '</pre>';
    }

    function randomRgb() {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);

        $return = 'rgb(' . $r . ', ' . $g . ', ' . $b . ')';

        return $return;
    }

    function randomHsl() {
        $h = rand(1, 359);
        $s = rand(30, 100) . '%';
        $l = rand(35, 70) . '%';
        
        return 'hsl(' . $h . ', ' . $s . ', ' . $l . ')';
    }
    function randomHsla() {
        $h = rand(1, 359);
        $s = rand(30, 100) . '%';
        $l = rand(30, 70) . '%';
        $a = rand(50, 100) / 100;

        return 'hsla(' . $h . ', ' . $s . ', ' . $l . ', ' . $a . ')';
    }
    function br($input) {
        $output = '';
        for ($i = 0; $i < $input; ++$i) {
            $output .= '<br />';
        }
        return $output;
    }
    
    function breakingLine() {
        $output = '';
        $output .= '<br>';
        $output .= '===================================================';
        $output .= '<br>';
        return $output;
    }