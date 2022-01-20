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
$joomlalogin               = $params->get('joomlalogin', 0);
$joomlalogin_module        = $params->get('joomlalogin_module', 0);
$whendisplay               = $params->get('when_login_module_display', '');

if ($whendisplay) {
    $user       =   \JFactory::getUser();
	if ((isset($user->id) && $user->id && $whendisplay == 'logged-out') || ($whendisplay == 'logged-in' && (!isset($user->id) || !$user->id))) {
		return;
	}
}
if (!$joomlalogin || !$joomlalogin_module) {
	return;
}
$module = JModuleHelper::getModuleById($joomlalogin_module);
$title  =   $module && isset($module->title) && $module->title ? $module->title : JText::_('TPL_JOLLYANY_LOGIN');
?>
	<div class="jollyany-login">
		<a href="#jollyany-login-content" class="jollyany-login-icon" uk-toggle><i class="fas fa-user mr-1"></i> <?php echo $title; ?></a>
	</div>
<?php
ob_start();
?>
    <!-- Modal -->
    <div id="jollyany-login-content" uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body">
            <h2 class="uk-modal-title" id="jollyany-login-title"><?php echo JText::_('TPL_JOLLYANY_LOGIN'); ?></h2>
            <?php echo $document->loadModule("{loadmoduleid $joomlalogin_module}"); ?>
            <button class="uk-modal-close-default" type="button" uk-close></button>
        </div>
    </div>
<?php
$jollyany_login_content = ob_get_clean();
$document->addCustomTag($jollyany_login_content, 'body');