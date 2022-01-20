<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die('Restricted access');
?>
<!-- CODE -->
<?php
$show_code  =   $this->params->get('jollyany_hikashop_show_product_code', '');
if ($show_code == '') {
    $show_code  =   $this->config->get('show_code');
}
if ($show_code) { ?>
    <span class='hikashop_product_code_list uk-text-meta'>
        <?php echo $this->row->product_code; ?>
    </span>
<?php } ?>
<!-- EO CODE -->
