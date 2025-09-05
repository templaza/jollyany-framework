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
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
extract($displayData);
$params = Astroid\Framework::getTemplate()->getParams();
$document = Astroid\Framework::getDocument();
$joomlalogin               = $params->get('joomlalogin', 0);
$joomlalogin_module        = $params->get('joomlalogin_module', 0);
$whendisplay               = $params->get('when_login_module_display', '');
$joomlalogin_enable_text   = $params->get('joomlalogin_enable_text', 1);
$joomlalogin_font_size     = $params->get('joomlalogin_font_size', '');
$joomlalogin_class         = $params->get('joomlalogin_class', '');
$joomlalogin_uikit_icon    = $params->get('joomlalogin_uikit_icon', 0);

if ($whendisplay) {
    $user       =   Factory::getApplication()->getIdentity();
	if ((isset($user->id) && $user->id && $whendisplay == 'logged-out') || ($whendisplay == 'logged-in' && (!isset($user->id) || !$user->id))) {
		return;
	}
}
if (!$joomlalogin || !$joomlalogin_module) {
	return;
}
if (empty($joomlalogin_class)) {
    $joomlalogin_class = 'fas fa-user';
}
$icon = '';
if ($joomlalogin_uikit_icon) {
    $icon   =   '<span data-uk-icon="icon:user; width:'.$joomlalogin_font_size.';"></span>';
} else {
    $icon   =   '<i class="'.$joomlalogin_class.' mr-1"'.($joomlalogin_font_size ? ' style="font-size: '.$joomlalogin_font_size.'px;"' : '').'></i>';
}
$module = ModuleHelper::getModuleById($joomlalogin_module);
$title  =   $module && isset($module->title) && $module->title ? $module->title : JText::_('TPL_JOLLYANY_LOGIN');
?>
	<div class="jollyany-login">
		<a href="#jollyany-login-content" class="jollyany-login-icon" uk-toggle><?php echo $icon; ?><?php echo $joomlalogin_enable_text ? ' ' . $title : ''; ?></a>
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