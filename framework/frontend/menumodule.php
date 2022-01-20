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
$template = Astroid\Framework::getTemplate();
$params = $template->getParams();
$document = Astroid\Framework::getDocument();
$menu                   = $params->get('menu_option', 0);
$menu_module            = $params->get('menu_module', 0);
$whendisplay            = $params->get('when_menu_module_display', '');

if ($whendisplay) {
	$user       =   \JFactory::getUser();
	if ((isset($user->id) && $user->id && $whendisplay == 'logged-out') || ($whendisplay == 'logged-in' && (!isset($user->id) || !$user->id))) {
		return;
	}
}
if (!$menu || !$menu_module) {
	return;
}
?>

<div class="jollyany-menu">
	<?php echo $document->loadModule("{loadmoduleid $menu_module}"); ?>
</div>