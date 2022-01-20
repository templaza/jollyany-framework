<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('JPATH_BASE') or die;

jimport('jollyany.framework.helper');
jimport('jollyany.framework.importer.data');

JFormHelper::loadFieldClass('list');

/**
 * Modules Position field.
 *
 * @since  3.4.2
 */
class JFormFieldJollyanyLicense extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.4.2
     */
    protected $type = 'JollyanyLicense';
    /**
     *    Current activated license
     */
    private static $license;

    /**
     *    Laborator API Server URL
     */
    public static $api_server = 'https://www.templaza.com';

    protected function getInput() {
        $html       =   array();
	    $jollyany   =   \JPluginHelper::getPlugin('system', 'jollyany');
	    $params     =   new \JRegistry($jollyany->params);
	    $lictext    =   JollyanyFrameworkHelper::getLicense();
	    $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
        $totaltemp  =   JollyanyFrameworkDataImport::getTotalTemplate();
        $template   =   Astroid\Framework::getTemplate();

        $html[]     =   '<div class="row mt-4">';
        $html[]     =   '<div class="col-12 col-xl-4 col-xxl-5 mb-4">';
        $html[]     =   '<div class="card"><img src="'.JUri::root().'templates/'.$template->template.'/template_preview.png" class="card-img-top" alt="'.$template->template.'" /><div class="card-body">';
        $html[]     =   '<h6 class="card-subtitle mb-2 text-muted">You are using: Version <strong>'.$template->version.'</strong></h6>';
        $html[]     =   '<h5 class="card-title">'.JText::_($template->template).'</h5>';
        $html[]     =   '<div class="card-text">'.JText::_(preg_replace('/tz_/i', 'tpl_', $template->template).'_desc').'</div>';
        $html[]     =   '</div></div>';
        $html[]     =   '</div>';
        $html[]     =   '<div class="col-12 col-xl-8 col-xxl-7 license-info">';
	    $html[]     =   '<div class="card"><div class="card-body">';
        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
	        $license->support_expired    = strtotime( $license->supported_until ) < time();
	        self::$license = $license;
	        $html[]     =   '<h3 class="card-title">'.JText::_('JOLLYANY_LICENSE_ACTIVATED').'</h3>';
	        $html[]     =   '<p class="card-text">'.JText::_('JOLLYANY_WELCOME_DESC'). ' '.JText::_ ('JOLLYANY_WELCOME_PREMIUM').'</p>';
	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush">';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_BUYER').':</strong> '.$license->buyer.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_DOMAIN').':</strong> '.$license->domain.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_PURCHASE_CODE').':</strong> '.$license->purchase_code.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_LICENCE_TYPE').':</strong> '.$license->license_type.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_PURCHASE_DATE').':</strong> '.$license->purchase_date.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.JText::_('JOLLYANY_ACTIVATE_SUPPORTED_UNTIL').':</strong> ';
	        if ($license->support_expired) {
		        $html[]     =   $license->supported_until.' <span class="badge badge-danger">Your support is expired!</span> <a href="https://1.envato.market/zODvW" target="_blank"><strong>click here to renew your license</strong></a> and re-activate your package.';
	        } else {
		        $html[]     =   $license->supported_until.' <span class="badge badge-success">Supported '.round((strtotime($license->supported_until)-time())/86400).' days left</span>';
	        }
	        $html[]     =   '</li>';
	        $html[]     =   '</ul>';
	        $html[]     =   '<div class="card-body license-action-buttons"><a href="#" id="jollyany-theme-activate" class="btn btn-primary"><i class="fas fa-sync-alt"></i> '.JText::_('JOLLYANY_WELCOME_REACTIVE_PRODUCT').'</a> <button type="button" class="btn btn-danger delete-template-activation" data-token="'.JSession::getFormToken().'"><i class="fas fa-times"></i> '.JText::_('JOLLYANY_ACTIVATE_DELETE_ACTIVATION').'</button></div>';
	        $html[]     =   '</div>';
            $html[]     =   '<div class="row mt-4">
  <div class="col-sm-6">
    <div class="card h-100">
      <div class="card-body">
        <div class="card-img-top display-4 text-success"><i class="far fa-smile-beam"></i></div>
        <h5 class="card-title">I am satisfied with this template</h5>
        <p class="card-text">Thank you very much! If you love our service please help us rate/review for Jollyany on <a href="https://themeforest.net/item/jollyany-responsive-multipurpose-joomla-template/8596818" target="_blank" rel="nofollow">Themeforest</a></p>
        <a href="https://themeforest.net/item/jollyany-responsive-multipurpose-joomla-template/8596818" target="_blank" rel="nofollow" class="btn btn-success">Rate for Jollyany</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card h-100">
      <div class="card-body">
        <div class="card-img-top display-4 text-danger"><i class="far fa-tired"></i></div>
        <h5 class="card-title">I\'m not satisfied with this stupid template</h5>
        <p class="card-text">I am sorry for this inconvenience. You can ask a support on our <a href="https://www.templaza.com/forums.html" target="_blank" rel="nofollow">forum</a> or <a href="https://themeforest.net/refund_requests/new" target="_blank" rel="nofollow">Request a full refund</a> no hassles, no questions asked!</p>
        <a href="https://www.templaza.com/forums.html" target="_blank" rel="nofollow" class="btn btn-info">Ask a question</a> <a href="https://themeforest.net/refund_requests/new" target="_blank" rel="nofollow" class="btn btn-danger">Request a Refund</a>
      </div>
    </div>
  </div>
</div>';
            $html[]     =   '<blockquote class="blockquote text-center mt-4">
  <p class="mb-0">I\'m not here to save the world. For now, your heart is enough. (^_^")</p>
  <footer class="blockquote-footer">Sonny in <cite title="Source Title">TemPlaza.com</cite></footer>
</blockquote>';
        } else {
            $html[]     =   '<h3>'.JText::_('JOLLYANY_OPTIONS_PACKAGE').'</h3>';
            $html[]     =   '<p>'.JText::_('JOLLYANY_WELCOME_FREE_DESC').'</p><hr />';
	        $html[]     =   '<div class="row">';
	        $html[]     =   '<div class="col-12 col-sm-6">';
	        $html[]     =   '<div class="card card-highlight"><div class="card-body">';
	        $html[]     =   '<h4 class="card-title">'.JText::_('JOLLYANY_BENEFIT').'</h4>';
	        $html[]     =   '<h6 class="card-subtitle mb-2 text-muted">Paid only once</h6>';
	        $html[]     =   '<h3><small class="text-muted"><del>$1089</del></small> <strong>$59</strong></h3>';

	        $html[]     =   '<p class="card-text">If you haven\'t purchased Jollyany, <a href="https://1.envato.market/jollyany-multipurpose-joomla-template" target="_blank"><strong>click here to buy a license</strong></a> and activate template.</p>';
	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush">';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;All Jollyany templates</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;'.$totaltemp.'+ Joomla Templates</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;6 Months Support</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;Lifetime Usage</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;Lifetime Update in 1 valid domain</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;Copyright removal</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;40% Renewal Discount</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;SP Page Builder Pro Included</li>';
	        $html[]     =   '<li class="list-group-item"><i class="fas fa-check"></i>&nbsp;&nbsp;TZ Portfolio Pro Personal License</li>';
	        $html[]     =   '</ul>';
	        $html[]     =   '<div class="card-body"><a class="btn btn-primary" href="https://1.envato.market/jollyany-multipurpose-joomla-template" target="_blank"><i class="fas fa-shopping-cart"></i> Click here to buy a License</a></div>';
	        $html[]     =   '</div>';
	        $html[]     =   '</div>';
	        $html[]     =   '<div class="col-12 col-sm-6">';
	        $html[]     =   '<div class="card"><div class="card-body">';
	        $html[]     =   '<h4 class="card-title">'.JText::_('JOLLYANY_WELCOME_TEMPLATE_ACTIVATION').'</h4>';
            $html[]     =   '<p class="card-text">'.JText::_('JOLLYANY_WELCOME_TEMPLATE_ACTIVATION_DESC').'</p>';
	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush"><li class="list-group-item">'.JText::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP1').'</li><li class="list-group-item">'.JText::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP2').'</li><li class="list-group-item">'.JText::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP3').'</li><li class="list-group-item">'.JText::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP4').'</li></ul>';
	        $html[]     =   '<div class="card-body"><a href="#" id="jollyany-theme-activate" class="btn btn-success"><i class="fas fa-hand-pointer"></i> '.JText::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT').'</a></div>';
	        $html[]     =   '</div>';
            $html[]     =   '</div>';
	        $html[]     =   '</div>';
	        $html[]     =   '</div></div>';
        }

	    $html[]     =   '</div>';
	    $html[]     =   '</div>';
        $key        =   $params->get('secret_key','');
        if (!$key) {
            $key            =   md5(uniqid('Jollyany'));
            $table          =   JTable::getInstance('extension');
            $params->set('secret_key', $key);
            $table->load($jollyany->id);
            $table->save(array('params' => $params->toString()));
        }

        $javascript =   json_encode( array(
            // Request product activation
            'action'   => 'activate-product',

            // Jollyany API site url to go for activation
            'api'      => self::$api_server,

            // Jollyany Itemid
            'envatoid' => (string)$this->element['envatoid'],

            // Jollyany Itemid
            'productname' => (string)$this->element['productname'],

            // URL to activate license for
            'url'      => \JUri::root(),

            // URL to return back data
            'callback_url'      => \JUri::root().'index.php?option=com_ajax&jollyany=activation&key='.$key
        ) );
        $html[]     =   '<script id="jollyany-form-data-json" type="text/template">'.$javascript.'</script>';
        return implode($html);
    }
}