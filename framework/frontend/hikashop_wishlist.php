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
$hikawishlist               = $params->get('hikawishlist', 0);
$hikawishlist_module        = $params->get('hikawishlist_module', 0);

if (!$hikawishlist || !$hikawishlist_module) {
    return;
}
?>
    <div class="jollyany-hikawishlist">
        <a href="#jollyany-hikawishlist-content" class="jollyany-hikawishlist-icon" data-uk-toggle><i class="fas fa-heart mr-1"></i> <?php echo JText::_('TPL_JOLLYANY_YOUR_WISHLIST'); ?></a>
    </div>
<?php
ob_start();
?>
    <!-- Modal -->
    <div id="jollyany-hikawishlist-content" class="uk-modal-container" data-uk-modal>
        <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body">
            <h2 class="uk-modal-title" id="jollyany-hikawishlist-title"><?php echo JText::_('TPL_JOLLYANY_YOUR_WISHLIST'); ?></h2>
            <?php echo $document->loadModule("{loadmoduleid $hikawishlist_module}"); ?>
            <button class="uk-modal-close-default" type="button" data-uk-close></button>
        </div>
    </div>
<?php
$jollyany_hikawishlist_content = ob_get_clean();
$document->addCustomTag($jollyany_hikawishlist_content, 'body');