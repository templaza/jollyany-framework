<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2022 TemPlaza.
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
class JFormFieldJollyanyImport extends JFormFieldList {

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.4.2
	 */
	protected $type = 'JollyanyImport';

	protected function getInput() {
		$html       =   array();
		$lictext    =   JollyanyFrameworkHelper::getLicense();

		$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
        $config     =   \JFactory::getConfig();
		$activated  =   0;
		if ( is_object( $license ) && isset( $license->purchase_code ) ) {
			$activated  =   1;
		}
		$templates  =   JollyanyFrameworkDataImport::getData();
		$html[]     =   '<div class="row g-3 g-lg-4">';
		foreach ($templates as $index => $value) {
			$status     =   $value['category'] == 'comingsoon' ? ' tabindex="-1" aria-disabled="true"' : '';
			$clsstatus  =   $value['category'] == 'comingsoon' ? ' disabled' : '';
			$comingsoon =   $value['category'] == 'comingsoon' ? '_COMINGSOON' : '';
			$tpl_code   =   JollyanyFrameworkDataImport::getConvertCode($index);
            $current_version    =   JollyanyFrameworkHelper::getExtVersion($tpl_code);
			$data   =  '<div class="col-12 col-md-6 col-lg-6">';
			$data   .=  '<div class="card '.$tpl_code.'">';
			$data   .=  '<img data-src="'.$value['thumb'].'" data-width="590" data-height="555" class="card-img-top" alt="'.$value['name'].'" data-uk-img />';
			$data   .=  '<div class="card-body"><h6 class="card-title">'.$value['name'].($current_version ? ' <span class="badge rounded-pill text-bg-primary">'.JText::_('JOLLYANY_INSTALLED_VERSION') . ': '.$current_version.'</span>' : '').'</h6><p class="card-text form-text">'.$value['desc'].'</p><div class="btn-group" role="group" aria-label="Install Action"><a href="#" class="btn btn-sm btn-as btn-primary intall-package'.$clsstatus.'"  data-token="'.JSession::getFormToken().'" data-name="'.$value['name'].'" data-file="'.$index.'" data-status="'.$activated.'"'.$status.'>'.JText::_('JOLLYANY_ACTION_INSTALL_PACKAGE'.$comingsoon).'</a><a href="'.$value['demo_url'].'" class="btn btn-as btn-outline-primary'.$clsstatus.'" target="_blank"'.$status.'>'.JText::_('JOLLYANY_ACTION_DEMO_URL').'</a><a href="https://www.templaza.com/download/joomla-templates.html" class="btn btn-sm btn-as btn-outline-primary'.$clsstatus.'" target="_blank"'.$status.'>'.JText::_('JOLLYANY_ACTION_DOWNLOAD_URL').'</a></div></div>';
			$data   .=  '</div>';
			$data   .=  '</div>';
			$html[] =   $data;
		}
		$html[]     .=  '</div>';
		$html[]     .=  '<div class="modal fade" id="install-package-dialog" tabindex="-1" role="dialog" aria-labelledby="Demo Content Package" aria-hidden="true"></div>';
		$html[]     .=  '<script id="jollyany-dialog-template" type="text/template"><div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="install-package-title">'.JText::_('JOLLYANY_ACTION_DIALOG_TITLE').' <strong class="package-name">Package</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted">'.JText::_('JOLLYANY_ACTION_DIALOG_TITLE_DESC').'</p>
        <div class="form-group form-check pl-4">
		  <input type="checkbox" class="form-check-input" id="template-package" checked>
		  <label class="form-check-label" for="template-package"><h5>'.JText::_('JOLLYANY_ACTION_DIALOG_TEMPLATE_INSTALL').'</h5><small class="text-muted">'.JText::_('JOLLYANY_ACTION_DIALOG_TEMPLATE_INSTALL_DESC').'</small></label>
		</div>
		<hr />
		<h5>'.JText::_('JOLLYANY_ACTION_DIALOG_EXTENSION_INSTALL').'</h5><small class="text-muted">'.JText::_('JOLLYANY_ACTION_DIALOG_EXTENSION_INSTALL_DESC').'</small>
		<div class="extensions-container"></div>
		<hr />
		<h5>'.JText::_('JOLLYANY_ACTION_DIALOG_QUICKSTART_DATA_INSTALL').'</h5>
		<p class="text-lead">'.JText::_('JOLLYANY_ACTION_DIALOG_QUICKSTART_DATA_INSTALL_DESC').'</p>
		<div class="db_info card bg-light mb-2" style="display: none;">
           <div class="card-body">
             <h5 class="card-title">Your database information</h5>
             <p class="card-text">This is your database information. Please save it in a safe place. <mark>You will need it when installing Quickstart.</mark></p>
             <ul class="list-unstyled m-0">
               <li><strong>Host Name:</strong> <mark>'.$config->get('host').'</mark></li>
               <li><strong>Database Name:</strong> <mark>'.$config->get('db').'</mark></li>
               <li><strong>Username:</strong> <mark>'.$config->get('user').'</mark></li>
               <li><strong>Password:</strong> <mark>'.$config->get('password').'</mark></li>
             </ul>
           </div>
        </div>
		<div class="form-group form-check pl-4 border-0">
		  <input type="checkbox" class="form-check-input" id="demo-data-package">
		  <label class="form-check-label" for="demo-data-package">
              <h5>'.JText::_('JOLLYANY_ACTION_DIALOG_DATA_INSTALL').'</h5>
              <p class="text-lead text-danger">'.JText::_('JOLLYANY_ACTION_DIALOG_DATA_INSTALL_DESC').'</p>
		  </label>
		</div>
		<div class="dialogDebug mt-3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'.JText::_('JCANCEL').'</button>
        <button type="button" class="btn btn-primary install-action" data-token="'.JSession::getFormToken().'" data-file="">'.JText::_('JOLLYANY_ACTION_INSTALL_PACKAGE').'</button>
      </div>
    </div>
  </div></script>';
        $tzthumbs   =   array();
		if (count(JollyanyFrameworkDataImport::$cache['thumb'])) {
		    foreach (JollyanyFrameworkDataImport::$cache['thumb'] as $value) {
                $tzthumbs[]     =   "'$value'";
            }
        }
        $document = Astroid\Framework::getDocument();
        $document->addScriptDeclaration('var tzthumbs_cache = ['.implode(',', $tzthumbs).']; var tztoken = \''.JSession::getFormToken().'\';');
		return implode($html);
	}
}
