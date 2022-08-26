<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2022 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or Later
 */
// no direct access
defined('_JEXEC') or die;

if (!class_exists('jollyanyInstallerScript')) {
    class jollyanyInstallerScript
    {

        /**
         *
         * Function to run when installing the component
         * @return void
         */
        public function install($parent)
        {
        }

        /**
         *
         * Function to run when updating the component
         * @return void
         */
        function update($parent)
        {
        }

        /**
         *
         * Function to run before installing the component
         */
        public function preflight($type, $parent)
        {
            $plugin_dir = JPATH_LIBRARIES . '/' . 'jollyany' . '/' . 'plugins' . '/';
            $plugins = array_filter(glob($plugin_dir . '*'), 'is_dir');
            foreach ($plugins as $plugin) {
                if ($type == "uninstall") {
                    $this->uninstallPlugin($plugin, $plugin_dir);
                }
            }
        }

        /**
         *
         * Function to run after installing the component
         */
        public function postflight($type, $parent)
        {
            $plugin_dir = JPATH_LIBRARIES . '/' . 'jollyany' . '/' . 'plugins' . '/';
            $plugins = array_filter(glob($plugin_dir . '*'), 'is_dir');
            foreach ($plugins as $plugin) {
                if ($type == "install" || $type == "update") {
                    $this->installPlugin($plugin, $plugin_dir);
                    if (file_exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'jollyany_installation')) {
                        jimport('joomla.filesystem.folder');
                        JFolder::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.'jollyany_installation');
                    }
                }
            }
        }

        public function installPlugin($plugin, $plugin_dir)
        {
            $db = JFactory::getDbo();
            $plugin_name = str_replace($plugin_dir, '', $plugin);
            $plugin_name = explode('_', $plugin_name);
            $plugin_name = end($plugin_name);

            $installer = new JInstaller;
            $installer->install($plugin);

            $query = $db->getQuery(true);
            $query->update('#__extensions');
            $query->set($db->quoteName('enabled') . ' = 1');
            $query->where($db->quoteName('element') . ' = ' . $db->quote($plugin_name));
            $query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
            $db->setQuery($query);
            $db->execute();
            return true;
        }

        public function uninstallPlugin($plugin, $plugin_dir)
        {
            $db = JFactory::getDbo();
            $plugin_name = str_replace($plugin_dir, '', $plugin);
            $plugin_name = explode('_', $plugin_name);
            $plugin_name = end($plugin_name);
            $query = $db->getQuery(true);
            $query->update('#__extensions');
            $query->set($db->quoteName('enabled') . ' = 0');
            $query->where($db->quoteName('element') . ' = ' . $db->quote($plugin_name));
            $query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
            $db->setQuery($query);
            $db->execute();
            return true;
        }
    }
}