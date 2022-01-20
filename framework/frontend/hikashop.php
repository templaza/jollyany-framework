<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
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
$hikacart               = $params->get('hikacart', 0);
$hikacart_module        = $params->get('hikacart_module', 0);
if (!$hikacart || !$hikacart_module) {
	return;
}
?>
<div class="jollyany-hikacart">
    <a href="#jollyany-hikacart-content" class="jollyany-hikacart-icon" uk-toggle><i class="fas fa-shopping-cart mr-1"></i> <?php echo JText::_('TPL_JOLLYANY_YOUR_CART'); ?></a>
</div>
<?php
ob_start();
?>
<!-- Modal -->
<div id="jollyany-hikacart-content" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body">
        <h2 class="uk-modal-title" id="jollyany-hikacart-title"><?php echo JText::_('TPL_JOLLYANY_YOUR_CART'); ?></h2>
        <?php echo $document->loadModule("{loadmoduleid $hikacart_module}"); ?>
        <button class="uk-modal-close-default" type="button" uk-close></button>
    </div>
</div>
<?php
$jollyany_hikacart_content = ob_get_clean();
$document->addCustomTag($jollyany_hikacart_content, 'body');