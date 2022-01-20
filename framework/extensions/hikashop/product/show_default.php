<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.4
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
	$form = ',0';
	if(!$this->config->get('ajax_add_to_cart', 1)) {
		$form = ',\'hikashop_product_form\'';
	}
?>
<div class="uk-child-width-1-2@m" data-uk-grid>
	<div id="hikashop_product_left_part"<?php if (isset($reserved) && $reserved) echo 'class="uk-flex-last"'; ?>>
<!-- LEFT BEGIN EXTRA DATA -->
<?php if(!empty($this->element->extraData->leftBegin)) { echo implode("\r\n",$this->element->extraData->leftBegin); } ?>
<!-- EO LEFT BEGIN EXTRA DATA -->
<!-- IMAGE -->
<?php
	$this->row =& $this->element;
	$this->setLayout('show_block_img');
	echo $this->loadTemplate();
?>
<!-- EO IMAGE -->
<!-- LEFT END EXTRA DATA -->
<?php if(!empty($this->element->extraData->leftEnd)) { echo implode("\r\n",$this->element->extraData->leftEnd); } ?>
<!-- EO LEFT END EXTRA DATA -->
	</div>

	<div id="hikashop_product_right_part">
        <!-- TOP BEGIN EXTRA DATA -->
        <?php if(!empty($this->element->extraData->topBegin)) { echo implode("\r\n",$this->element->extraData->topBegin); } ?>
        <!-- EO TOP BEGIN EXTRA DATA -->
        <?php
        if(!empty($this->links->previous) || !empty($this->links->next)) {
            echo '<div class="hikashop-product-nav float-right uk-grid-small uk-child-width-auto" data-uk-grid>';
        }
        if(!empty($this->links->previous)) {
            echo '<div class="hikashop_previous_product_btn">'.
                '<a title="'.JText::_('PREVIOUS_PRODUCT').'" href="'.$this->links->previous.'" data-uk-tooltip="'.JText::_('PREVIOUS_PRODUCT').'" data-uk-icon="icon: arrow-left; ratio: 1.2;">'.
                '</a>'.
                '</div>';
        }
        if(!empty($this->links->next)) {
            echo '<div class="hikashop_next_product_btn">'.
                '<a title="'.JText::_('NEXT_PRODUCT').'" href="'.$this->links->next.'" data-uk-tooltip="'.JText::_('NEXT_PRODUCT').'" data-uk-icon="icon: arrow-right; ratio: 1.2;">'.
                '</a>'.
                '</div>';
        }
        if(!empty($this->links->previous) || !empty($this->links->next)) {
            echo '</div>';
        }
        ?>
        <!-- CATEGORIES-->
        <?php
        if (count($this->categories)) echo '<div class="hikashop_product_category uk-text-meta">';
        $hk_categories = array();
        foreach ($this->categories as $key => $value) {
            $hk_categories[]    =   '<span id="hikashop_product_category_'.$value->category_id.'">'.$value->category_name.'</span>';
        }
        echo implode(', ', $hk_categories);
        if (count($this->categories)) echo '</div>';
        ?>
        <!-- EO CATEGORIES-->
        <!-- NAME -->
        <h1 id="hikashop_product_name_main" class="hikashop_product_name_main uk-margin-remove-top" itemprop="name">
            <?php
            if(hikashop_getCID('product_id') != $this->element->product_id && isset($this->element->main->product_name))
                echo $this->element->main->product_name;
            else
                echo $this->element->product_name;
            ?>
        </h1>
        <!-- EO NAME -->
        <meta itemprop="sku" content="<?php echo $this->element->product_code; ?>">
        <meta itemprop="productID" content="<?php echo $this->element->product_code; ?>">
        <!-- TOP END EXTRA DATA -->
        <?php if(!empty($this->element->extraData->topEnd)) { echo implode("\r\n", $this->element->extraData->topEnd); } ?>
        <!-- EO TOP END EXTRA DATA -->
        <!-- SOCIAL NETWORKS -->
        <?php
        $this->setLayout('show_block_social');
        echo $this->loadTemplate();
        ?>
        <!-- EO SOCIAL NETWORKS -->
<!-- RIGHT BEGIN EXTRA DATA -->
<?php if(!empty($this->element->extraData->rightBegin)) { echo implode("\r\n",$this->element->extraData->rightBegin); } ?>
<!-- EO RIGHT BEGIN EXTRA DATA -->
<!-- VOTE -->
		<div id="hikashop_product_vote_mini" class="hikashop_product_vote_mini"><?php
	if($this->params->get('show_vote_product')) {
		$js = '';
		$this->params->set('vote_type', 'product');
		$this->params->set('vote_ref_id', isset($this->element->main) ? (int)$this->element->main->product_id : (int)$this->element->product_id );
		echo hikashop_getLayout('vote', 'mini', $this->params, $js);
	}
		?></div>
<!-- EO VOTE -->
        <!-- META DESCRIPTION -->
        <?php
        if (isset($this->element->product_meta_description) && $this->element->product_meta_description) {
            echo '<div class="meta-description uk-margin">'.$this->element->product_meta_description.'</div>';
        }
        ?>
        <!-- EO META DESCRIPTION -->
        <!-- CODE -->
        <?php if ($this->config->get('show_code')) { ?>
                <div class="uk-margin">
                    <span class="hikashop_sku"><?php echo JText::_('TPL_JOLLYANY_SKU').': '; ?></span>
                    <span id="hikashop_product_code_main" class="hikashop_product_code_main"><?php
                        echo $this->element->product_code;
                        ?></span>
                </div>
        <?php } ?>
        <!-- EO CODE -->
        <!-- DIMENSIONS -->
        <?php
        $this->setLayout('show_block_dimensions');
        echo $this->loadTemplate();
        ?>
        <!-- EO DIMENSIONS -->
        <!-- CHARACTERISTICS -->
        <?php
        if($this->params->get('characteristic_display') != 'list') {
            $this->setLayout('show_block_characteristic');
            echo $this->loadTemplate();
            ?>
        <?php } ?>
        <!-- EO CHARACTERISTICS -->
        <!-- OPTIONS -->
        <?php
        if(hikashop_level(1) && !empty ($this->element->options)) {
            ?>
            <div id="hikashop_product_options" class="hikashop_product_options"><?php
                $this->setLayout('option');
                echo $this->loadTemplate();
                ?></div>
            <?php
            $form = ',\'hikashop_product_form\'';
            if($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
                ?>
                <input type="hidden" name="popup" value="1"/>
                <?php
            }
        }
        ?>
        <!-- EO OPTIONS -->
        <!-- RIGHT MIDDLE EXTRA DATA -->
        <?php if(!empty($this->element->extraData->rightMiddle)) { echo implode("\r\n",$this->element->extraData->rightMiddle); } ?>
        <!-- EO RIGHT MIDDLE EXTRA DATA -->
        <!-- PRICE -->
        <?php
        $itemprop_offer = '';
        if (!empty($this->element->prices))
            $itemprop_offer = 'itemprop="offers" itemscope itemtype="https://schema.org/Offer"';
        ?>
        <span id="hikashop_product_price_main" class="hikashop_product_price_main" <?php echo $itemprop_offer; ?>>
<?php
$main =& $this->element;
if(!empty($this->element->main))
    $main =& $this->element->main;
if(!empty($main->product_condition) && !empty($this->element->prices)) {
    ?>
    <meta itemprop="itemCondition" itemtype="https://schema.org/OfferItemCondition" content="https://schema.org/<?php echo $main->product_condition; ?>" />
    <?php
}
if($this->params->get('show_price') && (empty($this->displayVariants['prices']) || $this->params->get('characteristic_display') != 'list')) {
    $this->row =& $this->element;
    $this->setLayout('listing_price');
    echo $this->loadTemplate();
    if (!empty($this->element->prices)) {
        ?>
        <meta itemprop="price" content="<?php echo $this->itemprop_price; ?>" />
        <meta itemprop="availability" content="https://schema.org/<?php echo ($this->row->product_quantity != 0) ? 'InStock' : 'OutOfstock' ;?>" />
        <meta itemprop="priceCurrency" content="<?php echo $this->currency->currency_code; ?>" />
    <?php	}
}
?>		</span>
        <!-- EO PRICE -->
<!-- CUSTOM ITEM FIELDS -->
<?php
	if(!$this->params->get('catalogue') && ($this->config->get('display_add_to_cart_for_free_products') || ($this->config->get('display_add_to_wishlist_for_free_products', 1) && hikashop_level(1) && $this->params->get('add_to_wishlist') && $this->config->get('enable_wishlist', 1)) || !empty($this->element->prices))) {
		if(!empty($this->itemFields)) {
			$form = ',\'hikashop_product_form\'';
			if ($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
?>
		<input type="hidden" name="popup" value="1"/>
<?php
			}
			$this->setLayout('show_block_custom_item');
			echo $this->loadTemplate();
		}
	}
?>
<!-- EO CUSTOM ITEM FIELDS -->
<!-- PRICE WITH OPTIONS -->
<?php
	if($this->params->get('show_price')) {
?>
		<span id="hikashop_product_price_with_options_main" class="hikashop_product_price_with_options_main">
		</span>
<?php
	}
?>
<!-- EO PRICE WITH OPTIONS -->
<!-- ADD TO CART BUTTON -->
<?php
	if(empty($this->element->characteristics) || $this->params->get('characteristic_display') != 'list') {
?>
		<div id="hikashop_product_quantity_main" class="hikashop_product_quantity_main uk-margin"><?php
			$this->row =& $this->element;
			$this->formName = $form;
			$this->ajax = 'if(hikashopCheckChangeForm(\'item\',\'hikashop_product_form\')){ return hikashopModifyQuantity(\'' . (int)$this->element->product_id . '\',field,1' . $form . ',\'cart\'); } else { return false; }';
			$this->setLayout('quantity');
			echo $this->loadTemplate();
		?></div>
		<div id="hikashop_product_quantity_alt" class="hikashop_product_quantity_main_alt" style="display:none;">
			<?php echo JText::_('ADD_TO_CART_AVAILABLE_AFTER_CHARACTERISTIC_SELECTION'); ?>
		</div>
<?php
	}
?>
<!-- EO ADD TO CART BUTTON -->
<!-- CONTACT US BUTTON -->
		<div id="hikashop_product_contact_main" class="hikashop_product_contact_main uk-margin"><?php
	$contact = (int)$this->config->get('product_contact', 0);
	if(hikashop_level(1) && ($contact == 2 || ($contact == 1 && !empty($this->element->product_contact)))) {
		$css_button = $this->config->get('css_button', 'hikabtn');
?>
			<a rel="noindex, nofollow" href="<?php echo hikashop_completeLink('product&task=contact&cid=' . (int)$this->element->product_id . $this->url_itemid); ?>" class="uk-button uk-button-default uk-button-large uk-width-1-1 <?php echo $css_button; ?>"><?php
				echo '<i class="fas fa-headphones-alt uk-margin-small-right"></i>' .JText::_('CONTACT_US_FOR_INFO');
			?></a>
<?php
	}
?>
		</div>
<!-- EO CONTACT US BUTTON -->
<!-- CUSTOM PRODUCT FIELDS -->
<?php
	if(!empty($this->fields)) {
		$this->setLayout('show_block_custom_main');
		echo $this->loadTemplate();
	}
?>
<!-- EO CUSTOM PRODUCT FIELDS -->
<!-- TAGS -->
<?php
	if(HIKASHOP_J30) {
		$this->setLayout('show_block_tags');
		echo $this->loadTemplate();
	}
?>
<!-- EO TAGS -->
<!-- RIGHT END EXTRA DATA -->
<?php if(!empty($this->element->extraData->rightEnd)) { echo implode("\r\n",$this->element->extraData->rightEnd); } ?>
<!-- EO RIGHT END EXTRA DATA -->
<span id="hikashop_product_id_main" class="hikashop_product_id_main">
	<input type="hidden" name="product_id" value="<?php echo (int)$this->element->product_id; ?>" />
</span>
</div>
</div>
<!-- END GRID -->
<div id="hikashop_product_bottom_part" class="hikashop_product_bottom_part">
<!-- BOTTOM BEGIN EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomBegin)) { echo implode("\r\n",$this->element->extraData->bottomBegin); } ?>
<!-- EO BOTTOM BEGIN EXTRA DATA -->
<!-- DESCRIPTION -->
	<div id="hikashop_product_description_main" class="hikashop_product_description_main" itemprop="description"><?php
		echo JHTML::_('content.prepare',preg_replace('#<hr *id="system-readmore" */>#i','',$this->element->product_description));
	?></div>
<!-- EO DESCRIPTION -->
<!-- MANUFACTURER URL -->
	<span id="hikashop_product_url_main" class="hikashop_product_url_main"><?php
		if(!empty($this->element->product_url)) {
			echo JText::sprintf('MANUFACTURER_URL', '<a href="' . $this->element->product_url . '" target="_blank">' . $this->element->product_url . '</a>');
		}
	?></span>
<!-- EO MANUFACTURER URL -->
<!-- FILES -->
<?php
	$this->setLayout('show_block_product_files');
	echo $this->loadTemplate();
?>
<!-- EO FILES -->
<!-- BOTTOM MIDDLE EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomMiddle)) { echo implode("\r\n",$this->element->extraData->bottomMiddle); } ?>
<!-- EO BOTTOM MIDDLE EXTRA DATA -->
<!-- BOTTOM END EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomEnd)) { echo implode("\r\n",$this->element->extraData->bottomEnd); } ?>
<!-- EO BOTTOM END EXTRA DATA -->
</div>
