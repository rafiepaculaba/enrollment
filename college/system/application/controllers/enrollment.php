<?php
class Enrollment extends Controller 
{
	var $id;
	var $module_menu;
	var $days = '';
	var $subjTotal;
	var $subject;
	var $subject11;
	var $subject12;
	var $subject14;
	var $subject21;
	var $subject22;
	var $subject24;
	var $subject31;
	var $subject32;
	var $subject34;
	var $subject41;
	var $subject42;
	var $subject44;
	
	var $currID;
	
	function Enrollment()
	{
		parent::Controller();
        //menu settings
		$this->Menu_model->enrollment();

		// loading of necessary models
	    $this->load->model('User_model');
	    $this->load->model('Reservation_model');
	    $this->load->model('Reservation_detail_model');
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
		
		$this->load->view('modules/enrollment/studyload');
		$this->load->view('footer');
	}
	
	
	
/************************ START: ALL METHODS *********************************/	
	/**
	 * This will display the list of studyload
	 */
	function studyload()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
			
        $this->load->view('header', $data);

        $this->load->view('modules/enrollment/studyload', $data);
		$this->load->view('footer');
	}
	
	/**
	 * This will create reservation
	 */
	function reservation()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
			
        $this->load->view('header', $data);
		
        $this->load->view('modules/enrollment/reservation', $data);
		$this->load->view('footer');
	}

	/**
	 * This will display the subject offerings
	 */
	function schedules()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
			
//        $this->load->view('header', $data);

        $this->load->view('modules/enrollment/schedules', $data);
//		$this->load->view('footer');
	}
	
	/**
	 * This will display the subject offerings
	 */
	function refresher()
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
			
//        $this->load->view('header', $data);

        $this->load->view('modules/enrollment/refresher', $data);
//		$this->load->view('footer');
	}
	
/************************ END: ALL METHODS *********************************/		
	
	

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

        $this->load->view('modules/enrollment/create', $data);
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
	function view($id='')
	{
		
		// tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		
		$this->load->view('header', $data);
		$this->Reservation_model->retrieve($id);
		
		$data['resID']		= $id;
		$data['idno']		= $this->Reservation_model->idno;
		$data['courseID']	= $this->Reservation_model->courseID;
		$data['yrLevel']  	= $this->Reservation_model->yrLevel;
		$data['semCode'] 	= $this->Reservation_model->semCode;
		$data['studType']	= $this->Reservation_model->studType;
		$data['schYear']   	= $this->Reservation_model->schYear;
		$data['rstatus']  	= $this->Reservation_model->rstatus;
		
		$this->load->view('modules/enrollment/view', $data);
		$this->load->view('footer');
	}

	/**
	 * This will display an edit test item form
	 * 
	 * @param integer $id
	*/
	function edit($id='')
	{
        // tab settings
		require_once('includes/modules.php');
		
		// data settings		
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;

		$this->load->view('header', $data);
//        $this->load->library('validation');
		$this->Reservation_model->retrieve($id);
		
		$data['resID']		= $id;
		$data['idno']		= $this->Reservation_model->idno;
		$data['courseID']	= $this->Reservation_model->courseID;
		$data['yrLevel']  	= $this->Reservation_model->yrLevel;
		$data['semCode'] 	= $this->Reservation_model->semCode;
		$data['studType']	= $this->Reservation_model->studType;
		$data['schYear']   	= $this->Reservation_model->schYear;
		$data['rstatus']  	= $this->Reservation_model->rstatus;
		
		$this->load->view('modules/enrollment/reservation_edit', $data);
		$this->load->view('footer');
	}

	/**
	 * This is the method to save/update test item
	 */
	function save($id='')
	{
		// tab settings
		require_once('includes/modules.php');
		
		// data settings
		$data['title'] 	 = "Index";
		$data['modules'] = $modules;
		$data['menu'] 	 = $this->module_menu;
		$this->load->view('header', $data);

		//posting values
		
		$idno	 	= $this->Reservation_model->idno 		= trim($this->input->get_post('idno'));
		$courseID 	= $this->Reservation_model->courseID 	= trim($this->input->get_post('courseID'));
		$yrLevel 	= $this->Reservation_model->yrLevel 	= trim($this->input->get_post('yrLevel'));
		$semCode 	= $this->Reservation_model->semCode 	= trim($this->input->get_post('semCode'));
		$studType 	= $this->Reservation_model->studType 	= trim($this->input->get_post('studType'));
		$schYear 	= $this->Reservation_model->schYear 	= trim($this->input->get_post('schYear'));
		$rstatus 	= $this->Reservation_model->rstatus 	= 1;

		if (!$id) {
			
			
			//create for header			
			$this->Reservation_model->create();
			foreach ($_SESSION['subject'] as $row) {
			}
			$lastID = $this->Reservation_model->getLastID($schYear, $semCode, $idno);
			$this->Reservation_model->resID = $lastID[0]->resID;

			//create for details
			foreach ($_SESSION['subject'] as $row) {
				if($row) {
					$this->Reservation_detail_model->resID 		= $lastID[0]->resID;
					$this->Reservation_detail_model->subjID  	= $row['subjID'];
					$this->Reservation_detail_model->schedID 	= $row['schedID'];
					$this->Reservation_detail_model->secID		= $row['secID'];
					$this->Reservation_detail_model->profID		= 1;
					$this->Reservation_detail_model->rstatus	= 1;
					$this->Reservation_detail_model->create();	
				}
			}

			$data['class'] 	 = "notificationbox";
			$data['display'] = "Block";
			$data['msg']     = "Record successfully saved.";
		} else {

			$this->Reservation_detail_model->update();
			foreach ($_SESSION['subject'] as $row) {
			}
			$lastID = $this->Reservation_model->getLastID($schYear, $semCode, $idno);
			$this->Reservation_model->resID = $lastID[0]->resID;

			//create for details
			foreach ($_SESSION['subject'] as $row) {
				if($row) {
					$this->Reservation_detail_model->resID 		= $lastID[0]->resID;
					$this->Reservation_detail_model->subjID  	= $row['subjID'];
					$this->Reservation_detail_model->schedID 	= $row['schedID'];
					$this->Reservation_detail_model->secID		= $row['secID'];
					$this->Reservation_detail_model->profID		= 1;
					$this->Reservation_detail_model->rstatus	= 1;
					$this->Reservation_detail_model->create();	
				}
			}

            $data['class'] 	 = "notificationbox";
			$data['display'] = "Block";
			$data['msg']     = "Record successfully updated.";
		}

		$this->load->view('modules/enrollment/save', $data);
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

		$this->load->model('reser');
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
	 * This will delete selected schedule
	 *
	 * @param string $schedID
	 */
	function deleteSched($id)
    {
    	$this->db->where('resDetailID', $id);
		$this->db->delete('reservation_details'); 
    }
    
	/**
	 * This will delete selected schedule
	 *
	 * @param string $schedID
	 */
    function deleteSchedule($schedID)
    {
    	if ($_SESSION['subject']) {
	        $ctr = 0;
	        foreach ($_SESSION['subject'] as $row) {
	            if ($row['schedID'] == $schedID) {
	                // found schedule here
	                $found = 1;
	                $r=0;
	                for ($r=$ctr; $r < (count($_SESSION['subject'])-1); $r++) {
	                    $_SESSION['subject'][$r] = $_SESSION['subject'][$r+1];
	                }
	                // clear the last record since the target was record already
	                unset ($_SESSION['subject'][$r]);

	                break;
	            }
	            $ctr++;
	        }
	    }

	   $display = '<table class="listView" width="100%" border="0" cellpadding="0" cellspacing="0"><tbody>
				    <tr height="20">
						<th class="dataField" align="left">&nbsp;</th>
						<th class="dataField" align="left">Subject</th>
				
						<th class="dataField" align="left">Descriptive Title</th>
						<th class="dataField" align="left">Units</th>
						<th class="dataField" align="left">Section</th>
						<th class="dataField" align="left">Schedule</th>
						<th class="dataField" align="left">Room</th>
						<th class="dataField" align="left">Teacher</th>
				
					</tr>
					
					<tr onmouseover="setPointer(this, \'0\', \'over\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmouseout="setPointer(this, \'1\', \'out\', \'#fdfdfd\', \'#DEEFFF\', \'\');" onmousedown="setPointer(this, \'0\', \'click\', \'#fdfdfd\', \'#DEEFFF\', \'\');" height="20">
						<td scope="row" class="evenListRowS1" valign="top" width="2%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="10%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="30%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="5%" align="left" bgcolor="#fdfdfd"></td>
				
						<td scope="row" class="evenListRowS1" valign="top" width="10%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="15%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="5%" align="left" bgcolor="#fdfdfd"></td>
						<td scope="row" class="evenListRowS1" valign="top" width="15%" align="left" bgcolor="#fdfdfd"></td>
					</tr>
				
					<tr>
						<td colspan="20" class="listViewHRS1" height="1"></td>
					</tr>
				
					<tr height="20">
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
						<td scope="row" class="evenListRowS1" valign="top" align="right" bgcolor="#fdfdfd"><b>Total units advised for this term : </b></td>
				
						<td scope="row" class="evenListRowS1" valign="top" align="left" bgcolor="#fdfdfd"> <b></b></td>
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
						<td scope="row" valign="top" align="left" bgcolor="#fdfdfd">&nbsp;</td>
					</tr>
					</tbody></table>';

	    echo $display;
    }
	/************************ END: ALL MISC & AJAX HANDLER METHODS *********************************/
}

?>