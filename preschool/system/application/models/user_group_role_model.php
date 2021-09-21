<?php
class User_group_role_model extends Model 
{
	var $grID;
	var $groupID;
	var $roleID;
	var $rstatus;
	
	function User_group_role_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
        
        if ($id) {
            $this->retrieve($id);
        }
    } 
    
    function addGroupRole()
    {
    	$data['grID']            = '' ;
       	$data['groupID']         = $this->groupID;
      	$data['roleID']          = $this->roleID ;
        $this->db->insert('user_group_roles', $data); 
    }
	
    function retrieve($id)
    {
    	$query = $this->db->query("SELECT * FROM `user_group_roles` Where grID = '".$id."' ");    	
    	$row = $query->result();
    	
    	if ($row && $id) {
        	$this->grID        = $row[0]->grID;
        	$this->groupID     = $row[0]->groupID;
        	$this->roleID      = $row[0]->roleID;
        	$this->rstatus      = $row[0]->rstatus;
    	}
    }
        
    function retrieveRole($id)
    {   
    	$query = $this->db->query("Select ur.* from user_group_roles ugr, roles ur where ugr.groupID=$id and ugr.roleID=ur.roleID");    	
    	$records = $query->result();

    	$str = "";
	    $ctr = 0;
    	if ($records) {
    	   
    	   foreach ($records as $row) {
    	       if ($ctr>0) {
    	           $str .= ",".$row->roleID; 
	           } else {
	               $str .= $row->roleID; 
	           }
	           
	           $ctr++;
    	   }
    	}
    	
    	if ($str) {
    	   $query = $this->db->query("Select * from roles where roleID not in ($str)");
    	} else {
    	   $query = $this->db->query("Select * from roles");
    	}
    	
    	$records = $query->result();
    	return $records;
    }
    
    function update($id)
    {
       	$data['roleName'] 	= $this->roleName;
      	$data['description'] 	= $this->description ;
       	
       	$this->db->where('roleID', $id);
        $this->db->update('user_roles', $data); 
        
    }

    function delete($id)
    {
    	$this->db->where('roleID', $id);
		$this->db->delete('user_roles');     	

    }
    
    function retrieveAllRoles()
    {
        $query = $this->db->get("user_roles");
    	return $query->result();
    }
    
    function retrieveAll()
    {
        $query = $this->db->get("user_group_roles");
    	return $query->result();
    }

    function isExist($roleID, $groupID)
    {
    	$this->db->where('groupID', $groupID);
    	$this->db->where('roleID', $roleID);
    	$this->db->select('grID');
		$query = $this->db->get('user_group_roles');
		if($query->result()) {
			return 1;
		} else {
			return 0;
		}
    }
    
    function getlastID($roleName)
    {
    	$this->db->where('roleName', $roleName);
    	$this->db->select('roleID');
		$query = $this->db->get('user_roles',1); 
		return $query->result();
    }
    
    function insertGroupRole($roleids,$groupid)
    {
        foreach ($roleids as $id) {
            $data['roleID'] 	= $id;
    	    $data['groupID'] 	= $groupid;
            $this->db->insert('user_group_roles', $data); 
        }
    	
    }
    
    function deleteRole($roleids)
    {
        if($roleids){
            foreach ($roleids as $id) {
            $this->db->where('roleID', $id);
            $this->db->delete('user_group_roles');
        }
        }
    }
}

?>