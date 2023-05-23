<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2023 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPLv3 or Later
 */

namespace Jollyany\Helper;

defined('_JEXEC') or die;
class EasyBlog
{
    public static function getCategories()
    {
        if (!class_exists('EB')) return array();
        $model = \EB::model('Categories');

        $result = $model->getCategoryTree('ordering');

        $categories = [0 => \JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLE_ALL_CAT')];
        $sort = [];

        foreach ($result as $item) {
            $categories[$item->id] = ($item->depth ? '|' : '') . str_repeat('_ ', $item->depth) . $item->title;
        }

        return $categories;
    }

    public static function getTags()
    {
        if (!class_exists('EB')) return array();
        $model = \EB::model('Tags');

        $result = $model->getTags();

        $tags = [];

        foreach ($result as $item) {
            $tags[$item->id] = $item->title;
        }

        return $tags;
    }

    public static function getPostType()
    {
        $postType = [
            'blogger' => 'Blogger',
            'category' => 'Category',
            'tag' => 'Tag',
            'team' => 'Team',
            'latest' => 'Latest',
        ];

        return $postType;
    }

    public static function getPosts($options = [])
    {
        if (!class_exists('EB')) return array();
        $categories	= \EB::normalize($options, 'includeCats', []);
        $catIds = array();

        if (!empty($categories)) {
            if (!is_array($categories)) {
                $categories	= array($categories);
            }

            foreach ($categories as $item) {
                if (!$item) {
                    continue;
                }

                $category = new \stdClass();
                $category->id = trim( $item );

                $catIds[] = $category->id;

                if (\EB::normalize($options, 'includeSubCats', false)) {
                    $category->childs = null;
                    \EB::buildNestedCategories($category->id, $category , false , true );
                    \EB::accessNestedCategoriesId($category, $catIds);
                }
            }

            $catIds = array_unique($catIds);
        }

        $cid = $catIds;

        $type = \EB::normalize($options, 'type', 'latest');

        if (!empty($cid)) {
            $type = 'category';
        }

        $model = \EB::model('Blog');
        $data = $model->getBlogsBy($type, $cid, [\EB::normalize($options, 'sort', 'latest'), 'DESC'], \EB::normalize($options, 'count', 0), EBLOG_FILTER_PUBLISHED, null, true, [], false, false, true, [], $cid, null, 'listlength', true, [], [], false, \EB::normalize($options, 'includeTags', 0), ['paginationType' => 'none']);

        $posts = \EB::formatter('list', $data, false);

        return $posts;
    }
}