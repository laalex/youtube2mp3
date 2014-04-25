<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller{
       public function __construct(){
              parent::__construct();
              //Check if user is logged in
              if(!$this->ion_auth->logged_in() || ! $this->ion_auth->is_admin()):
                     //The user is logged in -> Redirect to the application
                     redirect(base_url().'login');
              endif;
              $this->load->model('admin_model');
       }

       public function index(){
              $data['accounts'] = $this->admin_model->acc_count();
              $data['songs'] = $this->admin_model->song_data();
              $data['playlists'] = $this->admin_model->pls_count();
              $data['space_used'] = $this->admin_model->download_space_used();
              $this->load->view('admin/inc/header');
              $this->load->view('admin/inc/sidebar-menu');
              $this->load->view('admin/dashboard',$data);
              $this->load->view('admin/inc/footer');
       }

       public function feedback(){
              $data['feedback'] = $this->admin_model->get_feedback();
              $this->load->view('admin/inc/header');
              $this->load->view('admin/inc/sidebar-menu');
              $this->load->view('admin/feedback',$data);
              $this->load->view('admin/inc/footer');
       }

}