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
if(empty($this->cartHelper))
	$this->cartHelper = hikashop_get('helper.cart');
$quantity_counter = $this->cartHelper->getQuantityCounter($this);

$prefix = $this->params->get('id_prefix', 'hikashop_product_quantity_field');
$id = $prefix.'_'.$quantity_counter;
$this->last_quantity_field_id = $id;
$extra_data_attribute = '';
if(!isset($this->config))
	$this->config = hikashop_config();


if(isset($this->row) && isset($this->row->product_min_per_order)) {
	$min_quantity = ($this->row->product_min_per_order || empty($this->row->parent_product)) ? $this->row->product_min_per_order : $this->row->parent_product->product_min_per_order;
	$max_quantity = ($this->row->product_max_per_order || empty($this->row->parent_product)) ? $this->row->product_max_per_order : $this->row->parent_product->product_max_per_order;
	$min_quantity = max($min_quantity, 1);
	$max_quantity = max($max_quantity, 0);
	if($this->row->product_quantity > 0) {
		if($max_quantity == 0)
			$max_quantity = $this->row->product_quantity;
		else
			$max_quantity = min($max_quantity, $this->row->product_quantity);
	}
} else {
	$min_quantity = max((int)$this->params->get('min_quantity', 0), 1);
	$max_quantity = max((int)$this->params->get('max_quantity', 0), 0);
}
$current_quantity = (int)$this->params->get('product_quantity', $min_quantity);
if(isset($this->row) && isset($this->row->cart_product_quantity)) {
	$current_quantity = (int)$this->row->cart_product_quantity;
	$extra_data_attribute .= ' data-hk-allow-zero="true"';
}

$quantity_fieldname = $this->params->get('quantity_fieldname', 'quantity');

$quantityLayout = isset($this->quantityLayout) ? $this->quantityLayout : $this->params->get('quantityLayout', 'inherit');
if((empty($quantityLayout) || $quantityLayout == 'inherit') && isset($this->row))
	$quantityLayout = $this->cartHelper->getProductQuantityLayout($this->row);
if(empty($quantityLayout) || $quantityLayout == 'inherit') {
	$quantityLayout = $this->config->get('product_quantity_display', 'show_default_div');
}
hikashop_loadJslib('notify');
hikashop_loadJslib('translations');
$script = $this->params->get('onchange_script', 'window.hikashop.checkQuantity(this);');
$increment_script = str_replace('{id}', $id, $this->params->get('onincrement_script', 'return window.hikashop.updateQuantity(this, \''.$id.'\');'));
$extra_data = $this->params->get('extra_data', '');
$in_cart = !empty($this->row->cart_product_id);

if(!isset($this->row->all_prices) && isset($this->row->prices))
	$this->row->all_prices =& $this->row->prices;
if($quantityLayout == 'show_select_price' && !isset($this->row->all_prices)) {
	$quantityLayout = 'show_select';
}

$force = $this->params->get('force_input', false);

if($force && $quantityLayout == 'show_none')
	$quantityLayout = 'show_simple';

switch($quantityLayout) {
	case 'show_none':
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_none">
			<input id="<?php echo $id; ?>" type="hidden" value="<?php echo $current_quantity; ?>" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
			<span><?php echo $current_quantity; ?></span>
		</div>
<?php
		break;

	case 'show_regrouped':
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_regrouped">
            <div class="uk-flex uk-margin-remove">
                <input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" onfocus="this.select()" class="hikashop_product_quantity_field uk-input uk-text-center" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
                <div class="hikashop_product_quantity_div hikashop_product_quantity_change_div_regrouped uk-padding-remove-vertical h-100">
                    <div class="hikashop_product_quantity_change_div_regrouped_inner">
                        <a class="hikashop_product_quantity_field_change_plus hikashop_product_quantity_field_change uk-display-block" href="#" data-hk-qty-mod="1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: chevron-up; ratio: 0.5"></a>
                    </div>
                    <div class="hikashop_product_quantity_change_div_regrouped_inner">
                        <a class="hikashop_product_quantity_field_change_minus hikashop_product_quantity_field_change uk-display-block" href="#" data-hk-qty-mod="-1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: chevron-down; ratio: 0.5"></a>
                    </div>
                </div>
            </div>
		</div>
<?php
		break;

	case 'show_select':
		if(empty($max_quantity))
			$max_quantity = (int)$min_quantity * $this->config->get('quantity_select_max_default_value', 15);
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_select"><?php
			$r = range($min_quantity, $max_quantity, $min_quantity);
			if(!in_array($current_quantity, $r))
				$r[] = $current_quantity;
			if(!in_array($max_quantity, $r))
				$r[] = $max_quantity;
			$values = array_combine($r, $r);
			ksort($values);
			echo JHTML::_('select.genericlist', $values, '', 'style="width:auto;" class="uk-select" onchange="var el = document.getElementById(\''.$id.'\'); el.value = this.value; el.onchange();"', 'value', 'text', $current_quantity, $id.'_select');
			?>
			<input id="<?php echo $id; ?>" type="hidden" value="<?php echo $current_quantity; ?>" class="hikashop_product_quantity_field" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
		</div>
<?php
		break;

	case 'show_select_price':
		if(!$max_quantity)
			$max_quantity = (int)$min_quantity * $this->config->get('quantity_select_max_default_value', 15);
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_select"><?php
				$values = array();
				foreach($this->row->all_prices as $price) {
					$price_min_qty = max((int)$price->price_min_quantity, $min_quantity);
					$values[$price_min_qty] = $price_min_qty;
				}
				if(empty($values)) {
					$r = range($min_quantity, $max_quantity, $min_quantity);
					if(!in_array($max_quantity, $r))
						$r[] = $max_quantity;
					$values = array_combine($r, $r);
				}else{
					$min_quantity = min($values);
					$max_quantity = max($values);
					if($current_quantity < $min_quantity)
						$current_quantity = $min_quantity;
				}
				ksort($values);
				echo JHTML::_('select.genericlist', $values, '', 'class="uk-select" onchange="var el = document.getElementById(\''.$id.'\'); el.value = this.value; el.onchange();"', 'value', 'text', $current_quantity);
			?>
			<input id="<?php echo $id; ?>" type="hidden" value="<?php echo $current_quantity; ?>" class="hikashop_product_quantity_field" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
		</div>
<?php
		break;

	case 'show_simple':
?>
		<input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" class="hikashop_product_quantity_field uk-input uk-text-center" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
<?php
		break;

	case 'show_leftright':

	$extra_class = '';
	if (HIKASHOP_J40) {
		$extra_class = 'hika_j4';
	}
?>
		<div class="input-prepend input-append hikashop_product_quantity_div hikashop_product_quantity_div_leftright uk-button-group hikashop_product_quantity_default_div uk-margin-remove <?php echo $extra_class; ?>">
            <a class="hikashop_product_quantity_field_change_minus hikashop_product_quantity_field_change uk-button uk-button-default" href="#" data-hk-qty-mod="-1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: minus; ratio: 0.7"></a>
			<input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" onfocus="this.select()" class="hikashop_product_quantity_field uk-input" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
            <a class="hikashop_product_quantity_field_change_plus hikashop_product_quantity_field_change uk-button uk-button-default" href="#" data-hk-qty-mod="1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: plus; ratio: 0.7"></a>
		</div>
<?php
		break;

	case 'show_simplified':
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_simplified">
			<input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" onfocus="this.select()" class="hikashop_product_quantity_field uk-input uk-text-center" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
		</div>
<?php
		break;

	case 'show_html5':
		$html5_data = ((int)$max_quantity > 0) ? 'max="'.(int)$max_quantity.'"' : '';
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_simplified">
			<input id="<?php echo $id; ?>" type="number" min="<?php echo $min_quantity; ?>" value="<?php echo $current_quantity; ?>" class="hikashop_product_quantity_field uk-input uk-text-center" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
		</div>
<?php
		break;

	case 'show_default':
?>
        <div class="hikashop_product_quantity_div hikashop_product_quantity_input_div_regrouped">
            <div class="uk-flex uk-margin-remove">
                <input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" onfocus="this.select()" class="hikashop_product_quantity_field uk-input uk-text-center" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
                <div class="hikashop_product_quantity_div hikashop_product_quantity_change_div_regrouped uk-padding-remove-vertical h-100">
                    <div class="hikashop_product_quantity_change_div_regrouped_inner">
                        <a class="hikashop_product_quantity_field_change_plus hikashop_product_quantity_field_change uk-display-block" href="#" data-hk-qty-mod="1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: chevron-up; ratio: 0.5"></a>
                    </div>
                    <div class="hikashop_product_quantity_change_div_regrouped_inner">
                        <a class="hikashop_product_quantity_field_change_minus hikashop_product_quantity_field_change uk-display-block" href="#" data-hk-qty-mod="-1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: chevron-down; ratio: 0.5"></a>
                    </div>
                </div>
            </div>
        </div>
<?php
		break;

	default:
	case 'show_default_div':
?>
		<div class="hikashop_product_quantity_div hikashop_product_quantity_default_div uk-button-group">
            <a class="hikashop_product_quantity_field_change_minus hikashop_product_quantity_field_change uk-button uk-button-default uk-padding-small uk-padding-remove-vertical" href="#" data-hk-qty-mod="-1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: minus; ratio: 0.7"></a>
			<input id="<?php echo $id; ?>" type="text" value="<?php echo $current_quantity; ?>" onfocus="this.select()" class="hikashop_product_quantity_field" name="<?php echo $quantity_fieldname; ?>" data-hk-qty-old="<?php echo $current_quantity; ?>" data-hk-qty-min="<?php echo $min_quantity; ?>" data-hk-qty-max="<?php echo $max_quantity; ?>"<?php echo $extra_data_attribute; ?> onchange="<?php echo $script; ?>" <?php echo $extra_data; ?> />
            <a class="hikashop_product_quantity_field_change_plus hikashop_product_quantity_field_change uk-button uk-button-default uk-padding-small uk-padding-remove-vertical" href="#" data-hk-qty-mod="1" onclick="<?php echo $increment_script; ?>" data-uk-icon="icon: plus; ratio: 0.7"></a>
		</div>
<?php
		break;
}

if($in_cart && !in_array($quantityLayout, array('show_none','show_select','show_select_price'))) {
?>
		<div class="hikashop_cart_product_quantity_refresh">
			<a class="hikashop_no_print" href="#" onclick="var input = document.getElementById('<?php echo $id; ?>'); if(input.value == <?php echo (int)$current_quantity; ?> || (input.form.onsubmit && !input.form.onsubmit())) return; if(input.form.task){ input.form.task.value = 'apply'; } input.form.submit();" title="<?php echo JText::_('HIKA_REFRESH'); ?>">
				<i class="fa fa-sync"></i>
			</a>
		</div>
<?php
}
