<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
namespace Jollyany\Helper;
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;
use Joomla\Database\ParameterType;

class Course {
    public static function getData($id) {
        if (!isset($id) || !$id) {
            return false;
        }

        if (!self::checkCourseDB()) {
            return false;
        }

        $db = Factory::getContainer()->get(DatabaseInterface::class);
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__jollyany_course_data'))
            ->where($db->quoteName('cid') . ' = :cid');
        $query->bind(':cid', (int) $id, ParameterType::INTEGER);
        $db->setQuery($query);
        return $db->loadObject();
    }

    public static function save($table) {
        if (!self::checkCourseDB()) {
            return false;
        }

        try {
            $db   = Factory::getContainer()->get(DatabaseInterface::class);
            $data = json_encode($table->jollyany_course_data);

            // Check if a record exists for this cid
            $query = $db->getQuery(true)
                ->select('COUNT(*)')
                ->from($db->quoteName('#__jollyany_course_data'))
                ->where($db->quoteName('cid') . ' = :cid');
            $query->bind(':cid', (int) $table->id, ParameterType::INTEGER);
            $db->setQuery($query);
            $exists = (int) $db->loadResult() > 0;

            if ($exists) {
                $query = $db->getQuery(true)
                    ->update($db->quoteName('#__jollyany_course_data'))
                    ->set($db->quoteName('data') . ' = :data')
                    ->where($db->quoteName('cid') . ' = :cid');
                $query->bind(':data', $data, ParameterType::STRING);
                $query->bind(':cid', (int) $table->id, ParameterType::INTEGER);
                $db->setQuery($query)->execute();
            } else {
                $columns = [$db->quoteName('cid'), $db->quoteName('data')];
                $valuesQuery = $db->getQuery(true)
                    ->insert($db->quoteName('#__jollyany_course_data'))
                    ->columns($columns)
                    ->values(':cid, :data');
                $valuesQuery->bind(':cid', (int) $table->id, ParameterType::INTEGER);
                $valuesQuery->bind(':data', $data, ParameterType::STRING);
                $db->setQuery($valuesQuery)->execute();
            }
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }

        return true;
    }

    public static function checkCourseDB () {
        $db = Factory::getContainer()->get(DatabaseInterface::class);

        try {
            // Ask driver for known tables (prefix already expanded)
            $tables = method_exists($db, 'getTableList') ? $db->getTableList() : [];
            $tableName = $db->replacePrefix('#__jollyany_course_data');
            if (!in_array($tableName, $tables, true)) {
                return self::createCourseDB();
            }
            return true;
        } catch (\RuntimeException $e) {
            // Fallback: try to create the table if listing failed
            return self::createCourseDB();
        }
    }

    public static function createCourseDB () {
        try {
            $db = Factory::getContainer()->get(DatabaseInterface::class);

            $table = $db->quoteName('#__jollyany_course_data');
            $id = $db->quoteName('id');
            $cid = $db->quoteName('cid');
            $data = $db->quoteName('data');

            $sql = 'CREATE TABLE IF NOT EXISTS ' . $table . ' ('
                 . $id . ' INT(11) NOT NULL AUTO_INCREMENT,'
                 . $cid . ' INT(11) NOT NULL,'
                 . $data . ' LONGTEXT NOT NULL,'
                 . 'PRIMARY KEY (' . $id . '),'
                 . 'UNIQUE KEY ' . $db->quoteName('idx_cid_unique') . ' (' . $cid . ')'
                 . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

            // Ensure prefix replacement
            $db->setQuery($db->replacePrefix($sql));
            $db->execute();
        } catch (\RuntimeException | \InvalidArgumentException $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
        return true;
    }
}
