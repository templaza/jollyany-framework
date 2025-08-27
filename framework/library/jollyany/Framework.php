<?php

/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or Later
 */

namespace Jollyany;

use Jollyany\Helper\DataImport;

defined('_JEXEC') or die;

abstract class Framework
{
    public static $dataimport = null;
    public static function init()
    {
        define('_JOLLYANY', 1); // define astroid
        self::constants();
        self::$dataimport = new DataImport();
    }

    public static function constants()
    {
        define('JOLLYANY_PACKAGE', 'https://www.templaza.com/joomla-templates.html');
        define('JOLLYANY_SUPPORT', 'https://www.templaza.com/forums.html');
        define('JOLLYANY_DOCUMENT', 'https://docs.jollyany.co/');
        define('JOLLYANY_PURCHASE', 'https://1.envato.market/jollyany-joomla-package');
    }

    public static function getDataImport()
    {
        if (!self::$dataimport) {
            self::$dataimport = new DataImport();
        }
        return self::$dataimport;
    }
}
