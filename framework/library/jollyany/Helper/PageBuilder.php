<?php

/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or Later
 */

namespace Jollyany\Helper;

defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;
class PageBuilder
{
    public static function getUKIcon()
    {
        return array(
            '' => 'Select an icon',
            'home' => 'home',
            'sign-in' => 'sign-in',
            'sign-out' => 'sign-out',
            'user' => 'user',
            'users' => 'users',
            'lock' => 'lock',
            'unlock' => 'unlock',
            'settings' => 'settings',
            'cog' => 'cog',
            'nut' => 'nut',
            'comment' => 'comment',
            'commenting' => 'commenting',
            'comments' => 'comments',
            'hashtag' => 'hashtag',
            'tag' => 'tag',
            'cart' => 'cart',
            'bag' => 'bag',
            'credit-card' => 'credit-card',
            'mail' => 'mail',
            'receiver' => 'receiver',
            'print' => 'print',
            'search' => 'search',
            'location' => 'location',
            'bookmark' => 'bookmark',
            'code' => 'code',
            'paint-bucket' => 'paint-bucket',
            'camera' => 'camera',
            'video-camera' => 'video-camera',
            'bell' => 'bell',
            'microphone' => 'microphone',
            'bolt' => 'bolt',
            'star' => 'star',
            'heart' => 'heart',
            'happy' => 'happy',
            'lifesaver' => 'lifesaver',
            'rss' => 'rss',
            'social' => 'social',
            'git-branch' => 'git-branch',
            'git-fork' => 'git-fork',
            'world' => 'world',
            'calendar' => 'calendar',
            'clock' => 'clock',
            'history' => 'history',
            'future' => 'future',
            'pencil' => 'pencil',
            'trash' => 'trash',
            'move' => 'move',
            'link' => 'link',
            'question' => 'question',
            'info' => 'info',
            'warning' => 'warning',
            'image' => 'image',
            'thumbnails' => 'thumbnails',
            'table' => 'table',
            'list' => 'list',
            'menu' => 'menu',
            'grid' => 'grid',
            'more' => 'more',
            'more-vertical' => 'more-vertical',
            'plus' => 'plus',
            'plus-circle' => 'plus-circle',
            'minus' => 'minus',
            'minus-circle' => 'minus-circle',
            'close' => 'close',
            'check' => 'check',
            'ban' => 'ban',
            'refresh' => 'refresh',
            'play' => 'play',
            'play-circle' => 'play-circle',
            'tv' => 'tv',
            'desktop' => 'desktop',
            'laptop' => 'laptop',
            'tablet' => 'tablet',
            'phone' => 'phone',
            'tablet-landscape' => 'tablet-landscape',
            'phone-landscape' => 'phone-landscape',
            'file' => 'file',
            'file-text' => 'file-text',
            'file-pdf' => 'file-pdf',
            'copy' => 'copy',
            'file-edit' => 'file-edit',
            'folder' => 'folder',
            'album' => 'album',
            'push' => 'push',
            'pull' => 'pull',
            'server' => 'server',
            'database' => 'database',
            'cloud-upload' => 'cloud-upload',
            'cloud-download' => 'cloud-download',
            'download' => 'download',
            'upload' => 'upload',
            'reply' => 'reply',
            'forward' => 'forward',
            'expand' => 'expand',
            'shrink' => 'shrink',
            'arrow-up' => 'arrow-up',
            'arrow-down' => 'arrow-down',
            'arrow-left' => 'arrow-left',
            'arrow-right' => 'arrow-right',
            'chevron-up' => 'chevron-up',
            'chevron-down' => 'chevron-down',
            'chevron-left' => 'chevron-left',
            'chevron-right' => 'chevron-right',
            'chevron-double-left' => 'chevron-double-left',
            'chevron-double-right' => 'chevron-double-right',
            'triangle-up' => 'triangle-up',
            'triangle-down' => 'triangle-down',
            'triangle-left' => 'triangle-left',
            'triangle-right' => 'triangle-right',
            'bold' => 'bold',
            'italic' => 'italic',
            'strikethrough' => 'strikethrough',
            'quote-right' => 'quote-right',
            '500px' => '500px',
            'behance' => 'behance',
            'discord' => 'discord',
            'dribbble' => 'dribbble',
            'etsy' => 'etsy',
            'facebook' => 'facebook',
            'flickr' => 'flickr',
            'foursquare' => 'foursquare',
            'github' => 'github',
            'github-alt' => 'github-alt',
            'gitter' => 'gitter',
            'google' => 'google',
            'instagram' => 'instagram',
            'joomla' => 'joomla',
            'linkedin' => 'linkedin',
            'pagekit' => 'pagekit',
            'pinterest' => 'pinterest',
            'reddit' => 'reddit',
            'soundcloud' => 'soundcloud',
            'tiktok' => 'tiktok',
            'tripadvisor' => 'tripadvisor',
            'tumblr' => 'tumblr',
            'twitch' => 'twitch',
            'twitter' => 'twitter',
            'uikit' => 'uikit',
            'vimeo' => 'vimeo',
            'whatsapp' => 'whatsapp',
            'wordpress' => 'wordpress',
            'xing' => 'xing',
            'yelp' => 'yelp',
            'youtube' => 'youtube',
        );
    }

    public static function general_options() {
        return array(
	        'addon_container' => array(
		        'type' => 'select',
		        'title' => Text::_('Container'),
		        'desc' => Text::_('Add the uk-container class to widget to give it a max-width and wrap the main content'),
		        'values' => array(
			        '' => Text::_('Keep existing'),
			        'default' => Text::_('Default'),
			        'xsmall' => Text::_('XSmall'),
			        'small' => Text::_('Small'),
			        'large' => Text::_('Large'),
			        'xlarge' => Text::_('X-Large'),
			        'expand' => Text::_('Expand'),
		        ),
		        'std' => '',
	        ),
	        'addon_max_width' => array(
		        'type' => 'select',
		        'title' => Text::_('Max Width'),
		        'desc' => Text::_('Set the maximum content width.'),
		        'values' => array(
			        '' => Text::_('None'),
			        'small' => Text::_('Small'),
			        'medium' => Text::_('Medium'),
			        'large' => Text::_('Large'),
			        'xlarge' => Text::_('X-Large'),
			        '2xlarge' => Text::_('2X-Large'),
		        ),
		        'std' => '',
	        ),
	        'addon_max_width_breakpoint' => array(
		        'type' => 'select',
		        'title' => Text::_('Max Width Breakpoint'),
		        'desc' => Text::_('Define the device width from which the element\'s max-width will apply.'),
		        'values' => array(
			        '' => Text::_('Always'),
			        's' => Text::_('Small (Phone Landscape)'),
			        'm' => Text::_('Medium (Tablet Landscape)'),
			        'l' => Text::_('Large (Desktop)'),
			        'xl' => Text::_('X-Large (Large Screens)'),
		        ),
		        'std' => '',
		        'depends' => array(array('addon_max_width', '!=', '')),
	        ),
	        'block_align'=>array(
		        'type'=>'select',
		        'title'=>Text::_('Block Alignment'),
		        'desc'=>Text::_('Define the alignment in case the container exceeds the element\'s max-width.'),
		        'values'=>array(
			        ''=>Text::_('Left'),
			        'center'=>Text::_('Center'),
			        'right'=>Text::_('Right'),
		        ),
		        'std'=>'',
		        'depends'=>array(array('addon_max_width', '!=', '')),
	        ),
	        'block_align_breakpoint'=>array(
		        'type'=>'select',
		        'title'=>Text::_('Block Alignment Breakpoint'),
		        'desc'=>Text::_('Define the device width from which the alignment will apply.'),
		        'values'=>array(
			        ''=>Text::_('Always'),
			        's'=>Text::_('Small (Phone Landscape)'),
			        'm'=>Text::_('Medium (Tablet Landscape)'),
			        'l'=>Text::_('Large (Desktop)'),
			        'xl'=>Text::_('X-Large (Large Screens)'),
		        ),
		        'std'=>'',
		        'depends'=>array(array('addon_max_width', '!=', '')),
	        ),
	        'block_align_fallback'=>array(
		        'type'=>'select',
		        'title'=>Text::_('Block Alignment Fallback'),
		        'desc'=>Text::_('Define the alignment in case the container exceeds the element\'s max-width.'),
		        'values'=>array(
			        ''=>Text::_('Left'),
			        'center'=>Text::_('Center'),
			        'right'=>Text::_('Right'),
		        ),
		        'std'=>'',
		        'depends'=>array(
			        array('addon_max_width', '!=', ''),
			        array('block_align_breakpoint', '!=', '')
		        ),
	        ),
	        'alignment' => array(
		        'type' => 'select',
		        'title' => Text::_('Text Alignment'),
		        'desc' => Text::_('Center, left and right alignment.'),
		        'values' => array(
			        '' => Text::_('Inherit'),
			        'left' => Text::_('Left'),
			        'center' => Text::_('Center'),
			        'right' => Text::_('Right'),
			        'justify' => Text::_('Justify'),
		        ),
		        'std' => '',
	        ),
	        'text_breakpoint' => array(
		        'type' => 'select',
		        'title' => Text::_('Text Alignment Breakpoint'),
		        'desc' => Text::_('Display the text alignment only on this device width and larger'),
		        'values' => array(
			        '' => Text::_('Always'),
			        's' => Text::_('Small (Phone Landscape)'),
			        'm' => Text::_('Medium (Tablet Landscape)'),
			        'l' => Text::_('Large (Desktop)'),
			        'xl' => Text::_('X-Large (Large Screens)'),
		        ),
		        'std' => '',
		        'depends' => array(array('alignment', '!=', '')),
	        ),
	        'text_alignment_fallback' => array(
		        'type' => 'select',
		        'title' => Text::_('Text Alignment Fallback'),
		        'desc' => Text::_('Define an alignment fallback for device widths below the breakpoint'),
		        'values' => array(
			        '' => Text::_('Inherit'),
			        'left' => Text::_('Left'),
			        'center' => Text::_('Center'),
			        'right' => Text::_('Right'),
			        'justify' => Text::_('Justify'),
		        ),
		        'std' => '',
		        'depends' => array(
			        array('text_breakpoint', '!=', ''),
			        array('alignment', '!=', '')
		        ),
	        ),
	        'animation' => array(
		        'type' => 'select',
		        'title' => Text::_('Animation'),
		        'desc' => Text::_('A collection of smooth animations to use within your page.'),
		        'values' => array(
			        '' => Text::_('Inherit'),
			        'fade' => Text::_('Fade'),
			        'scale-up' => Text::_('Scale Up'),
			        'scale-down' => Text::_('Scale Down'),
			        'slide-top-small' => Text::_('Slide Top Small'),
			        'slide-bottom-small' => Text::_('Slide Bottom Small'),
			        'slide-left-small' => Text::_('Slide Left Small'),
			        'slide-right-small' => Text::_('Slide Right Small'),
			        'slide-top-medium' => Text::_('Slide Top Medium'),
			        'slide-bottom-medium' => Text::_('Slide Bottom Medium'),
			        'slide-left-medium' => Text::_('Slide Left Medium'),
			        'slide-right-medium' => Text::_('Slide Right Medium'),
			        'slide-top' => Text::_('Slide Top 100%'),
			        'slide-bottom' => Text::_('Slide Bottom 100%'),
			        'slide-left' => Text::_('Slide Left 100%'),
			        'slide-right' => Text::_('Slide Right 100%'),
			        'parallax' => Text::_('Parallax'),
		        ),
		        'std' => '',
	        ),
	        'animation_repeat' => array(
		        'type' => 'checkbox',
		        'title' => Text::_('Repeat Animation'),
		        'desc' => Text::_('Applies the animation class every time the element is in view'),
		        'std' => 0,
		        'depends' => array(
			        array('animation', '!=', ''),
			        array('animation', '!=', 'parallax')
		        ),
	        ),
	        'delay_element_animations' => array(
		        'type' => 'checkbox',
		        'title' => Text::_('Delay Element Animations'),
		        'desc' => Text::_('Delay element animations so that animations are slightly delayed and don\'t play all at the same time. Slide animations can come into effect with a fixed offset or at 100% of the element\’s own size.'),
		        'std' => 0,
		        'depends' => array(
			        array('animation', '!=', ''),
			        array('animation', '!=', 'parallax')
		        ),
	        ),
	        'separator_parallax_options' => array(
		        'type' => 'separator',
		        'title' => Text::_('Parallax Animation Settings'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'horizontal_start' => array(
		        'type' => 'slider',
		        'title' => Text::_('Horizontal Start'),
		        'min' => -600,
		        'max' => 600,
		        'desc' => Text::_('Animate the horizontal position (translateX) in pixels.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'horizontal_end' => array(
		        'type' => 'slider',
		        'title' => Text::_('Horizontal End'),
		        'min' => -600,
		        'max' => 600,
		        'desc' => Text::_('Animate the horizontal position (translateX) in pixels.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'vertical_start' => array(
		        'type' => 'slider',
		        'title' => Text::_('Vertical Start'),
		        'min' => -600,
		        'max' => 600,
		        'desc' => Text::_('Animate the vertical position (translateY) in pixels.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'vertical_end' => array(
		        'type' => 'slider',
		        'title' => Text::_('Vertical End'),
		        'min' => -600,
		        'max' => 600,
		        'desc' => Text::_('Animate the vertical position (translateY) in pixels.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'scale_start' => array(
		        'type' => 'slider',
		        'title' => Text::_('Scale Start'),
		        'min' => 50,
		        'max' => 200,
		        'desc' => Text::_('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'scale_end' => array(
		        'type' => 'slider',
		        'title' => Text::_('Scale End'),
		        'min' => 50,
		        'max' => 200,
		        'desc' => Text::_('Animate the scaling. Min: 50, Max: 200 =>  100 means 100% scale, 200 means 200% scale, and 50 means 50% scale.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'rotate_start' => array(
		        'type' => 'slider',
		        'title' => Text::_('Rotate Start'),
		        'min' => 0,
		        'max' => 360,
		        'desc' => Text::_('Animate the rotation clockwise in degrees.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'rotate_end' => array(
		        'type' => 'slider',
		        'title' => Text::_('Rotate End'),
		        'min' => 0,
		        'max' => 360,
		        'desc' => Text::_('Animate the rotation clockwise in degrees.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'opacity_start' => array(
		        'type' => 'slider',
		        'title' => Text::_('Opacity Start'),
		        'min' => 0,
		        'max' => 100,
		        'desc' => Text::_('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'opacity_end' => array(
		        'type' => 'slider',
		        'title' => Text::_('Opacity End'),
		        'min' => 0,
		        'max' => 100,
		        'desc' => Text::_('Animate the opacity. 100 means 100% opacity, and 0 means 0% opacity.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'easing' => array(
		        'type' => 'slider',
		        'title' => Text::_('Easing'),
		        'min' => -200,
		        'max' => 200,
		        'desc' => Text::_('Set the animation easing. A value below 100 is faster in the beginning and slower towards the end while a value above 100 behaves inversely.'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'viewport' => array(
		        'type' => 'slider',
		        'title' => Text::_('Viewport'),
		        'min' => 10,
		        'max' => 100,
		        'desc' => Text::_('Set the animation end point relative to viewport height, e.g. 50 for 50% of the viewport'),
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'parallax_target' => array(
		        'type' => 'checkbox',
		        'title' => Text::_('Target'),
		        'desc' => Text::_('Animate the element as long as the section is visible.'),
		        'std' => 0,
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'parallax_zindex' => array(
		        'type' => 'checkbox',
		        'title' => Text::_('Z Index'),
		        'desc' => Text::_('Set a higher stacking order.'),
		        'std' => 0,
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'breakpoint' => array(
		        'type' => 'select',
		        'title' => Text::_('Breakpoint'),
		        'desc' => Text::_('Display the parallax effect only on this device width and larger. It is useful to disable the parallax animation on small viewports.'),
		        'values' => array(
			        '' => Text::_('Always'),
			        's' => Text::_('Small (Phone)'),
			        'm' => Text::_('Medium (Tablet)'),
			        'l' => Text::_('Large (Desktop)'),
			        'xl' => Text::_('X-Large (Large Screens)'),
		        ),
		        'std' => '',
		        'depends' => array(array('animation', '=', 'parallax')),
	        ),
	        'visibility' => array(
		        'type' => 'select',
		        'title' => Text::_('Visibility'),
		        'desc' => Text::_('Display the element only on this device width and larger.'),
		        'values' => array(
			        '' => Text::_('Always'),
			        'uk-visible@s' => Text::_('Small (Phone Landscape)'),
			        'uk-visible@m' => Text::_('Medium (Tablet Landscape)'),
			        'uk-visible@l' => Text::_('Large (Desktop)'),
			        'uk-visible@xl' => Text::_('X-Large (Large Screens)'),
			        'uk-hidden@s' => Text::_('Hidden Small (Phone Landscape)'),
			        'uk-hidden@m' => Text::_('Hidden Medium (Tablet Landscape)'),
			        'uk-hidden@l' => Text::_('Hidden Large (Desktop)'),
			        'uk-hidden@xl' => Text::_('Hidden X-Large (Large Screens)'),
		        ),
		        'std' => '',
	        ),
        );
    }

    public static function general_styles($settings) {
        $general        = ( isset( $settings->visibility ) && $settings->visibility ) ? ' ' . $settings->visibility : '';
        $class          = ( isset( $settings->class ) && $settings->class ) ? ' ' . $settings->class : '';

	    $container  =   isset($settings->addon_container) && $settings->addon_container ? $settings->addon_container : '';
	    if ($container) {
		    if ($container == 'default') {
			    $container = ' uk-container';
		    } else {
			    $container = ' uk-container uk-container-'.$container;
		    }
	    }

        $max_width_cfg              = ( isset( $settings->addon_max_width ) && $settings->addon_max_width ) ? ' uk-width-' . $settings->addon_max_width : '';
        $addon_max_width_breakpoint = ( $max_width_cfg ) ? ( ( isset( $settings->addon_max_width_breakpoint ) && $settings->addon_max_width_breakpoint ) ? '@' . $settings->addon_max_width_breakpoint : '' ) : '';

        $block_align            = ( isset( $settings->block_align ) && $settings->block_align ) ? $settings->block_align : '';
        $block_align_breakpoint = ( isset( $settings->block_align_breakpoint ) && $settings->block_align_breakpoint ) ? '@' . $settings->block_align_breakpoint : '';
        $block_align_fallback   = ( isset( $settings->block_align_fallback ) && $settings->block_align_fallback ) ? $settings->block_align_fallback : '';

        // Block Alignment CLS.
        $block_cls[] = '';

        if ( empty( $block_align ) ) {
            if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
                $block_cls[] = ' uk-margin-auto-right' . $block_align_breakpoint;
                $block_cls[] = 'uk-margin-remove-left' . $block_align_breakpoint . ( $block_align_fallback == 'center' ? ' uk-margin-auto' : ' uk-margin-auto-left' );
            }
        }

        if ( $block_align == 'center' ) {
            $block_cls[] = ' uk-margin-auto' . $block_align_breakpoint;
            if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
                $block_cls[] = 'uk-margin-auto' . ( $block_align_fallback == 'right' ? '-left' : '' );
            }
        }

        if ( $block_align == 'right' ) {
            $block_cls[] = ' uk-margin-auto-left' . $block_align_breakpoint;
            if ( ! empty( $block_align_breakpoint ) && ! empty( $block_align_fallback ) ) {
                $block_cls[] = $block_align_fallback == 'center' ? 'uk-margin-remove-right' . $block_align_breakpoint . ' uk-margin-auto' : 'uk-margin-auto-left';
            }
        }

        $block_cls = implode( ' ', array_filter( $block_cls ) );

        $max_width_cfg .= $addon_max_width_breakpoint . ( $max_width_cfg ? $block_cls : '' );

	    $flex_alignment          = ( isset( $settings->alignment ) && $settings->alignment ) ? ' uk-flex-' . $settings->alignment : '';
	    $flex_breakpoint         = ( $flex_alignment ) ? ( ( isset( $settings->text_breakpoint ) && $settings->text_breakpoint ) ? '@' . $settings->text_breakpoint : '' ) : '';
	    $flex_alignment_fallback = ( $flex_alignment && $flex_breakpoint ) ? ( ( isset( $settings->text_alignment_fallback ) && $settings->text_alignment_fallback ) ? ' uk-flex-' . $settings->text_alignment_fallback : '' ) : '';
	    $flex_alignment          .=$flex_breakpoint. $flex_alignment_fallback;
		
        $text_alignment          = ( isset( $settings->alignment ) && $settings->alignment ) ? ' uk-text-' . $settings->alignment : '';
        $text_breakpoint         = ( $text_alignment ) ? ( ( isset( $settings->text_breakpoint ) && $settings->text_breakpoint ) ? '@' . $settings->text_breakpoint : '' ) : '';
        $text_alignment_fallback = ( $text_alignment && $text_breakpoint ) ? ( ( isset( $settings->text_alignment_fallback ) && $settings->text_alignment_fallback ) ? ' uk-text-' . $settings->text_alignment_fallback : '' ) : '';
	    $text_alignment          .=$text_breakpoint. $text_alignment_fallback;

        // Parallax Animation.
        $horizontal_start = ( isset( $settings->horizontal_start ) && $settings->horizontal_start ) ? $settings->horizontal_start : '0';
        $horizontal_end   = ( isset( $settings->horizontal_end ) && $settings->horizontal_end ) ? $settings->horizontal_end : '0';
        $horizontal       = ( ! empty( $horizontal_start ) || ! empty( $horizontal_end ) ) ? 'x: ' . $horizontal_start . ',' . $horizontal_end . ';' : '';

        $vertical_start = ( isset( $settings->vertical_start ) && $settings->vertical_start ) ? $settings->vertical_start : '0';
        $vertical_end   = ( isset( $settings->vertical_end ) && $settings->vertical_end ) ? $settings->vertical_end : '0';
        $vertical       = ( ! empty( $vertical_start ) || ! empty( $vertical_end ) ) ? 'y: ' . $vertical_start . ',' . $vertical_end . ';' : '';

        $scale_start = ( isset( $settings->scale_start ) && $settings->scale_start ) ? ( (int) $settings->scale_start / 100 ) : 1;
        $scale_end   = ( isset( $settings->scale_end ) && $settings->scale_end ) ? ( (int) $settings->scale_end / 100 ) : 1;
        $scale       = ( ! empty( $scale_start ) || ! empty( $scale_end ) ) ? 'scale: ' . $scale_start . ',' . $scale_end . ';' : '';

        $rotate_start = ( isset( $settings->rotate_start ) && $settings->rotate_start ) ? $settings->rotate_start : '0';
        $rotate_end   = ( isset( $settings->rotate_end ) && $settings->rotate_end ) ? $settings->rotate_end : '0';
        $rotate       = ( ! empty( $rotate_start ) || ! empty( $rotate_end ) ) ? 'rotate: ' . $rotate_start . ',' . $rotate_end . ';' : '';

        $opacity_start = ( isset( $settings->opacity_start ) && $settings->opacity_start ) ? ( (int) $settings->opacity_start / 100 ) : 1;
        $opacity_end   = ( isset( $settings->opacity_end ) && $settings->opacity_end ) ? ( (int) $settings->opacity_end / 100 ) : 1;
        $opacity       = ( ! empty( $opacity_start ) || ! empty( $opacity_end ) ) ? 'opacity: ' . $opacity_start . ',' . $opacity_end . ';' : '';

        $easing     = ( isset( $settings->easing ) && $settings->easing ) ? ( (int) $settings->easing / 100 ) : '';
        $easing_cls = ( ! empty( $easing ) ) ? 'easing:' . $easing . ';' : '';

        $breakpoint     = ( isset( $settings->breakpoint ) && $settings->breakpoint ) ? $settings->breakpoint : '';
        $breakpoint_cls = ( ! empty( $breakpoint ) ) ? 'media: @' . $breakpoint . ';' : '';

        $viewport     = ( isset( $settings->viewport ) && $settings->viewport ) ? ( (int) $settings->viewport / 100 ) : '';
        $viewport_cls = ( ! empty( $viewport ) ) ? 'viewport:' . $viewport . ';' : '';

        $parallax_target = ( isset( $settings->parallax_target ) && $settings->parallax_target ) ? $settings->parallax_target : false;
        $target_cls      = ( $parallax_target ) ? ' target: !.sppb-section;' : '';

	    // Default Animation.

	    $animation        = ( isset( $settings->animation ) && $settings->animation ) ? $settings->animation : '';
	    $animation_repeat = ( $animation ) ? ( ( isset( $settings->animation_repeat ) && $settings->animation_repeat ) ? ' repeat: true;' : '' ) : '';

	    $parallax_zindex = ( isset( $settings->parallax_zindex ) && $settings->parallax_zindex ) ? $settings->parallax_zindex : false;
	    $zindex_cls      = ( $parallax_zindex && $animation == 'parallax' ) ? ' uk-position-z-index uk-position-relative' : '';

	    $delay_element_animations = ( isset( $settings->delay_element_animations ) && $settings->delay_element_animations ) ? $settings->delay_element_animations : '';
	    $scrollspy_cls            = ( $delay_element_animations ) ? ' uk-scrollspy-class' : '';
	    $scrollspy_target         = ( $delay_element_animations ) ? 'target: [uk-scrollspy-class]; ' : '';
	    $animation_delay          = ( $delay_element_animations ) ? ' delay: 200;' : '';

	    if ( $animation == 'parallax' ) {
		    $animation = ' uk-parallax="' . $horizontal . $vertical . $scale . $rotate . $opacity . $easing_cls . $viewport_cls . $breakpoint_cls . $target_cls . '"';
	    } elseif ( ! empty( $animation ) ) {
		    $animation = ' uk-scrollspy="' . $scrollspy_target . 'cls: uk-animation-' . $animation . ';' . $animation_repeat . $animation_delay . '"';
	    }

        return array(
			'container' => $zindex_cls . $container . $general,
            'class' => $class. $text_alignment . $flex_alignment . $scrollspy_cls. $max_width_cfg,
            'animation' => $animation
        );
    }
}
