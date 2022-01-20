<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('JPATH_BASE') or die;

jimport('jollyany.framework.helper');

JFormHelper::loadFieldClass('list');

/**
 * Modules Position field.
 *
 * @since  3.4.2
 */
class JFormFieldJollyanyPreset extends JFormFieldList {

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.4.2
	 */
	protected $type = 'JollyanyPreset';
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
		$presets    =   JollyanyFrameworkHelper::getPresets();
		$html[]     =   '<div class="row mt-4">';
		$colors     =   ['#ffcdd2','#e1bee7','#bbdefb','#b2dfdb','#ffcc80'];

		for ($i = 0; $i<count($presets); $i++) {
			$preset     =   $presets[$i];
			$arrName        =   explode(' ',$preset['title']);
			$avaName        =   '';
			for ($j=0; $j<count($arrName) && $j<3; $j++){
				if ($word = trim($arrName[$j])) {
					$avaName.=$word[0];
				}
			}
			$thumbnail  =   '<div class="jollyany_placeholder" style="background-color: '.$colors[rand(0,4)].';">'.$avaName.'</div>';
            if (!empty($preset['thumbnail'])) {
				$thumbnail  =   '<div class="jollyany_placeholder" style="background-image: url('.$preset['thumbnail'].');"></div>';
			}
			$demo       =   '';
			if (!empty($preset['demo'])) {
			    $demo   =   ' <a href="'.$preset['demo'].'" target="_blank" class="btn btn-secondary">'.JText::_('JOLLYANY_LIVE_PREVIEW').'</a>';
            }
			$html[]     =   '<div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-4">';
			$html[]     =   '<div class="card jollyany-preset"><button type="button" class="close jollyany-del-preset" aria-label="Close" data-token="'.JSession::getFormToken().'" data-name="'.$preset['name'].'"><span aria-hidden="true">&times;</span></button>'.$thumbnail.'<div class="card-body">';
			$html[]     =   '<h5 class="card-title">'.$preset['title'].'</h5>';
			$html[]     =   !empty($preset['desc']) ? '<p class="card-text">'.$preset['desc'].'</p>' : '';
			$html[]     =   '<a href="#" class="btn btn-primary jollyany-load-preset" data-token="'.JSession::getFormToken().'" data-name="'.$preset['name'].'">'.JText::_('JOLLYANY_LOAD_PRESET').'</a>'.$demo;
			$html[]     =   '</div></div>';
			$html[]     =   '</div>';
		}
		$html[]     =   '<div class="col-12 col-md-6 col-xl-4 col-xxl-3 mb-4">';
		$html[]     =   '<div class="card jollyany-create-preset"><div class="card-header">Create Preset</div><div class="card-body">';
		$html[]     =   '<div class="form-group"><label for="jollyany-preset-name">Title</label><input type="text" name="jollyany-preset-name" class="form-control" id="jollyany-preset-name" placeholder="Name of Preset"></div>';
		$html[]     =   '<div class="form-group"><label for="jollyany-preset-desc">Description</label><textarea class="form-control" name="jollyany-preset-desc" id="jollyany-preset-desc" rows="3"></textarea></div>';
		$html[]     =   '<input type="hidden" name="jollyany-preset" id="jollyany-preset" rows="3">';
		$html[]     =   '<input type="hidden" name="jollyany-template" id="jollyany-template" rows="3">';
		$html[]     =   '<a href="#" class="btn btn-primary" id="jollyany-save-preset">'.JText::_('JOLLYANY_SAVE_PRESET').'</a>';
		$html[]     =   '</div></div>';
		$html[]     =   '</div>';
		$html[]     =   '</div>';

		return implode($html);
	}

	/**
	 * Get template information
	 * @return object|null
	 */
	protected function getTemplateInfo() {
		$input = JFactory::getApplication()->input;
		if($input->getCmd('option') == 'com_ajax' && $input->getCmd('astroid') == 'manager'){
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$id = $input->getInt('id');

			$query
				->select('*')
				->from('#__template_styles')
				->where('id='.(int)$id);

			$db->setQuery($query);
			return $db->loadObject();
		} else {
			return null;
		}
	}
}