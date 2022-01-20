<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 * 	DO NOT MODIFY THIS FILE DIRECTLY AS IT WILL BE OVERWRITTEN IN THE NEXT UPDATE
 *  You can easily override all files under /frontend/ folder.
 *	Just copy the file to ROOT/templates/YOURTEMPLATE/html/frontend/ folder to create and override
 */
// No direct access.
defined('_JEXEC') or die;
extract($displayData);
$params = Astroid\Framework::getTemplate()->getParams();
$document = Astroid\Framework::getDocument();
$menu                   = $params->get('dropdownmenu_option', 0);
$menu_module            = $params->get('dropdownmenu_module', 0);
$whendisplay            = $params->get('when_dropdownmenu_module_display', '');

if ($whendisplay) {
	$user       =   \JFactory::getUser();
	if ((isset($user->id) && $user->id && $whendisplay == 'logged-out') || ($whendisplay == 'logged-in' && (!isset($user->id) || !$user->id))) {
		return;
	}
}
if (!$menu || !$menu_module) {
	return;
}
$module = JModuleHelper::getModuleById($menu_module);
$title  =   $module && isset($module->title) && $module->title ? $module->title : JText::_('TPL_JOLLYANY_MENU');
?>

	<div class="jollyany-dropdownmenu uk-inline">
		<a href="#" id="jollyany-dropdownmenu"><i class="fas fa-bars mr-1"></i> <?php echo $title; ?></a>
        <div uk-dropdown>
	        <?php echo $document->loadModule("{loadmoduleid $menu_module}"); ?>
        </div>
	</div>