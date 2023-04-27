<?php

define('DS', DIRECTORY_SEPARATOR);
define('__ROOT__', dirname(dirname(dirname(__FILE__))).DS); 

require_once(__ROOT__ . "local_config/config.php");
require_once(__ROOT__ . "php/inc/database.php");
require_once(__ROOT__ . "php/utilities/general.php");
require_once(__ROOT__ . "php/utilities/incidents.php");

try{
    if (get_param('oper') === 'getIncidentsListing' && 
        get_param('type', 1) == 3 // Incident sent to portal (used in login.php)
    ) {
        echo get_incidents_in_range(get_param('filter', 'prev2Month'), get_param('fromDate',0), get_param('toDate',0), get_param('type',1) );
	    exit; 
    }

    validate_session(); // For all other requests, the user must be logged in
    
    switch (get_param('oper')) {
    	    	
    	 case 'getIncidentTypes':
	        printXML(stored_query_XML_fields('get_incident_types'));
	        exit;        

	    //if incident_id > 0 edit, otherwise create new
	    case 'mngIncident':
	       	echo manage_incident(get_param('incident_id',0));
	        exit;
				
	    case 'delIncident':
	        echo do_stored_query('delete_incident', get_param('incident_id'));
	        //echo 1;
	        exit;

	    case 'getIncidentsListing':
	        echo get_incidents_in_range(get_param('filter', 'prev2Month'), get_param('fromDate',0), get_param('toDate',0), get_param('type',1) );
	    	exit; 
	    	
	    case 'getIncidentsById':
	    	printXML(stored_query_XML_fields('get_incidents_by_ids', get_param('idlist'), get_param('type',0)));	
	    	exit;

	    	
	    default:  
	    	 throw new Exception("ctrlIncidents: oper={$_REQUEST['oper']} not supported");  
	        break;
    }


} 

catch(Exception $e) {
    header('HTTP/1.0 401 ' . $e->getMessage());
    die ($e->getMessage());
}  


?>