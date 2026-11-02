<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://templaza.com
 * @copyright Copyright (C) 2009 - 2021 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
namespace Jollyany\Helper;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

class DataImport {
	protected $api  =   '';
    protected $isCloud =   false;
    protected $cloudKey   =   '';
	public $cache   =    array('thumb' => array());
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
	protected $data =    null;
    protected static $replacer   =   [
        'tz_fashion_semona_joomla'  => 'tz_fashion',
        'tz_everline_joomla'        => 'tz_everline',
        'tz_eventory_joomla'        => 'tz_eventory',
        'tz_charity_joomla'         => 'tz_charity',
        'tz_foodz_joomla'           => 'tz_foodz',
        'profiler-joomla-template'  => 'tz_profiler',
    ];

    public function __construct($api= 'https://templaza.com')
    {
        $this->api = $api;
        $this->data = array(
            'tz_unican'      =>  array(
                // Pack Info
                'name'        => 'Unican',
                'desc'        => 'Education & Online Courses Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/unican/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://unican.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Unican Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_unican',
                    'ext_code'  =>  'tz-unican-api',
                ),
            ),
            'astroid_sbona'      =>  array(
                // Pack Info
                'name'        => 'Sbona',
                'desc'        => 'Sport Clubs & Outdoors Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/sbona/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://sbona.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Sbona Template',
                    'type'      =>  'included',
                    'code'      =>  'astroid_sbona',
                    'ext_code'  =>  'astroid-sbona-api',
                ),
            ),
            'astroid_kowalski'      =>  array(
                // Pack Info
                'name'        => 'Kowalski',
                'desc'        => 'Creative Portfolio Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/kowalski/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://kowalski.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Kowalski Template',
                    'type'      =>  'included',
                    'code'      =>  'astroid_kowalski',
                    'ext_code'  =>  'astroid-kowalski-api',
                ),
            ),
            'astroid_nika'      =>  array(
                // Pack Info
                'name'        => 'Nika',
                'desc'        => 'AI Software Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/nika/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://nika.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Nika Template',
                    'type'      =>  'included',
                    'code'      =>  'astroid_nika',
                    'ext_code'  =>  'astroid-nika-api',
                ),
            ),
            'tz_kamper'      =>  array(
                // Pack Info
                'name'        => 'Kamper',
                'desc'        => 'Camping & Outdoor accommodation Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/kamper/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://kamper.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Kamper Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_kamper',
                    'ext_code'  =>  'tz-kamper-api',
                ),
            ),
            'tz_likeastar'      =>  array(
                // Pack Info
                'name'        => 'Like a Star',
                'desc'        => 'Creative Agency Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/likeastar/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://likeastar.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/like-a-star',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Like a Star Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_likeastar',
                    'ext_code'  =>  'tz-likeastar-api',
                ),
            ),
            'tz_travelami'      =>  array(
                // Pack Info
                'name'        => 'Travelami',
                'desc'        => 'Tour & Travel Booking Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/travelami/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://travelami.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/travelami',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Travelami Template',
                    'type'      =>  'included',
                    'code'      =>  'tz_travelami',
                    'ext_code'  =>  'tz-travelami-api',
                ),

                'extensions'  => array(
                    self::$exts['tz-portfolio'],
                ),
            ),
            'astroid_template_two'      =>  array(
                // Pack Info
                'name'        => 'Two',
                'desc'        => 'Free Astroid Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/two/thumbnail.jpg',
                'category'    => 'joomla',
                'type'        => 'free',
                'download'    => 'https://github.com/templaza/astroid-framework/releases/latest',

                'demo_url'    => 'https://demo.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/',

                'joomla_version'     => array(4,5,6),

                'template'      => array(
                    'name'      =>  'Astroid Two Template',
                    'type'      =>  'included',
                    'code'      =>  'astroid_template_two',
                    'ext_code'  =>  'astroid-template-two-api',
                ),

                'extensions'  => array(
                ),
            ),
            'tz_probike'      =>  array(
                // Pack Info
                'name'        => 'ProBike',
                'desc'        => 'Bike Shop & Bicycle Rental Joomla Template',

                // Pack Data
                'thumb'       => '/images/stories/probike/thumbnail.jpg',
                'category'    => 'joomla',

                'demo_url'    => 'https://probike.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/probike',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://autobike.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/autobike',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://express.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/express',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://amanus.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/amanus',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://plazart.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/plazart',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://todaynews.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/todaynews',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://interiart.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/interiart',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://medil.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/medil',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://agruco.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/agruco',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://oraz.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/oraz',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://goldenheart.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/goldenheart',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://organico.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/organico',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://baressco.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/baressco',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://powfit.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/powfit',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://alex.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/alex',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://lefala.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/lefala',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://newspaper.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/newspaper',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://magazine.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/magazine',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://varaham.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/varaham',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://krypton.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/krypton',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://alita.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/alita',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://martha.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/martha',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://logistics.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/logistics',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://pethub.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/pethub',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://goldena.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/goldena',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://educab.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/educab',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://profiler.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/profiler',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://musika.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/musika',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://jollyany.astroidframe.work/',
                'doc_url'     => 'https://astroidframe.work/support/documentation',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://everline.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/everline',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://eventory.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/eventory',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://meetup.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/meetup',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://newage.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/new-age',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://nish2.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/nish_ii',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://fashion.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/fashion',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://justice.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/lawyer-justice',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://charity.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/charity',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://foodz.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/foodz',

                'joomla_version'     => array(4,5,6),

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

                'demo_url'    => 'https://construction.astroidframe.work/',
                'doc_url'     => 'https://docs.astroidframe.work/templates/construction/',

                'joomla_version'     => array(4,5,6),

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
        foreach ($this->data as $key => &$temp) {
            $temp['thumb'] = $this->getThumb($temp['thumb']);
        }
    }

	public function getThumb($src) {
        if (file_exists(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'jollyany'.$src)) {
            return Uri::base(true).'/cache/jollyany'.$src;
        } else {
            $this->cache['thumb'][] =   $src;
            return $this->api.$src;
        }
    }

    public function getTotalTemplate() {
        return count($this->getData());
    }

	public function getApiUrl() {
		return $this->api;
	}

    public function setApiUrl($api = ''): void
    {
        if ($api) $this->api = $api;
    }

    public function setCloudKey($key = ''): void
    {
        if ($key) {
            $this->isCloud  =   true;
            $this->cloudKey =   $key;
        }
    }

    public function isCloudPackage()
    {
        return $this->isCloud;
    }

    public function getCloudKey()
    {
        return $this->cloudKey;
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

	public function getData() {
		return $this->data;
	}
}
