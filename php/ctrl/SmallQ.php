<?php


define('DS', DIRECTORY_SEPARATOR);
define('__ROOT__', dirname(dirname(dirname(__FILE__))).DS); 

require_once(__ROOT__ . "local_config/config.php");
require_once(__ROOT__ . "php/inc/database.php");
require_once(__ROOT__ . "php/utilities/general.php");
require_once(__ROOT__ . 'local_config/lang/'.get_session_language() . '.php');


global $Text; 

try{
    validate_session(); // The user must be logged in.
    
    switch ($_REQUEST['oper']) {

	    case 'configMenu':
	        printXML(get_config_menu($_REQUEST['user_role']));
	        exit;
	        
	    case 'getFieldOptions':
	        echo get_field_options_live(get_param('table'), get_param('field1',''), get_param('field2',''), get_param('field3',''));
	        exit;
	
	        
	    case 'getRoles':
	        printXML(get_roles());
	        exit;
	
	    case 'getCommissions':
	        printXML(get_commissions());
	        exit;

		case 'getExistingLanguages':
	        printXML(existing_languages_XML());
	        exit;
	        
	    //returns a list of all active providers for shopping (only name and id). 
		case 'getActiveProviders':
			printXML(stored_query_XML_fields('get_all_active_providers'));
			exit;
			
		case 'getExistingThemes':
			printXML(get_existing_themes_XML());
			exit;

    default:
        throw new Exception('ctrlSmallQ.php: Operation ' . $_REQUEST['oper'] . ' not supported.');
    }
} 

catch(Exception $e) {
    header('HTTP/1.0 401 ' . $e->getMessage());
    die($e->getMessage());
}  
?>