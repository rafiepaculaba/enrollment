<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class Pagination2 {


	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function Pagination2()
	{
	}
	
	
    /**
     * this will setup a page for pagination
     *
     * @param unknown_type $image_path
     * @param unknown_type $url
     * @param unknown_type $offset
     * @param unknown_type $total_rec
     * @param unknown_type $limit
     * @return unknown string
     */
    function pageSetup($url,$offset,$total_rec,$limit,$export_link="",$print_link="") 
    {
        $image_path = "images/";
        $start_rec = 0;
    	if ($image_path && $url && (strlen($offset)>0) && (strlen($total_rec)>0) && (strlen($limit)>0) ) {
    		if($start_rec>$total_rec) $start_rec=$offset+($limit-($start_rec-$total_rec));
    		
    		$end_rec=$offset+$limit; 
    		if($end_rec>$total_rec) $end_rec=$offset+($limit-($end_rec-$total_rec));
    		
    								 
    		if ($total_rec>0) {
    		//	$offset= $offset==0?  1:$offset;
    			$offset += 1;
    		}
    		
    		if ($offset>$limit)
    			$prev=($offset-$limit)-1; 
    		else 
    			$prev=0;
    		
    		
    		if (($total_rec % $limit)==0) $end_no=$total_rec - $limit;
    		else $end_no=$total_rec - ($total_rec % $limit);
    		
    		
    		$start_url = $url."/0/$limit";
    		$prev_url  = $url."/$prev/$limit";
    		$next_url  = $url."/$end_rec/$limit";
    		$last_url  = $url."/$end_no/$limit";
    		
    		return $this->pagination_display2 ($image_path, $start_url, $prev_url, $next_url, $last_url, $offset, $start_rec, $end_rec, $total_rec, $limit, $export_link, $print_link);
    	}
    	
    	return 0;
    }


    /**
     * this will create a pagination
     *
     * @param unknown_type $image_path
     * @param unknown_type $start_url
     * @param unknown_type $prev_url
     * @param unknown_type $next_url
     * @param unknown_type $last_url
     * @param unknown_type $offset
     * @param unknown_type $start_rec
     * @param unknown_type $end_rec
     * @param unknown_type $total_rec
     * @param unknown_type $limit
     * @return unknown string
     */
    function pagination_display2 ($image_path, $start_url, $prev_url, $next_url, $last_url, $offset, $start_rec, $end_rec, $total_rec, $limit, $export_link="", $print_link="")
    {
    
        if ( !$image_path || !$start_url || !$prev_url || !$next_url || !$last_url )
        	return 0;
        	
        	
        $paging = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>';
        	
        $paging .= '<td nowrap width="30%" align="left" class="listViewPaginationTdS1">';
        if (!empty($export_link)) {
            $paging .= '<a href="'.$export_link.'" target="_blank" id="export_link"><img src="'.$image_path.'export.gif" width="11" height="9" alt="Export"  border="0" align="absmiddle" />&nbsp;Export</a>';
        } 
        
        if (!empty($print_link)) {
            $paging .= '&nbsp;&nbsp;<a href="#" onclick="popUp(\''.$print_link.'\')" id="print_link"><img src="'.$image_path.'print.gif" width="11" height="9" alt="Export"  border="0" align="absmiddle" />&nbsp;Print</a>';
        }
        $paging .='</td>';    
        
        $paging .= '<td nowrap width="70%" align="right"  class="listViewPaginationTdS1">';
            	if ($offset > 1) {
            		$paging .= '<a href="'.$start_url.'" class="listViewPaginationLinkS1"> <img src="'.$image_path.'start.gif" width="11" height="9" alt="Next"  border="0" align="absmiddle">&nbsp; Start</a>';
            	} else {
            		$paging .= '<img src="'.$image_path.'start_off.gif" width="11" height="9" alt="Next"  border="0" align="absmiddle">&nbsp; Start';
            	}
            			
        		$paging .= '&nbsp;&nbsp;';
        		
            	if ($offset > $limit) {
            		$paging .= '<a href="'.$prev_url.'" class="listViewPaginationLinkS1"> <img src="'.$image_path.'previous.gif" width="11" height="9" alt="End"  border="0" align="absmiddle">&nbsp; Previous</a>';
            	} else {
            		$paging .= '<img src="'.$image_path.'previous_off.gif" width="11" height="9" alt="End"  border="0" align="absmiddle">&nbsp; Previous';
        		}
            	
        		$paging .= '&nbsp;&nbsp;';
        		
        		$paging .= '<span class="pageNumbers">';
        		 
        		if ($total_rec>0)		 
        			$paging .= '( '.$offset.' - '.$end_rec.' of '.$total_rec.' )';
        		else 
        		 	$paging .= '( '.$offset.' - '.$end_rec.' of '.$total_rec.' )';
        		 
        		$paging .= '</span>';
        		$paging .= '&nbsp;&nbsp; ';
            	
            	if ($end_rec<$total_rec) {
            		$paging .= '<a href="'.$next_url.'" class="listViewPaginationLinkS1"> Next &nbsp;<img src="'.$image_path.'next.gif" width="11" height="9" alt="Next"  border="0" align="absmiddle"></a>';
            	} else {
            		$paging .= 'Next &nbsp;<img src="'.$image_path.'next_off.gif" width="11" height="9" alt="Next"  border="0" align="absmiddle">';
            	}
            	
        		$paging .='&nbsp;&nbsp; ';
        		
            	if ( $end_rec < $total_rec ) {
            		$paging .= '<a href="'.$last_url.'" class="listViewPaginationLinkS1"> End	&nbsp;<img src="'.$image_path.'end.gif" width="11" height="9" alt="End"  border="0" align="absmiddle"></a>';
            	} else {
            		$paging .= 'End	&nbsp;<img src="'.$image_path.'end_off.gif" width="11" height="9" alt="End"  border="0" align="absmiddle">';
            	}
            	
        	$paging .='</td>';
        
        $paging .='</tr>';
        $paging .='</table>';
        
        
        return $paging;
    }
	
}
// END Pagination2 Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */