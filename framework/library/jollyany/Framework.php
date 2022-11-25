<?php

/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or Later
 */

namespace Jollyany;

defined('_JEXEC') or die;

abstract class Framework
{
    public static function init()
    {
        define('_JOLLYANY', 1); // define astroid
        self::constants();
    }

    public static function constants()
    {
        define('JOLLYANY_PACKAGE', 'https://www.templaza.com/joomla-templates.html');
        define('JOLLYANY_SUPPORT', 'https://www.templaza.com/forums.html');
        define('JOLLYANY_DOCUMENT', 'https://docs.jollyany.co/');
        define('JOLLYANY_PURCHASE', 'https://1.envato.market/jollyany-joomla-package');
    }
}
