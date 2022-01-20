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
if(isset($this->element->main)){
	if($this->element->product_weight==0 && isset($this->element->main->product_weight)){
		$this->element->product_weight = $this->element->main->product_weight;
	}
	if($this->element->product_width==0 && isset($this->element->main->product_width)){
		$this->element->product_width = $this->element->main->product_width;
	}
	if($this->element->product_height==0 && isset($this->element->main->product_height)){
		$this->element->product_height = $this->element->main->product_height;
	}
	if($this->element->product_length==0 && isset($this->element->main->product_length)){
		$this->element->product_length = $this->element->main->product_length;
	}
}
if (($this->config->get('weight_display', 0) && isset($this->element->product_weight) && bccomp($this->element->product_weight,0,3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_width, 0, 3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_length, 0, 3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_height, 0, 3))
    || ($this->config->get('manufacturer_display', 0) && !empty($this->element->product_manufacturer_id))
) {
    echo '<ul class="hikashop_dimensions uk-list uk-list-collapse">';
}
?>
<!-- WEIGHT -->
<?php
if ($this->config->get('weight_display', 0)) {
	if(isset($this->element->product_weight) && bccomp($this->element->product_weight,0,3)){ ?>
        <li>
            <div id="hikashop_product_weight_main" class="hikashop_product_weight_main uk-grid-small" data-uk-grid>
                <?php echo '<div class="uk-width-expand" data-uk-leader>'.JText::_('PRODUCT_WEIGHT').'</div><div>'.rtrim(rtrim($this->element->product_weight,'0'),',.').' '.JText::_($this->element->product_weight_unit).'</div>'; ?>
            </div>
        </li>
        <?php
	}
}
?>
<!-- EO WEIGHT -->
<!-- WIDTH -->
<?php
if ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_width, 0, 3)) {
?>
    <li>
        <div id="hikashop_product_width_main" class="hikashop_product_width_main uk-grid-small" data-uk-grid>
            <?php echo '<div class="uk-width-expand" data-uk-leader>'.JText::_('PRODUCT_WIDTH').'</div><div>'.rtrim(rtrim($this->element->product_width,'0'),',.').' '.JText::_($this->element->product_dimension_unit).'</div>'; ?>
        </div>
    </li>
    <?php
}
?>
<!-- EO WIDTH -->
<!-- LENGTH -->
<?php
if ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_length, 0, 3)) {
?>
    <li>
        <div id="hikashop_product_length_main" class="hikashop_product_length_main uk-grid-small" data-uk-grid>
            <?php echo '<div class="uk-width-expand" data-uk-leader>'.JText::_('PRODUCT_LENGTH').'</div><div>'.rtrim(rtrim($this->element->product_length,'0'),',.').' '.JText::_($this->element->product_dimension_unit).'</div>'; ?>
        </div>
    </li>
<?php
}
?>
<!-- LENGTH -->
<!-- HEIGHT -->
<?php
if ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_height, 0, 3)) {
?>
    <li>
        <div id="hikashop_product_height_main" class="hikashop_product_height_main uk-grid-small" data-uk-grid>
            <?php echo '<div class="uk-width-expand" data-uk-leader>'.JText::_('PRODUCT_HEIGHT').'</div><div>'.rtrim(rtrim($this->element->product_height,'0'),',.').' '.JText::_($this->element->product_dimension_unit).'</div>'; ?>
        </div>
    </li>
<?php
}
?>
<!-- EO HEIGHT -->
<!-- BRAND -->
<?php
if($this->config->get('manufacturer_display', 0) && !empty($this->element->product_manufacturer_id)){
	$categoryClass = hikashop_get('class.category');
	$manufacturer = $categoryClass->get($this->element->product_manufacturer_id);
	if($manufacturer->category_published){
		$menuClass = hikashop_get('class.menus');
		$Itemid = $menuClass->loadAMenuItemId('manufacturer','listing');
		if(empty($Itemid)){
			$Itemid = $menuClass->loadAMenuItemId('','');
		}
		$categoryClass->addAlias($manufacturer);
        echo '<li>';
        echo '<div id="hikashop_product_brand_main" class="hikashop_product_brand_main uk-grid-small" data-uk-grid>';
		echo '<div class="uk-width-expand" data-uk-leader>'.JText::_('MANUFACTURER').'</div><div>'.'<a href="'.hikashop_contentLink('category&task=listing&cid='.$manufacturer->category_id.'&name='.$manufacturer->alias.'&Itemid='.$Itemid,$manufacturer).'">'.$manufacturer->category_name.'</a>'.'</div>';
		echo '</div>';
        echo "<span style='display:none;' itemprop='brand'>". $manufacturer->category_name ."</span>";
        echo '</li>';
	}
}
?>
<!-- EO BRAND -->
<?php
if (($this->config->get('weight_display', 0) && isset($this->element->product_weight) && bccomp($this->element->product_weight,0,3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_width, 0, 3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_length, 0, 3))
    || ($this->config->get('dimensions_display', 0) && bccomp($this->element->product_height, 0, 3))
    || ($this->config->get('manufacturer_display', 0) && !empty($this->element->product_manufacturer_id))
) {
    echo '</ul>';
}