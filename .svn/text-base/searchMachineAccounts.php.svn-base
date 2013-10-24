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
$sr=ldap_search($ds,"ou=All,dc=iesebre,dc=com", "(gidNumber=515)");   
echo "Search result is ".$sr."<p>"; 
echo "Number of entries returned is ".ldap_count_entries($ds,$sr)."<p>"; 

echo "Getting entries ...<p>"; 
$info = ldap_get_entries($ds, $sr); 
echo "Data for ".$info["count"]." items returned:<p>"; 

$gidnumbers=array();
for ($i=0; $i<$info["count"]; $i++  ) { 
	echo "i:" + $i . " dn is: ". $info[$i]["dn"] . "gidnumber: ". $info[$i]["gidnumber"][0] ."\n"; 
	$gidnumbers[]=$info[$i]["gidnumber"][0];
} 

echo "Closing connection\n"; 
ldap_close($ds); 

?>
