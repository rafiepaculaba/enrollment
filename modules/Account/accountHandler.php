<?php
if (!$_SESSION){
    session_start();
}

// ajax action
$action = $_GET['action'];

if ( strtoupper($action)=='GETTERMS' ) {
    require_once('../../commonAjax.php');
    require_once('../Config/ConfigCol.php');  
    
    // get all default setting from configs
    $config = new Config();
    
    // get parameters
    $semCode = $_GET['semCode'];

    // get the default school year
    $total_terms = 0;
	if ($semCode<4) {
	    if ($semCode) {
            $total_terms = $config->getConfig('Semestral Terms');
	    }
	} else {
	    if ($semCode) {
	       $total_terms = $config->getConfig('Summer Terms');
	    }
	}
	
    echo $total_terms;
}