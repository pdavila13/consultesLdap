<?php

#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/etc/paraulesdepas.php";


$ldapconfig['host'] = '192.168.0.8';
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = NULL;
$ldapconfig['basedn'] = 'dc=iesebre,dc=com';

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=$PASSWD;
$dn="cn=admin,dc=iesebre,dc=com";

$basedn="ou=All,dc=iesebre,dc=com";

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct\n");
} else {
  # Error
}


$dnis=array();


function getDirectory( $path = '.', $level = 0 ) {

    $ignore = array( 'cgi-bin', '.', '..' );
    
    // Directories to ignore when listing output. Many hosts
    // will deny PHP access to the cgi-bin.

    $dh = @opendir( $path );
    // Open the directory to the handle $dh
    
    while( false !== ( $file = readdir( $dh ) ) ){
    // Loop through the directory
    
        if( !in_array( $file, $ignore ) ){
        // Check that this file is not to be ignored
            
            str_repeat( ' ', ( $level * 4 ) );
            // Just to add spacing to the list, to better
            // show the directory tree.
            
            if( is_dir( "$path/$file" ) ){
            // Its a directory, so we need to keep reading down...
            
                echo "$path/$file;";
                getDirectory( "$path/$file", ($level+1) );
                // Re-call this same function but on a new directory.
                // this is what makes function recursive.
            
            } else {
                echo "$path/$file;";
                // Just print out the filename
            
            }
        
        }
    
    }
    
    closedir( $dh );
    // Close the directory handle

}

ob_start();
getDirectory( "/home/sergi/prova/TIC2011-12" );

$files = ob_get_contents();
ob_end_clean();

//echo $files."\n\n\n\n\n\n";

$files_a=split(";",$files);
$files_a_filtered = preg_grep("/^.*\.(png)$/i", $files_a);

//DEBUG
//print_r($files_a);
//print_r($fl_array);
/*
foreach ($files_a_filtered as $filea) {
	echo $filea."\n";
}
exit;
* */

foreach ($files_a_filtered as $file) {
    echo $file."\n";
    //echo basename($file,".png")."\n";
    
    
    //Search Ldap object with this DNI
    echo "Searching DNI: " . basename($file,".png") . "..."; 
    
    // Search surname entry 
    $filter="(irisPersonalUniqueID=".basename($file,".png").")";
    $sr=ldap_search($ds,$basedn, $filter);   
    
    $found=ldap_count_entries($ds,$sr); 
    
	switch ($found) {
		case 0:
			echo "DNI NOT FOUND! $file\n";
			break;
		case 1:
			//Comprovar si existeix el camp jpegPhoto
			$info = ldap_get_entries($ds, $sr); 
			//echo "Data for ".$info["count"]." items returned:<p>"; 
			echo "dn is: ". $info[0]["dn"] . " "; 
			//echo "array: ". print_r($info[0]) ."\n"; 
			if (in_array("jpegphoto", $info[0])) {
				echo "PHOTO OK!\n";
			} else {
				echo "PHOTO NOT FOUND!\n";
			}
				
			/*
			for ($i=0; $i<$info["count"]; $i++  ) { 
				echo "dn is: ". $info[$i]["dn"] ."\n"; 
				echo "i:"+$i."\n";
			} *
			*/
			break;
		default:
			echo "MULTIPLE RESULTS FOUND! $file\n";
			break;
	}


/*
    echo "Getting entries ...<p>"; 
    $info = ldap_get_entries($ds, $sr); 
    echo "Data for ".$info["count"]." items returned:<p>"; 

    for ($i=0; $i<$info["count"]; $i++  ) { 
        echo "dn is: ". $info[$i]["dn"] ."\n"; 
        echo "i:"+$i."\n";
    } 
*/
}


echo "Closing connection"; 
ldap_close($ds); 


?> 
