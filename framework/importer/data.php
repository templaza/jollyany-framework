<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2009 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;

class JollyanyFrameworkDataImport {
	protected static $api  =   'https://www.templaza.com';
	public static $cache   =    array('thumb' => array());
	protected static $exts =    array(
	    'sp-page-builder'  =>   array(
            'name'      =>  'SP Page Builder',
            'type'      =>  'included',
            'code'      =>  'tz_extensions',
            'ext_code'  =>  'sp-page-builder',
        ),
	    'uk-sp-addons'  =>   array(
		    'name'      =>  'SP Page Builder Addons',
		    'type'      =>  'included',
		    'code'      =>  'tz_extensions',
		    'ext_code'  =>  'uk-sp-addons',
	    ),
        'ui-sp-addons'  =>   array(
            'name'      =>  'SP Page Builder UI Addons',
            'type'      =>  'included',
            'code'      =>  'tz_extensions',
            'ext_code'  =>  'ui-sp-addons',
        ),
        'tz-portfolio'  =>      array(
            'name'      =>  'TZ Portfolio',
            'type'      =>  'url',
            'url'       =>  'https://github.com/templaza/tz_portfolio_plus/archive/master.zip',
            'ext_code'  =>  'tz-portfolio',
        ),
        'hikashop'      =>      array(
            'name'      =>  'Hikashop',
            'type'      =>  'url',
            'url'       =>  'https://www.hikashop.com/component/updateme/downloadxml/component-hikashop/level-starter/download.zip',
            'ext_code'  =>  'hikashop',
        )
    );
    protected static $exts_convert       =   [
        'sp-page-builder' => 'com_sppagebuilder',
        'tz-portfolio' => 'com_tz_portfolio_plus',
        'hikashop' => 'com_hikashop',
    ];
	protected static $data =    null;
    protected static $replacer   =   [
        'tz_fashion_semona_joomla'  => 'tz_fashion',
        'tz_everline_joomla'        => 'tz_everline',
        'tz_eventory_joomla'        => 'tz_eventory',
        'tz_charity_joomla'         => 'tz_charity',
        'tz_foodz_joomla'           => 'tz_foodz',
        'profiler-joomla-template'  => 'tz_profiler',
    ];

	public static function getThumb($src) {
        if (file_exists(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jollyany'.$src)) {
            return JUri::base(true).'/cache/jollyany'.$src;
        } else {
            self::$cache['thumb'][] =   $src;
            return self::$api.$src;
        }
    }

    public static function getTotalTemplate() {
        return count(self::getData());
    }

	public static function getApiUrl() {
		return self::$api;
	}

	public static function getExtensions() {
	    return self::$exts;
    }

    public static function getExtCode($key) {
	    if (isset(self::$exts_convert[$key])) {
            return self::$exts_convert[$key];
        }
        return false;
    }

    public static function getConvertCode($key) {
        if (isset(self::$replacer[$key])) {
            return self::$replacer[$key];
        }
        return $key;
    }

	public static function getData() {
	    self::$data   =   array(
            'tz_probike'      =>  array(
                // Pack Info
                'name'        => 'ProBike',
                'desc'        => 'Bike Shop & Bicycle Rental Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/probike/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://probike.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/probike',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'ProBike Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_probike',
                    'ext_code'  =>  'tz-probike-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['hikashop'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_autobike'      =>  array(
                // Pack Info
                'name'        => 'Autobike',
                'desc'        => 'Moto Store & Bike Rental Services Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/autobike/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://autobike.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/autobike',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Autobike Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_autobike',
                    'ext_code'  =>  'tz-autobike-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['hikashop'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_express'      =>  array(
                // Pack Info
                'name'        => 'Express',
                'desc'        => 'Newspaper & News Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/express/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://express.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/express',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Express Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_express',
                    'ext_code'  =>  'tz-express-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                ),
            ),
            'tz_amanus'      =>  array(
                // Pack Info
                'name'        => 'Amanus',
                'desc'        => 'Yacht Charter Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/amanus/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://amanus.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/amanus',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Amanus Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_amanus',
                    'ext_code'  =>  'tz-amanus-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_plazart'      =>  array(
                // Pack Info
                'name'        => 'Plazart',
                'desc'        => 'Construction Equipment Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/plazart/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://plazart.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/plazart',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Plazart Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_plazart',
                    'ext_code'  =>  'tz-plazart-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_todaynews'      =>  array(
                // Pack Info
                'name'        => 'Today News',
                'desc'        => 'Newspaper, Magazine & News Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/todaynews/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://todaynews.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/todaynews',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Today News Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_todaynews',
                    'ext_code'  =>  'tz-todaynews-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                ),
            ),
            'tz_interiart'      =>  array(
                // Pack Info
                'name'        => 'InteriArt',
                'desc'        => 'Furniture & Interior Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/interiart/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://interiart.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/interiart',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'InteriArt Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_interiart',
                    'ext_code'  =>  'tz-interiart-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_medil'      =>  array(
                // Pack Info
                'name'        => 'Medil',
                'desc'        => 'Medical & Healthcare Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/medil/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://medil.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/medil',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Medil Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_medil',
                    'ext_code'  =>  'tz-medil-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_agruco'      =>  array(
                // Pack Info
                'name'        => 'Agruco',
                'desc'        => 'Agriculture & Organic Food Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/agruco/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://agruco.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/agruco',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Agruco Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_agruco',
                    'ext_code'  =>  'tz-agruco-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_oraz'      =>  array(
                // Pack Info
                'name'        => 'Oraz',
                'desc'        => 'Music Band Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/oraz/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://oraz.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/oraz',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Oraz Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_oraz',
                    'ext_code'  =>  'tz-oraz-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_goldenheart'      =>  array(
                // Pack Info
                'name'        => 'Golden Hearts',
                'desc'        => 'Fundraising & Charity Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/golden_hearts/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://goldenheart.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/goldenheart',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Golden Hearts Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_goldenheart',
                    'ext_code'  =>  'tz-goldenheart-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_organico'      =>  array(
                // Pack Info
                'name'        => 'Organico',
                'desc'        => 'Nutritionist Food & Farm Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/organico/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://organico.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/organico',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Organico Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_organico',
                    'ext_code'  =>  'tz-organico-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_baressco'      =>  array(
                // Pack Info
                'name'        => 'Baressco',
                'desc'        => 'Wine & Vineyard Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/baressco/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://baressco.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/baressco',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Baressco Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_baressco',
                    'ext_code'  =>  'tz-baressco-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_powfit'      =>  array(
                // Pack Info
                'name'        => 'PowFit',
                'desc'        => 'Gym Fitness Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/powfit/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://powfit.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/powfit',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'PowFit Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_powfit',
                    'ext_code'  =>  'tz-powfit-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_alex'      =>  array(
                // Pack Info
                'name'        => 'Alex',
                'desc'        => 'Portfolio Personal Blogger Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/alex/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://alex.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/alex',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Alex Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_alex',
                    'ext_code'  =>  'tz-alex-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                ),
            ),
            'tz_lefala'      =>  array(
                // Pack Info
                'name'        => 'Lefala',
                'desc'        => 'Hikashop eCommerce Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/lefala/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://lefala.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/lefala',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Lefala Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_lefala',
                    'ext_code'  =>  'tz-lefala-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
                    self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_newspaper'      =>  array(
                // Pack Info
                'name'        => 'Newspaper',
                'desc'        => 'Magazine, Blog Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/newspaper/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://newspaper.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/newspaper',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Newspaper Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_newspaper',
                    'ext_code'  =>  'tz-newspaper-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                ),
            ),
            'tz_magazine'      =>  array(
                // Pack Info
                'name'        => 'Magazine',
                'desc'        => 'Blog, Newspaper Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/magazine/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://magazine.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/magazine',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Magazine Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_magazine',
                    'ext_code'  =>  'tz-magazine-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                ),
            ),
            'tz_varaham'      =>  array(
                // Pack Info
                'name'        => 'Varaham',
                'desc'        => 'Education University Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/varaham/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://varaham.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/varaham',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Varaham Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_varaham',
                    'ext_code'  =>  'tz-varaham-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                ),
            ),
            'tz_krypton'      =>  array(
                // Pack Info
                'name'        => 'Krypton',
                'desc'        => 'Bitcoin Crypto Currency Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/krypton/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://krypton.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/krypton',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Krypton Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_krypton',
                    'ext_code'  =>  'tz-krypton-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                ),
            ),
            'tz_alita'      =>  array(
                // Pack Info
                'name'        => 'Alita',
                'desc'        => 'Web Studio & Creative Agency Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/alita/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://alita.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/alita',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Alita Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_alita',
                    'ext_code'  =>  'tz-alita-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_martha'      =>  array(
                // Pack Info
                'name'        => 'Martha',
                'desc'        => 'Creative Portfolio Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/martha/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://martha.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/martha',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Martha Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_martha',
                    'ext_code'  =>  'tz-martha-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_logistics'      =>  array(
                // Pack Info
                'name'        => 'Logistics',
                'desc'        => 'Cargo Transportation Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/logistics/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://logistics.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/logistics',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Logistics Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_logistics',
                    'ext_code'  =>  'tz-logistics-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_pethub'      =>  array(
                // Pack Info
                'name'        => 'PetHub',
                'desc'        => 'Dog, Cat Care & Veterinary Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/pethub/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://pethub.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/pethub',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'PetHub Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_pethub',
                    'ext_code'  =>  'tz-pethub-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['ui-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_goldena'      =>  array(
                // Pack Info
                'name'        => 'GoldenA',
                'desc'        => 'Single Property Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/goldena/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://goldena.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/goldena',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'GoldenA Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_goldena',
                    'ext_code'  =>  'tz-goldena-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_educab'      =>  array(
                // Pack Info
                'name'        => 'Educab',
                'desc'        => 'University Education Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/educab/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://educab.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/educab',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Educab Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_educab',
                    'ext_code'  =>  'tz-educab-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'profiler-joomla-template'      =>  array(
                // Pack Info
                'name'        => 'Profiler',
                'desc'        => 'Personal Blog Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/profiler/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://profiler.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/profiler',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Profiler Template',
                    'type'      =>  'included',
                    'code'      =>  'profiler-joomla-template',
                    'ext_code'  =>  'tz-profiler-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_musika'      =>  array(
                // Pack Info
                'name'        => 'Musika',
                'desc'        => 'Music Band Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/musika/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://musika.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/musika',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Musika Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_musika',
                    'ext_code'  =>  'tz-musika-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_jollyany'   =>  array(
                // Pack Info
                'name'        => 'Jollyany Classic',
                'desc'        => 'Multi-purpose, Business & Corporation',

                // Pack Data
                'thumb'       => '/images/stories/jollyany/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://jollyany.co/',
                'doc_url'     => 'https://jollyany.co/support/documentation',

                'joomla_version'     => array(3,4,5),

                'template'    => array(
                    'name'      =>  'Jollyany Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_jollyany',
                    'ext_code'  =>  'tz-jollyany-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                ),
            ),
            'tz_everline_joomla'      =>  array(
                // Pack Info
                'name'        => 'Everline',
                'desc'        => 'Wedding Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/everline/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://everline.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/everline',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Everline Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_everline_joomla',
                    'ext_code'  =>  'tz-everline-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_eventory_joomla'      =>  array(
                // Pack Info
                'name'        => 'Eventory',
                'desc'        => 'Festival, Event Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/eventory/eventory_590.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://eventory.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/eventory',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Eventory Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_eventory_joomla',
                    'ext_code'  =>  'tz-eventory-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_meetup'      =>  array(
                // Pack Info
                'name'        => 'Meetup',
                'desc'        => 'Conference Event Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/meetup/meetup.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://meetup.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/meetup',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Meetup Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_meetup',
                    'ext_code'  =>  'tz-meetup-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_new_age'      =>  array(
                // Pack Info
                'name'        => 'New Age',
                'desc'        => 'Creative Agency, Business, Company',

                // Pack Data
                'thumb'       => '/images/stories/new_age/new_age_590.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://newage.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/new-age',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'New Age Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_new_age',
                    'ext_code'  =>  'tz-new-age-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_nish_ii'   =>  array(
                // Pack Info
                'name'        => 'Nish II',
                'desc'        => 'Portfolio, Agency & Photography',

                // Pack Data
                'thumb'       => '/images/stories/nish_ii/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://nish2.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/nish_ii',

                'joomla_version'     => array(3,4,5),

                'template'    => array(
                    'name'      =>  'Nish II Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_nish_ii',
                    'ext_code'  =>  'tz-nish-ii-api',
                ),

                'extensions'  => array(
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_fashion_semona_joomla'      =>  array(
                // Pack Info
                'name'        => 'Fashion',
                'desc'        => 'Model Agency, Photography',

                // Pack Data
                'thumb'       => '/images/stories/fashion/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://fashion.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/fashion',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Fashion Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_fashion_semona_joomla',
                    'ext_code'  =>  'tz-fashion-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_lawyer'    =>  array(
                // Pack Info
                'name'        => 'Lawyer Justice',
                'desc'        => 'Lawyers Attorneys and Law Firm',

                // Pack Data
                'thumb'       => '/images/stories/lawyer_justice/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://justice.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/lawyer-justice',

                'joomla_version'     => array(3,4,5),

                'template'    => array(
                    'name'      =>  'Lawyer Justice Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_lawyer',
                    'ext_code'  =>  'tz-lawyer-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_charity_joomla'    =>  array(
                // Pack Info
                'name'        => 'Charity',
                'desc'        => 'Non-profit, NGO & Fundraising',

                // Pack Data
                'thumb'       => '/images/stories/charity/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://charity.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/charity',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Charity Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_charity_joomla',
                    'ext_code'  =>  'tz-charity-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_foodz_joomla'      =>  array(
                // Pack Info
                'name'        => 'Foodz',
                'desc'        => 'Restaurant, Receipt & Bakery',

                // Pack Data
                'thumb'       => '/images/stories/foodz/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://foodz.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/foodz',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Foodz Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_foodz_joomla',
                    'ext_code'  =>  'tz-foodz-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
            'tz_construction'      =>  array(
                // Pack Info
                'name'        => 'Construction',
                'desc'        => 'Building, Construction & Architect',

                // Pack Data
                'thumb'       => '/images/stories/construction/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://construction.jollyany.co/',
                'doc_url'     => 'https://docs.jollyany.co/templates/construction/',

                'joomla_version'     => array(3,4,5),

                'template'      => array(
                    'name'      =>  'Construction Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_construction',
                    'ext_code'  =>  'tz-construction-api',
                ),

                'extensions'  => array(
                    self::$exts['sp-page-builder'],
	                self::$exts['uk-sp-addons'],
                    self::$exts['tz-portfolio'],
                    self::$exts['hikashop'],
                ),
            ),
        );
	    foreach (self::$data as $key => &$temp) {
	        $temp['thumb'] = self::getThumb($temp['thumb']);
        }
		return self::$data;
	}
}
