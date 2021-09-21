<?php
class Form137 extends Controller 
{
	var $module_menu;
	var $subjects1;
	var $subjects2;
	var $subjects3;
	var $subjects4;
	var $subjTotal;
	var $enrollment;
    var $ctr = 0;
    var $enID11;
	var $subj1_legend=array();
	var $subj2_legend=array();
	var $subj3_legend=array();
	var $subj4_legend=array();
	var $currID;
	var $rstatus;
	
	
	function Form137()
	{
		parent::Controller();
        //menu settings
		$this->Menu_model->form137();

		// loading of necessary models
	    $this->load->model('User_model');
	}
	
	/**
	 * Index page of this controller
	 */
    function index()
	{
		//$this->listview();
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		
		$this->load->view('header', $data);        
		
		$this->load->view('modules/form137/view');
		$this->load->view('footer');
	}




    /************************ START: ALL BASIC METHODS *********************************/	
	/**
	 * This will display a new test item form
	 */
	function create()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		
		// get all records user groups
        $data['record'] = $this->User_group_model->retrieveAll();
		
        $this->load->view('header', $data);

        $this->load->view('modules/User/create', $data);
		$this->load->view('footer');
	}
	
	/**
	 * This will display the list of all test items
	 */
	
	function listview()
	{
		// tab settings
		require_once('includes/modules.php');

		// loading of necessary models
//		$this->load->model('User_model');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		
		$this->load->view('header', $data);
		$filtered  	 	 = $this->input->get_post('cmdFilter');
		
		unset($data);
		$data['lastName']  = $lastName 	= trim($this->input->get_post('lastName'))?   trim($this->input->get_post('lastName')):'';
		$data['firstName'] = $firstName	= trim($this->input->get_post('firstName'))?  trim($this->input->get_post('firstName')):'';
		$data['middleName']= $middleName= trim($this->input->get_post('middleName'))? trim($this->input->get_post('middleName')):'';
		$data['groupID']   = $groupID	= trim($this->input->get_post('groupID'))?    trim($this->input->get_post('groupID')):'';
		$data['localNum']  = $localNum	= trim($this->input->get_post('localNum'))?   trim($this->input->get_post('localNum')):'';
		$data['telNum']    = $telNum	= trim($this->input->get_post('telNum'))?     trim($this->input->get_post('telNum')):'';
		$data['rstatus']   = $rstatus	= trim($this->input->get_post('rstatus'))?    trim($this->input->get_post('rstatus')):'';
		
		if ($filtered) {
			if ($lastName) {
				$this->db->like('lastName', $lastName);
	    	}
	    	
			if ($firstName) {
				$this->db->like('firstName', $firstName);
	    	}
	    	
	    	if ($middleName) {
				$this->db->like('middleName', $middleName);
	    	}
	    	
	    	if ($groupID) {
				$this->db->where('groupID', $groupID);
	    	}

	    	if ($localNum) {
				$this->db->where('localNum', $localNum);
	    	}
	    	
	    	if ($telNum) {
				$this->db->where('telNum', $telNum);
	    	}
	    	
	    	if ($rstatus) {
				$this->db->where('rstatus', $rstatus);
	    	}
		}

		$data['record'] = $this->User_model->retrieveAll();
		$this->load->view('modules/User/listview', $data);
		$this->load->view('footer');
	}

	/**
	 * This will display a view test item form
	 *
	 * @param integer $id
	 */
	function view($id)
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		$this->load->view('header', $data);
		$this->User_model->retrieve($id);
		
		$data['userID']    = $id;
		$data['userName']  = $this->User_model->userName;
		$data['userPswd']  = $this->User_model->userPswd;
		$data['lastName']  = $this->User_model->lastName;
		$data['firstName'] = $this->User_model->firstName;
		$data['middleName']= $this->User_model->middleName;
		$data['groupID']   = $this->User_model->groupID;
		$data['localNum']  = $this->User_model->localNum;
		$data['telNum']    = $this->User_model->telNum;
		$data['rstatus']   = $this->User_model->rstatus;
		
		$this->User_group_model->retrieve($this->User_model->groupID);
		
		$data['groupName']    = $this->User_group_model->groupName;
		$data['records']      = $this->User_model->retrieveAllRole($id);
		
		$this->load->view('modules/User/view', $data);
//		
//		if ($id) {
//			$this->db->where('userID', $id);
//	    }
//	    
//	    $user_roles = $this->User_model->retrieveAllUserRole();
//	    
//	    foreach ($user_roles as $row) {
//           unset($where);
//           if ($row->roleID) {
//    			$this->db->where('roleID', $row->roleID);
//    	    }
//           $data['roles'] = $this->Role_model->retrieveAll();
//           
//           $this->load->view('modules/User/view2', $data);
//	    }
		
		$this->load->view('footer');
	}

	/**
	 * This will display an edit test item form
	 * 
	 * @param integer $id
	 */
	function edit($userID)
	{
        // tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;

		$this->load->view('header', $data);
        $this->load->library('validation');
        
		$this->User_model->retrieve($userID);
		$data['userID']    = $userID;
		$data['userName']  = $this->User_model->userName;
		$data['userPswd']  = $this->User_model->userPswd;
		$data['lastName']  = $this->User_model->lastName;
		$data['firstName'] = $this->User_model->firstName;
		$data['middleName']= $this->User_model->middleName;
		$data['groupID']   = $this->User_model->groupID;
		$data['localNum']  = $this->User_model->localNum;
		$data['telNum']    = $this->User_model->telNum;
		$data['rstatus']   = $this->User_model->rstatus;
		
		$data['usergroups'] = $this->User_group_model->retrieveAll();
		
		$this->load->view('modules/User/edit', $data);
		$this->load->view('footer');
	}
	
	/**
	 * This is the method to save/update test item
	 */
	function save($id='')
	{
		// tab settings
		require_once('includes/modules.php');
		
		// loading of necessary models
		$this->load->model('User_model');
		
		// data settings
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		$this->load->view('header', $data);

		//posting values
		//$id 		    = trim($this->input->get_post('userID'));
		$userName 		= $this->User_model->userName 		= trim($this->input->get_post('userName'));
		$userPswd 		= $this->User_model->userPswd 		= trim($this->input->get_post('userPswd'));
		$reuserPswd 	= $this->User_model->reuserPswd 	= trim($this->input->get_post('reuserPswd'));
		$groupID 		= $this->User_model->groupID 		= trim($this->input->get_post('groupID'));
		$lastName 		= $this->User_model->lastName 		= trim($this->input->get_post('lastName'));
		$firstName 		= $this->User_model->firstName 		= trim($this->input->get_post('firstName'));
		$middleName 	= $this->User_model->middleName 	= trim($this->input->get_post('middleName'));
		$telNum 		= $this->User_model->telNum 		= trim($this->input->get_post('telNum'));
		$localNum		= $this->User_model->localNum		= trim($this->input->get_post('localNum'));
		$rstatus		= $this->User_model->rstatus		= 1;

		if($this->input->get_post('is_admin')) {
		    $is_admin		= $this->User_model->is_admin		= 1;
		} else {
		    $is_admin		= $this->User_model->is_admin		= 0;
		}
		
		if (!$id) {
			// saving a new record
			$this->User_model->userID 		= md5(time());
			$this->User_model->create();
            
            $getLastID = $this->User_model->getLastID($userName);
            $data['lastID'] = $getLastID[0]->userID;
            $newID = $getLastID[0]->userID;

            
            // assign all the roles under the usergroup
            // get the roles of the user group
	    	if ($groupID) {
				$this->db->where('groupID', $groupID);
	    	}

            $theGroupRoles = $this->User_group_role_model->retrieveAll();
        
            if ($theGroupRoles) {
                foreach($theGroupRoles as $row) {

                    $roleID = $row->roleID;
                    $userID = $newID;
                    
                    $this->User_model->addUserRole($roleID, $newID);
                }
            }
			$data['class'] 	 = "notificationbox";
			$data['display'] = "Block";
			$data['msg']     = "Record successfully saved.";
			
		} else {

		  if ($groupID) {
				$this->db->where('groupID', $groupID);
	    	}

            $theGroupRoles = $this->User_group_role_model->retrieveAll();
        
            $newID = $id;
            if ($theGroupRoles) {
                // vcode generator

                $userID = $newID;
                                
                //delete all existing all role to previous userGroup
                $this->User_model->deleteAllRole($userID);
                
                foreach($theGroupRoles as $row) {
                    $roleID = $row->roleID;
    
//                    $isExist = $this->User_model->isExistRole($userID, $roleID);
//                    
//                    if(!$isExist) {
//                        $this->User_model->addUserRole($roleID, $newID);
//                    }
                //save all roles
                $this->User_model->addUserRole($roleID, $newID);
                }
                
            }
			// updating an existing record
			$this->User_model->userID 		= $id;
			$this->User_model->update($id);
            $data['lastID'] = $id;

            $data['class'] 	 = "notificationbox";
			$data['display'] = "Block";
			$data['msg']     = "Record successfully updated.";
		}

		$this->load->view('modules/User/save', $data);
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}

	/**
	 * This is to delete the target test item
	 *
	 * @param integer $id
	 */
	function delete($id)
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;

		$this->load->view('header', $data);

		$this->load->model('User_model');
		$this->User_model->delete($id);
		
		$data['class'] 	 = "notificationbox";
		$data['display'] = "Block";
		$data['msg']     = "Record permanently deleted.";

		$this->load->view('modules/User/delete');
		$this->load->view('msg',$data);
		$this->load->view('footer');
	}
	
	function viewmsg()
	{
	   // tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		$data['class'] 	 = "notificationbox";
		$data['display'] = "Block";
		$data['msg']     = "The quick brown fox jumps over the lazy dog.";
		
		$this->load->view('header', $data);
		$this->load->view('modules/msg',$data);	
		$this->load->view('footer');
	}
	/************************ END: ALL BASIC METHODS *********************************/
	
	/************************ START: ALL MISC & AJAX HANDLER METHODS *********************************/
	/**
	 * This will check if the target is already exist
	 *
	 * @param string $userName
	 */
    function isExist($userName)
    {
        if ($this->User_model->isExist($userName)) {
            echo 1; // return 1 if username exist
        } else {
            echo 0; // 
        }
    }

	
	function displayName()
	{
	   $row[0]['lname'] = $this->input->get_post('lname');
	   $row[0]['fname'] = $this->input->get_post('fname');
	   echo $this->services_json->encode($row);
	}
	
	
	function populateUserGroup()
	{
	   $row[0]['id'] = 1;
	   $row[0]['name'] = "Admin";
	   
	   $row[1]['id'] = 2;
	   $row[1]['name'] = "Requestor";
	   
	   $row[2]['id'] = 3;
	   $row[2]['name'] = "OJT";
	   echo $this->services_json->encode($row);
	}
	
	
	function viewPopup($id)
    {
        // tab settings
        require_once('includes/modules.php');
        
        $data['userID']    = $id;
        $data['roleID']     = $this->Role_model->roleID;
        $data['roleName']   = $this->Role_model->roleName;
        $data['description']= $this->Role_model->description;
        
        $data['record']     = $this->User_model->retrieveRole($id);
        $this->load->view('modules/user/popup', $data);
    }
    
    function displayRole()
    {
        $roleids = $this->input->get_post('chkRole');
        $userID = $this->input->get_post('userID');
        
        if ($roleids) {
            foreach ($roleids as $id) {
                echo $id;
            }
        }
        
        $this->User_model->insertUserRole($roleids,$userID);
        $this->User_model->retrieveRole($userID);
        
        $data['userID'] = $userID;
        
        $this->load->view('modules/user/saverole', $data);
        
    }
    
    function deleteRole()
    {
        $roleids = $this->input->get_post('chkRole');
        $userid = $this->input->get_post('userID');
        $this->User_model->deleteRole($roleids);
        $this->view($userid);
    }
	/************************ END: ALL MISC & AJAX HANDLER METHODS *********************************/
}

?>