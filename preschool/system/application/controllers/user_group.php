<?php
class User_group extends Controller 
{
    var $module_menu;
    function User_group()
	{
		parent::Controller();
		$this->load->model('User_group_model');  
		$this->load->model('User_group_role_model');  

		// menu settings
		$this->Menu_model->user_group();
	}
	
	function index()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;

		$this->load->view('header', $data);
		$this->load->view('user_group/menu', $data);
		$this->load->view('footer');
	}

/************************ START: ALL BASIC METHODS *********************************/
    function create()
    {
        // tab settings
        require_once('includes/modules.php');
        
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        // data settings
        $this->load->view('header', $data);
        $this->load->library('validation');
        
        $data['groupName'] 	= "";
        $data['description']	= "";
        $this->load->view('modules/user_group/create', $data);
        $this->load->view('footer');
    }
    
    function listview($offset=0,$limit=0)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        $this->load->library('pagination');
        $filtered  	 	 = $this->input->get_post('cmdFilter');
        
        unset($data);
        if ($filtered) {
    		$data['groupID']      = $groupID	= trim($this->input->get_post('groupID'))?  trim($this->input->get_post('groupID')):'';
    		$data['groupName']    = $groupName	= trim($this->input->get_post('groupName'))?  trim($this->input->get_post('groupName')):'';
    		$data['description']  = $description= trim($this->input->get_post('description'))? trim($this->input->get_post('description')):'';
        } else {
            $data['groupID']      = $groupID    = $this->session->userdata('groupID');  
            $data['groupName']    = $groupName  = $this->session->userdata('groupName');  
            $data['description']  = $description= $this->session->userdata('description');
        }

        // set session variables
        $this->session->set_userdata('groupID',$groupID);
        $this->session->set_userdata('groupName',$groupName);
        $this->session->set_userdata('description',$description);
        
		if ($groupID) {
			$this->db->like('groupID', $groupID, 'after');
    	}

    	if ($groupName) {
			$this->db->like('groupName', $groupName, 'after');
    	}

    	if ($description) {
			$this->db->like('description', $description, 'after');
    	}

    	// get total records
        $total_rec  = $this->db->count_all_results('user_groups');

		if ($groupID) {
			$this->db->like('groupID', $groupID, 'after');
    	}
    	
        if ($groupName) {
			$this->db->like('groupName', $groupName, 'after');
    	}

    	if ($description) {
			$this->db->like('description', $description, 'after');
    	}

    	$this->db->order_by('groupName','ASC');

    	// overwrite default value of the limit
    	if (!$limit) {
    	   $limit = 50; //$record_limit[$this->uri->segment(1)];
    	}
    	
    	if ($offset) {
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);
        }

        // get all records
        $data['record'] = $this->User_group_model->retrieveAll();
        
        $main_url   = "index.php?user_group/listview";
        $data['pagination'] = $this->pagination2->pageSetup($main_url,$offset,$total_rec,$limit);
        
        $this->load->view('modules/user_group/listview', $data);
        
        $this->load->view('footer');
    }

    function view($groupID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        
//        $this->load->model('User_group_model');
        $this->load->model('Role_model');
        
        $this->User_group_model->retrieve($groupID);
        
        $data['groupID']      = $this->User_group_model->groupID;
        $data['groupName']    = $this->User_group_model->groupName;
        $data['description']  = $this->User_group_model->description;
        $data['records']      = $this->User_group_model->retrieveAllGR($groupID);
//        $data['rolerecords']  = $this->Role_model->retrieveAll();
        
        $this->load->view('modules/user_group/view', $data);
        $this->load->view('footer');
    }

    function edit($groupID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        $this->load->library('validation');
        
        $this->User_group_model->retrieve($groupID);

        $data['groupID']    = $groupID; 
        $data['groupName']  = $this->User_group_model->groupName; 
        $data['description']   = $this->User_group_model->description; 
        $this->load->view('modules/user_group/edit', $data);
        
        $this->load->view('footer');
    }   
    
    function save($id='')
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        
        $id = $this->input->get_post('groupID');
        if (!$id) {
        
            $groupName 	    = $this->User_group_model->groupName       = $this->input->get_post('groupName');
            $description 	= $this->User_group_model->description     = $this->input->get_post('description');
            $rstatus 	    = $this->User_group_model->rstatus         = 1;
        
            $this->User_group_model->create();
            $getLastID = $this->User_group_model->getLastID($groupName);
            $data['lastID'] = $getLastID[0]->groupID;

            $data['class'] 	 = "notificationbox";
            $data['display'] = "Block";
            $data['msg']     = "Successfully Saved!";
            echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?user_group/listview/">';		
            $this->load->view('msg',$data);
        } else {     
            $this->User_group_model->groupName 	        = $this->input->get_post('groupName');
            $this->User_group_model->description 	  	= $this->input->get_post('description');
            $this->User_group_model->update($id);
            $data['lastID'] = $id;
            
            $data['class'] 	 = "notificationbox";
            $data['display'] = "Block";
            $data['msg']     = "Successfully Updated!";
            echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?user_group/view/'.$id.'">';			
            $this->load->view('msg',$data);
        }
        $this->load->view('footer');
    }  
    
    function delete($groupID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        
        $data['lastID'] = $groupID;  
        
        $this->User_group_model->delete($groupID);
        $data['class'] 	 = "notificationbox";
		$data['display'] = "Block";
		$data['msg']     = "Successfully deleted!";	
		$this->load->view('msg',$data);
        echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?user_group/listview/">';
        $this->load->view('footer');
    }
    
/************************ END: ALL BASIC METHODS *********************************/

/************************ START: ALL MISC METHODS *********************************/
    
/************************ END: ALL MISC METHODS *********************************/

/************************ START: ALL MISC AND HANDLER METHODS *********************************/
    function isExist($groupName)
    {
        if ($this->User_group_model->isExist($groupName)) {
            echo 1; // return 1 if groupCode
        } else {
            echo 0; // 
        }
    }
    
     function displayRole()
    {
        $roleids = $this->input->get_post('chkRole');
        $groupID = $this->input->get_post('groupID');
        
        if ($roleids) {
            foreach ($roleids as $id) {
                echo $id;
            }
        }
        
        $this->User_group_role_model->insertGroupRole($roleids,$groupID);
        $this->User_group_role_model->retrieveRole($groupID);
        
        $data['groupID'] = $groupID;
        
        $this->load->view('modules/user_group/save',$data);
        
    }
    
    function deleteRole()
    {
        $roleids = $this->input->get_post('chkRole');
        $groupid = $this->input->get_post('groupID');
        $this->User_group_role_model->deleteRole($roleids);
        $this->view($groupid);
    }
/************************ END: ALL MISC AND HANDLER METHODS *********************************/

}
?>