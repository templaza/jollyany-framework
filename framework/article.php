<?php
/**
 * @package   Jollyany Framework
 * @author    TemPlaza https://www.templaza.com
 * @copyright Copyright (C) 2011 - 2023 TemPlaza.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;
jimport('astroid.framework.article');
jimport('jollyany.framework.jollyany');
use Astroid\Framework;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\PluginHelper;

class JollyanyFrameworkArticle extends AstroidFrameworkArticle {
    public $print;
    public $isCategoryView;
    public $categoryParams;
	function __construct($article, $categoryView = false, $print = null) {
		parent::__construct($article, $categoryView);
		$this->template         =   Framework::getTemplate();
		$this->print            =   $print;
		$this->isCategoryView   =   $categoryView;
		$this->categoryParams   =   $this->_getCategoryParams();
	}

    public function renderArticleBody()
    {
        $html   =   $this->renderEventData();
        $html   .=  $this->renderCourseData();
        return $html;
    }

    public function renderCourseData() {
        $canEdit = $this->article->params->get('access-edit');
        $assocParam = (JLanguageAssociations::isEnabled() && $this->article->params->get('show_associations'));
        $lessons    =   $this->article->params->get('jollyany_course_lessons', '');
        ob_start();
        // Todo Not that elegant would be nice to group the params
        $useDefList = ($this->article->params->get('show_modify_date') || $this->article->params->get('show_publish_date') || $this->article->params->get('show_create_date') || $this->article->params->get('show_hits') || $this->article->params->get('show_category') || $this->article->params->get('show_parent_category') || $this->article->params->get('show_author') || $assocParam || $this->template->params->get('astroid_readtime', 1));
        if (($this->categoryParams->get('course_category_data','') || ($this->categoryParams->get('course_category_data','') === "" && $this->template->params->get('course_category_data',''))) && (is_array($lessons) && count($lessons))) : ?>
            <div class="jollyany-course-tab">
                <ul class="uk-child-width-expand" uk-tab uk-switcher="connect: .jollyany-course-content">
                    <li>
                        <a class="nav-link" href="#description"><?php echo JText::_('JGLOBAL_DESCRIPTION') ?></a>
                    </li>
                    <li>
                        <a class="nav-link" href="#lessons"><?php echo JText::_('JOLLYANY_COURSE_OPTIONS_TITLE_BASIC_LABEL') ?></a>
                    </li>
                    <li>
                        <a class="nav-link" href="#contact"><?php echo JText::_('JOLLYANY_COURSE_CONTACT_DETAILS') ?></a>
                    </li>
                </ul>
                <div class="uk-switcher jollyany-course-content uk-margin-medium">
                    <div class="uk-animation-slide-bottom-small">
                        <?php if (!$this->print) : ?>
                            <?php if ($canEdit || $this->article->params->get('show_print_icon') || $this->article->params->get('show_email_icon')) :  ?>
                                <?php echo LayoutHelper::render('joomla.content.icons', array('params' => $this->article->params, 'item' => $this->article, 'print' => false)); ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($useDefList) : ?>
                                <div id="pop-print" class="btn hidden-print">
                                    <?php echo HTMLHelper::_('icon.print_screen', $this->article, $this->article->params); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php echo $this->article->text; ?>
                    </div>
                    <div class="uk-animation-slide-bottom-small jollyany-course-table">
                        <?php
                        $opened_flag    =   false;
                        $modal_content  =   '';
                        $table_content  =   '';
                        $index          =   0;
                        $section        =   0;
                        foreach ($lessons as $key => $lesson) {
                            if ($lesson['jollyany_lesson_type'] == 'section') {
                                $section++;
                                if ($opened_flag) $table_content    .=  '</tbody></table>';
                                $table_content  .=  '<h4 class="lesson-section-title">'.$lesson['lesson_section_title'].'</h4>';
                                $table_content  .=  '<table class="table table-hover lesson-table"><tbody>';
                                $opened_flag    =    true;
                                $index          =   0;
                            } else {
                                $index++;
                                if (!$opened_flag) {
                                    $table_content  .=  '<table class="table table-hover lesson-table"><tbody>';
                                    $opened_flag    =   true;
                                }
                                $modal_content  .=  '<div id="jollyany-course-modal-'.$key.'" class="uk-modal-full jollyany-course-detail" data-token="'.\JSession::getFormToken().'" data-id="'.$key.'" data-cid="'.$this->article->id.'" uk-modal><div class="uk-modal-dialog"><button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>';
                                $modal_content  .=  '<div class="uk-grid-collapse" uk-height-match uk-grid>';

                                $modal_content  .=  '<div class="jollyany-course-lesson-detail uk-padding-large uk-width-2-3@m uk-width-3-5@l uk-flex-last@m" uk-height-viewport></div>';
                                $modal_content  .=  '<div class="jollyany-course-table-content uk-padding-large uk-background-muted uk-width-1-3@m uk-width-2-5@l"></div>';

                                $modal_content  .=  '</div>';
                                $modal_content  .=  '</div></div>';
                                $downloadslider     =   isset($lesson['lesson_content_download_link']) && $lesson['lesson_content_download_link'] ? '<div><a href="'.JUri::root().'images/'.$lesson['lesson_content_download_link'].'" title="'.$lesson['lesson_content_title'].'" target="_blank"><span class="uk-badge"><i class="fas fa-download"></i></span></a></div>' : '';
//                            echo '<tr><td width="45"><span uk-icon="play-circle"></span></td><td class="lesson-title"><a href="'.$lesson['lesson_content_video_url'].'" title="'.$lesson['lesson_content_title'].'" data-fancybox>'.$lesson['lesson_content_title'].'</a></td><td class="lesson-option">'.$lesson['lesson_content_duration'].'<span>'.$downloadslider.'</td></tr>';
                                $table_content  .=  '<tr><td class="lesson-icon" width="45"><span uk-icon="file-text"></span></td><td class="lesson-index uk-visible@m" width="110">'.JText::_('JOLLYANY_COURSE_LECTURE').' '.$section.'.'.$index.'</td><td class="lesson-title"><a href="#jollyany-course-modal-'.$key.'" uk-toggle>'.$lesson['lesson_content_title'].'</a></td><td class="lesson-option uk-width-small uk-text-meta"><div class="uk-grid-small uk-flex-middle uk-flex-right" uk-grid><div>'.$lesson['lesson_content_duration'].'</div>'.$downloadslider.'</div></td></tr>';
                            }
                        }
                        $table_content  .=  '</tbody></table>';
                        echo $table_content;
                        $table_modal    =   preg_replace('/<a href="#jollyany-course-modal-(.*?)" uk-toggle>(.*?)<\/a>/i', '<a href="#" class="jollyany-course-modal-detail" data-id="$1" data-cid="'.$this->article->id.'">$2</a>', $table_content);
                        $table_modal    =   preg_replace('/<td class="lesson-icon" width="45">/i', '<td class="lesson-icon uk-visible@l">', $table_modal);
                        $table_modal    =   preg_replace('/<td class="lesson-index uk-visible@m" width="110">/i', '<td class="lesson-index uk-visible@xl" width="110">', $table_modal);
                        echo '<script id="jollyany-course-table-content-template" type="text/template">'.$table_modal.'</script>'
                        ?>
                    </div>
                    <div class="uk-animation-slide-bottom-small">
                        <?php
                        $contact_course_info    =   $this->categoryParams->get('course_category_contact_info','');
                        if (!$contact_course_info) {
                            $contact_course_info = $this->template->params->get('course_contact_info','');
                        }
                        echo '<div class="course-contact-info">'.$contact_course_info.'</div>';
                        ?>
                        <form class="jollyany-course-contact-form">
                            <div class="uk-child-width-1-2@m uk-margin uk-grid-small" uk-grid>
                                <div>
                                    <input class="uk-input" name="from_name" type="text" required="required" placeholder="<?php echo JText::_('JOLLYANY_COURSE_CONTACT_NAME'); ?>">
                                </div>
                                <div>
                                    <input class="uk-input" name="from_email" type="text" required="required" placeholder="<?php echo JText::_('JOLLYANY_COURSE_CONTACT_EMAIL'); ?>">
                                </div>
                            </div>
                            <div class="uk-child-width-1-2@m uk-margin uk-grid-small" uk-grid>
                                <div>
                                    <input class="uk-input" name="phone" type="text" placeholder="<?php echo JText::_('JOLLYANY_COURSE_CONTACT_TELEPHONE'); ?>">
                                </div>
                                <div>
                                    <input class="uk-input" name="subject" type="text" required="required" placeholder="<?php echo JText::_('JOLLYANY_COURSE_CONTACT_MESSAGE_SUBJECT_DESC'); ?>">
                                </div>
                            </div>
                            <div class="uk-margin">
                                <textarea class="uk-textarea" name="message" rows="5" required="required" placeholder="<?php echo JText::_('JOLLYANY_COURSE_CONTACT_ENTER_MESSAGE_DESC'); ?>"></textarea>
                            </div>
                            <div class="uk-margin">
                                <label><input class="uk-checkbox" name="agreement" type="checkbox"><?php echo ' '.$this->template->params->get('course_contact_agreement','I agree with the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and I declare that I have read the information that is required in accordance with <a href="http://eur-lex.europa.eu/legal-content/EN/TXT/?uri=uriserv:OJ.L_.2016.119.01.0001.01.ENG&amp;toc=OJ:L:2016:119:TOC" target="_blank">Article 13 of GDPR.</a>'); ?></label>
                            </div>
                            <?php if ($this->template->params->get('course_contact_recaptcha',0)) : ?>
                                <div class="uk-margin">
                                    <?php
                                    if ($this->template->params->get('course_contact_recaptcha_type','recaptcha')) {
                                        PluginHelper::importPlugin('captcha', 'recaptcha');
//                                        $dispatcher = Dispatcher::getInstance();
//                                        $dispatcher->trigger('onInit', 'jollyany_course_contact_recaptcha');
                                        $recaptcha = Factory::getApplication()->triggerEvent('onDisplay', array(null, 'jollyany_course_contact_recaptcha' , 'jollyany-course-contact-recaptcha'));
                                        echo (isset($recaptcha[0])) ? $recaptcha[0] : '<p class="uk-alert-danger">' . JText::_('JOLLYANY_RECAPTCHA_NOT_INSTALLED') . '</p>';
                                    } else {
                                        PluginHelper::importPlugin('captcha', 'recaptcha_invisible');
//                                        $dispatcher = Dispatcher::getInstance();
//                                        $dispatcher->trigger('onInit', 'jollyany_course_contact_invisible_recaptcha');
                                        $recaptcha = Factory::getApplication()->triggerEvent('onDisplay', array(null, 'jollyany_course_contact_invisible_recaptcha' , 'jollyany-course-contact-invisible-recaptcha'));
                                        echo (isset($recaptcha[0])) ? $recaptcha[0] : '<p class="uk-alert-danger">' . JText::_('JOLLYANY_RECAPTCHA_NOT_INSTALLED') . '</p>';
                                    }
                                    ?>
                                    <input type="hidden" name="captcha_type" value="<?php echo $this->template->params->get('course_contact_recaptcha_type','recaptcha'); ?>">
                                </div>
                            <?php endif; ?>
                            <input type="hidden" class="token" name="<?php echo \JSession::getFormToken(); ?>" value="1">
                            <div class="uk-margin">
                                <button type="submit" class="uk-button uk-button-primary uk-border-rounded"><?php echo JText::_('JOLLYANY_COURSE_CONTACT_SENT_TEXT'); ?></button>
                            </div>
                            <div class="jollyany-ajax-contact-status uk-margin"></div>
                        </form>
                    </div>
                </div>
            </div>
            <?php echo $modal_content; ?>
        <?php else: ?>
            <?php echo $this->article->text; ?>
        <?php endif;
        return ob_get_clean();
    }

    public function renderEventData() {
	    ob_start();
        $event_available    =   $this->article->params->get('jollyany_event_location', '') || $this->article->params->get('jollyany_event_phone', '') || $this->article->params->get('jollyany_event_start', '') || $this->article->params->get('jollyany_event_end', '') || $this->article->params->get('jollyany_event_spot', '') || $this->article->params->get('jollyany_event_long_lat', '') || $this->article->params->get('jollyany_event_url', '');
        if ($event_available) :
            $document = Framework::getDocument();
            echo '<div class="event-information uk-card uk-card-body uk-card-default uk-margin-medium">';
            echo '<div class="event-countdown">';
            if ((!$this->isCategoryView || ($this->isCategoryView && $this->categoryParams->get('jollyany_show_event_countdown',0))) && ($this->article->params->get('jollyany_event_start', '') || $this->article->params->get('jollyany_event_end', ''))) {

                echo '<div class="time-count-down">';
                $expired_ms     =   time() < strtotime($this->article->params->get('jollyany_event_end', ''))  ? JText::_('JOLLYANY_EVENT_START_MS') : JText::_('JOLLYANY_EVENT_EXPIRED_MS');
                $event_expired  =   $this->article->params->get('jollyany_event_expired', $expired_ms);
                $document->addScript('media/jollyany/assets/js/vendor/jquery.countdown.min.js');
                $countdown_id    =   uniqid('countdown_');
                $txt            =   '';
                $countdown_time =   '';
                if (time() < strtotime($this->article->params->get('jollyany_event_start', ''))) {
                    $txt        =   JText::_('JOLLYANY_COUNTDOWN_START');
                    $countdown_time =   date('Y/m/d H:i:s', strtotime($this->article->params->get('jollyany_event_start', '')));
                }
                elseif (time() < strtotime($this->article->params->get('jollyany_event_end', ''))) {
                    $txt        =   JText::_('JOLLYANY_COUNTDOWN_END');
                    $countdown_time =   date('Y/m/d H:i:s', strtotime($this->article->params->get('jollyany_event_end', '')));
                }

                echo $txt ? '<div class="count-down-intro">'.$txt.'</div>' : '';
                ?>
                <h3 id="<?php echo $countdown_id; ?>" class="uk-heading-small uk-margin-remove-vertical"></h3>
                <script type="text/javascript">
                    jQuery(function($){
                        $(document).ready(function(){
                            $('#<?php echo $countdown_id; ?>').countdown('<?php echo $countdown_time; ?>')
                                .on('update.countdown', function(event) {
                                    var format = '%H:%M:%S';
                                    if((event.offset.totalDays > 0 && event.offset.weeks === 0) || (event.offset.totalDays % 7 > 0)) {
                                        format = '<?php echo JText::_('JOLLYANY_EVENT_DAY'); ?> ' + format;
                                    }
                                    if(event.offset.weeks > 0) {
                                        format = '<?php echo JText::_('JOLLYANY_EVENT_WEEK'); ?> ' + format;
                                    }
                                    $(this).html(event.strftime(format));
                                })
                                .on('finish.countdown', function(event) {
                                    $(this).html('<?php echo addslashes($event_expired); ?>')
                                        .parent().addClass('disabled');
                                });
                        });
                    });
                </script>
                <?php
                echo '</div>';
            }
            if ( !$this->isCategoryView && $this->article->params->get('jollyany_event_url', '') && (!$this->article->params->get('jollyany_event_start', '') || time() < strtotime($this->article->params->get('jollyany_event_start', '')))) { ?>
                <div class="call-to-action"><a href="<?php echo $this->article->params->get('jollyany_event_url', ''); ?>" class="uk-button uk-button-primary"><?php echo $this->article->params->get('jollyany_event_url_text', JText::_('JOLLYANY_EVENT_BUTTON_TEXT')); ?></a></div>
            <?php }
            echo '</div>';
            echo '<hr />';
            echo '<div class="event-info">';
            echo '<table><tbody>';
            if ((!$this->isCategoryView || ($this->isCategoryView && $this->categoryParams->get('jollyany_show_event_location',0))) && $this->article->params->get('jollyany_event_location', '')) {
                echo '<tr><td class="event-location" width="30"><span uk-icon="icon: location"></span></td><td>'. $this->article->params->get('jollyany_event_location', '') .'</td></tr>';
            }
            if ((!$this->isCategoryView || ($this->isCategoryView && $this->categoryParams->get('jollyany_show_event_duration',0))) && ($this->article->params->get('jollyany_event_start', '') || $this->article->params->get('jollyany_event_end', ''))) {
                $event_duration =   array();
                if ($this->article->params->get('jollyany_event_start', '')) {
                    $event_duration[]   =   HTMLHelper::_('date', $this->article->params->get('jollyany_event_start', ''), Text::_('DATE_FORMAT_LC2'));
                }
                if ($this->article->params->get('jollyany_event_end', '')) {
                    $event_duration[]   =   HTMLHelper::_('date', $this->article->params->get('jollyany_event_end', ''), Text::_('DATE_FORMAT_LC2'));
                }
                echo '<tr><td class="event-duration"><span uk-icon="icon: calendar"></span></td><td>'. implode('<span uk-icon="icon: arrow-right"></span>', $event_duration) .'</td></tr>';
            }
            if ((!$this->isCategoryView || ($this->isCategoryView && $this->categoryParams->get('jollyany_show_event_seats',0))) && $this->article->params->get('jollyany_event_spot', '')) {
                echo '<tr><td class="event-spot"><span uk-icon="icon: users"></span></td><td>'. JText::sprintf('JOLLYANY_EVENT_SPOT_TEXT', $this->article->params->get('jollyany_event_spot', ''))  .'</td></tr>';
            }
            if ((!$this->isCategoryView || ($this->isCategoryView && $this->categoryParams->get('jollyany_show_event_phone',0))) && $this->article->params->get('jollyany_event_phone', '')) {
                echo '<tr><td class="event-phone"><span uk-icon="icon: receiver"></span></td><td>'. $this->article->params->get('jollyany_event_phone', '') .'</td></tr>';
            }
            echo '</tbody></table>';
            echo '</div>';
            echo '</div>';
            if (!$this->isCategoryView && $this->article->params->get('jollyany_event_long_lat', '')) {
                $longlat    =   explode(',', $this->article->params->get('jollyany_event_long_lat', ''));
                $googlemapmousescroll   =   $this->template->params->get('googlemapmousescroll', 0) ? 'true' : 'false';
                $googlemapshowcontrol   =   $this->template->params->get('googlemapshowcontrol', 0) ? 'false' : 'true';
                $locations    =   $this->article->params->get('event_multi_locations', '');
                $location_addr = [];
                foreach ($locations as $location) {
                    $location_longlat   =   explode(',', $location['jollyany_location_long_lat']);
                    if (count($location_longlat)>1) {
                        $location_addr[] = array('address'=>$location['jollyany_location_infowindow'], 'latitude'=>trim($location_longlat[0]),'longitude'=>trim($location_longlat[1]));
                    }
                }
                $location_json = json_encode($location_addr);
                $google_id    =   uniqid('googlemap_');
                $document->addStyleDeclaration('#'.$google_id.'{height:'.$this->template->params->get('googlemapheight', '400').'px;}');
                $document->addScript('https://maps.googleapis.com/maps/api/js?key='. $this->template->params->get('googleapikey', ''));
                $document->addScript('media/jollyany/assets/js/vendor/gmap.min.js');
                echo '<div class="event_googlemaps uk-margin-medium">';
                echo '<div id="'.$google_id.'" class="googlemapapi" data-lat="' . trim($longlat[0]) . '" data-lng="' . trim($longlat[1]) . '"  data-location=\''.base64_encode($location_json).'\' data-maptype="' . $this->template->params->get('googlemaptype','ROADMAP') . '" data-mapzoom="' . $this->template->params->get('googlemapzoom', '15') . '" data-mousescroll="' . $googlemapmousescroll . '" data-infowindow="' . base64_encode($this->article->params->get('jollyany_event_infowindow', '')) . '" data-show-controll=\''.$googlemapshowcontrol.'\'></div>';
                echo '</div>';
            }
        endif;
            $html   =   ob_get_clean();
        return $html;
    }

    protected function _getCategoryParams()
    {
        $params = new JRegistry();
        if (!empty($this->article->catid)) {
            $db = JFactory::getDbo();
            $query = "SELECT `params` FROM `#__categories` WHERE `id`=" . $this->article->catid;
            $db->setQuery($query);
            $result = $db->loadObject();
            if (!empty($result)) {
                $params->loadString($result->params, 'JSON');
            }
        }
        return $params;
    }

    public static function getLectureTotal($id) {
	    if (!$id) return '';
	    $content = '';
        $course_data =   JollyanyFrameworkCourse::getData($id);
        if ($course_data) {
            $courses = json_decode($course_data->data,true);
            if (count($courses)) {
                $lectures   =   0;
                foreach ($courses as $course) {
                    if ($course['jollyany_lesson_type'] == 'content') {
                        $lectures++;
                    }
                }
                $content .= '<div class="uk-text-meta uk-margin">';
                $content .= '<i class="fas fa-book"></i>&nbsp;&nbsp;'. $lectures . ' ' . JText::_('JOLLYANY_COURSE_LECTURES');
                $content .= '</div>';
            }
        }
        return $content;
    }

    public static function getEventData($params, $row) {
        if (!$params) return '';
        $content = '';
        if ($params->get('jollyany_show_event_duration',0) || $params->get('jollyany_show_event_location',0) || $params->get('jollyany_show_event_seats',0) || $params->get('jollyany_show_event_phone',0)) {
            $content .= '<div class="ui-article-event uk-text-meta uk-margin">';
            if ($params->get('jollyany_show_event_duration',0) && ($row->get('jollyany_event_start','') || $row->get('jollyany_event_end',''))) {
                $content .= '<div class="uk-grid-small" uk-grid>';
                $event_duration =   array();
                if ($row->get('jollyany_event_start','')) {
                    $event_duration[]   =   HTMLHelper::_('date', $row->get('jollyany_event_start',''), 'F d, Y H:i');
                }
                if ($row->get('jollyany_event_end','')) {
                    $event_duration[]   =   HTMLHelper::_('date', $row->get('jollyany_event_end',''), 'F d, Y H:i');
                }
                $content .= '<div class="uk-width-auto"><span uk-icon="icon: clock; ratio: 0.8"></span></div><div class="uk-width-expand">'. implode('<span uk-icon="icon: arrow-right"></span>', $event_duration).'</div>';
                $content .= '</div>';
            }

            if ($params->get('jollyany_show_event_location',0) && $row->get('jollyany_event_location','')) {
                $content .= '<div class="uk-grid-small" uk-grid>';
                $content .= '<div class="uk-width-auto"><span uk-icon="icon: location; ratio: 0.8"></span></div><div class="uk-width-expand">'.$row->get('jollyany_event_location','').'</div>';
                $content .= '</div>';
            }

            if ($params->get('jollyany_show_event_seats',0) && $row->get('jollyany_event_spot','')) {
                $content .= '<div class="uk-grid-small" uk-grid>';
                $content .= '<div class="uk-width-auto"><span uk-icon="icon: users; ratio: 0.8"></span></div><div class="uk-width-expand">'.JText::sprintf('JOLLYANY_EVENT_SPOT_TEXT', $row->get('jollyany_event_spot','')).'</div>';
                $content .= '</div>';
            }

            if ($params->get('jollyany_show_event_phone',0) && $row->get('jollyany_event_phone','')) {
                $content .= '<div class="uk-grid-small" uk-grid>';
                $content .= '<div class="uk-width-auto"><span uk-icon="icon: receiver; ratio: 0.8"></span></div><div class="uk-width-expand">'.$row->get('jollyany_event_phone','').'</div>';
                $content .= '</div>';
            }
            $content .= '</div>';
        }

        return $content;
    }
}