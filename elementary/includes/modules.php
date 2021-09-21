<?php
//$this->load->library('session');
//$this->load->model('Access_checker_model');

// module configuration
// module array controller_name => tab_display

//$access = "Create Dispatch";
//$accessCode = $this->Access_checker_model->getAccessCode($access);
//if ($this->Access_checker_model->check_access($_SESSION['userID'],$accessCode)) {

$modules['home']            = 'Home';
$modules['information']     = 'My Profile';
$modules['account']   		= 'My Accounts';
$modules['enrollment']  	= 'Enrollment';
$modules['form137']  		= 'Form 137';
$modules['grade']           = 'Grades';

// pagination setup
//$record_limit['mechanical'] = 10;
?>