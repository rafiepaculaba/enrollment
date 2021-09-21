<?php
class Reservation_model extends Model 
{
	var $resID;
	var $idno;
	var $courseID;
	var $yrLevel;
	var $semCode;
	var $schYear;
	var $studType;
	var $rstatus;

    function Reservation_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function create()
    {
    	$data['resID'] 		= $this->resID;
       	$data['idno'] 		= $this->idno;
       	$data['courseID'] 	= $this->courseID;
       	$data['yrLevel'] 	= $this->yrLevel;
       	$data['semCode'] 	= $this->semCode;
       	$data['schYear'] 	= $this->schYear;
       	$data['studType'] 	= $this->studType;
       	$data['rstatus'] 	= $this->rstatus;
       	$this->db->insert('reservation', $data); 
    }
    
    function retrieve($id)
    {
    	$query = $this->db->query("SELECT * FROM `reservation` Where resID = '".$id."' ");
    	$row = $query->result();
    	
    	if ($row && $id) {
        	$this->resID    = $row[0]->resID;
        	$this->idno    	= $row[0]->idno;
        	$this->courseID = $row[0]->courseID;
        	$this->yrLevel 	= $row[0]->yrLevel;
        	$this->semCode 	= $row[0]->semCode;
        	$this->schYear 	= $row[0]->schYear;
        	$this->studType	= $row[0]->studType;
        	$this->rstatus 	= $row[0]->rstatus;
    	}
    }
    
    function update($id = '')
    {
    	$data['resDetailID']= $id;
    	$data['resID'] 		= $this->resID;
       	$data['idno'] 		= $this->idno;
       	$data['courseID'] 	= $this->courseID;
       	$data['yrLevel'] 	= $this->yrLevel;
       	$data['semCode'] 	= $this->semCode;
       	$data['schYear'] 	= $this->schYear;
       	$data['studType'] 	= $this->studType;
       	$data['rstatus'] 	= $this->rstatus;
       	
       	$this->db->where('resID', $id);
        $this->db->update('reservation_detail', $data); 
    }

	function delete($id)
    {
    	$this->db->where('resDetailID', $id);
		$this->db->delete('reservation'); 
    }
    
    function getLastID($schYear, $semCode, $idno) 
    {
    	$this->db->where('schYear', $schYear);
    	$this->db->where('semCode', $semCode);
    	$this->db->where('idno', $idno);
    	$this->db->select('resID');
//    	$this->db->order('DESC');
    	$query = $this->db->get('reservation',1);
    	return $query->result();
    }
    
  	function retrieveReservations($schYear, $semCode, $idno) 
    {
    	$this->db->where('schYear', $schYear);
    	$this->db->where('semCode', $semCode);
    	$this->db->where('idno', $idno);
//    	$this->db->select('resID');
//    	$this->db->order('DESC');
    	$query = $this->db->get('reservation',1);
    	return $query->result();
    }
}

?>