<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;
jimport('astroid.framework.template');
jimport('jollyany.framework.helper');
jimport('astroid.framework.element');

class JollyanyFrameworkTemplate extends AstroidFrameworkTemplate{
    public $id;
	public function __construct($template) {
		parent::__construct($template);
		$this->id   =   $template->id;
	}

	/**
	 * Get Preset data
	 * @return array
	 */
	public function getPresets() {
		$presets_path = JPATH_SITE . "/templates/{$this->template}/astroid/presets/";
		if (!file_exists($presets_path)) {
			return [];
		}
		$files = array_filter(glob($presets_path . '/' . '*.json'), 'is_file');
		$presets = [];
		foreach ($files as $file) {
			$json = file_get_contents($file);
			$data = \json_decode($json, true);
			$preset = ['title' => pathinfo($file)['filename'], 'colors' => [], 'preset' => [], 'thumbnail' => '', 'name' => pathinfo($file)['filename']];
			if (isset($data['title']) && !empty($data['title'])) {
				$preset['title'] = \JText::_($data['title']);
			}
			if (isset($data['thumbnail']) && !empty($data['thumbnail'])) {
				$preset['thumbnail'] = \JURI::root() . 'templates/' . $this->template . '/' . $data['thumbnail'];
			}
			if (isset($data['colors'])) {
				$colors = [];
				$properties = [];
				foreach ($data['colors'] as $prop => $color) {
					if (is_array($color)) {
						foreach ($color as $subprop => $color2) {
							if (!empty($color2)) {
								$properties[$prop][$subprop] = $color2;
								$colors[] = $color;
							}
						}
					} else {
						if (!empty($color)) {
							$properties[$prop] = $color;
							$colors[] = $color;
						}
					}
				}
				$colors = array_keys(array_count_values($colors));
				$preset['colors'] = array_unique($colors);
				$preset['preset'] = $properties;
			}
			$presets[] = $preset;
		}
		return $presets;
	}
}