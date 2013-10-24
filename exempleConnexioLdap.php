<?php 

include "/etc/paraulesdepas.php";


#CONNEXIÓ LDAP

// LDAP variables
$ldaphost = "192.168.0.8";  // your ldap servers
$ldapport = 389;                // your ldap server's port number
$basedn="ou=All,dc=iesebre,dc=com";

// Connecting to LDAP
$ldapconn = ldap_connect($ldaphost, $ldapport)
          or die("Could not connect to $ldaphost");
          
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        
if ( $ldapconn ) {
	echo "Connexió correcta!\n";
	// binding to ldap server
	$ldaprdn="";
	$ldappass="";
    $ldapbind = ldap_bind($ldapconn);

    // verify binding
    if ($ldapbind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }
}

$sr=ldap_search($ldapconn, $basedn , "(employeeNumber=*)", array("employeenumber"));

ldap_sort ( $ldapconn , $sr , "employeenumber");

$info = ldap_get_entries($ldapconn, $sr);

//print_r($info);

echo $info["count"]." entries returned\n";

$gentuza=array();
for ($i=0; $i<$info["count"]; $i++  ) { 
	$employeeNumber=$info[$i]["employeenumber"][0];
	$dng=$info[$i]["dn"];
	//echo "i: $i | employeeNumber: " . $employeeNumber;
	//echo " dn: " . $info[$i]["dn"] . "\n";
	$gentuza[$employeeNumber]=$dng;
}

print_r($gentuza);


function cmpGentuza($a, $b)    {
    return strnatcmp($a["employeenumber"], $b["employeenumber"]);   
}
    
usort($gentuza, "cmpGentuza");

print_r($gentuza);

?>
