<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2020 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('Restricted access');

$addon_id = $displayData['addon_id'];
$class = $displayData['class'];
$options = $displayData['options'];

$btn_style = (isset($options->button_type) && $options->button_type) ? $options->button_type : '';
$appearance = (isset($options->button_appearance) && $options->button_appearance) ? $options->button_appearance : '';

$custom_style = '';
$custom_style_sm = '';
$custom_style_xs = '';
if ($appearance == 'outline') {
    $custom_style .= (isset($options->button_background_color) && $options->button_background_color) ? ' border-color: ' . $options->button_background_color . ';' : '';
    $custom_style .= (isset($options->button_border_width) && $options->button_border_width) ? ' border-width: ' . $options->button_border_width . ';' : '';
    $custom_style .= 'background-color: transparent;';
} else if ($appearance == '3d') {
    $custom_style .= (isset($options->button_background_color_hover) && $options->button_background_color_hover) ? ' border-bottom-color: ' . $options->button_background_color_hover . ';' : '';
    $custom_style .= (isset($options->button_background_color) && $options->button_background_color) ? ' background-color: ' . $options->button_background_color . ';' : '';
} else if ($appearance == 'gradient') {
    $radialPos = (isset($options->button_background_gradient->radialPos) && !empty($options->button_background_gradient->radialPos)) ? $options->button_background_gradient->radialPos : 'center center';

    $gradientColor = (isset($options->button_background_gradient->color) && !empty($options->button_background_gradient->color)) ? $options->button_background_gradient->color : '';

    $gradientColor2 = (isset($options->button_background_gradient->color2) && !empty($options->button_background_gradient->color2)) ? $options->button_background_gradient->color2 : '';

    $gradientDeg = (isset($options->button_background_gradient->deg) && !empty($options->button_background_gradient->deg)) ? $options->button_background_gradient->deg : '0';

    $gradientPos = (isset($options->button_background_gradient->pos) && !empty($options->button_background_gradient->pos)) ? $options->button_background_gradient->pos : '0';

    $gradientPos2 = (isset($options->button_background_gradient->pos2) && !empty($options->button_background_gradient->pos2)) ? $options->button_background_gradient->pos2 : '100';

    if (isset($options->button_background_gradient->type) && $options->button_background_gradient->type == 'radial') {
        $custom_style .= "\tbackground-image: radial-gradient(at " . $radialPos . ", " . $gradientColor . " " . $gradientPos . "%, " . $gradientColor2 . " " . $gradientPos2 . "%);\n";
    } else {
        $custom_style .= "\tbackground-image: linear-gradient(" . $gradientDeg . "deg, " . $gradientColor . " " . $gradientPos . "%, " . $gradientColor2 . " " . $gradientPos2 . "%);\n";
    }
    $custom_style .= "\tborder: none;\n";
} else {
    $custom_style .= (isset($options->button_background_color) && $options->button_background_color) ? ' background-color: ' . $options->button_background_color . ';' : '';
}
$custom_style .= (isset($options->button_color) && $options->button_color) ? ' color: ' . $options->button_color . ';' : '';

$custom_style .= (isset($options->button_padding) && trim($options->button_padding)) ? ' padding: ' . $options->button_padding . ';' : '';
$custom_style_sm .= (isset($options->button_padding_sm) && trim($options->button_padding_sm)) ? ' padding: ' . $options->button_padding_sm . ';' : '';
$custom_style_xs .= (isset($options->button_padding_xs) && trim($options->button_padding_xs)) ? ' padding: ' . $options->button_padding_xs . ';' : '';

if (isset($options->fontsize->md)) $options->fontsize = $options->fontsize->md;
$custom_style .= (isset($options->fontsize) && $options->fontsize) ? ' font-size: ' . $options->fontsize . 'px;' : '';
$custom_style_sm .= (isset($options->fontsize_sm) && $options->fontsize_sm) ? ' font-size: ' . $options->fontsize_sm . 'px;' : '';
$custom_style_xs .= (isset($options->fontsize_xs) && $options->fontsize_xs) ? ' font-size: ' . $options->fontsize_xs . 'px;' : '';

if (isset($options->button_margin_top) && is_object($options->button_margin_top)) {
    $custom_style .= (isset($options->button_margin_top->md) && $options->button_margin_top->md) ? ' margin-top: ' . $options->button_margin_top->md . ';' : '';
    $custom_style_sm .= (isset($options->button_margin_top->sm) && $options->button_margin_top->sm) ? ' margin-top: ' . $options->button_margin_top->sm . ';' : '';
    $custom_style_xs .= (isset($options->button_margin_top->xs) && $options->button_margin_top->xs) ? ' margin-top: ' . $options->button_margin_top->xs . ';' : '';
}

$hover_style = ($appearance == 'outline') ? ((isset($options->button_background_color_hover) && $options->button_background_color_hover) ? ' border-color: ' . $options->button_background_color_hover . ';' : '') : '';
$hover_style .= (isset($options->button_background_color_hover) && $options->button_background_color_hover) ? ' background-color: ' . $options->button_background_color_hover . ';' : '';
$hover_style .= (isset($options->button_color_hover) && $options->button_color_hover) ? ' color: ' . $options->button_color_hover . ';' : '';

if ($appearance == 'gradient') {
    $radialPos = (isset($options->button_background_gradient_hover->radialPos) && !empty($options->button_background_gradient_hover->radialPos)) ? $options->button_background_gradient_hover->radialPos : 'center center';

    $gradientColor = (isset($options->button_background_gradient_hover->color) && !empty($options->button_background_gradient_hover->color)) ? $options->button_background_gradient_hover->color : '';

    $gradientColor2 = (isset($options->button_background_gradient_hover->color2) && !empty($options->button_background_gradient_hover->color2)) ? $options->button_background_gradient_hover->color2 : '';

    $gradientDeg = (isset($options->button_background_gradient_hover->deg) && !empty($options->button_background_gradient_hover->deg)) ? $options->button_background_gradient_hover->deg : '0';

    $gradientPos = (isset($options->button_background_gradient_hover->pos) && !empty($options->button_background_gradient_hover->pos)) ? $options->button_background_gradient_hover->pos : '0';

    $gradientPos2 = (isset($options->button_background_gradient_hover->pos2) && !empty($options->button_background_gradient_hover->pos2)) ? $options->button_background_gradient_hover->pos2 : '100';

    if (isset($options->button_background_gradient_hover->type) && $options->button_background_gradient_hover->type == 'radial') {
        $hover_style .= "\tbackground-image: radial-gradient(at " . $radialPos . ", " . $gradientColor . " " . $gradientPos . "%, " . $gradientColor2 . " " . $gradientPos2 . "%);\n";
    } else {
        $hover_style .= "\tbackground-image: linear-gradient(" . $gradientDeg . "deg, " . $gradientColor . " " . $gradientPos . "%, " . $gradientColor2 . " " . $gradientPos2 . "%);\n";
    }
    $hover_style .= "\tborder: none;\n";
}


$style = (isset($options->button_letterspace) && $options->button_letterspace) ? 'letter-spacing: ' . $options->button_letterspace . ';' : '';

$css = '';

// Font Style
$modern_font_style = false;
if (isset($options->button_font_style->underline) && $options->button_font_style->underline) {
    $style .= 'text-decoration: underline;';
    $modern_font_style = true;
}

if (isset($options->button_font_style->italic) && $options->button_font_style->italic) {
    $style .= 'font-style: italic;';
    $modern_font_style = true;
}

if (isset($options->button_font_style->uppercase) && $options->button_font_style->uppercase) {
    $style .= 'text-transform: uppercase;';
    $modern_font_style = true;
}

if (isset($options->button_font_style->weight) && $options->button_font_style->weight) {
    $style .= 'font-weight: ' . $options->button_font_style->weight . ';';
    $modern_font_style = true;
}

// legcy font style
if (!$modern_font_style) {
    $font_style = (isset($options->button_fontstyle) && $options->button_fontstyle) ? $options->button_fontstyle : '';
    if (is_array($font_style) && count($font_style)) {
        if (in_array('underline', $font_style)) {
            $style .= 'text-decoration: underline;';
        }

        if (in_array('uppercase', $font_style)) {
            $style .= 'text-transform: uppercase;';
        }

        if (in_array('italic', $font_style)) {
            $style .= 'font-style: italic;';
        }

        if (in_array('lighter', $font_style)) {
            $style .= 'font-weight: lighter;';
        } else if (in_array('normal', $font_style)) {
            $style .= 'font-weight: normal;';
        } else if (in_array('bold', $font_style)) {
            $style .= 'font-weight: bold;';
        } else if (in_array('bolder', $font_style)) {
            $style .= 'font-weight: bolder;';
        }
    }
}
if($btn_style=='link'){
    $link_style ='';
    $link_style .= (isset($options->link_button_color) && $options->link_button_color) ? ' color: ' . $options->link_button_color . ';' : '';
    $link_style .= (isset($options->link_border_color) && $options->link_border_color) ? ' border-color: ' . $options->link_border_color . ';' : '';
    $link_style .= (isset($options->link_button_border_width) && $options->link_button_border_width) ? ' border-width: 0 0 ' . $options->link_button_border_width . 'px 0;' : '';
    $link_style .= (isset($options->link_button_padding_bottom) && gettype($options->link_button_padding_bottom) == 'string') ? ' padding: 0 0 ' . $options->link_button_padding_bottom . 'px 0;' : '';
    $css .= $addon_id . ' .' . $class . '.sppb-btn-link {';
        $css .= $link_style;
        $css .= 'text-decoration:none;';
        $css .= 'border-radius:0;';
    $css .= '}';
    
    $link_hover_style ='';
    $link_hover_style .= (isset($options->link_button_hover_color) && $options->link_button_hover_color) ? ' color: ' . $options->link_button_hover_color . ';' : '';
    $link_hover_style .= (isset($options->link_button_border_hover_color) && $options->link_button_border_hover_color) ? ' border-color: ' . $options->link_button_border_hover_color . ';' : '';
    $css .= $addon_id . ' .' . $class . '.sppb-btn-link:hover,';
    $css .= $addon_id . ' .' . $class . '.sppb-btn-link:focus {';
        $css .= $link_hover_style;
    $css .= '}';

}
if ($style) {
    $css .= $addon_id . ' .' . $class . '.sppb-btn-' . $btn_style . '{' . $style . '}';
}

if ($btn_style == 'custom') {
    if ($custom_style) {
        $css .= $addon_id . ' .' . $class . '.sppb-btn-custom {' . $custom_style . '}';
    }

    if ($hover_style) {
        $css .= $addon_id . ' .' . $class . '.sppb-btn-custom:hover {' . $hover_style . '}';
    }

    // Responsive Tablet
    if (!empty($custom_style_sm)) {
        $css .= "@media (min-width: 768px) and (max-width: 991px) {";
        $css .= $addon_id . ' .' . $class . ".sppb-btn-custom {\n" . $custom_style_sm . "}\n";
        $css .= "}";
    }

    // Responsive Phone
    if (!empty($custom_style_xs)) {
        $css .= "@media (max-width: 767px) {";
        $css .= $addon_id . ' .' . $class . ".sppb-btn-custom {\n" . $custom_style_xs . "}\n";
        $css .= "}";
    }
}

echo $css;
