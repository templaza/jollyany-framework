<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
jimport('astroid.framework.astroid');
jimport('jollyany.framework.template');

abstract class JollyanyFramework extends AstroidFramework {
	public static $template = null;
	public static function getTemplate() {
		if (!self::$template) {
			self::$template = self::createTemplate();
		}
		return self::$template;
	}
	public static function createTemplate() {
		return new JollyanyFrameworkTemplate(JFactory::getApplication()->getTemplate(true));
	}
}
