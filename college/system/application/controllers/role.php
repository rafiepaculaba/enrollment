<?php
class Role extends Controller 
{
    var $module_menu;
    
    function Role()
	{
		parent::Controller();
		$this->load->model('Role_model');
		$this->load->model('User_group_role_model');

		// menu settings
		$this->Menu_model->role();
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
		$data['record'] = $this->Role_model->retrieveAll();
		$this->load->view('modules/role/listview', $data);
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
        
        $data['roleName'] 	= "";
        $data['description']	= "";
        $this->load->view('modules/role/create', $data);
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
    		$data['roleName']     = $roleName	= trim($this->input->get_post('roleName'))?  trim($this->input->get_post('roleName')):'';
    		$data['description']  = $description= trim($this->input->get_post('description'))? trim($this->input->get_post('description')):'';
        } else {
            $data['roleName']     = $roleName   = $this->session->userdata('roleName');  
            $data['description']  = $description= $this->session->userdata('description');
        }
        
        // set session variables
        $this->session->set_userdata('roleName',$roleName);
        $this->session->set_userdata('description',$description);
        
		if ($roleName) {
			$this->db->like('roleName', $roleName, 'after');
    	}
    	
    	if ($description) {
			$this->db->like('description', $description, 'after');
    	}
        
    	// get total records
        $total_rec  = $this->db->count_all_results('user_roles');
        
		if ($roleName) {
			$this->db->like('roleName', $roleName, 'after');
    	}
    	
    	if ($description) {
			$this->db->like('description', $description, 'after');
    	}
    	
    	$this->db->order_by('roleName','ASC');
    	
    	// overwrite default value of the limit
    	if (!$limit) {
    	   $limit = 5; //please change this
    	}
    	
    	if ($offset) {
            $this->db->limit($limit, $offset);
        } else {
            $this->db->limit($limit);
        }
        
    	
        // get all records
        
        $main_url   = "index.php?role/listview";
        $data['pagination'] = $this->pagination2->pageSetup($main_url,$offset,$total_rec,$limit);
        
        $data['record'] = $this->Role_model->retrieveAll();
        
        $this->load->view('modules/role/listview', $data);
        
        $this->load->view('footer');
    }
    
    function view($roleID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);

        $this->Role_model->retrieve($roleID);
        $data['roleID']   = $this->Role_model->roleID;
        $data['roleName'] = $this->Role_model->roleName;
        $data['description']  = $this->Role_model->description;
        
        $this->load->view('modules/role/view', $data);
        $this->load->view('footer');
    }
    
    function edit($roleID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        $this->load->library('validation');
        
        $this->Role_model->retrieve($roleID);
        $data['roleID']    = $roleID; 
        $data['roleName']  = $this->Role_model->roleName; 
        $data['description']   = $this->Role_model->description; 
        
        $this->load->view('modules/role/edit', $data);
        
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
        
        $id = $this->input->get_post('roleID');
        
        if (!$id) {
        
            $roleID 	     = $this->Role_model->roleID 		    = $this->input->get_post('roleID');
            $roleName 	     = $this->Role_model->roleName 		    = $this->input->get_post('roleName');
            $description 	 = $this->Role_model->description 		= $this->input->get_post('description');
            $rstatus 	     = $this->Role_model->rstatus      		= 1;
            
            $this->Role_model->create();
            $getLastID = $this->Role_model->getLastID($roleName);
            $data['lastID'] = $getLastID[0]->roleID;
            $id = $getLastID[0]->roleID;
            $data['class'] 	 = "notificationbox";
            $data['display'] = "Block";
            $data['msg']     = "Successfully Saved!";
            echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?role//view/'.$id.'">';		
            $this->load->view('msg',$data);
        } else {     
            $this->Role_model->roleName 	= $this->input->get_post('roleName');
            $this->Role_model->description 	  	= $this->input->get_post('description');
            $this->Role_model->update($id);
            $data['lastID'] = $id;
            
            $data['class'] 	 = "notificationbox";
            $data['display'] = "Block";
            $data['msg']     = "Successfully Updated!";
            echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?role/view/'.$id.'">';
            $this->load->view('msg',$data);
        }
    
    
        $this->load->view('footer');
    }  
    
    function delete($roleID)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $data['title'] 	 = "Index";
        $data['modules'] = $modules;
        $data['menu'] 	 = $this->module_menu;
        
        $this->load->view('header', $data);
        
        $data['lastID'] = $roleID;  
        
        $this->Role_model->delete($roleID);
        $data['class'] 	 = "notificationbox";
		$data['display'] = "Block";
		$data['msg']     = "Successfully deleted!";	
		$this->load->view('msg',$data);
        echo '<meta HTTP-EQUIV="REFRESH" content="3; url=index.php?role/listview/">';
        $this->load->view('footer');
    }
    
/************************ END: ALL BASIC METHODS *********************************/

/************************ START: ALL MISC METHODS *********************************/
    
/************************ END: ALL MISC METHODS *********************************/

/************************ START: ALL MISC AND HANDLER METHODS *********************************/
    function isExist($roleName)
    {
        if ($this->Role_model->isExist($roleName)) {
            echo 1; // return 1 if roleCode
        } else {
            echo 0; // 
        }
    }
    
    function viewPopup($id)
    {
        // tab settings
        require_once('includes/modules.php');
        
        // data settings		
        $this->load->model('role_model');
        
        $data['groupID']    = $id;
        $data['roleID']     = $this->Role_model->roleID;
        $data['roleName']   = $this->Role_model->roleName;
        $data['description']= $this->Role_model->description;
        
        $data['record']     = $this->User_group_role_model->retrieveRole($id);
        $this->load->view('modules/role/popup', $data);
    }
/************************ END: ALL MISC AND HANDLER METHODS *********************************/

    }


?>