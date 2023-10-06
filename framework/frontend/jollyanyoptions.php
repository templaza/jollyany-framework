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

use Astroid\Helper\Style;
use Astroid\Framework;
$template = Framework::getTemplate();
$params = $template->getParams();
$document = Framework::getDocument();
$app = JFactory::getApplication();
$sitename = $app->get('sitename');
jimport('joomla.filesystem.file');

// Linearicon icon
$document->addStyleSheet('media/jollyany/assets/fonts/linearicons/font.min.css');

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
$body_meta_color = Style::getColor($params->get('body_meta_color', ''));
$sticky_off_canvas_button_color = Style::getColor($params->get('sticky_off_canvas_button_color', ''));
$background_image = $params->get('body_background_image', false);
$body_link_color = Style::getColor($params->get('body_link_color', ''));
$body_link_hover_color = Style::getColor($params->get('body_link_hover_color', ''));
$login_icon_color = Style::getColor($params->get('login_icon_color', ''));
$hikacart_icon_color = Style::getColor($params->get('hikacart_icon_color', ''));
$dropdownmenu_icon_color = Style::getColor($params->get('dropdownmenu_icon_color', ''));
$social_profiles_style = $params->get('social_profiles_style', 1);

if (!empty($background_image)) {
    Style::addCssBySelector('body', 'background-image', 'url('.JURI::root() . Astroid\Helper\Media::getPath() . '/' . $background_image.')');
}
Style::addCssBySelector('.uk-text-meta, .uk-article-meta', 'color', $body_meta_color['light']);
Style::addCssBySelector('[data-bs-theme=dark] .uk-text-meta, [data-bs-theme=dark] .uk-article-meta', 'color', $body_meta_color['dark']);

Style::addCssBySelector('#astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner, #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::before, #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::after', 'background-color', $sticky_off_canvas_button_color['light']);
Style::addCssBySelector('[data-bs-theme=dark] #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner, [data-bs-theme=dark] #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::before, [data-bs-theme=dark] #astroid-sticky-header .header-offcanvas-trigger.burger-menu-button .inner::after', 'background-color', $sticky_off_canvas_button_color['dark']);

Style::addCssBySelector('.tpp-bootstrap a', 'color', $body_link_color['light']);
Style::addCssBySelector('[data-bs-theme=dark] .tpp-bootstrap a', 'color', $body_link_color['dark']);

Style::addCssBySelector('.tpp-bootstrap a:hover, a.uk-link-heading:hover, .uk-link-heading a:hover, .uk-link-toggle:hover .uk-link-heading, .uk-link-toggle:focus .uk-link-heading', 'color', $body_link_hover_color['light']);
Style::addCssBySelector('[data-bs-theme=dark] .tpp-bootstrap a:hover, [data-bs-theme=dark] a.uk-link-heading:hover, [data-bs-theme=dark] .uk-link-heading a:hover, [data-bs-theme=dark] .uk-link-toggle:hover .uk-link-heading, [data-bs-theme=dark] .uk-link-toggle:focus .uk-link-heading', 'color', $body_link_hover_color['dark']);

Style::addCssBySelector('.jollyany-login-icon, .jollyany-login-icon > i', 'color', $login_icon_color['light'] . ' !important');
Style::addCssBySelector('[data-bs-theme=dark] .jollyany-login-icon, [data-bs-theme=dark] .jollyany-login-icon > i', 'color', $login_icon_color['dark'] . ' !important');

Style::addCssBySelector('.jollyany-hikacart-icon, .jollyany-hikacart-icon > i', 'color', $hikacart_icon_color['light'] . ' !important');
Style::addCssBySelector('[data-bs-theme=dark] .jollyany-hikacart-icon, [data-bs-theme=dark] .jollyany-hikacart-icon > i', 'color', $hikacart_icon_color['dark'] . ' !important');

Style::addCssBySelector('#jollyany-dropdownmenu > i', 'color', $dropdownmenu_icon_color['light'] . ' !important');
Style::addCssBySelector('[data-bs-theme=dark] #jollyany-dropdownmenu > i', 'color', $dropdownmenu_icon_color['dark'] . ' !important');

// Color Menu Options
$dropdown_link_color = Style::getColor($params->get('dropdown_link_color', ''));
$dropdown_menu_link_hover_color = Style::getColor($params->get('dropdown_menu_link_hover_color', ''));
$dropdown_menu_active_bg_color = Style::getColor($params->get('dropdown_menu_active_bg_color', ''));
$dropdown_bg_color = Style::getColor($params->get('dropdown_bg_color', ''));

$sidebar_menu_style     =   new Style('.astroid-sidebar-menu');
$sidebar_link   =   $sidebar_menu_style->child('.nav-item-submenu a.item-link-component');
$sidebar_link->addCss('color', $dropdown_link_color['light']);
$sidebar_link->hover()->addCss('color', $dropdown_menu_link_hover_color['light']);
$sidebar_link->active()->addCss('color', $dropdown_menu_active_bg_color['light']);
$sidebar_menu_style->child('.navbar-subnav')->addCss('background-color', $dropdown_bg_color['light']);
$sidebar_menu_style->render();

$sidebar_menu_style     =   new Style('.astroid-sidebar-menu', 'dark');
$sidebar_link   =   $sidebar_menu_style->child('.nav-item-submenu a.item-link-component');
$sidebar_link->addCss('color', $dropdown_link_color['dark']);
$sidebar_link->hover()->addCss('color', $dropdown_menu_link_hover_color['dark']);
$sidebar_link->active()->addCss('color', $dropdown_menu_active_bg_color['dark']);
$sidebar_menu_style->child('.navbar-subnav')->addCss('background-color', $dropdown_bg_color['dark']);
$sidebar_menu_style->render();

// Color Footer Options
$footer_background_color = Style::getColor($params->get('footer_background_color', ''));
$footer_text_color = Style::getColor($params->get('footer_text_color', ''));
$footer_heading_color = Style::getColor($params->get('footer_heading_color', ''));
$footer_link_color = Style::getColor($params->get('footer_link_color', ''));
$footer_link_hover_color = Style::getColor($params->get('footer_link_hover_color', ''));

$bottom_style   =   new Style('.jollyany-bottom-section');
$bottom_style->addCss('background-color', $footer_background_color['light'] . ' !important');
$bottom_style->addCss('color', $footer_text_color['light'] . ' !important');
$bottom_style->child('h1,h2,h3,h4,h5,h6')->addCss('color', $footer_heading_color['light'] . '!important');
$bottom_style->link()->addCss('color', $footer_link_color['light'] . ' !important');
$bottom_style->link()->hover()->addCss('color', $footer_link_hover_color['light'] . ' !important');
$bottom_style->render();

$bottom_style   =   new Style('.jollyany-bottom-section', 'dark');
$bottom_style->addCss('background-color', $footer_background_color['dark'] . ' !important');
$bottom_style->addCss('color', $footer_text_color['dark'] . ' !important');
$bottom_style->child('h1,h2,h3,h4,h5,h6')->addCss('color', $footer_heading_color['dark'] . '!important');
$bottom_style->link()->addCss('color', $footer_link_color['dark'] . ' !important');
$bottom_style->link()->hover()->addCss('color', $footer_link_hover_color['dark'] . ' !important');
$bottom_style->render();