<?php
class Access_checker_model extends Model 
{
    function Access_checker_model()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
        session_start();
    }
    
    /** 
     * function: getAccessCode - method that will get the role id of the specified role name
     *
     * @param string $roleName
     * @return string id
     */
    function getAccessCode($roleName)
    {
        if ($roleName) {
        	$query = $this->db->query("SELECT roleID FROM `roles` WHERE roleName = '$roleName'");
        	foreach ($query->result() as $value) {
        	    return $value->roleID;
        	}
        } else {
            return -1;
        }
    }
    
    /**
     * function: checkAccess - method that will check the access code if the current user has an access to this particular role
     *                       - checking in the database
     *
     * @param string $userid
     * @param string $accesscode(string id) 
     * @return int(-1) missing required fields
     * @return int(0) no access
     * @return int(1) has access
     */	
    function check_access($userid, $accesscode)
    {
        //admin has always access to all so it will return 1 if user is admin
        if ($_SESSION['userID'] == '1') {
            return 1;
        } else if ($_SESSION['is_admin'] == '1') {
            return 1;
        } else if ($userid && $accesscode) {
            $query = $this->db->query("SELECT * FROM `user_roles` WHERE roleID = '$accesscode' AND userID = '$userid'");
        	$this->db->last_query();
        	if($query->result()) {
        	    return 1;
        	} else {
        		return 0;
        	}
        }
    }
}
?>