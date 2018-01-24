<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
include (APPPATH . 'controllers/AdminController.php');

/**
 * Properties controllers
 *
 * @author          Syed Abidur Rahman <aabid048@gmail.com>
 *
 * @property        CI_User_agent $agent
 * @property        Advantage $advantage
 * @property        Property $property
 * @property        Type $type
 * @property        PropertyImage $propertyImage
 * @property        Status $status
 * @property        Region $region

 * @property        Location $location
 * @property        Slogan $slogan
 */
class Properties extends AdminController {

	protected $navBar = 'property';

	public function __construct() {
		parent::__construct();
		$this->load->model('property');
	}

	public function index() {
		// echo "<pre>";
		// print_r($this->layout);
		// echo "</pre>";die();
		$languages = $this->language->getAll();
		$options = $this->uri->uri_to_assoc();

		$this->load->model(array('location'));

		$this->data['locations'] = $this->location->getLocationList();

		$userData = $this->session->userdata('userData');
		$isPermittedToAdd = in_array($userData['role'], array(User::ADMIN, User::AGENT));
		$search_data = $this->input->post();
		$this->data['search_result'] = '';
		if(isset($search_data['search_form']) && $search_data['search_form']==1){
			$options['tab'] = 3;
			$this->data['search_result'] = $this->property->getSearchResult($search_data,$this->session->userdata('adminLanguage'));
		}else if (!empty($_POST) && $isPermittedToAdd) {
			$options['tab'] = 2;
			$this->load->library('form_validation');
			// $this->form_validation->setRulesForPropertySave($languages, $userData['role']);
			// if ($this->form_validation->run($this)) {
				$_POST = array_merge($_POST, array('user_id' => $userData['user_id']));
				if ($this->input->post('location_id')) {
					$_POST['location'] = $this->data['locations'][$this->input->post('location_id')];
				}
				$propertyId = $this->property->insert($_POST, $languages);
				$uploaded_file = $this->uploadImage($propertyId);
				
				if (isset($uploaded_file['error'])) {
						$this->data['errorMsg'] = $uploaded_file['error'];
					}
				if (empty($propertyId)) {
					$this->redirectForFailure('properties/index/2', lang('Something went wrong! Please, try again.'));
				} else {
						$this->redirectForSuccess('properties', lang('Adding a property has been successfully done.'));
					}
			// } else {
			// 	$this->data['errorMsg'] = lang('Please check the following errors.');
			// }
		}

		$this->data['tab'] = (int) (empty($options['tab']) ? 1 : $options['tab']);
		$this->data['order'] = (int) (isset($options['order']) ? ($options['order'] == 'asc') : 0);
		$this->data['page'] = (int) (empty($options['page']) ? 0 : $options['page']); 
		if ($userData['role'] == User::AGENT) {
			$options['agent_id'] = $userData['user_id'];
		}
		$this->data['properties'] = $this->property->getProperties($options);

		$this->load->library('pagination');
		unset($options['page']);
		unset($options['tab']);
		$this->pagination->setOptions(array(
			'baseUrl' => site_url('properties/index/tab/1/' . $this->uri->assoc_to_uri($options) . '/page/'),
			'segmentValue' => $this->uri->getSegmentIndex('page') + 1,
			'numRows' => $this->property->countProperties($options)
		));
		$this->data['propertyPagination'] = $this->pagination->create_links();

		$this->load->model(array('type', 'status', 'region', 'advantage', 'slogan'));
		$this->data['title'] = 'Property Manage';
		$this->data['propertyTypes'] = $this->type->getTypeList($this->session->userdata('adminLanguage'));
		$this->data['statuses'] = $this->status->getStatusList($this->session->userdata('adminLanguage'));
		$this->data['regions'] = $this->region->getRegionList($this->session->userdata('adminLanguage'));
		$this->data['advantages'] = $this->advantage->getAdvantageList($this->session->userdata('adminLanguage'));
		$this->data['slogans'] = $this->slogan->getSloganList($this->session->userdata('adminLanguage'));
		$this->data['languages'] = $languages;
		$this->data['isPermittedToChange'] = $this->isPermittedToChange($userData);
		$this->data['isPermittedToAdd'] = $isPermittedToAdd;
		if ($userData['role'] == User::ADMIN) {
			$this->data['agents'] = $this->user->getAgentList();
		} elseif ($userData['role'] == User::AGENT) {
			$this->data['agentNotNeeded'] = true;
		}
		$this->data['region_locations'] = json_encode($this->location->getLocationAndRegionIdList($this->session->userdata('adminLanguage')));
		$this->layout->view('admin/properties/index', $this->data);
	}

	private function uploadImage($propertyId) {
		$error = array();
		$this->load->library('upload');
		$this->load->model('propertyImage');
		$this->config->load('image_setting');
		$configSetting = (array) $this->config->item('imageSetting');
		$configSetting['upload_path'] .= "/{$propertyId}/";
		$configSetting['thumb_upload_path'] = "./assets/uploads"."/{$propertyId}/"."thumb_image";
		file_exists($configSetting['upload_path']) || mkdir($configSetting['upload_path'], 0777, true);
		file_exists($configSetting['thumb_upload_path']) || mkdir($configSetting['thumb_upload_path'], 0777, true);
		$this->upload->initialize($configSetting);
		if (!empty($_FILES)) {
			foreach ($_FILES AS $field => $value) {
				if (!empty($value['tmp_name']) && !is_array($value['tmp_name'])) {
					if ($this->upload->do_upload($field)) {
						$data = $this->upload->data();
						$this->propertyImage->insert(array(
							'property_id' => $propertyId,
							'name' => $data['file_name'],
							'type' => (($field !== 'property_image') ? PropertyImage::APPENDIX : PropertyImage::MAIN)
						));
					} else {
						$error['error'] = $this->upload->display_errors();
						return $error;
					}
				}else if(!empty($value['tmp_name'][0]) && is_array($value['tmp_name'])){
					 if($this->upload->do_multi_upload($field)){
						 $data = $this->upload->get_multi_upload_data();
						 foreach($data as $img_data){
							$this->propertyImage->insert(array(
							'property_id' => $propertyId,
							'name' => $img_data['file_name'],
							'type' => (($field !== 'property_image') ? PropertyImage::APPENDIX : PropertyImage::MAIN)
						)); 
						 }
					 }else{
						$error['error'] = $this->upload->display_errors();
						return $error; 
					 }
				}
			}
		}
	}

	public function view($propertyId) {
		if (!($this->data['property'] = $this->property->getPropertyById($propertyId, false))) {
			$this->redirectForFailure('properties', lang('Property detail has not been found.'));
		}

		$this->data['languages'] = $this->language->getAll();
		$this->data['isPermittedToChange'] = $this->isPermittedToChange($this->session->userdata('userData'));
		$this->layout->view('admin/properties/view', $this->data);
	}

	public function edit($propertyId) {
		$languages = $this->language->getAll();
		$userData = $this->session->userdata('userData');

		$this->load->model(array('location'));

		$this->data['locations'] = $this->location->getLocationList();

		if (!empty($_POST) && $this->isPermittedToChange($userData)) {
			$this->load->library('form_validation');
			$this->form_validation->setRulesForPropertySave($languages, $userData['role'], true, 'property_id.' . $this->input->post('property_id'));

			// if ($this->form_validation->run($this)) {
				if ($userData['role'] == User::ADMIN) {
					unset($_POST['user_id']);
				}

				if ($this->input->post('location_id')) {
					$_POST['location'] = $this->data['locations'][$this->input->post('location_id')];
				}
				$propertyId = $this->property->update($_POST, $this->input->post('property_id'), $languages);
				$uploaded_file = $this->uploadImage($propertyId);
				if (isset($uploaded_file['error'])) {
						$this->redirectForFailure('properties/edit/' . $this->input->post('property_id'), $uploaded_file['error']);
					}
				if (empty($propertyId)) {
					$this->redirectForFailure('properties/edit/' . $this->input->post('property_id'), lang('Something went wrong! Please, try again.'));
				} else {
					$this->redirectForSuccess('properties', lang('Updating property information has been successfully done.'));
				}
				
			// } else {
			// 	$this->data['errorMsg'] = lang('Please check the following errors.');
			// }
		} else {

			$property = $this->property->getPropertyById($propertyId, false);
			if (empty($property)) {
				$this->redirectForFailure('properties', lang('Property detail has not been found.'));
			} else {
				if ($userData['user_id'] != $property['user_id'] && !$this->isPermittedToChange($userData)) {
					$this->redirectForFailure('properties', lang('You are not permitted to do this.'));
				}

				$this->load->model(array('type', 'status', 'advantage', 'slogan'));
				$propertyTypes = $this->type->getTypeList(Language::EN);
				$propertyStatuses = $this->status->getStatusList(Language::EN);
				$propertyAdvantages = $this->advantage->getAdvantageList(Language::EN);
				$propertySlogans = $this->slogan->getSloganList(Language::EN);

				$property['types'] = $this->searchKey($property['types'], $propertyTypes);
				$property['statuses'] = $this->searchKey($property['statuses'], $propertyStatuses);
				$property['advantages'] = $this->searchKey($property['advantages'], $propertyAdvantages);
				$property['slogan'] = array_search($property['slogan'], $propertySlogans);
				$_POST = $property;
			}
		}

		if ($userData['role'] == User::ADMIN) {
			$this->data['agents'] = $this->user->getAgentList();
			$this->data['isNotPropertyOwner'] = true;
		} else {
			if ($userData['role'] == User::AGENT) {
				$this->data['isNotPropertyOwner'] = true;
			}
			$this->data['agentNotNeeded'] = true;
		}

		$this->load->model(array('type', 'status', 'region', 'advantage', 'slogan', 'propertyImage'));
		$this->data['propertyTypes'] = $this->type->getTypeList($this->session->userdata('adminLanguage'));
		$this->data['statuses'] = $this->status->getStatusList($this->session->userdata('adminLanguage'));
		$this->data['regions'] = $this->region->getRegionList($this->session->userdata('adminLanguage'));
		$this->data['advantages'] = $this->advantage->getAdvantageList($this->session->userdata('adminLanguage'));
		$this->data['slogans'] = $this->slogan->getSloganList($this->session->userdata('adminLanguage'));
		$this->data['languages'] = $languages;
		$this->data['propertyImages'] = $this->propertyImage->getByProperty($this->input->post('property_id'));
		$this->data['region_locations'] = json_encode($this->location->getLocationAndRegionIdList($this->session->userdata('adminLanguage')));
		$this->layout->view('admin/properties/edit', $this->data);
	}

	public function deleteImage() {
		if ($this->input->is_ajax_request()) {
			if (!($propertyId = $this->input->post('propertyId'))) {
				echo json_encode(array('status' => 'error', 'error' => 'data-not-given', 'msg' => 'Data has not been given.'));
			} elseif (!($propertyDetail = $this->property->findById($propertyId, false))) {
				echo json_encode(array('status' => 'error', 'error' => 'data-not-found', 'msg' => 'Data has not been found.'));
			} else {
				$userData = $this->session->userdata('userData');
				if ($userData['user_id'] != $propertyDetail['user_id'] && $userData['user_id'] != $propertyDetail['agent_id'] && !$this->isPermittedToChange($userData)) {
					echo json_encode(array('status' => 'error', 'error' => 'un-authorized', 'msg' => lang('You are not authenticated.')));
				} else {
					$this->load->model('propertyImage');
					if ($this->propertyImage->deleteByPropertyAndImageId($propertyId, $this->input->post('imageId'))) {
						echo json_encode(array('status' => 'success', 'msg' => lang('Property image has been successfully removed.')));
					} else {
						echo json_encode(array('status' => 'error', 'error' => 'unknown', 'msg' => 'Something went wrong! Please, try again.'));
					}
				}
			}
			die;
		} else {
			$this->redirectForFailure('properties', lang('You are not authenticated.'));
		}
	}

	private function searchKey($needle, array $haystack) {
		$temp = array();
		foreach ($needle AS $row) {
			if (($key = array_search($row, $haystack))) {
				$temp[] = $key;
			}
		}

		return $temp;
	}

	public function delete() {
		if ($this->input->is_ajax_request()) {
			if (!($propertyId = $this->uri->segment(3, false))) {
				echo json_encode(array('status' => 'error', 'error' => 'data-not-given'));
			} elseif (!($propertyDetail = $this->property->findById($propertyId, false))) {
				echo json_encode(array('status' => 'error', 'error' => 'data-not-found'));
			} else {
				$userData = $this->session->userdata('userData');
				if ($userData['user_id'] != $propertyDetail['user_id'] && !$this->isPermittedToChange($userData)) {
					echo json_encode(array('status' => 'error', 'error' => lang('You are not permitted to do this.')));
				} elseif ($this->property->remove($propertyId)) {
					$this->setSuccessMessage(lang('Property has been successfully removed.'));
					echo json_encode(array('status' => 'success', 'redirectTo' => site_url('properties')));
				} else {
					echo json_encode(array('status' => 'error', 'error' => 'unknown'));
				}
			}
			die;
		} else {
			$this->redirectForFailure('properties', lang('This action has not been permitted.'));
		}
	}

	public function activate() {
		if (!($propertyId = $this->uri->segment(3, false))) {
			$this->redirectForFailure('properties', lang('Property info has been not given.'));
		} elseif (!($propertyDetail = $this->property->findById($propertyId, false))) {
			$this->redirectForFailure('properties', lang('Property info has not been found.'));
		} else {
			$this->load->library('user_agent');
			$userData = $this->session->userdata('userData');
			if ($userData['user_id'] != $propertyDetail['user_id'] && !$this->isPermittedToChange($userData)) {
				$this->redirectForFailure($this->agent->referrer(), lang('You are not permitted to do this.'));
			} elseif ($this->property->updateActivationStatus(array('is_active' => 1), $propertyId)) {
				$this->redirectForSuccess($this->agent->referrer(), lang('Property has been successfully activated.'));
			} else {
				$this->redirectForFailure($this->agent->referrer(), lang('Something went wrong! Please, try again.'));
			}
		}
	}

	public function deactivate() {
		if (!($propertyId = $this->uri->segment(3, false))) {
			$this->redirectForFailure('properties', lang('Property info has been not given.'));
		} elseif (!($propertyDetail = $this->property->findById($propertyId, false))) {
			$this->redirectForFailure('properties', lang('Property info has not been found.'));
		} else {
			$this->load->library('user_agent');
			$userData = $this->session->userdata('userData');
			if ($userData['user_id'] != $propertyDetail['user_id'] && !$this->isPermittedToChange($userData)) {
				$this->redirectForFailure($this->agent->referrer(), lang('You are not permitted to do this.'));
			} elseif ($this->property->updateActivationStatus(array('is_active' => 0), $propertyId)) {
				$this->redirectForSuccess($this->agent->referrer(), lang('Property has been successfully deactivated.'));
			} else {
				$this->redirectForFailure($this->agent->referrer(), lang('Something went wrong! Please, try again.'));
			}
		}
	}

	public function is_city_or_island_given() {
		if (empty($_POST['location_id'])) {
			return false;
		} else {
			return true;
		}
	}

	public function checkReferenceNoUnique() {
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->property->checkReferenceNoUnique($this->input->post('referenceNo'), $this->input->post('propertyId')));
		} else {
			die(lang('Ajax request is needed.'));
		}
	}

	private function isPermittedToChange($userData) {
		return (in_array($userData['role'], array(User::ADMIN, /* User::PROPERTY_OWNER, */ User::AGENT)));
	}

}

/* End of Properties Controller */
/* application/modules/admin/controllers/properties.php */