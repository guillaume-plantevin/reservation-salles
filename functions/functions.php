<?php
    function print_r_pre($array, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        print_r($array);
        echo '</pre>', "\n";
    }
    function var_dump_pre($array, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        var_dump($array);
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
        // echo $r . ' ' . $g . ' ' . $b;
        $return = 'rgb(' . $r . ', ' . $g . ', ' . $b . ')';
        return $return;
    }
    function randomHsl() {
        $h = rand(0, 359);
        $s = rand(45, 100);
        if ($s !== 0) 
            $s .= '%';
        $l = rand(35, 80);
        if ($l !== 0) 
            $l .= '%';
        return 'hsl(' . $h . ', ' . $s . ', ' . $l . ')';
    }
    function randomHsla() {
        $h = rand(1, 359);
        $s = rand(10, 100);
        $s .= '%';
        $l = rand(0, 70);
        if ($l !== 0) 
            $l .= '%';
        $a = rand(50, 100) / 100;

        return 'hsl(' . $h . ', ' . $s . ', ' . $l . ', ' . $a . ')';
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