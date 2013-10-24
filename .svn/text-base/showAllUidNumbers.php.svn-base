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

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct\n");
} else {
  # Error
  echo("Login incorrect\n");
}

// Search all users
$sr=ldap_search($ds,"ou=All,dc=iesebre,dc=com", "(uidnumber=*)");   
echo "Search result is ".$sr."<p>"; 
echo "Number of entries returned is ".ldap_count_entries($ds,$sr)."<p>"; 

echo "Getting entries ...<p>"; 
$info = ldap_get_entries($ds, $sr); 
echo "Data for ".$info["count"]." items returned:<p>"; 

$uidnumbers=array();
for ($i=0; $i<$info["count"]; $i++  ) { 
	//echo "i:" + $i . " dn is: ". $info[$i]["dn"] ."\n"; 
	//echo "uidnumber: ". $info[$i]["uidnumber"][0] ."\n"; 
	$uidnumbers[]=$info[$i]["uidnumber"][0];
} 

sort($uidnumbers);
$uniqueuidnumbers = array_unique ($uidnumbers);
foreach ($uniqueuidnumbers as $key => $val) {
    echo "uniqueuidnumbers[" . $key . "] = " . $val . "\n";
}

echo "Closing connection\n"; 
ldap_close($ds); 

?>
