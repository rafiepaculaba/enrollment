<?php
class Reservation_detail_model extends Model 
{
	var $resDetailID;
	var $resID;
	var $subjID;
	var $schedID;
	var $secID;
	var $profID;
	var $rstatus;

    function Reservation_detail_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function create()
    {
    	$data['resDetailID']	= $this->resDetailID;
    	$data['resID'] 			= $this->resID;
       	$data['subjID'] 		= $this->subjID;
       	$data['schedID'] 		= $this->schedID;
       	$data['secID'] 			= $this->secID;
       	$data['profID'] 		= $this->profID;
       	$data['rstatus'] 		= $this->rstatus;
       	$this->db->insert('reservation_details', $data); 
    }
    
    function retrieve($id)
    {
    	$query = $this->db->query("SELECT * FROM `reservation_details` Where resDetailID = '".$id."' ");
    	$row = $query->result();
    	
    	if ($row && $id) {
        	$this->resDetailID	= $row[0]->resDetailID;
        	$this->resID    	= $row[0]->resID;
        	$this->subjID 		= $row[0]->subjID;
        	$this->schedID 		= $row[0]->schedID;
        	$this->secID 		= $row[0]->secID;
        	$this->profID 		= $row[0]->profID;
        	$this->rstatus 		= $row[0]->rstatus;
    	}
    }
    
    function update($id = '')
    {
    	$data['resDetailID']	= $id;
    	$data['resID'] 			= $this->resID;
       	$data['subjID'] 		= $this->subjID;
       	$data['schedID'] 		= $this->schedID;
       	$data['secID'] 			= $this->secID;
       	$data['profID'] 		= $this->profID;
       	$data['rstatus'] 		= $this->rstatus;
       	
       	$this->db->where('resDetailID', $id);
        $this->db->update('reservation_details', $data); 
    }

	function delete($id)
    {
    	$this->db->where('resDetailID', $id);
		$this->db->delete('reservation_details'); 
    }
    
    
	function retrieveAll()
    {
    	$query = $this->db->get('reservation_details');
    	$row = $query->result();
    	
    	return $row;
    	
    	if ($row && $id) {
        	$this->resDetailID	= $row[0]->resDetailID;
        	$this->resID    	= $row[0]->resID;
        	$this->subjID 		= $row[0]->subjID;
        	$this->schedID 		= $row[0]->schedID;
        	$this->secID 		= $row[0]->secID;
        	$this->profID 		= $row[0]->profID;
        	$this->rstatus 		= $row[0]->rstatus;
    	}
    }

    
}

?>