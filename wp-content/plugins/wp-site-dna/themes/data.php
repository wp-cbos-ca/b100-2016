<?php

defined( 'ABSPATH' ) || die();

function get_theme_template(){
    $template = array ( 'activate' => 1, 'title' => 'Twenty Sixteen', 'option_name' => 'template', 'option_value' => 'twentysixteen', );
    return $template;
}

function get_theme_stylesheet(){
    $stylesheet = array ( 'activate' => 0, 'title' => 'Twenty Sixteen Child', 'option_name' => 'stylesheet', 'option_value' => 'twentysixteen-child', );
    return $stylesheet;
}
