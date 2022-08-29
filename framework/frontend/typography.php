<?php

/**
 * @package   Astroid Framework
 * @author    JoomDev https://www.joomdev.com
 * @copyright Copyright (C) 2009 - 2019 JoomDev.
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

// Body Font Styles
$bodyType = $params->get('body_typography','');
if (trim($bodyType) == 'custom') {
    $typography     = $params->get('body_typography_options');
    $selector       = 'html';
    Helper\Style::renderTypography($selector, $typography);
}

// Top Bar Font Styles
$topbarType = $params->get('top_bar_typography','');
if (trim($topbarType) == 'custom') {
    $typography     = $params->get('top_bar_typography_options');
    $selector       = '.top-bar';
    Helper\Style::renderTypography($selector, $typography);
}

// Footer Font Styles
$footerType = $params->get('footer_typography','');
if (trim($footerType) == 'custom') {
    $typography     = $params->get('footer_typography_options');
    $selector       = '.astroid-footer, .astroid-footer-section, .jollyany-bottom-section';
    Helper\Style::renderTypography($selector, $typography);
}

// Article detail Font Styles
$articleType = $params->get('article_typography','');
if (trim($articleType) == 'custom') {
    $typography     = $params->get('article_typography_options');
    $selector       = '.articleBody, #eb .eb-entry-article, .tpItemPage > #tz-portfolio-template-body';
    Helper\Style::renderTypography($selector, $typography);
}

// Header Font Styles
$headerType = $params->get('header_typography','');
if (trim($headerType) == 'custom') {
    $typography     = $params->get('header_typography_options');
    $selector       = '.astroid-header-section, .astroid-sidebar-header';
    Helper\Style::renderTypography($selector, $typography);
}

// Button Font Styles
$buttonType = $params->get('button_typography','');
if (trim($buttonType) == 'custom') {
    $typography     = $params->get('button_typography_options');
    $selector       = 'button, [type="button"], [type="reset"], [type="submit"], .sppb-btn, .btn';
    Helper\Style::renderTypography($selector, $typography);
}