<?php
class Login extends Controller {

    var $error;
    
	function Login()
	{
		parent::Controller();
//		$this->load->library('session');
//        if(!$_SESSION){session_start();}
	}
	
	function index()
	{
	    
		// data settings		
		$data['title'] 	 = "Index";
		$data['error'] 	 = "";
		$this->load->view('login', $data);
	}
	function authenticate()
	{
	    // posted data settings (username, password)
		$uname   	= $this->input->post('uname');
		$pswd 		= md5($this->input->post('pswd'));
		
		if($uname!='' && $pswd!='') {
            
		    $this->load->model('User_model');
            //check if the user exist
	    	if ($uname) {
				$this->db->where('uname', $uname);
	    	}
	    	if ($pswd) {
				$this->db->where('pswd', $pswd);
	    	}
	    	$current_user = $this->User_model->retrieveAll();
            
	    	if ($current_user) {
	    		
	    		$_SESSION['current_user'] = $current_user;
	    		
    	    	foreach ($current_user as $value) {
                    
    	    	    // assigning data to session variables
    	    	    $_SESSION['idno']       = $value->idno;
    	    	    $_SESSION['uname']     	= $value->uname;
    	    	    $_SESSION['pswd']     	= $value->pswd;
    	    	    $_SESSION['fname']    	= $value->fname;
    	    	    $_SESSION['lname']    	= $value->lname;
    	    	    $_SESSION['mname']    	= $value->mname;
    	    	    $_SESSION['gender']    	= $value->gender;
    	    	    $_SESSION['age']    	= $value->age;
    	    	    $_SESSION['bday']    	= $value->bday;

//                    for codeigniter sessions
//    	    	      $this->session->set_userdata('userID', $value->userID);
//                    $this->session->set_userdata('userName', $value->userName);
//                    $this->session->set_userdata('lastName', $value->lastName);
                }
            
            //redirection if the input username and password is valid
            header('location: index.php?home');
                
	    	} else {
    		    $data['error'] = "Error: You must specify a valid username and password.";
    		    $this->load->view('login', $data);
	    	}
		} else {
		    
		    $data['error'] = "Error: You must specify a valid username and password."; 
		    $this->load->view('login', $data);
		}
        
//		switch ($uname) {
//		    case 'requestor':
//				// requestor account
//				
//				$this->session->set_userdata('USERTYPE', 1);
//				$this->session->set_userdata('USER_DISPLAY', 'Requestor');
//				break;
//				
//			case 'admin':
//				// admin account
//				$this->session->set_userdata('USERTYPE', 2);
//				$this->session->set_userdata('USER_DISPLAY', 'Admin');
//				break;
//				
//			case 'ojt':
//				// ojt account
//				
//				$this->session->set_userdata('USERTYPE', 3);
//				$this->session->set_userdata('USER_DISPLAY', 'OJT');
//				break;
//			
//			default:
//				// admin account
//				$this->session->set_userdata('USERTYPE', 2);
//				$this->session->set_userdata('USER_DISPLAY', 'Admin');
//		}
//				    header('location: index.php?unsorted');
	}
}

?>