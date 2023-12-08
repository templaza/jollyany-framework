<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2022 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;

if (file_exists(JPATH_LIBRARIES . '/astroid/framework/library/astroid')) {
    JLoader::registerNamespace('Astroid', JPATH_LIBRARIES . '/astroid/framework/library/astroid', false, false, 'psr4');
}
use Astroid\Framework;
use Astroid\Helper;
use Joomla\Registry\Registry;
if (file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
    JLoader::registerNamespace('Jollyany', JPATH_LIBRARIES . '/jollyany/framework/library/jollyany', false, false, 'psr4');
    jimport('jollyany.framework.course');
}

/**
 * Jollyany system plugin
 *
 * @since  3.5.11
 */

class plgSystemJollyany extends JPlugin {
	protected $app;
    public function onAfterDispatch()
    {
        if (!file_exists(JPATH_LIBRARIES . '/astroid/framework/library/astroid') || !$this->isEnableExtension('astroid', 'plugin', 'system') || !$this->isEnableExtension('astroid', 'library')) {
            return false;
        }
        Astroid\Framework::getDocument()->addLayoutPath(JPATH_LIBRARIES . '/jollyany/framework/frontend/');
    }
    public function onBeforeRender()
    {
        if (!file_exists(JPATH_LIBRARIES . '/astroid/framework/library/astroid') || !file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        if (Framework::isSite()) {
            $document = Astroid\Framework::getDocument(); // Astroid Document
            if ($this->params->get('jollyany_load_uikit', 'local') === 'local') {
                $document->addScript('media/jollyany/assets/js/uikit.min.js', 'body');
                $document->addScript('media/jollyany/assets/js/uikit-icons.min.js', 'body');
            } else {
                $document->addScript('https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js', 'body');
                $document->addScript('https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js', 'body');
            }

            $document->addScript('media/jollyany/assets/js/frontend.min.js', 'body');
        }
    }
	public function onAfterInitialise() {
        if (!file_exists(JPATH_LIBRARIES . '/astroid/framework/library/astroid') || !file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        Jollyany\Framework::init();
		// load jollyany language
		$lang = JFactory::getLanguage();
		$lang->load("jollyany", JPATH_SITE);
        $option     = $this->app->input->get('option', '');
        $jollyany   = $this->app->input->get('jollyany', '');
        $astroid    = $this->app->input->get('astroid', '');
		if(!Framework::isAdmin() && $jollyany!='activation' && $jollyany!='course_contact_form'  && $jollyany!='course_get_data') return false;
        if (version_compare(Helper\Constants::$astroid_version, "2.5.5")<1) {
            JFactory::getApplication()->enqueueMessage( 'Your Astroid version is '.Helper\Constants::$astroid_version.'. Jollyany required Astroid v2.5.5+. Please download and update <a target="_blank" href="https://github.com/templaza/astroid-framework/releases/latest">latest Astroid version</a>' );
        }
		if ($option == 'com_ajax') {
			switch ($jollyany) {
                case 'check_domain':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        $domain     =   JUri::getInstance() -> getHost();
                        // If is localhost do-not do anything
                        if ( in_array($domain, array('localhost', '127.0.0.1', '::1')) ) {
                            throw new \Exception(\JText::_('JOLLYANY_IS_LOCALHOST'), 204);
                        }
                        jimport('jollyany.framework.helper');
                        jimport('jollyany.framework.importer.data');
                        $lictext    =   JollyanyFrameworkHelper::getLicense();
                        $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
                        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, JollyanyFrameworkDataImport::getApiUrl());
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_setopt($ch, CURLOPT_POSTREDIR, 3);

                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS,
                                "option=com_tz_envato_license&task=licenses.verify&purchase_code=".$license->purchase_code."&domain=".$domain);

                            $data     =   json_decode(curl_exec ($ch));

                            curl_close ($ch);
                            if (isset($data->error)) {
                                throw new \Exception($data->error_description, 403);
                            }
                            $return["data"]     =   $data;
                            $return["status"]   =   "success";
                            $return["code"]     =   200;
                        } else {
                            throw new \Exception(\JText::_('JOLLYANY_FREE_LICENSE'), 204);
                        }
                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
				case 'activation' :
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						if ($this->params->get('secret_key') != $this->app->input->get('key')) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						$license                    =   new stdClass();
						$license->purchase_code     =   $this->app->input->get('purchase_code', '', 'RAW');
						$license->license_type      =   $this->app->input->get('license_type', '', 'RAW');
						$license->purchase_date     =   $this->app->input->get('purchase_date', '', 'RAW');
						$license->supported_until   =   $this->app->input->get('supported_until', '', 'RAW');
						$license->buyer             =   $this->app->input->get('buyer', '', 'RAW');
						$license->domain            =   $this->app->input->get('domain', '', 'RAW');
						jimport('joomla.filesystem.file');
						jimport('joomla.filesystem.folder');
						if (JFolder::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey')) {
							JFolder::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey');
						}
						JFile::write(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey'.DIRECTORY_SEPARATOR.'index.html','<!DOCTYPE html><title></title>');
						JFile::write(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey'.DIRECTORY_SEPARATOR.uniqid('key_').'.txt', JollyanyFrameworkHelper::maybe_serialize($license));
						echo '<html><head><title>Product Activated!</title><style>.product-activated-window {background: url(media/jollyany/assets/images/success.png) no-repeat center top;background-size: auto;background-size: 40px;padding-top: 50px;margin-top: 30px;text-align: center; }.product-activated-window .about-description {max-width: 400px;margin: 0 auto;margin-bottom: 0px;margin-bottom: 40px; }.product-activated-window .start-using-product {display: block;text-decoration: none;background: #72bf40;color: #fff;font-size: 25px;text-align: center;padding: 20px 10px; }</style></head><body><div class="product-activated-window"><h1>Product Activated!</h1><div class="about-description">Congratulations! <strong>'.$license->buyer.'</strong> has been successfully activated and now you can get latest updates of the template.</div><a href="#" class="start-using-product close-this-window" onclick="window.close();">Start using Jollyany!</a><br><p>You can <a href="#" class="close-this-window" onclick="window.close();">close this window</a> now.</p></div></body></html>';
					} catch (\Exception $e) {
					    header('Content-Type: application/json');
                        $return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
                        echo \json_encode($return);
					}
					die();
					break;
				case 'deactivate' :
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						if ($this->params->get('jollyany_license')) {
							$this->params->set('jollyany_license', '');
							$jollyany       =   \JPluginHelper::getPlugin('system', 'jollyany');
							$table          = JTable::getInstance('extension');
							$table->load($jollyany->id);
							$table->save(array('params' => $this->params->toString()));
						}
						jimport('joomla.filesystem.folder');
						if (JFolder::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey')) {
							JFolder::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'jollyanykey');
						}
						$return["status"] = "success";
						$return["code"] = 200;
						$return["data"] = $this->params->get('jollyany_license');
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
				case 'download_package':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						jimport('jollyany.framework.importer.data');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$demo_data_package     =   $this->app->input->post->get('demo-data-package', 0);
							$install_code          =   $this->app->input->post->get('install_code', '', 'RAW');
							$step                  =   $this->app->input->post->get('step', 1);
							$file_name             =   $this->app->input->post->get('file_name', '', 'RAW');

                            $templates             =   JollyanyFrameworkDataImport::getData();
                            if (is_array($templates) && isset($templates[$install_code])) {
                                $template          =   $templates[$install_code];
                                if (!$this->compareJoomlaVersion($template['joomla_version'])) {
                                    throw new \Exception(\JText::_('JOLLYANY_AJAX_NOT_COMPATIBLE_JOOMLA_VERSION'));
                                }
                            }

							if (!$demo_data_package) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
							$config         =   \JFactory::getConfig();
							$tmp_part       =   $config->get('tmp_path') ;
							jimport('joomla.filesystem.file');
							$url        = JollyanyFrameworkDataImport::getApiUrl().'/index.php?option=com_tz_membership';
							//install quickstart package
							/* Get package zip file from server */
                            ini_set('memory_limit', '-1');
							$data = array(
								'task'          => 'download.package',
								'produce'       => $install_code,
								'purchase_code' => $license->purchase_code,
                                'domain'        => JUri::getInstance() -> getHost(),
								'step'          => $step,
								'type'          => 'quickstart-api'
							);
							$http       =   JHttpFactory::getHttp();
							$response   =   $http -> post ($url, $data, array(
								'Content-type' => 'application/x-www-form-urlencoded'
							));

							if($response -> code == 200) {
								$header     = $response -> headers;
								$filePartCount  = isset($header['Files-Part-Count'])?$header['Files-Part-Count']:0;
                                if (isset($header['Content-Disposition']) && $header['Content-Disposition']) {
                                    $f_name =   preg_replace('/(^[^=]+=)|(;$)/', '', $header['Content-Disposition']);
                                    if ( is_array($f_name) && isset($f_name[0]) ) {
                                        $f_name =   $f_name[0];
                                    } elseif ( !is_string($f_name) ) {
                                        $f_name =   null;
                                    }
                                } else {
                                    $f_name = null;
                                }
								if (!$f_name) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_CAN_NOT_DOWNLOAD_PACKAGE'));
								$file_name  =   $file_name.'.'.JFile::getExt($f_name);
                                $filePartCount = is_array($filePartCount) && isset($filePartCount[0]) ? $filePartCount[0] : $filePartCount;
								if($filePartCount && $step <= $filePartCount){
									JFile::append($tmp_part.'/'.$file_name,$response -> body, true);
									$return["pathcount"]    =   $filePartCount;
									if ($step == $filePartCount) {
										$return['archive']  =   $tmp_part.'/'.$file_name;
									}
								} else {
									throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_CAN_NOT_DOWNLOAD_PACKAGE'));
								}
							} else {
								throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_CAN_NOT_CONNECT_SERVER'));
							}
							$return["status"] = "success";
							$return["code"] = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
				case 'unzip_package':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						jimport('jollyany.framework.importer.data');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$demo_data_package     =   $this->app->input->post->get('demo-data-package', 0);
							$p_filename            =   $this->app->input->post->get('archive', '', 'RAW');

							if (!$demo_data_package) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
							$config         =   \JFactory::getConfig();
							jimport('joomla.filesystem.file');
							//unzip quickstart package
							@chmod(JPATH_ROOT.DIRECTORY_SEPARATOR.'configuration.php', 0644);
							$package    =   JollyanyFrameworkHelper::unpack($p_filename, true);
							if ($package['extractdir']== null){
								throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_PACKAGE_NOT_FOUND'));
							} else {
								if (!$raw_data       = file_get_contents(JPATH_ROOT.DIRECTORY_SEPARATOR.'installation'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'databases.json')) {
									throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_QUICKSTART_CAN_NOT_FOUND'));
								}
								$packagedb          = json_decode($raw_data, true);
								$packagedb['site.sql']['dbname'] = $config->get('db');
								$packagedb['site.sql']['dbhost'] = $config->get('host');
								$packagedb['site.sql']['dbuser'] = $config->get('user');
								$packagedb['site.sql']['dbpass'] = $config->get('password');
								$packagedb['site.sql']['prefix'] = $config->get('dbprefix');

								JFile::write(JPATH_ROOT.DIRECTORY_SEPARATOR.'installation'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'databases.json', json_encode($packagedb), true);
								$return["package"]  = json_encode($package);
								$return["url_root"] = JUri::root();
							}
							$return["status"] = "success";
							$return["code"] = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
				case 'get_extensions_data':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						jimport('jollyany.framework.importer.data');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$install_code          =   $this->app->input->post->get('install_code', '', 'RAW');
							$templates             =   JollyanyFrameworkDataImport::getData();
							if (is_array($templates) && isset($templates[$install_code])) {
								$template          =   $templates[$install_code];
								$return['data']    =   json_encode($template['extensions']);
							} else {
								throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CODE'));
							}
							$return["status"] = "success";
							$return["code"] = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
				case 'get_package_data':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						jimport('jollyany.framework.importer.data');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$extension_package     =   $this->app->input->post->get('extension-package', array(), 'RAW');
							$template_package      =   $this->app->input->post->get('template-package', 1);
							$install_code          =   $this->app->input->post->get('install_code', '', 'RAW');

							if (empty($extension_package) && !$template_package) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
							$templates             =   JollyanyFrameworkDataImport::getData();
							if (is_array($templates) && isset($templates[$install_code])) {
								$template          =   $templates[$install_code];
								$arr_extensions    =   array();
								if ($template_package) {
                                    if (!$this->compareJoomlaVersion($template['joomla_version'])) {
                                        throw new \Exception(\JText::_('JOLLYANY_AJAX_NOT_COMPATIBLE_JOOMLA_VERSION'));
                                    }
                                    $arr_extensions[]   =   $template['template'];
								}
								if (!empty($extension_package)) {
									$extension  =   array();
									foreach ($extension_package as $i) {
										$extension[]    =   $template['extensions'][$i];
									}
									$arr_extensions     =   array_merge($arr_extensions, $extension);
								}
								$return['data']    =   json_encode($arr_extensions);
							} else {
								throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CODE'));
							}
							$return["status"] = "success";
							$return["code"] = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
                case 'get_extension_package':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }
                        jimport('jollyany.framework.helper');
                        jimport('jollyany.framework.importer.data');
                        $lictext    =   JollyanyFrameworkHelper::getLicense();
                        $license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
                        if ( is_object( $license ) && isset( $license->purchase_code ) ) {
                            $install_code          =   $this->app->input->post->get('install_code', '', 'RAW');
                            if (empty($install_code)) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
                            $extensions            =   JollyanyFrameworkDataImport::getExtensions();
                            if (is_array($extensions) && isset($extensions[$install_code])) {
                                $arr_extensions    =   array($extensions[$install_code]);
                                $return['data']    =   json_encode($arr_extensions);
                            } else {
                                throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CODE'));
                            }
                            $return["status"] = "success";
                            $return["code"] = 200;
                        } else {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
                        }
                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
				case 'install_package':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$extension_package     =   $this->app->input->post->get('extension-package', 1);
							$template_package      =   $this->app->input->post->get('template-package', 1);
							$extension             =   json_decode($this->app->input->post->get('extension', '', 'RAW'));
							jimport('joomla.filesystem.file');
							jimport('joomla.filesystem.folder');
							if (!$extension_package && !$template_package) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
							if (is_object($extension) && isset($extension->name)) {
								$config   = JFactory::getConfig();
								$tmp_dest = $config->get('tmp_path');
								if ($extension->type == 'included') {
									$path    =   $this->getPackageData(1, $extension, $license);
									if (!$path) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_EXTENSION_NOT_FOUND'));
									// Unpack the downloaded package file.
									$e_package  =   JInstallerHelper::unpack($path, true);
									$install_result  =   JollyanyFrameworkHelper::installPackage($path, $e_package, $tmp_dest);
									if (!$install_result['status']) {
										throw new \Exception($install_result['message']);
									}
								} elseif ($extension->type == 'url') {
									// Get the URL of the package to install.
									$url = $extension->url;

									// Did you give us a URL?
									if (!$url)
									{
										throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_EXTENSION_URL_NOT_FOUND'));
									}

									// Handle updater XML file case:
									if (preg_match('/\.xml\s*$/', $url))
									{
										jimport('joomla.updater.update');
										$update = new JUpdate;
										$update->loadFromXml($url);
										$package_url = trim($update->get('downloadurl', false)->_data);

										if ($package_url)
										{
											$url = $package_url;
										}

										unset($update);
									}

									// Download the package at the URL given.
									$p_file = JInstallerHelper::downloadPackage($url);

									// Was the package downloaded?
									if (!$p_file)
									{
										throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_EXTENSION_URL_INVALID'));
									}

									// Unpack the downloaded package file.
									$e_package = JInstallerHelper::unpack($tmp_dest . '/' . $p_file, true);
									$install_result  =   JollyanyFrameworkHelper::installPackage($url, $e_package, $tmp_dest);
									if (!$install_result['status']) {
										throw new \Exception($install_result['message']);
									}
									$return["message"]  =   $install_result['message'];
								}
							} else {
								throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_PACKAGE_NOT_FOUND'));
							}
							$return["status"] = "success";
							$return["code"] = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
				case 'clean_up_install':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						jimport('jollyany.framework.helper');
						$lictext    =   JollyanyFrameworkHelper::getLicense();
						$license    =   JollyanyFrameworkHelper::maybe_unserialize($lictext);
						if ( is_object( $license ) && isset( $license->purchase_code ) ) {
							$package               =   json_decode($this->app->input->post->get('package', '', 'RAW'));
							// Cleanup the install files.
							if (!is_file($package->packagefile))
							{
								$config = JFactory::getConfig();
								$package->packagefile = $config->get('tmp_path') . '/' . $package->packagefile;
							}

							JInstallerHelper::cleanupInstall($package->packagefile, $package->extractdir);
							$return["status"]   = "success";
							$return["code"]     = 200;
						} else {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_LICENSE'));
						}
					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
                case 'loadpreset':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }
                        $template_name  = $this->app->input->get('template', NULL, 'RAW');
                        $presets_path   = JPATH_SITE . "/templates/$template_name/astroid/presets/";
                        $file           = $this->app->input->post->get('name', '', 'RAW');
                        $json           = file_get_contents($presets_path.$file.'.json');
                        if (!$json) {
                            throw new \Exception(\JText::_('JOLLYANY_LOAD_PRESET_FILE_ERROR').': '.$presets_path.$file.'.json');
                        }
                        $data = \json_decode($json, true);
                        if (!isset($data['preset']) || empty($data['preset'])) {
                            throw new \Exception(\JText::_('JOLLYANY_PRESET_EMPTY_ERROR'));
                        }
                        $return["status"]   =   'success';
                        $return["data"]     =   $data['preset'];
                        $return["code"]     =   200;

                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
				case 'removepreset':
					header('Content-Type: application/json');
					header('Access-Control-Allow-Origin: *');
					$return = array();
					try {
						// Check for request forgeries.
						if (!JSession::checkToken()) {
							throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
						}
						$template_name  = $this->app->input->get('template', NULL, 'RAW');
						$presets_path   = JPATH_SITE . "/templates/$template_name/astroid/presets/";
						$file           = $this->app->input->post->get('name', '', 'RAW');
						$file_name      = $presets_path.$file.'.json';
						jimport('joomla.filesystem.file');
						if (\JFile::exists($file_name)) {
							\JFile::delete($file_name);
						}
						$return["status"]   =   'success';
						$return["code"]     =   200;

					} catch (\Exception $e) {
						$return["status"] = "error";
						$return["code"] = $e->getCode();
						$return["message"] = $e->getMessage();
					}
					echo \json_encode($return);
					die();
					break;
                case 'get_version':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }
                        jimport('jollyany.framework.helper');
                        jimport('jollyany.framework.importer.data');
                        $code          =   $this->app->input->post->get('code', '', 'RAW');
                        $return['element']  =   $code;
                        if (empty($code)) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_NO_FILE_INSTALL'));
                        $ext_code           =   JollyanyFrameworkDataImport::getExtCode($code);
                        if ($ext_code) {
                            $ext_version            =   JollyanyFrameworkHelper::getExtVersion($ext_code, 'component');
                            if (!empty($ext_version)) {
                                $return['data']     =   JText::_('JOLLYANY_CURRENT_VERSION'). ': '. $ext_version;
                                $return['type']     =   'extension';
                            } else {
                                throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CODE'));
                            }
                        } else {
                            $tpl_code               =   JollyanyFrameworkDataImport::getConvertCode($code);
                            $ext_version            =   JollyanyFrameworkHelper::getExtVersion($tpl_code, 'template');
                            if (!empty($ext_version)) {
                                $return['element']  =   $tpl_code;
                                $return['data']     =    JText::_('JOLLYANY_INSTALLED_VERSION'). ': '. $ext_version;
                                $return['type']     =   'template';
                            } else {
                                throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CODE'));
                            }
                        }
                        $return["status"] = "success";
                        $return["code"] = 200;
                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
                case 'cache_thumb':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }
                        $thumbs     = $this->app->input->get('thumbs', array(), 'RAW');
                        jimport('joomla.filesystem.file');
                        jimport('jollyany.framework.importer.data');
                        $api_url    =   JollyanyFrameworkDataImport::getApiUrl();
                        for ($i = 0; $i < count($thumbs); $i++) {
                            $http       =   JHttpFactory::getHttp();
                            $response   =   $http -> get ($api_url.$thumbs[$i], array(
                                'Content-type' => 'application/x-www-form-urlencoded'
                            ));
                            if ($response->code == 200) {
                                JFile::write(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jollyany'.$thumbs[$i], $response->body);
                            }
                        }

                        $return["status"]   =   'success';
                        $return["code"]     =   200;

                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
                case 'course_contact_form':
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        // if cache isn't enable
                        if( !\JFactory::getConfig()->get('caching') && !JPluginHelper::getPlugin('system', 'cache') ) {
                            // Check CSRF
                            if (!\JSession::checkToken()) {
                                throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                            }
                        }
                        $input = $this->app->input;

                        $mail = JFactory::getMailer();
                        $message = '';
                        $showcaptcha = false;
                        //inputs
                        $inputs = $input->get('data', array(), 'ARRAY');
                        foreach ($inputs as $input) {

                            if ($input['name'] == 'captcha_type') {
                                $captcha_type = $input['value'];
                            }

                            if ($input['name'] == 'from_email') {
                                $from_email = $input['value'];
                            }

                            if ($input['name'] == 'from_name') {
                                $from_name = $input['value'];
                            }

                            if ($input['name'] == 'name') {
                                $name = $input['value'];
                            }

                            if ($input['name'] == 'subject') {
                                $subject = $input['value'];
                            }

                            if ($input['name'] == 'phone') {
                                $phone = $input['value'];
                            }

                            if ($input['name'] == 'message') {
                                $message = nl2br($input['value']);
                            }

                            if ($input['name'] == 'g-recaptcha-response') {
                                $gcaptcha = $input['value'];
                                $showcaptcha = true;
                            }
                            if ($input['name'] == 'agreement') {
                                $agreement = $input['value'];
                            }
                        }

                        if ($showcaptcha) {
                            if ($captcha_type == 'recaptcha' || $captcha_type == 'recaptcha_invisible') {
                                if($gcaptcha == ''){
                                    throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CAPTCHA'));
                                } else {
                                    if($captcha_type == 'recaptcha_invisible') {
                                        JPluginHelper::importPlugin('captcha', 'recaptcha_invisible');
                                    } else {
                                        JPluginHelper::importPlugin('captcha', 'recaptcha');
                                    }
                                    $dispatcher = JEventDispatcher::getInstance();
                                    $res = $dispatcher->trigger('onCheckAnswer', $gcaptcha);

                                    if (!$res[0]) {
                                        throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_INVALID_CAPTCHA'));
                                    }
                                }
                            }
                        }

                        //get sender UP
                        $senderip       = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
                        // Subject Structure
                        $site_name 	    = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
                        $mail_subject   = $subject . ' - ' . $from_email . ' - ' . $site_name;

                        // Message structure
                        $mail_body = '<div>';
                        if (isset($from_name) && $from_name) {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_NAME'). '</strong>: ' . $from_name .'</p>';
                        }
                        if (isset($from_email) && $from_email) {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_EMAIL'). '</strong>: ' . $from_email .'</p>';
                        }
                        if (isset($phone) && $phone) {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_PHONE'). '</strong>: ' . $phone .'</p>';
                        }
                        if (isset($message) && $message) {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_MESSAGE'). '</strong>: ' . $message .'</p>';
                        }
                        if (isset($agreement) && $agreement) {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_AGREEMENT'). '</strong>: ' . JText::_('JYES'). '</p>';
                        } else {
                            $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_AGREEMENT'). '</strong>: ' . JText::_('JNO'). '</p>';
                        }
                        $mail_body .= '<p><strong>' . JText::_('JOLLYANY_COURSE_AJAX_CONTACT_SENDER_IP'). '</strong>: ' . $senderip .'</p>';
                        $mail_body .= '</div>';

                        $config = JFactory::getConfig();

                        $sender = array( $config->get( 'mailfrom' ), $config->get( 'fromname' ) );
                        $recipient = $config->get( 'mailfrom' );

                        // $sender = array( $email, $name );

                        if (!empty($from_email)) {
                            $sender = array($from_email, $from_name);
                            $mail->addReplyTo($from_email, $from_name);
                        }

                        $mail->setSender($sender);
                        $mail->addRecipient($recipient);
                        $mail->setSubject($mail_subject);
                        $mail->isHTML(true);
                        $mail->Encoding = 'base64';
                        $mail->setBody($mail_body);

                        if ($mail->Send()) {
                            $return["status"]   =   'success';
                            $return["message"]  =   \JText::_('JOLLYANY_AJAX_ERROR_SENT_SUCCESSFULLY');
                            $return["code"]     =   200;
                        } else {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR_SENT_MAIL_FAILED'));
                        }
                        $return["status"]   =   'success';
                        $return["code"]     =   200;
                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
                case 'course_get_data' :
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        // Check for request forgeries.
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }
                        $cid            =   $this->app->input->get('cid', 0);
                        $id             =   $this->app->input->get('id', '');

                        if (!$cid || !$id) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        $course_data    =   JollyanyFrameworkCourse::getData($cid);
                        $modal_content  =   '';
                        if ($course_data) {
                            $courses    =   json_decode($course_data->data,true);
                            if (!$courses[$id]) throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                            $lesson     =   $courses[$id];
                            $lesson_type    =   isset($lesson['jollyany_content_type']) && $lesson['jollyany_content_type'] ? $lesson['jollyany_content_type'] : 'video';
                            if ($lesson_type == 'video') {
                                $video = parse_url($lesson['lesson_content_video_url']);
                                $src = '';
                                switch($video['host']) {
                                    case 'youtu.be':
                                        $id = trim($video['path'],'/');
                                        $src = '//www.youtube.com/embed/' . $id .'?iv_load_policy=3';
                                        break;

                                    case 'www.youtube.com':
                                    case 'youtube.com':
                                        parse_str($video['query'], $query);
                                        $id = $query['v'];
                                        $src = '//www.youtube.com/embed/' . $id .'?iv_load_policy=3';
                                        break;

                                    case 'vimeo.com':
                                    case 'www.vimeo.com':
                                        $id = trim($video['path'],'/');
                                        $src = "//player.vimeo.com/video/{$id}";
                                }
                                if ($src) {
                                    $modal_content .= '<div class="jollyany-embed-responsive jollyany-embed-responsive-16by9">';
                                    $modal_content .= '<iframe class="jollyany-embed-responsive-item" ' . 'src="'.$src.'"' . ' webkitAllowFullScreen mozallowfullscreen allowFullScreen loading="lazy"></iframe>';
                                    $modal_content .= '</div>';
                                }
                            }
                            $modal_content  .=  $lesson_type == 'embed' && isset($lesson['lesson_content_embed']) && $lesson['lesson_content_embed'] ? '<div class="jollyany-embed-responsive jollyany-embed-responsive-16by9">'.$lesson['lesson_content_embed'].'</div>' : '';
                            $modal_content  .=  isset($lesson['lesson_content_title']) && $lesson['lesson_content_title'] ? '<h1>'.$lesson['lesson_content_title'].'</h1>' : '';
                            $modal_content  .=  isset($lesson['jollyany_content_description']) && $lesson['jollyany_content_description'] ? $lesson['jollyany_content_description'] : '';
                        }

                        $return["data"]     =   $modal_content;
                        $return["status"]   =   'success';
                        $return["code"]     =   200;

                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                    }
                    echo \json_encode($return);
                    die();
                    break;
			}
            switch ($astroid) {
                case "save":
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    $return = array();
                    try {
                        if (!JSession::checkToken()) {
                            throw new \Exception(\JText::_('JOLLYANY_AJAX_ERROR'));
                        }

                        $jollyany_preset = $this->app->input->post->get('jollyany-preset', 0, 'INT');
                        if ($jollyany_preset) {
                            $params = $this->app->input->post->get('params', array(), 'RAW');
                            $template_name = $this->app->input->get('jollyany-template', NULL, 'RAW');
                            $preset = [
                                'title' => $this->app->input->post->get('jollyany-preset-name', '', 'RAW'),
                                'desc' => $this->app->input->post->get('jollyany-preset-desc', '', 'RAW'),
                                'thumbnail' => '', 'demo' => '',
                                'preset' => \json_encode($params)
                            ];
	                        jimport('joomla.filesystem.file');
	                        \JFile::write(JPATH_SITE . "/templates/{$template_name}/astroid/presets/" . uniqid(JFilterOutput::stringURLSafe($preset['title']).'-') . '.json', \json_encode($preset));
                        }
                    } catch (\Exception $e) {
                        $return["status"] = "error";
                        $return["code"] = $e->getCode();
                        $return["message"] = $e->getMessage();
                        echo \json_encode($return);
                        die();
                    }
                    break;
            }
		}
	}

	protected function getPackageData($step, $extension, $license) {
		jimport('jollyany.framework.importer.data');
		$url        = JollyanyFrameworkDataImport::getApiUrl().'/index.php?option=com_tz_membership';
		$data = array(
			'task'          => 'download.package',
			'produce'       => $extension->code,
			'purchase_code' => $license->purchase_code,
			'domain'        => JUri::getInstance() -> getHost(),
			'step'          => $step,
			'type'          => $extension->ext_code
		);
		$http       =   JHttpFactory::getHttp();
		$response   =   $http -> post ($url, $data, array(
			'Content-type' => 'application/x-www-form-urlencoded'
		));

		$config     =   JFactory::getConfig();
		$tmp_part   =   $config->get('tmp_path');
		if($response -> code == 200) {
			$header     = $response -> headers;
			$filePartCount  = isset($header['Files-Part-Count']) ? $header['Files-Part-Count'] : 0;
			if (isset($header['Content-Disposition']) && $header['Content-Disposition']) {
			    $f_name =   preg_replace('/(^[^=]+=)|(;$)/', '', $header['Content-Disposition']);
			    if ( is_array($f_name) && isset($f_name[0]) ) {
			        $f_name =   $f_name[0];
                } elseif ( !is_string($f_name) ) {
			        $f_name =   null;
                }
            } else {
			    $f_name = null;
            }
			if (!$f_name) return false;
			$filePartCount = is_array($filePartCount) && isset($filePartCount[0]) ? $filePartCount[0] : $filePartCount;
			if($filePartCount && $step <= $filePartCount){
				JFile::append($tmp_part.'/'.$f_name,$response -> body, true);
				if ($step == $filePartCount) {
					return $tmp_part.'/'.$f_name;
				} else {
					return $this->getPackageData($step+1, $extension, $license);
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// Astroid Admin Events
	public function onBeforeAstroidAdminRender(&$template) {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        $document = Framework::getDocument();
        $document->addStyleDeclaration('
		.jollyany_placeholder {
			width: 100%;
			min-height: 200px;
			display: flex;
			align-items: center;
		    justify-content: center;
		    font-size: 5rem;
		    text-transform: uppercase;
		    color: #ffffff;
		    background-size: cover;
            background-position: top;
		}
		.jollyany-preset .close {position: absolute;top: 5px;right: 8px;}
		#astroid-content-wrapper .jollyany-create-preset .form-control {max-width:100%;}
		#astroid-content-wrapper .jollyany-create-preset textarea {min-height:auto;}
		@media (min-width: 1500px) {
	    .col-xxl-7 {
	        flex: 0 0 58.3333333333% !important;
            max-width: 58.3333333333% !important;
	    }
	    .col-xxl-5 {
	        flex: 0 0 41.6666666667% !important;
            max-width: 41.6666666667% !important;
	    }
	    .col-xxl-3 {
	        flex: 0 0 25% !important;
            max-width: 25% !important;
	    }
	    }
	    @media (min-width: 576px) {
	        .card-group>.card.template-info {
	            flex: 0 0 40%;
	        }
	    }
		'); // to add css script
        $document->addScript(JUri::root().'media/vendor/jquery/js/jquery.min.js', "body");
        $document->addScript(JUri::root().'media/jollyany/assets/js/jollyany.min.js', "body"); // to add js file in body
        $document->addScript(JUri::root().'media/jollyany/assets/js/uikit.min.js', 'body');
		$document->addScriptDeclaration('var TZ_TEMPLATE_NAME = \''.$template->template.'\';'); // to add js script in head
        jimport('joomla.filesystem.file');
        if (JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template->template.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'logo-admin.png')) {
            $document->addScriptDeclaration('var TZ_LOGO_IMG = true;'); // to add js script in head
        } else {
            $document->addScriptDeclaration('var TZ_LOGO_IMG = false;'); // to add js script in head
        }

        if (file_exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'jollyany_installation')) {
            jimport('joomla.filesystem.folder');
            JFolder::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.'jollyany_installation');
        }
	}

    // Astroid Admin Events
    public function onBeforeAstroidTemplateFormLoad(&$template, &$form) {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        $form->loadOptions(JPATH_LIBRARIES . '/jollyany/framework/options');
    }

    public function onContentPrepareForm($form, $data) {
        if (!file_exists(JPATH_LIBRARIES . '/astroid/framework/library/astroid') || !file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        $pluginParams = Helper::getPluginParams();
        $lib_dir = 'libraries/jollyany';
        Helper::loadLanguage('jollyany');
        $frontendVisibility = $pluginParams->get('frontend_tabs_visibility', 1);

        \JForm::addFormPath(JPATH_SITE . '/' . $lib_dir . '/framework/forms');

        if ($form->getName() == 'com_content.article' && ((Framework::isSite() && $frontendVisibility) || Framework::isAdmin())) {
            $form->loadFile('article', false);
        }

        if ($form->getName() == 'com_menus.item' && (isset($data->request['option']) && $data->request['option'] == 'com_content') && (isset($data->request['view']) && $data->request['view'] == 'category') && (isset($data->request['layout']) && $data->request['layout'] == 'blog') && ((Framework::isSite() && $frontendVisibility) || Framework::isAdmin())) {
            $form->loadFile('article_menu', false);
        }
        if ($form->getName() == 'com_menus.item' && (isset($data->request['option']) && $data->request['option'] == 'com_content') && (isset($data->request['view']) && $data->request['view'] == 'featured') && ((Framework::isSite() && $frontendVisibility) || Framework::isAdmin())) {
            $form->loadFile('article_menu', false);
        }
        if ($form->getName() == 'com_categories.categorycom_content' && ((Framework::isSite() && $frontendVisibility) || Framework::isAdmin())) {
            $form->loadFile('category', false);
        }
        if ($form->getName() == 'com_menus.item' && (isset($data->request['option']) && $data->request['option'] == 'com_hikashop') && (isset($data->request['view']) && ($data->request['view'] == 'product' || $data->request['view'] == 'category')) && (isset($data->request['layout']) && $data->request['layout'] == 'listing') && ((Framework::isSite() && $frontendVisibility) || Framework::isAdmin())) {
            $form->loadFile('hikashop', false);
        }
    }

    public function onContentBeforeSave($context, $table, $isNew) {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        // Check we are handling the frontend edit form.
        if ($context == 'com_content.article' && JollyanyFrameworkCourse::checkCourseDB())
        {
            $table->attribs                 =   json_decode($table->attribs, true);
            $table->jollyany_course_data    =   $table->attribs['jollyany_course_lessons'];
            $table->attribs['jollyany_course_lessons']  =   '';
            $table->attribs                 =   json_encode($table->attribs);
            return true;
        }
    }

    public function onContentAfterSave($context, $table, $isNew) {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        if ($context == 'com_content.article') {
            return JollyanyFrameworkCourse::save($table);
        }
    }

    public function onContentPrepareData($context, $data)
    {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        if ($context == 'com_content.article' && $data->id && isset($data->attribs['jollyany_course_lessons'])) {
            $course =   JollyanyFrameworkCourse::getData($data->id);
            if ($course) {
                $data->attribs['jollyany_course_lessons'] = $course->data;
            }
            return true;
        }
    }

    public function onContentPrepare($context, &$row, &$params, $page = 0) {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return false;
        }
        if ($context == 'com_content.article') {
            $course =   JollyanyFrameworkCourse::getData($row->id);
            if ($course) {
                $params->set('jollyany_course_lessons',json_decode($course->data,true));
            }
            return true;
        }
    }

    public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
    {
        if (!file_exists(JPATH_LIBRARIES . '/jollyany/framework')) {
            return '';
        }
        if ($context == 'com_content.category') {
            jimport('jollyany.framework.article');
            $content = '';
            if ($params->get('jollyany_show_course_lecture',0)) {
                $content .= JollyanyFrameworkArticle::getLectureTotal($row->id);
            }
            // Convert parameter fields to objects.
            $row_params = new Registry($row->attribs);
            $content .= JollyanyFrameworkArticle::getEventData($params, $row_params);
            return $content;
        }

        return '';
    }

    protected function compareJoomlaVersion($template_joomla_version) {
        $joomla_current_version = new \JVersion;
        $joomla_current_version = $joomla_current_version->getShortVersion();
        $joomla_current_version = substr($joomla_current_version, 0, 1);
        return in_array($joomla_current_version, $template_joomla_version);
    }

    protected function isEnableExtension($element, $type = '', $folder = '') {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select(
                $db->quoteName('enabled')
            )
            ->from($db->quoteName('#__extensions'))
            ->where(
                $db->quoteName('element') . ' = '.$db->quote($element)
            );
        if (!empty($type)) {
            $query->where($db->quoteName('type') . ' = '.$db->quote($type));
        }
        if (!empty($folder)) {
            $query->where($db->quoteName('folder') . ' = '.$db->quote($folder));
        }
        $db->setQuery($query);
        $result = $db->loadResult();
        if (!empty($result) && $result == 1) {
            return true;
        }
        return false;
    }
}