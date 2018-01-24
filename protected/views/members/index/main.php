<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
include (APPPATH . 'controllers/HomeController.php');
/**
 * Main controller
 *
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 *
 * @property        CI_Email $email
 * @property        CI_User_agent $agent
 * @property        Property $property
 * @property        PropertyType $propertyType
 * @property        Type $type
 * @property        PropertyImage $propertyImage
 * @property        Status $status
 * @property        Region $region
 * @property        City $city
 * @property        Island $island
 * @property        Category $category
 * @property        Advantage $advantage
 * @property        Article $article
 * @property        Module $module
 */
class Main extends HomeController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('module', 'page'));
        $this->load->helper('text');
    }

    public function index()
    { 
        $this->load->model(array('type', 'status', 'region','location', 'property', 'article'));
        $this->data['nav'] = Page::HOME;
        $this->data['disableLeftModule'] = true;
        $this->data['disableRightModule'] = true;
        $this->data['propertyTypes'] = $this->type->getTypeList($this->session->userdata('language'));
        $this->data['propertyTypesEn'] = $this->type->getTypeList();
        $this->data['reservedStatuses'] = $this->status->getReservedStatuses();
        $this->data['properties'] = $this->property->getHighlightedProperties();
        $this->data['regions'] = $this->region->getRegionList($this->session->userdata('language'));
        $this->data['regionsEn'] = $this->region->getRegionList();
        $this->data['region_locations'] = json_encode($this->location->getLocationAndRegionIdList($this->session->userdata('language')));
        $this->data['region_locationsEn'] = json_encode($this->location->getLocationAndRegionIdList("EN"));
        $this->data['article'] = $this->article->getArticles();
        $this->data['modules'] = $this->module->getWritings(array('placement' => Module::MIDDLE, 'limit' => 4));
        $this->data['lang'] = strtolower($this->session->userdata('language'));
        $this->session->unset_userdata('current_url');

        $this->layout->view('home/main/index', $this->data);
    }

    public function about_us()
    {
        $this->load->model(array('article'));
        $this->data['about_us'] = $this->article->getById(7,$this->session->userdata('language'));
        $this->data['nav'] = Page::ABOUT_US;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->layout->view('home/main/about_us', $this->data);
    }

    public function contact()
    {
        if ($this->input->is_ajax_request()) {
            $message = '<html><body>';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . $this->input->post('name') . "</td></tr>";
            $message .= "<tr><td><strong>Email:</strong> </td><td>" . $this->input->post('email') . "</td></tr>";
            $message .= "<tr><td><strong>Phone:</strong> </td><td>" . $this->input->post('phone') . "</td></tr>";
            $message .= "<tr><td><strong>Message:</strong> </td><td>" . $this->input->post('message') . "</td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";

            $this->load->library('email');
            $this->email->from($this->input->post('email'), $this->input->post('name'));
            $this->email->to('admin@croestate.com, darko@broker.hr');
            $this->email->subject($this->input->post('subject'));
            $this->email->message($message);
            $this->email->send();

            echo json_encode(array('status' => 'success', 'message' => lang('Email Successfully Sent')));
            die;
        }

        $this->data['nav'] = Page::CONTACT;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));

        $this->layout->view('home/main/contact', $this->data);
    }

    public function articles()
    {
        $this->load->model(array('article', 'category'));
        $this->load->helper('text');

        if (empty($_POST)) {
            $conditions = $this->uri->uri_to_assoc();
        } else {
            $conditions = $_POST;
        }

        $conditions = array_filter($conditions);

        $this->load->library('pagination');
        $this->pagination->setOptions(array(
            'baseUrl' => site_url('main/articles/page/'),
            'segmentValue' => $this->uri->getSegmentIndex('page') + 1,
            'numRows' => $this->article->countArticles($conditions)
        ));

        $this->data['articles'] = $this->article->getArticles($conditions, $this->session->userdata('language'));
        $this->data['articleList'] = $this->article->getList($this->session->userdata('language'));
        $this->data['nav'] = Page::ARTICLE;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        /* echo "<pre>";
        // echo 'key_'.$this->uri->segment(3);
    // print_r($this->data['articleList']);
    echo "</pre>";*/
        $this->layout->view('home/main/articles', $this->data);
    }

    public function viewArticle()
    {
        $this->load->model('article');
        if (!($articleKey = $this->uri->segment(2))) {
            $this->redirectForFailure('main', lang('Article has not been found.'));
        }

        $this->data['article'] = $this->article->getArticleByKey($articleKey, $this->session->userdata('language'));
        
        $this->data['nav'] = Page::ARTICLE;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));

        $description = empty($this->data['article']['description_'.$this->session->userdata('language')])
            ? $this->data['article']['description_'.Language::EN]
            : $this->data['article']['description_'.$this->session->userdata('language')];

        $description = strip_tags(trim($description));

        $short_description = character_limiter($description, 160,'');

        $desc = explode(' ', $short_description);

        foreach ($desc AS $l) {
            if (strlen($l) > 3){
                $descriptionKeyword[] = $l;
            }
        }

        $title = empty($this->data['article']['title_'.$this->session->userdata('language')])
            ? $this->data['article']['title_'.Language::EN]
            : $this->data['article']['title_'.$this->session->userdata('language')];
        
        $this->data['meta']['description'] = $description;
        $this->data['meta']['keywords'] = implode(",", $descriptionKeyword);
        $this->data['meta']['title'] = $title;

        $this->layout->view('home/main/view-article', $this->data);
    }

    public function viewModule()
    {
        if (!($moduleId = $this->uri->segment(3))) {
            $this->redirectForFailure('main', lang('Module has not been found.'));
        }

        $this->data['module'] = $this->module->getById($moduleId);
        $this->data['placements'] = $this->module->getPlacements();
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));

        $this->layout->view('home/main/view-module', $this->data);
    }

    public function search()
    {
        if (empty($_POST)) {
            if ($this->session->userdata('postData')) {
                $_POST = $this->session->userdata('postData');
            } else {
                redirect('main');
            }
        } else {
            $this->session->set_userdata('postData', $_POST);
        }

        $this->load->model(array('property', 'article', 'module'));
        $this->data['properties'] = $this->property->getHomeSearchResult($_POST, $this->session->userdata('language'));
        $this->load->helper('text');
        $this->data['articles'] = $this->article->getHomeSearchResult($_POST, $this->session->userdata('language'));
        $this->data['articleList'] = $this->article->getList($this->session->userdata('language'));

        $this->data['modules'] = $this->module->getHomeSearchResult($_POST, $this->session->userdata('language'));
        $this->data['placements'] = $this->module->getPlacements();

        $this->data['nav'] = Page::SEARCH;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['lang'] =strtolower($this->session->userdata('language'));
        $this->layout->view('home/main/search', $this->data);
    }

    public function property_advance_search()
    {
        $this->load->model(array('type', 'status', 'region', 'location', 'advantage'));
        $this->data['propertyTypes'] = $this->type->getTypeList($this->session->userdata('language'));
        $this->data['statuses'] = $this->status->getStatusList($this->session->userdata('language'));
        $this->data['regions'] = $this->region->getRegionList($this->session->userdata('language'));
        $this->data['region_locations'] = json_encode($this->location->getLocationAndRegionIdList($this->session->userdata('language')));
        $this->data['advantages'] = $this->advantage->getAdvantageList($this->session->userdata('language'));
        $this->data['lang'] = strtolower($this->session->userdata('language'));
        $this->session->unset_userdata('current_url');
        $this->data['nav'] = Page::ADVANCED_SEARCH;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->layout->view('home/main/property_advance_search', $this->data);
    }

    public function search_by_region($id)
    {
        if (empty($id)) {
            redirect('main/property_advance_search');
        }

        $this->load->model('property');
        $this->data['nav'] = Page::SEARCH;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['search_result'] = $this->property->getSearchResult(array('region_id' => $id), $this->session->userdata('language'));
        $this->data['lang'] =strtolower($this->session->userdata('language'));
        $this->layout->view('home/main/search_result', $this->data);
    }

    public function property_search_result()
    {
        $this->load->model(array('property', 'type', 'region', 'location'));
        $array_search = $this->property->createSearchArray();
        
        if (isset($array_search) && !empty($array_search)) {
            $cur_url = $this->session->userdata('current_url');
            if (!$cur_url) {
                $this->session->set_userdata('current_url', $this->uri->uri_string());
            }
        }
        if (isset($_GET['sort'])) {
            $sort = $this->session->userdata('sort');
            if (!$sort) {
                $sort = $_GET['sort'] . " DESC";
                $this->session->set_userdata('sort', $sort);
            } else if ($sort && substr($sort, -3) == 'ASC') {
                $sort = $_GET['sort'] . " DESC";
                $this->session->set_userdata('sort', $sort);
            } else if ($sort && substr($sort, -4) == 'DESC') {
                $sort = $_GET['sort'] . ' ASC';
                $this->session->set_userdata('sort', $sort);
            }
        } else {
            $sort = null;
        }

        if($this->session->userdata('sort')) {
            $sort = $this->session->userdata('sort');
        }
    
        if (empty($array_search)) {
            if ($this->session->userdata('postData')) {
                // $postData = $this->session->userdata('postData');
                // $postData['order'] = $order;
                // $this->session->set_userdata('postData', $postData);
                $array_search = $this->session->userdata('postData');
            } else {
                redirect('main');
            }
        } else {
            // $array_search['order'] = $order;
            $this->session->set_userdata('postData', $array_search);
        }
        
        $this->load->library('pagination');

        $config['base_url'] = base_url().'index.php/'.$this->session->userdata('current_url');
        $config['total_rows'] = count($this->property->getSearchResult($array_search, $this->session->userdata('language')));;
        $config['per_page'] = '10';
        $config['first_tag_open'] = '<div class="pag_first">';
        $config['first_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="pag_last">';
        $config['last_tag_close'] = '</div>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<div class="pag_next">';
        $config['next_tag_close'] = '</div>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<div class="pag_prev">';
        $config['prev_tag_close'] = '</div>';
        $config['num_tag_open'] = '<div class="pag_num">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="pag_num current"><b>';
        $config['cur_tag_close'] = '</b></div>';
        
        $segments = $this->uri->segment_array();

        if(is_numeric($segments[$this->uri->total_segments()])) {
            $offset = $segments[$this->uri->total_segments()];
            $currentPage = floor(($offset/$config['per_page']) + 1); 
            $config['uri_segment'] = $this->uri->total_segments();
            $config["cur_page"] = $currentPage;
        } else {
            $offset = 0;
        }
        
        $this->pagination->initialize($config);
        
        $limit = $config['per_page'];
        $this->data['search_result'] = $this->property->getSearchResult($array_search, $this->session->userdata('language'), $limit, $offset, $sort);
        $this->data['nav'] = Page::SEARCH_RESULT;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['lang'] =strtolower($this->session->userdata('language'));
        
        $this->layout->view('home/main/search_result', $this->data);

    }

    public function property_detail($permalink)
    {
        $permalink = str_replace('amp', '&', $permalink);
        $permalink = urldecode($permalink);
        $this->layout->setLayout('home/layouts/property'); 
        if (empty($permalink)) {
            $this->redirectForFailure('main', lang('Property detail has not been found.'));
        }

        $this->load->model(array('property'));
        $this->data['property'] = $this->property->getPropertyByPermalink($permalink, true, $this->session->userdata('language'));

        if (empty($this->data['property'])) {
            $this->redirectForFailure('main', lang('Property detail has not been found.'));
        }

        $this->data['disableLeftModule'] = true;
        $this->data['properties'] = $this->property->getHighlightedProperties();
        $this->data['nav'] = Page::PROPERTY;
        $this->data['similarProperties'] = $this->property->getSimilarProperties($this->data['property']);
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['lang'] =strtolower($this->session->userdata('language'));

        $this->layout->view('home/main/property_detail', $this->data);
    }

    public function my_list()
    {
        if (($propertyIds = $this->session->userdata('userProperties'))) {
            $this->load->model('property');
            $this->data['properties'] = $this->property->getPropertiesByIds($propertyIds, $this->session->userdata('language'));
            $this->data['propertyIds'] = implode(', ', $propertyIds) ;
        }

        $this->data['nav'] = Page::MY_LIST;
        $this->data['leftModules'] = $this->module->getWritings(array('placement' => Module::LEFT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->data['rightModules'] = $this->module->getWritings(array('placement' => Module::RIGHT, 'is_active' => 1, 'limit' => Module::LOAD_NO_OF_MODULE));
        $this->layout->view('home/main/my_list', $this->data);
    }

    public function addPropertyToList()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('propertyId')) {
                $userProperties = $this->session->userdata('userProperties');
                $userProperties[] = $this->input->post('propertyId');
                $this->session->set_userdata('userProperties', $userProperties);
                $this->setSuccessMessage(lang('Property has been added into your list.'));
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'error', 'data' => 'not-inserted'));
            }
            die;
        } else {
            $this->redirectForFailure('main');
        }
    }

    public function removePropertyFromList()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('propertyId')) {
                $userProperties = $this->session->userdata('userProperties');
                $userProperties = array_diff($userProperties, array($this->input->post('propertyId')));
                $this->session->set_userdata('userProperties', $userProperties);
                $this->setSuccessMessage(lang('Property has been removed from your list.'));
                echo json_encode(array('status' => 'success'));
            } else {
                echo json_encode(array('status' => 'error', 'data' => 'not-removed'));
            }
            die;
        } else {
            $this->redirectForFailure('home/main/my_list');
        }
    }

    public function changeLanguage()
    {
        if ($this->input->is_ajax_request()) {
            $this->session->set_userdata('language', $this->input->post('language'));

            $this->load->library('user_agent');

            $referrer = str_replace(base_url(), '', $this->agent->referrer());
            $referrer = ltrim(str_replace('index.php', '', $referrer), '/');
            $lastSlashPosition = strripos($referrer, '/');
            
            if (empty($lastSlashPosition)) {
                $redirectTo = ''.$this->input->post('language');
            } else {
                $languageTerm = substr($referrer, $lastSlashPosition+1);
                if (in_array($languageTerm, array_keys($this->data['languages']))) {
                    if(strripos($referrer, 'property') !== false) {
                        $position = strripos($referrer, 'property') + strlen('property') + 1;
                        $permalink = substr($referrer, $position);
                        $slash = strripos($permalink, '/');
                        $permalink = substr($permalink, 0, $slash);
                        $this->load->model('property');
                        $newPermalink = $this->property->replasePermalink($permalink, $languageTerm, $this->input->post('language'));
                        $referrer = str_replace($permalink, $newPermalink, $referrer);
                        $lastSlashPosition = strripos($referrer, '/');
                    }
                    $redirectTo = substr_replace($referrer, $this->input->post('language'), $lastSlashPosition+1);
                } else {
                    $redirectTo = $referrer . '/' . $this->input->post('language');
                }
            }
            $this->setSuccessMessage(lang('Language has been changed to ').$this->input->post('language').'.');
            echo json_encode(array('status' => 'success', 'redirectTo' => site_url($redirectTo)));
            die;
        } else {
            $this->redirectForFailure('main');
        }
    }

    public function send_main_to_property_admin()
    {
        $propertyIds = explode(', ', $this->input->post('propertyIds'));
        $this->load->model('property');
        $lang = strtolower($this->session->userdata('language'));
        $recipients = $this->property->getRecipientsOfMail($propertyIds,$lang);

        foreach($recipients AS $recipient) {
            $this->sendEmail($recipient['email'], 'Inquiry from Croestate.com' , $this->load->view('home/main/email-message', array(
                'recipient' => $recipient,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'message' => $this->input->post('message')
            ), true));
        }
        echo json_encode(array('status' => 'success', 'message' => lang('Email Successfully Sent')));
    }

    private function sendEmail($email, $subject, $message, $attachment = null, $cc = null)
    {
        if (empty($email)) {
            $email = 'admin@croestate.com';
        }

        $this->load->library('email');
        $this->email->from('admin@croestate.com', 'Croestate');
        $this->email->to($email);
        empty($cc) || $this->email->cc($cc);
        $this->email->bcc('admin@croestate.com');
        $this->email->subject($subject);
        $this->email->message($message);
        empty($attachment) || $this->email->attach($attachment);
        $this->email->send();

    }

    public function create_property_pdf($id)
    {
        if (empty($id)) {
            $this->redirectForFailure('main', lang('Property detail has not been found.'));
        }

        $this->load->model(array('property'));
        
        $this->data['property'] = $this->property->getPropertyById($id, true, $this->session->userdata('language'));
        if(count($this->data['property']['images']) > 7) {
            array_splice($this->data['property']['images'], 7);
        }

        $html = $this->load->view('home/main/property_pdf', $this->data, true);

        $permalink = $this->data['property']['permalink_'.strtolower($this->session->userdata('language'))];
        $refNo = $this->data['property']['reference_no'];

        $fileName = $permalink ."-". $refNo;

        $this->load->helper(array('dompdf', 'file'));
        // echo $html;
        pdf_create($html, $fileName);
    }
}

/* End of Main Controller */
/* application/modules/home/controllers/main.php */