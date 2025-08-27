<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('JPATH_BASE') or die;

use Joomla\CMS\Form\Field\ListField;
use Jollyany\Helper as JollyanyFrameworkHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;

/**
 * Modules Position field.
 *
 * @since  3.4.2
 */
class JFormFieldJollyanyExts extends ListField {

    /**
     * The form field type.
     *
     * @var    string
     * @since  3.4.2
     */
    protected $type = 'JollyanyExts';

    private $replacer   =   [
            'tz_fashion'   => 'tz_fashion_semona_joomla',
            'tz_everline'  => 'tz_everline_joomla',
            'tz_eventory'  => 'tz_eventory_joomla',
            'tz_charity'   => 'tz_charity_joomla',
            'tz_foodz'     => 'tz_foodz_joomla',
            'tz_profiler'  => 'profiler-joomla-template',
        ];
    private $exts       =   [
        'sp-page-builder' => array(
			'element'   =>  'com_sppagebuilder',
			'type'      =>  'component',
			'folder'    =>  '',
        ),
        'tz-portfolio'  => array(
	        'element'   =>  'com_tz_portfolio_plus',
	        'type'      =>  'component',
	        'folder'    =>  '',
        ),
        'hikashop'      => array(
	        'element'   =>  'com_hikashop',
	        'type'      =>  'component',
	        'folder'    =>  '',
        ),
	    'uk-sp-addons'  => array(
		    'element'   =>  'jollyany',
		    'type'      =>  'plugin',
		    'folder'    =>  'sppagebuilder',
	    ),
    ];

    protected function getInput() {
        $html       =   array();
        $lictext    =   JollyanyFrameworkHelper::getLicense();

        $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);

        $activated  =   0;
        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
            $activated  =   1;
        }

        $templates  =   \Jollyany\Framework::getDataImport()->getData();
        $template   =   \Astroid\Framework::getTemplate();
        $key_name   =   $template->template;
        if (isset($this->replacer[$key_name])) {
            $key_name = $this->replacer[$key_name];
        }
        if (!isset($templates[$key_name]['extensions']) || !count($templates[$key_name]['extensions'])) {
            return Text::_('JOLLYANY_DATA_NO_EXTENSIONS');
        }
        $exts       =   $templates[$key_name]['extensions'];
        $html[]     =   '<div class="row g-3 g-lg-4">';
        foreach ($exts as $ext) {
            $data   =  '<div class="col-12 col-md-6 col-lg-6 col-xl-4">';
            $data   .=  '<div class="card '.$ext['ext_code'].'">';
            $data   .=  '<img data-src="'.Uri::root(true).'/media/jollyany/assets/images/extensions/'.$ext['ext_code'].'.jpg" data-width="600" data-height="256" class="card-img-top" alt="'.$ext['name'].'" data-uk-img />';
            $data   .=  '<div class="card-body"><h5 class="card-title">'.$ext['name'].'</h5>';
            if (isset($this->exts[$ext['ext_code']])) {
                $current_version    =   JollyanyFrameworkHelper::getExtVersion($this->exts[$ext['ext_code']]['element'], $this->exts[$ext['ext_code']]['type'], $this->exts[$ext['ext_code']]['folder']);
                $data    .=   '<p class="card-text form-text version">'. ($current_version ? Text::_('JOLLYANY_CURRENT_VERSION') . ': ' . $current_version : Text::_('JOLLYANY_EXT_NOT_INSTALLED'))  .'</p>';
            }
            $data   .=  '<div class="btn-group" role="group" aria-label="Install Action"><a href="#" class="btn btn-primary intall-extension btn-sm" data-token="'.Session::getFormToken().'" data-name="'.$ext['name'].'" data-file="'.$ext['ext_code'].'" data-status="'.$activated.'">'.Text::_('JOLLYANY_ACTION_INSTALL_EXT').'</a></div></div>';
            $data   .=  '</div>';
            $data   .=  '</div>';
            $html[] =   $data;
        }
        $html[]     =   '</div>';
        $html[]     .=  '<div class="modal fade" id="install-ext-dialog" tabindex="-1" role="dialog" aria-labelledby="Extension Install" aria-hidden="true"></div>';
        $html[]     .=  '<script id="jollyany-dialog-extension" type="text/template"><div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="install-extension-title">'.Text::_('JOLLYANY_ACTION_DIALOG_EXTENSION_TITLE').' <strong class="extension-name">Package</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted">'.Text::_('JOLLYANY_ACTION_DIALOG_EXTENSION_TITLE_DESC').'<strong class="extension-name"></strong></p>
		<div class="dialogDebug mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'.Text::_('JCANCEL').'</button>
        <button type="button" class="btn btn-primary install-action" data-token="'.Session::getFormToken().'" data-file="">'.Text::_('JOLLYANY_ACTION_INSTALL_PACKAGE').'</button>
      </div>
    </div>
  </div></script>';

        return implode($html);
    }
}
