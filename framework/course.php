<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;

abstract class JollyanyFrameworkCourse {
    public static function getData($id) {
        if (self::checkCourseDB()) {
            $db     =   \JFactory::getDbo();
            $db->setQuery('SELECT * FROM #__jollyany_course_data WHERE cid='.$id);
            return $db->loadObject();
        }
        return false;
    }

    public static function save($table) {
        if (self::checkCourseDB()) {
            try {
                $db     =   \JFactory::getDbo();
                $data   =   json_encode($table->jollyany_course_data);
                $db->setQuery('SELECT * FROM #__jollyany_course_data WHERE cid='.$table->id);
                if ($db->loadResult()) {
                    $db->setQuery('UPDATE #__jollyany_course_data SET `data`='.$db->quote($data).' WHERE cid='.$table->id);
                } else {
                    $db->setQuery('INSERT INTO #__jollyany_course_data(`cid`,`data`) VALUES ('.$table->id.','.$db->quote($data).')');
                }
                $db->execute();
            } catch (\InvalidArgumentException $e) {
                // $e->getMessage(); // Exception message already set in the method we try to use...
                // do some code using the $e->getMessage(), but do not return it...
                \JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error'); // for example
                // or log it: Log::add($e->getMessage(), Log::WARNING, 'jerror');
                // or you can ignore the Exception
                return false;
            }
            return true;
        }
        return false;
    }

    public static function checkCourseDB () {
        $db     =   \JFactory::getDbo();
        $results = $db->setQuery('SHOW TABLES')->loadColumn();
        $prefix = $db->getPrefix();
        $courseDB   =   true;
        if (!array_search($prefix.'jollyany_course_data',$results,true)) {
            $courseDB = self::createCourseDB();
        }
        return $courseDB;
    }

    public static function createCourseDB () {
        try {
            $db     =   \JFactory::getDbo();
            $db->setQuery('CREATE TABLE IF NOT EXISTS `#__jollyany_course_data` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `cid` int(11) NOT NULL,
                                      `data` longtext NOT NULL,
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;');
            $db->execute();
        }
        catch (\InvalidArgumentException $e) {
            // $e->getMessage(); // Exception message already set in the method we try to use...
            // do some code using the $e->getMessage(), but do not return it...
            \JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error'); // for example
            // or log it: Log::add($e->getMessage(), Log::WARNING, 'jerror');
            // or you can ignore the Exception
            return false;
        }
        return true;
    }
}
