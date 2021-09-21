<?php
class Admin extends Controller 
{
	var $module_menu;
	var $conds = array();
	
	function Admin()
	{
		parent::Controller();
		
		// menu settings
		$this->Menu_model->admin();
	}
	
//	function menu()
//	{
//		$this->module_menu[] = array('url' => 'index.php?user/listview', 'name' => 'Users', 'image' => 'menu');
//		$this->module_menu[] = array('url' => 'index.php?user/create', 'name' => 'New User', 'image' => 'menu');
//		$this->module_menu[] = array('url' => 'index.php?user_group/listview', 'name' => 'User Groups', 'image' => 'menu');
//		$this->module_menu[] = array('url' => 'index.php?user_group/create', 'name' => 'New User Group', 'image' => 'menu');
//		$this->module_menu[] = array('url' => 'index.php?role/listview', 'name' => 'Roles', 'image' => 'menu');
//		$this->module_menu[] = array('url' => 'index.php?role/create', 'name' => 'New Role', 'image' => 'menu');
//	    $this->module_menu[] = array('url' => 'index.php?plant', 'name' => 'Plant', 'image' => 'menu');
//        $this->module_menu[] = array('url' => 'index.php?rawMaterial', 'name' => 'Raw Material', 'image' => 'menu');
//        $this->module_menu[] = array('url' => 'index.php?supplier', 'name' => 'Supplier', 'image' => 'menu');
//        $this->module_menu[] = array('url' => 'index.php?product', 'name' => 'Products', 'image' => 'menu');
//	}
	
	function index()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;

		$this->load->view('header', $data);
		$this->load->view('modules/admin/menu', $data);
		$this->load->view('footer');
	}
//	
//	//******************************* USERS ***********************************
//	/**
//	 * method to display list of users with filters(optional)
//	 */
//	function list_user()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// loading of necessary models
//		$this->load->model('User_model');
//		
//		// menu settings
//		$this->Menu_model->admin();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$filtered  	 	= $this->input->get_post('cmdFilter');
//		
//		if ($filtered) {
//			unset($data);
//			$lastName 		= trim($this->input->get_post('lastName'));
//			$firstName		= trim($this->input->get_post('firstName'));
//			$middleName 	= trim($this->input->get_post('middleName'));
//			$deptID			= trim($this->input->get_post('deptID'));
//			$groupID		= trim($this->input->get_post('groupID'));
//			$localNum		= trim($this->input->get_post('localNum'));
//			$telNum			= trim($this->input->get_post('telNum'));
//			$rstatus		= trim($this->input->get_post('rstatus'));
//
//			$data['lastName'] 		= $lastName;
//			$data['firstName'] 		= $firstName;
//			$data['middleName'] 	= $middleName;
//			$data['deptID'] 		= $deptID;
//			$data['groupID'] 		= $groupID;
//			$data['localNum'] 		= $localNum;
//			$data['telNum'] 		= $telNum;
//			$data['rstatus'] 		= $rstatus;
//			
//			if ($lastName) {
//				$this->db->like('lastName', $lastName);
//	    	}
//	    	
//			if ($firstName) {
//				$this->db->like('firstName', $firstName);
//	    	}
//	    	
//	    	if ($middleName) {
//				$this->db->like('middleName', $middleName);
//	    	}
//	    	
//	    	if ($deptID) {
//				$this->db->where('deptID', $deptID);
//	    	}
//	    	if ($groupID) {
//				$this->db->where('groupID', $groupID);
//	    	}
//
//	    	if ($localNum) {
//				$this->db->where('localNum', $localNum);
//	    	}
//	    	if ($telNum) {
//				$this->db->where('telNum', $telNum);
//	    	}
//	    	if ($rstatus) {
//				$this->db->where('rstatus', $rstatus);
//	    	}
//
//		} else {
//			$data['lastName'] 		= '';
//			$data['firstName'] 		= '';
//			$data['middleName'] 	= '';
//			$data['deptID'] 		= '';
//			$data['groupID'] 		= '';
//			$data['localNum'] 		= '';
//			$data['telNum'] 		= '';
//			$data['rstatus'] 		= '';
//		}
//
//		$data['record'] = $this->User_model->retrieveAllUsers();
//		$this->load->view('modules/Admin/list_user', $data);
//		$this->load->view('footer');
//	}
//	
//	function create_user()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->library('validation');
//		
//		$this->load->view('modules/Admin/create_user');	
//		$this->load->view('footer');
//	}
//
//	function save_user($id = '')
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//		
//		// data settings
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//
//		//posting values
//		$userName 		= trim($this->input->get_post('userName'));
//		$userPswd 		= trim($this->input->get_post('userPswd'));
//		$reuserPswd 	= trim($this->input->get_post('reuserPswd'));
//		$deptID 		= trim($this->input->get_post('deptID'));
//		$groupID 		= trim($this->input->get_post('groupID'));
//		$lastName 		= trim($this->input->get_post('lastName'));
//		$firstName 		= trim($this->input->get_post('firstName'));
//		$middleName 	= trim($this->input->get_post('middleName'));
//		$telNum 		= trim($this->input->get_post('telNum'));
//		$localNum		= trim($this->input->get_post('localNum'));
//		
//		//for validation
//		$this->load->library('validation');
//		$rules['userName'] 	 = "trim|required|min_length[5]|max_length[12]|xss_clean";
//		$rules['userPswd'] 	 = "trim|required|matches[reuserPswd]";
//		$rules['reuserPswd'] = "trim|required";
//		$rules['deptID'] 	 = "trim|required";
//		$rules['groupID'] 	 = "trim|required";
//		$rules['groupID']  	 = "trim|required";
//		$rules['lastName'] 	 = "trim|required";
//		$rules['firstName']  = "trim|required";
//		$rules['middleName'] = "trim|required";
//		$rules['telNum'] 	 = "trim|required|numeric";
//		$rules['localNum'] 	 = "trim|required|numeric";
//		$this->validation->set_rules($rules);
//			
//		if ($this->validation->run() == FALSE) {
//			unset($data);
////			$data['posted']  = '1';			
//			$this->load->view('modules/Admin/create_user', $data);
//		}
//		else {
//			$this->load->model('User_model');
//			if (!$id) {
//				// saving a new record
//				// get posted data
//				$this->User_model->userID 			= md5(time());
//				$this->User_model->userName 		= $userName;
//				$this->User_model->userPswd 		= $userPswd;
//				$this->User_model->reuserPswd 		= $reuserPswd;
//				$this->User_model->deptID 			= $deptID;
//				$this->User_model->groupID 			= $groupID;
//				$this->User_model->lastName 		= $lastName;
//				$this->User_model->firstName 		= $firstName;
//				$this->User_model->middleName 		= $middleName;
//				$this->User_model->telNum 			= $telNum;
//				$this->User_model->localNum			= $localNum;
//				$this->User_model->rstatus			= '1';
//	
//				$this->User_model->createUser();
//				
//				$data['flag'] = '0';
//			} else {
//				// updating an existing record
//				// get posted data
//				$this->User_model->userID 			= $id;
//				$this->User_model->userName 		= $userName;
//				$this->User_model->userPswd 		= $userPswd;
//				$this->User_model->reuserPswd 		= $reuserPswd;
//				$this->User_model->deptID 			= $deptID;
//				$this->User_model->groupID 			= $groupID;
//				$this->User_model->lastName 		= $lastName;
//				$this->User_model->firstName 		= $firstName;
//				$this->User_model->middleName 		= $middleName;
//				$this->User_model->telNum 			= $telNum;
//				$this->User_model->localNum			= $localNum;
//				$this->User_model->rstatus			= '1';
//	
//				$this->User_model->updateUser($id);
//	
//				$data['flag'] = '1';
//			}
//				
//			$this->load->view('modules/Admin/save_user', $data);
//		}
//		
//		$this->load->view('footer');
//	}
//
//	function view_user($userID)
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//
//		$this->load->view('header', $data);
//
//		$this->load->model('User_model');
//		
//		$data['record'] = $this->User_model->retrieveUser($userID);
//		
//		$this->load->view('modules/Admin/view_user', $data);
//		$this->load->view('footer');
//	}
//
//	function edit_user($userID)
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//
//		$this->load->view('header', $data);
//
//		$this->load->model('User_model');
//		
//		$data['record'] = $this->User_model->retrieveUser($userID);
//		
//		$this->load->view('modules/Admin/edit_user', $data);
//		$this->load->view('footer');
//	}
//
//	function delete_user($userID)
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//
//		$this->load->view('header', $data);
//
//		$this->load->model('User_model');
//		$this->User_model->deleteUser($userID);
//		
//		$this->load->view('modules/Admin/delete_user', $data);
//		$this->load->view('footer');
//	}
//
//	/**
//	 * method to display list of user groups
//	 *
//	 */
//	function list_user_group()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/list_user_group');
//		$this->load->view('footer');
//	}
//	
//	function display_hello()
//	{
//		echo "hello ".$this->input->get_post('name');
//		
//	}
//
//	
//	
//	
//	
//	
//	//******************************* ITEMS ***********************************
//	
//	/**
//	 * Enter description here...
//	 *
//	 */
//	
//	function create_item()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->Menu_model->admin();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/create_item');
//		$this->load->view('footer');
//	}
//
//	function view_item()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/view_item');
//		$this->load->view('footer');
//	}
//
//	function edit_item()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/edit_item');
//		$this->load->view('footer');
//	}
//	
//	function item_list()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/item_list');
//		$this->load->view('footer');
//	}	
//	
//	
//	
//	//******************************* ROLES ***********************************
//	
//	function list_role()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/list_role');
//		$this->load->view('footer');
//	}
//	
//	
//
//	function create_role()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		$this->load->view('modules/Admin/create_role');
//		$this->load->view('footer');
//	}
//
//	function create_user_group()
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings		
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//		
//		$this->load->view('modules/Admin/create_user_group');
//		$this->load->view('footer');
//	}
//	
//	function save_user_group($id = '')
//	{
//		// tab settings
//		require_once('includes/modules.php');
//		
//		// menu settings
//		$this->menu();
//		
//		// data settings
//		$data['title'] 	 = "Index";
//		$data['modules'] = $modules;
//		$data['menu'] 	 = $this->module_menu;
//		
//		$this->load->view('header', $data);
//
//		//posting values
//		$groupName 		= trim($this->input->get_post('groupName'));
//		$groupDesc 		= trim($this->input->get_post('groupDesc'));
//		
//		//for validation
//		$this->load->library('validation');
//		$rules['groupName'] = "trim|required";
//		$this->validation->set_rules($rules);
//			
//		if ($this->validation->run() == FALSE) {
//			unset($data);
//			$data['posted'] = '1';			
//			$this->load->view('modules/Admin/create_user_group', $data);
//		}
//		else {
//			
//			$this->load->model('User_model');
//			if (!$id) {
//			//get posted data
//				$this->User_model->userID 			= md5(time());
//				$this->User_model->userName 		= $userName;
//				$this->User_model->userPswd 		= $userPswd;
//				$this->User_model->reuserPswd 		= $reuserPswd;
//				$this->User_model->deptID 			= $deptID;
//				$this->User_model->groupID 			= $groupID;
//				$this->User_model->lastName 		= $lastName;
//				$this->User_model->firstName 		= $firstName;
//				$this->User_model->middleName 		= $middleName;
//				$this->User_model->telNum 			= $telNum;
//				$this->User_model->localNum			= $localNum;
//				$this->User_model->rstatus			= '1';
//	
//				$this->User_model->createUser();
//				
//				$data['flag'] = '0';
//			} else {
//				//get posted data
//				$this->User_model->userID 			= $id;
//				$this->User_model->userName 		= $userName;
//				$this->User_model->userPswd 		= $userPswd;
//				$this->User_model->reuserPswd 		= $reuserPswd;
//				$this->User_model->deptID 			= $deptID;
//				$this->User_model->groupID 			= $groupID;
//				$this->User_model->lastName 		= $lastName;
//				$this->User_model->firstName 		= $firstName;
//				$this->User_model->middleName 		= $middleName;
//				$this->User_model->telNum 			= $telNum;
//				$this->User_model->localNum			= $localNum;
//				$this->User_model->rstatus			= '1';
//	
//				$this->User_model->updateUser($id);
//	
//				$data['flag'] = '1';
//			}
//				
//			$this->load->view('modules/Admin/save_user', $data);
//		}
//		
//		$this->load->view('footer');
//	}
}
?>