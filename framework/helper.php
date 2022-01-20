<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2019 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;
use Joomla\Archive\Archive;
\JLoader::import('joomla.filesystem.file');
\JLoader::import('joomla.filesystem.folder');
\JLoader::import('joomla.filesystem.path');
jimport('astroid.framework.helper');
use Astroid\Framework;
class JollyanyFrameworkHelper extends AstroidFrameworkHelper {

	/**
	 * Unserialize value only if it was serialized.
	 *
	 * @since 2.0.0
	 *
	 * @param string $original Maybe unserialized original, if is needed.
	 * @return mixed Unserialized data can be any type.
	 */
	public static function maybe_unserialize( $original ) {
		if ( self::is_serialized( $original ) ) { // don't attempt to unserialize data that wasn't serialized going in
			return @unserialize( $original );
		}
		return $original;
	}

	/**
	 * Serialize data, if needed.
	 *
	 * @since 2.0.5
	 *
	 * @param string|array|object $data Data that might be serialized.
	 * @return mixed A scalar data
	 */
	public static function maybe_serialize( $data ) {
		if ( is_array( $data ) || is_object( $data ) ) {
			return serialize( $data );
		}

		// Double serialization is required for backward compatibility.
		// See https://core.trac.wordpress.org/ticket/12930
		// Also the world will end. See WP 3.6.1.
		if ( self::is_serialized( $data, false ) ) {
			return serialize( $data );
		}

		return $data;
	}

	/**
	 * Check value to find if it was serialized.
	 *
	 * If $data is not an string, then returned value will always be false.
	 * Serialized data is always a string.
	 *
	 * @since 2.0.5
	 *
	 * @param string $data   Value to check to see if was serialized.
	 * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
	 * @return bool False if not serialized and true if it was.
	 */
	public static function is_serialized( $data, $strict = true ) {
		// if it isn't a string, it isn't serialized.
		if ( ! is_string( $data ) ) {
			return false;
		}
		$data = trim( $data );
		if ( 'N;' == $data ) {
			return true;
		}
		if ( strlen( $data ) < 4 ) {
			return false;
		}
		if ( ':' !== $data[1] ) {
			return false;
		}
		if ( $strict ) {
			$lastc = substr( $data, -1 );
			if ( ';' !== $lastc && '}' !== $lastc ) {
				return false;
			}
		} else {
			$semicolon = strpos( $data, ';' );
			$brace     = strpos( $data, '}' );
			// Either ; or } must exist.
			if ( false === $semicolon && false === $brace ) {
				return false;
			}
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 ) {
				return false;
			}
			if ( false !== $brace && $brace < 4 ) {
				return false;
			}
		}
		$token = $data[0];
		switch ( $token ) {
			case 's':
				if ( $strict ) {
					if ( '"' !== substr( $data, -2, 1 ) ) {
						return false;
					}
				} elseif ( false === strpos( $data, '"' ) ) {
					return false;
				}
			// or else fall through
			case 'a':
			case 'O':
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
			case 'b':
			case 'i':
			case 'd':
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		}
		return false;
	}

	/**
	 * Unpacks a file and verifies it as a Joomla element package
	 * Supports .gz .tar .tar.gz and .zip
	 *
	 * @param   string   $p_filename         The uploaded package filename or install directory
	 * @param   bool   $root         If true will extract file in root folder (use to install quickstart)
	 *
	 * @return  array  Array on success or boolean false on failure
	 *
	 * @since   3.1
	 */
	public static function unpack($p_filename, $root = false)
	{
		// Path to the archive
		$archivename = $p_filename;

		// Temporary folder to extract the archive into
		$tmpdir = uniqid('jollyany_');

		// Clean the paths to use for archive extraction
		if ($root) {
			$extractdir     =   \JPath::clean(JPATH_ROOT);
		} else {
			$extractdir     =   \JPath::clean(dirname($p_filename) . '/' . $tmpdir);
		}
		$archivename = \JPath::clean($archivename);

		// Do the unpacking of the archive
		try
		{
			$archive = new Archive(array('tmp_path' => \JFactory::getConfig()->get('tmp_path')));
			$extract = $archive->extract($archivename, $extractdir);
		}
		catch (\Exception $e)
		{
			return array(
				'extractdir'  => null,
				'packagefile' => $archivename,
			);
		}

		if (!$extract)
		{
			return array(
				'extractdir'  => null,
				'packagefile' => $archivename,
			);
		}

		/*
		 * Let's set the extraction directory and package file in the result array so we can
		 * cleanup everything properly later on.
		 */
		$retval['extractdir'] = $extractdir;
		$retval['packagefile'] = $archivename;

		/*
		 * Try to find the correct install directory.  In case the package is inside a
		 * subdirectory detect this and set the install directory to the correct path.
		 *
		 * List all the items in the installation directory.  If there is only one, and
		 * it is a folder, then we will set that folder to be the installation folder.
		 */
		$dirList = array_merge((array) \JFolder::files($extractdir, ''), (array) \JFolder::folders($extractdir, ''));

		if (count($dirList) === 1)
		{
			if (\JFolder::exists($extractdir . '/' . $dirList[0]))
			{
				$extractdir = \JPath::clean($extractdir . '/' . $dirList[0]);
			}
		}

		/*
		 * We have found the install directory so lets set it and then move on
		 * to detecting the extension type.
		 */
		$retval['dir'] = $extractdir;
		return $retval;
	}

	/**
	 * Install package from tmp folder
	 * @param string    $path  Path/url of archivefile
	 * @param array     $e_package unzip extension package
	 * @param string    $archivefile Source of archivefile
	 *
	 * @return array
	 */
	public static function installPackage($path, $e_package, $archivefile) {
		// Get an installer instance.
		$installer = JInstaller::getInstance();

		/*
		 * Check for a Joomla core package.
		 * To do this we need to set the source path to find the manifest (the same first step as JInstaller::install())
		 *
		 * This must be done before the unpacked check because JInstallerHelper::detectType() returns a boolean false since the manifest
		 * can't be found in the expected location.
		 */
		if (is_array($e_package) && isset($e_package['dir']) && is_dir($e_package['dir']))
		{
			$installer->setPath('source', $e_package['dir']);
		}

		// Was the package unpacked?
		if (!$e_package || !$e_package['type'])
		{
			JInstallerHelper::cleanupInstall($e_package['packagefile'], $e_package['extractdir']);
			return array(
				'status'    => false,
				'message'   => \JText::_('JOLLYANY_AJAX_ERROR_EXT_NOT_FOUND').' '.$path
			);
		}

		// Install the package.
		if (!$installer->install($e_package['dir']))
		{
			// There was an error installing the package.
			return array(
				'status'    => false,
				'message'   => \JText::_('JOLLYANY_AJAX_ERROR_CAN_NOT_INSTALL').' '.$path
			);
		}

		// Cleanup the install files.
		if (!is_file($e_package['packagefile']))
		{
			$e_package['packagefile'] = $archivefile . '/' . $e_package['packagefile'];
		}

		JInstallerHelper::cleanupInstall($e_package['packagefile'], $e_package['extractdir']);
		return array(
			'status'    => true,
			'message'   => \JText::_('JOLLYANY_AJAX_INSTALL_EXTENSION_SUCCESSFUL')
		);
	}

	/**
	 * Get license activation
	 * @return string
	 */
	public static function getLicense() {
		$lictext    =   '';
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		if (JFolder::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey')) {
			$key    =   JFolder::files(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey', '.txt', false, true);
			if (count($key)) {
				$lictext    =   file_get_contents($key[0]);
			}
		}
		if (!$lictext) {
			$jollyany   =   \JPluginHelper::getPlugin('system', 'jollyany');
			$params     =   new \JRegistry($jollyany->params);
			$lictext    =   $params->get('jollyany_license','');
		}
		return $lictext;
	}

	/**
	 * Get Preset data
	 * @return array
	 */
	public static function getPresets() {
		$template   =   Framework::getTemplate();
		$presets_path = JPATH_SITE . "/templates/{$template->template}/astroid/presets/";

		if (!file_exists($presets_path)) {
			return [];
		}
		$files = array_filter(glob($presets_path . '*.json'), 'is_file');
		$presets    =   [];
		foreach ($files as $file) {
			$json = file_get_contents($file);
			$data = \json_decode($json, true);
			$preset = ['title' => pathinfo($file)['filename'], 'desc' => '', 'thumbnail' => '', 'demo' => '', 'preset' => [], 'name' => pathinfo($file)['filename']];
			if (isset($data['title']) && !empty($data['title'])) {
				$preset['title'] = \JText::_($data['title']);
			}
			if (isset($data['desc'])) {
				$preset['desc'] = \JText::_($data['desc']);
			}
			if (isset($data['thumbnail']) && !empty($data['thumbnail'])) {
				$preset['thumbnail'] = \JURI::root() . 'templates/' . $template->template . '/' . $data['thumbnail'];
			}
			if (isset($data['demo'])) {
				$preset['demo'] = $data['demo'];
			}
			if (isset($data['preset'])) {
				$preset['preset'] = $data['preset'];
			}
			$presets[] = $preset;
		}
		return $presets;
	}

	public static function getExtVersion($element, $type = '') {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select(
                $db->quoteName('manifest_cache')
            )
            ->from($db->quoteName('#__extensions'))
            ->where(
                $db->quoteName('element') . ' = '.$db->quote($element)
            );
        if (!empty($type)) {
            $query->where($db->quoteName('type') . ' = '.$db->quote($type));
        }
        $db->setQuery($query);
        $result = $db->loadResult();
        if (!empty($result)) {
            $manifest   =   new \Joomla\Registry\Registry($result);
            return $manifest->get('version');
        }
    }

    public static function clearCache($template = '', $prefix = 'style')
    {
        $template_dir = JPATH_SITE . '/' . 'templates' . '/' . $template . '/' . 'css';
        $version = new \JVersion;
        $version->refreshMediaVersion();
        if (!file_exists($template_dir)) {
            throw new \Exception("Template not found.", 404);
        }

        if (is_array($prefix)) {
            foreach ($prefix as $pre) {
                $styles = preg_grep('~^' . $pre . '-.*\.(css)$~', scandir($template_dir));
                foreach ($styles as $style) {
                    $space_time    =   time() - filemtime($template_dir . '/' .$style);
                    if ($space_time > 86400) {
                        unlink($template_dir . '/' . $style);
                    }
                }
            }
        } else {
            $styles = preg_grep('~^' . $prefix . '-.*\.(css)$~', scandir($template_dir));
            foreach ($styles as $style) {
                $space_time    =   time() - filemtime($template_dir . '/' .$style);
                if ($space_time > 86400) {
                    unlink($template_dir . '/' . $style);
                }
            }
        }
        self::clearJoomlaCache();
        return true;
    }
}
