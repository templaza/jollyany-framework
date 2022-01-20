<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
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
class JFormFieldJollyanyExts extends JFormFieldList {

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
        'sp-page-builder' => 'com_sppagebuilder',
        'tz-portfolio' => 'com_tz_portfolio_plus',
        'hikashop' => 'com_hikashop',
    ];

    protected function getInput() {
        $html       =   array();
        $lictext    =   JollyanyFrameworkHelper::getLicense();

        $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);

        $activated  =   0;
        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
            $activated  =   1;
        }

        $templates  =   JollyanyFrameworkDataImport::getData();
        $template   =   Astroid\Framework::getTemplate();
        $key_name   =   $template->template;
        if (isset($this->replacer[$key_name])) {
            $key_name = $this->replacer[$key_name];
        }
        if (!isset($templates[$key_name]['extensions']) || !count($templates[$key_name]['extensions'])) {
            return JText::_('JOLLYANY_DATA_NO_EXTENSIONS');
        }
        $exts       =   $templates[$key_name]['extensions'];
        $html[]     =   '<div class="row mt-4">';
        foreach ($exts as $ext) {
            $data   =  '<div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-5">';
            $data   .=  '<div class="card '.$ext['ext_code'].'">';
            $data   .=  '<img data-src="'.JUri::root(true).'/media/jollyany/assets/images/extensions/'.$ext['ext_code'].'.jpg" data-width="600" data-height="256" class="card-img-top" alt="'.$ext['name'].'" data-uk-img />';
            $data   .=  '<div class="card-body"><h4 class="card-title">'.$ext['name'].'</h4>';
            if (isset($this->exts[$ext['ext_code']])) {
                $current_version    =   JollyanyFrameworkHelper::getExtVersion($this->exts[$ext['ext_code']]);
                $data    .=   '<p class="card-text version">'. ($current_version ? JText::_('JOLLYANY_CURRENT_VERSION') . ': ' . $current_version : JText::_('JOLLYANY_EXT_NOT_INSTALLED'))  .'</p>';
            }
            $data   .=  '<div class="btn-group" role="group" aria-label="Install Action"><a href="#" class="btn btn-primary intall-extension btn-sm" data-token="'.JSession::getFormToken().'" data-name="'.$ext['name'].'" data-file="'.$ext['ext_code'].'" data-status="'.$activated.'">'.JText::_('JOLLYANY_ACTION_INSTALL_EXT').'</a></div></div>';
            $data   .=  '</div>';
            $data   .=  '</div>';
            $html[] =   $data;
        }
        $html[]     =   '</div>';
        $html[]     .=  '<div class="modal fade" id="install-ext-dialog" tabindex="-1" role="dialog" aria-labelledby="Extension Install" aria-hidden="true"></div>';
        $html[]     .=  '<script id="jollyany-dialog-extension" type="text/template"><div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="install-extension-title">'.JText::_('JOLLYANY_ACTION_DIALOG_EXTENSION_TITLE').' <strong class="extension-name">Package</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted">'.JText::_('JOLLYANY_ACTION_DIALOG_EXTENSION_TITLE_DESC').'<strong class="extension-name"></strong></p>
		<div class="dialogDebug mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.JText::_('JCANCEL').'</button>
        <button type="button" class="btn btn-primary install-action" data-token="'.JSession::getFormToken().'" data-file="">'.JText::_('JOLLYANY_ACTION_INSTALL_PACKAGE').'</button>
      </div>
    </div>
  </div></script>';

        return implode($html);
    }
}
