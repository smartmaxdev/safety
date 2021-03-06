<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secure_area extends CI_Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	public function __construct($module_id=null)
	{
		parent::__construct();	
		if (!$this->User_model->is_logged_in()) {
			redirect('login');
		}
		
		if (!$this->User_model->has_permission($module_id,$this->User_model->get_logged_in_user_info()->user_id)) {
			redirect('no_access/'.$module_id);
		}
		
		//load up global data
	    $logged_in_info=$this->User_model->get_logged_in_user_info();
		$data['allowed_modules']=$this->Module_model->get_allowed_modules($logged_in_info->user_id);
		$data['allowed_main_modules']=$this->Module_model->get_allowed_main_modules($logged_in_info->user_id);
		$data['user_info']=$logged_in_info;
		$data['first_name']=$this->User_model->get_first_name($logged_in_info->user_id);
		$data['login_info']=$this->User_model->get_info($logged_in_info->user_id);
		$this->load->vars($data);
	}
}
