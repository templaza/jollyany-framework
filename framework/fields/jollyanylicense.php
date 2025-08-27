<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('JPATH_BASE') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;
use Jollyany\Helper as JollyanyFrameworkHelper;
use Joomla\CMS\Table\Extension;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;

/**
 * Modules Position field.
 *
 * @since  3.4.2
 */
class JFormFieldJollyanyLicense extends ListField {

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
	    $jollyany   =   PluginHelper::getPlugin('system', 'jollyany');
	    $params     =   new Registry($jollyany->params);
	    $lictext    =   JollyanyFrameworkHelper::getLicense();
	    $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
        $totaltemp  =   \Jollyany\Framework::getDataImport()->getTotalTemplate();
        $template   =   \Astroid\Framework::getTemplate();
        $preview_img=   file_exists(JPATH_SITE. '/media/templates/site/' . $template->template . '/images/template_preview.png') ? Uri::root().'media/templates/site/'.$template->template.'/images/template_preview.png' : Uri::root().'templates/'.$template->template.'/template_preview.png';

        $html[]     =   '<div class="card-group">';
        $html[]     =   '<div class="card template-info"><img src="'.$preview_img.'" class="card-img-top" alt="'.$template->template.'" />';

        $html[]     =   '<div class="card-body">';
        $html[]     =   '<h6 class="card-subtitle mb-2 text-muted">You are using: Version <strong>'.$template->version.'</strong></h6>';
        $html[]     =   '<h5 class="card-title">'.Text::_($template->template).'</h5>';
        $html[]     =   '<div class="card-text form-text">'.Text::_(preg_replace('/tz_/i', 'tpl_', $template->template).'_desc').'</div>';
        $html[]     =   '</div>';

        $html[]     =   '<ul class="list-group list-group-flush">';
        $html[]     =   '<li class="list-group-item"><a href="https://docs.jollyany.co/getting-started/how-to-download-templates" target="_blank">How to download Quickstart & Template?</a></li>';
        $html[]     =   '<li class="list-group-item"><a href="https://docs.jollyany.co/getting-started/template-installation" target="_blank">How to install template?</a></li>';
        $html[]     =   '<li class="list-group-item"><a href="https://docs.jollyany.co/getting-started/update-template-and-3rd-party-extension" target="_blank">How to update extensions?</a></li>';
        $html[]     =   '</ul>';

        $html[]     =   '</div>';

        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
            $html[]     =   '<div class="card"><div class="card-header">';
	        $license->support_expired    = strtotime( $license->supported_until ) < time();
	        self::$license = $license;
	        $html[]     =   '<h5 class="m-0">'.Text::_('JOLLYANY_LICENSE_ACTIVATED').'</h5>';

	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush">';
	        $html[]     =   '<li class="list-group-item"><p class="card-text form-text mt-0">'.Text::_('JOLLYANY_WELCOME_DESC'). ' '.Text::_ ('JOLLYANY_WELCOME_PREMIUM').'</p></li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_BUYER').':</strong> '.$license->buyer.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_DOMAIN').':</strong> '.$license->domain.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_PURCHASE_CODE').':</strong> '.$license->purchase_code.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_LICENCE_TYPE').':</strong> '.$license->license_type.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_PURCHASE_DATE').':</strong> '.$license->purchase_date.'</li>';
	        $html[]     =   '<li class="list-group-item"><strong>'.Text::_('JOLLYANY_ACTIVATE_SUPPORTED_UNTIL').':</strong> ';
	        if ($license->support_expired) {
		        $html[]     =   $license->supported_until.' <span class="badge badge-danger">Your support is expired!</span> <a href="https://1.envato.market/zODvW" target="_blank"><strong>click here to renew your license</strong></a> and re-activate your package.';
	        } else {
		        $html[]     =   $license->supported_until.' <span class="badge badge-success">Supported '.round((strtotime($license->supported_until)-time())/86400).' days left</span>';
	        }
	        $html[]     =   '</li>';
	        $html[]     =   '</ul>';
	        $html[]     =   '<div class="card-body license-action-buttons"><a href="#" id="jollyany-theme-activate" class="btn btn-primary"><i class="fas fa-sync-alt"></i> '.Text::_('JOLLYANY_WELCOME_REACTIVE_PRODUCT').'</a> <button type="button" class="btn btn-danger delete-template-activation" data-token="'.Session::getFormToken().'"><i class="fas fa-times"></i> '.Text::_('JOLLYANY_ACTIVATE_DELETE_ACTIVATION').'</button></div>';
	        $html[]     =   '</div>';
	        $html[]     =   '</div>';

            $html[]     =   '<div class="card-group mt-4">
    <div class="card">
      <div class="card-body">
        <div class="card-img-top display-4 text-success"><i class="far fa-smile-beam"></i></div>
        <h6 class="card-title">I am satisfied with this template</h6>
        <p class="card-text form-text">Thank you very much! If you love our service please help us rate/review for Jollyany on <a href="https://themeforest.net/item/jollyany-responsive-multipurpose-joomla-template/8596818" target="_blank" rel="nofollow">Themeforest</a></p>
        <a href="https://themeforest.net/item/jollyany-responsive-multipurpose-joomla-template/8596818" target="_blank" rel="nofollow" class="btn btn-sm btn-as btn-success">Rate for Jollyany</a>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="card-img-top display-4 text-danger"><i class="far fa-tired"></i></div>
        <h6 class="card-title">I\'m not satisfied with this stupid template</h6>
        <p class="card-text form-text">I am sorry for this inconvenience. You can ask a support on our <a href="https://www.templaza.com/forums.html" target="_blank" rel="nofollow">forum</a> or <a href="https://themeforest.net/refund_requests/new" target="_blank" rel="nofollow">Request a full refund</a> no hassles, no questions asked!</p>
        <a href="https://www.templaza.com/forums.html" target="_blank" rel="nofollow" class="btn btn-sm btn-as btn-info">Ask a question</a> <a href="https://themeforest.net/refund_requests/new" target="_blank" rel="nofollow" class="btn btn-sm btn-as btn-danger">Request a Refund</a>
      </div>
    </div>
</div>';
            $html[]     =   '<blockquote class="blockquote text-center mt-4">
  <p>I\'m not here to save the world. For now, your heart is enough. (^_^")</p>
  <footer class="blockquote-footer">Sonny in <cite title="Source Title">TemPlaza.com</cite></footer>
</blockquote>';
        } else {
            $html[]     =   '<div class="card"><div class="card-body">';
            $html[]     =   '<h3>'.Text::_('JOLLYANY_OPTIONS_PACKAGE').'</h3>';
            $html[]     =   '<p class="form-text">'.Text::_('JOLLYANY_WELCOME_FREE_DESC').'</p><hr />';
	        $html[]     =   '<div class="card"><div class="card-body">';
	        $html[]     =   '<h5 class="card-title">'.Text::_('JOLLYANY_BENEFIT').'</h5>';
	        $html[]     =   '<h6 class="card-subtitle mb-2 text-muted">Paid only once</h6>';
	        $html[]     =   '<h3><small class="text-muted"><del>$1280</del></small> <strong>$79</strong></h3>';

	        $html[]     =   '<p class="card-text form-text">If you haven\'t purchased Jollyany, <a href="https://1.envato.market/jollyany-multipurpose-joomla-template" target="_blank"><strong>click here to buy a license</strong></a> and activate template.</p>';
	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush form-text">';
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
	        $html[]     =   '<div class="card-body"><a class="btn btn-sm btn-as btn-as-primary" href="https://1.envato.market/jollyany-multipurpose-joomla-template" target="_blank"><i class="fas fa-shopping-cart"></i> Click here to buy a License</a></div>';
	        $html[]     =   '</div>';
	        $html[]     =   '<div class="card mt-3"><div class="card-body">';
	        $html[]     =   '<h5 class="card-title">'.Text::_('JOLLYANY_WELCOME_TEMPLATE_ACTIVATION').'</h5>';
            $html[]     =   '<p class="card-text form-text">'.Text::_('JOLLYANY_WELCOME_TEMPLATE_ACTIVATION_DESC').'</p>';
	        $html[]     =   '</div>';
	        $html[]     =   '<ul class="list-group list-group-flush form-text"><li class="list-group-item">'.Text::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP1').'</li><li class="list-group-item">'.Text::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP2').'</li><li class="list-group-item">'.Text::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP3').'</li><li class="list-group-item">'.Text::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT_STEP4').'</li></ul>';
	        $html[]     =   '<div class="card-body"><a href="#" id="jollyany-theme-activate" class="btn btn-sm btn-as btn-success"><i class="fas fa-hand-pointer"></i> '.Text::_('JOLLYANY_WELCOME_ACTIVE_PRODUCT').'</a></div>';
	        $html[]     =   '</div>';
	        $html[]     =   '</div>';
	        $html[]     =   '</div></div>';
        }

        $key        =   $params->get('secret_key','');
        if (!$key) {
            $key = md5(uniqid('Jollyany', true));
            $table = new Extension();
            $params->set('secret_key', $key);
            $table->load($jollyany->id);
            $table->params = $params->toString();
            $table->store();
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
            'url'      => Uri::root(),

            // URL to return back data
            'callback_url'      => Uri::root().'index.php?option=com_ajax&jollyany=activation&key='.$key
        ) );
        $html[]     =   '<script id="jollyany-form-data-json" type="text/template">'.$javascript.'</script>';
        return implode($html);
    }
}