<?php

/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 * 	DO NOT MODIFY THIS FILE DIRECTLY AS IT WILL BE OVERWRITTEN IN THE NEXT UPDATE
 *  You can easily override all files under /frontend/ folder.
 * 	Just copy the file to ROOT/templates/YOURTEMPLATE/html/frontend/ folder to create and override
 */
// No direct access.
defined('_JEXEC') or die;

use Astroid\Helper;
use Astroid\Framework;
$template = Framework::getTemplate();
$params = $template->getParams();
$document = Framework::getDocument();
$app = JFactory::getApplication();
$sitename = $app->get('sitename');
jimport('joomla.filesystem.file');

// Linearicon icon
$document->addStyleSheet('media/jollyany/assets/fonts/linearicons/font.css');

// Preloader Logo
if ($params->get('preloader', 1)) {
    $preloader_logo = $params->get('preloader_logo', false);
    if (!empty($preloader_logo)) {
        $svg    =    JFile::getExt($preloader_logo) == 'svg' ? 'uk-svg' : '';
        $document->addCustomTag('<script id="jollyany-preloader-logo-template" type="text/template"><div class="jollyany-preloader-logo mb-3"><img src="'.JURI::root() . Astroid\Helper\Media::getPath() . '/' . $preloader_logo .'" alt="'.$sitename.'" '.$svg.' class="astroid-logo-preloader" /></div></script>', 'body');
    }
}

// Header Absolute option
$header_absolute = $params->get('header_absolute');
if ($header_absolute == '1') {
    $document->addScriptDeclaration('
	jQuery(function($){
		$(document).ready(function(){
			$(".astroid-header-section").addClass("header-absolute");
		});
	});
	', 'body');
}

// Logo sidebar
$sidebar_logo = $params->get('sidebar_logo', false);
if (!empty($sidebar_logo)) {
    $svg    =    JFile::getExt($sidebar_logo) == 'svg' ? 'uk-svg' : '';
    $document->addCustomTag('<script id="jollyany-sidebar-collapsed-logo-template" type="text/template"><div class="astroid-sidebar-collapsed-logo"><img src="'.JURI::root() . Astroid\Helper\Media::getPath() . '/' . $sidebar_logo .'" alt="'.$sitename.'" '.$svg.' class="astroid-logo-sidebar" /></div></script>', 'body');
}

// Color option
$styles = [];
$body_heading_color = $params->get('body_heading_color', '');
$body_meta_color = $params->get('body_meta_color', '');
$header_heading_color = $params->get('header_heading_color', '');
$header_link_color = $params->get('header_link_color', '');
$header_link_hover_color = $params->get('header_link_hover_color', '');
$topbar_bordercolor = $params->get('topbar_bordercolor', '');
$sticky_off_canvas_button_color = $params->get('sticky_off_canvas_button_color', '');
$stick_header_menu_link_color = $params->get('stick_header_menu_link_color', '');
$stick_header_menu_link_hover_color = $params->get('stick_header_menu_link_hover_color', '');
$background_image = $params->get('body_background_image', false);
$body_link_color = $params->get('body_link_color', '');
$body_link_hover_color = $params->get('body_link_hover_color', '');
$login_icon_color = $params->get('login_icon_color', '');
$hikacart_icon_color = $params->get('hikacart_icon_color', '');
$dropdownmenu_icon_color = $params->get('dropdownmenu_icon_color', '');
$social_icon_color = $params->get('social_icon_color', '');
$social_icon_color_hover = $params->get('social_icon_color_hover', '');
$social_profiles_style = $params->get('social_profiles_style', 1);

if (!empty($background_image)) {
    $styles[] = 'body{ background-image: url('.JURI::root() . Astroid\Helper\Media::getPath() . '/' . $background_image.');}';
}
if (!empty($body_heading_color)) {
    $styles[] = 'h1,h2,h3,h4,h5,h6{ color: ' . $body_heading_color . ';}';
}
if (!empty($body_meta_color)) {
    $styles[] = '.uk-text-meta, .uk-article-meta { color: ' . $body_meta_color . ';}';
}
if (!empty($header_heading_color)) {
    $styles[] = 'header h1,header h2,header h3,header h4,header h5,header h6{ color: ' . $header_heading_color . ';}';
}
if (!empty($header_link_color)) {
    $styles[] = 'body header a{ color: ' . $header_link_color . ';}';
}
if (!empty($header_link_hover_color)) {
    $styles[] = 'body header a:hover{ color: ' . $header_link_hover_color . ';}';
}
if (!empty($topbar_bordercolor)) {
    $styles[]    = '.top-bar, .top-bar .astroid-contact-info > span,.top-bar .astroid-social-icons > li,.top-bar .jollyany-hikacart, .top-bar .jollyany-login, .top-bar .border-right {border-color:'.$topbar_bordercolor.';}';
}
if (!empty($sticky_off_canvas_button_color)) {
    $styles[]    = '#astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner, #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::before, #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::after {background-color:'.$sticky_off_canvas_button_color.';}';
}
if (!empty($stick_header_menu_link_color)) {
    $styles[]    = '#astroid-sticky-header a {color:'.$stick_header_menu_link_color.';}';
}
if (!empty($stick_header_menu_link_hover_color)) {
    $styles[]    = '#astroid-sticky-header a:hover {color:'.$stick_header_menu_link_hover_color.';}';
}
if (!empty($body_link_color)) {
    $styles[] = '.tpp-bootstrap a{ color: ' . $body_link_color . ';}';
}
if (!empty($body_link_hover_color)) {
    $styles[] = '.tpp-bootstrap a:hover, a.uk-link-heading:hover, .uk-link-heading a:hover, .uk-link-toggle:hover .uk-link-heading, .uk-link-toggle:focus .uk-link-heading{ color: ' . $body_link_hover_color . ';}';
}
if (!empty($login_icon_color)) {
    $styles[] = '.jollyany-login-icon, .jollyany-login-icon > i{ color: ' . $login_icon_color . ' !important;}';
}
if (!empty($hikacart_icon_color)) {
    $styles[] = '.jollyany-hikacart-icon, .jollyany-hikacart-icon > i{ color: ' . $hikacart_icon_color . ' !important;}';
}
if (!empty($dropdownmenu_icon_color)) {
    $styles[] = '#jollyany-dropdownmenu > i{ color: ' . $dropdownmenu_icon_color . ' !important;}';
}

// Color Menu Options
$dropdown_link_color = $params->get('dropdown_link_color', '');
$dropdown_menu_link_hover_color = $params->get('dropdown_menu_link_hover_color', '');
$dropdown_menu_active_bg_color = $params->get('dropdown_menu_active_bg_color', '');
$dropdown_bg_color = $params->get('dropdown_bg_color', '');

if (!empty($dropdown_link_color)) {
    $styles[]    = '.astroid-sidebar-menu .nav-item-submenu a.item-link-component {color:'.$dropdown_link_color.';}';
}
if (!empty($dropdown_menu_link_hover_color)) {
    $styles[]    = '.astroid-sidebar-menu .nav-item-submenu a.item-link-component:hover {color:'.$dropdown_menu_link_hover_color.';}';
}
if (!empty($dropdown_menu_active_bg_color)) {
    $styles[]    = '.astroid-sidebar-menu .nav-item-submenu a.item-link-component.active {color:'.$dropdown_menu_active_bg_color.';}';
}
if (!empty($dropdown_bg_color)) {
    $styles[]    = '.astroid-sidebar-menu .navbar-subnav {background-color:'.$dropdown_bg_color.';}';
}

// Color Footer Options
$footer_background_color = $params->get('footer_background_color', '');
$footer_text_color = $params->get('footer_text_color', '');
$footer_heading_color = $params->get('footer_heading_color', '');
$footer_link_color = $params->get('footer_link_color', '');
$footer_link_hover_color = $params->get('footer_link_hover_color', '');
if (!empty($footer_background_color)) {
    $styles[]    = '.jollyany-bottom-section {background-color:'.$footer_background_color.' !important;}';
}
if (!empty($footer_text_color)) {
    $styles[]    = '.jollyany-bottom-section {color:'.$footer_text_color.' !important;}';
}
if (!empty($footer_heading_color)) {
    $styles[]    = '.jollyany-bottom-section h1, .jollyany-bottom-section h2, .jollyany-bottom-section h3, .jollyany-bottom-section h4, .jollyany-bottom-section h5, .jollyany-bottom-section h6 {color:'.$footer_heading_color.' !important;}';
}
if (!empty($footer_link_color)) {
    $styles[]    = '.jollyany-bottom-section a {color:'.$footer_link_color.' !important;}';
}
if (!empty($footer_link_hover_color)) {
    $styles[]    = '.jollyany-bottom-section a:hover {color:'.$footer_link_hover_color.' !important;}';
}

$document->addStyledeclaration(implode('', $styles));