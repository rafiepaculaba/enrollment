<?php
class Menu_model extends Model 
{
	var $module_menu;
	
    function Menu_model()
    {
        // Call the Model constructor
        parent::Model();
//        $this->load->model('Access_checker_model');
    }

    function home()
    {
//        $access = "Create User";
//        $accessCode = $this->Access_checker_model->getAccessCode($access);
//        if ($this->Access_checker_model->check_access($this->session->userdata('userID'),$accessCode)) {
//            $this->module_menu[] = array('url' => 'index.php?unsorted/listview', 'name' => 'Receive List', 'image' => 'menu');
//        }
        
        $this->module_menu[] = array('url' => 'index.php?home', 'name' => 'Home', 'image' => 'menu');
    }

    function information()
    {
        $this->module_menu[] = array('url' => 'index.php?information', 'name' => 'Personal Information', 'image' => 'menu');
    }

    function account()
    {
    	$this->module_menu[] = array('url' => 'index.php?account/statement_of_account', 'name' => 'Statement of Account', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?account/assessmentlist', 'name' => 'Assessments', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?account/paymentlist', 'name' => 'Payments', 'image' => 'menu');
    }

    function enrollment()
    {
        $this->module_menu[] = array('url' => 'index.php?enrollment/studyload', 'name' => 'Studyload', 'image' => 'menu');
//        $this->module_menu[] = array('url' => 'index.php?enrollment/reservation', 'name' => 'Create Reservation', 'image' => 'menu');
//        $this->module_menu[] = array('url' => 'index.php?enrollment/subj_offerings', 'name' => 'Subject Offerings', 'image' => 'menu');
    }

    function form137()
    {
        $this->module_menu[] = array('url' => 'index.php?form137', 'name' => 'Form 137', 'image' => 'menu');
    }

    function grade()
    {
        $this->module_menu[] = array('url' => 'index.php?grade/current_grades', 'name' => 'Current Grade', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?grade/form137', 'name' => 'Form 137', 'image' => 'menu');
    }
    
    function about()
    {
        $this->module_menu[] = array('url' => 'index.php?home', 'name' => 'Home', 'image' => 'menu');
    }
    
    function admin()
    {
        $this->module_menu[] = array('url' => 'index.php?user/create', 'name' => 'Create User', 'image' => 'menu');
    }

    function user()
    {
        $this->module_menu[] = array('url' => 'index.php?user/listview', 'name' => 'Users', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user/create', 'name' => 'Create User', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user_group/listview', 'name' => 'User Groups', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user_group/create', 'name' => 'Create User Group', 'image' => 'menu');
    }

    function user_group()
    {
        $this->module_menu[] = array('url' => 'index.php?user/listview', 'name' => 'Users', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user/create', 'name' => 'Create User', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user_group/listview', 'name' => 'User Groups', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?user_group/create', 'name' => 'Create User Group', 'image' => 'menu');
    }
    
    function role()
    {
        $this->module_menu[] = array('url' => 'index.php?role/listview', 'name' => 'Roles', 'image' => 'menu');
        $this->module_menu[] = array('url' => 'index.php?role/create', 'name' => 'Create Role', 'image' => 'menu');
    }
}
?>