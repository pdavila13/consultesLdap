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
$basedn1="dc=iesebre,dc=com";

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct\n");
} else {
  echo("Login incorrect\n");
  # Error
}

//Search al Unix Accounts
$filter="(physicalDeliveryOfficeName=*)";
$sr=ldap_search($ds,$basedn, $filter);   

$totalGroups=ldap_count_entries($ds,$sr); 

echo "Grups totals:".$totalGroups."\n";

$info = ldap_get_entries($ds, $sr); 
echo "Data for ".$info["count"]." items returned:<p>"; 

for ($i=0; $i<$info["count"]; $i++  ) { 
	echo "i: "+$i . "|". $info[$i]["physicaldeliveryofficename"][0] ."|". $info[$i]["dn"] ."\n"; 
} 

$schoolTotalUsers=0;
$schoolTotalGroups=0;
//Users
for ($i=0; $i<$info["count"]; $i++  ) { 
	echo "i: "+$i . "|". $info[$i]["physicaldeliveryofficename"][0] ."|". $info[$i]["dn"] ; 
	
	$filter1="(objectclass=posixAccount)";
    //echo "filter1: $filter1\n";
	$sr1=ldap_search($ds,$info[$i]["dn"] , $filter1);   
	
	$totalUsers=ldap_count_entries($ds,$sr1); 
	
	echo "|".$totalUsers;
	
	$filter2="(objectclass=posixGroup)";
    //echo "filter1: $filter1\n";
	$sr2=ldap_search($ds,$info[$i]["dn"] , $filter2);   
	
	$totalGroups=ldap_count_entries($ds,$sr2); 
	
	echo "|".$totalGroups."\n";
	
	$schoolTotalUsers=$schoolTotalUsers+$totalUsers;
	$schoolTotalGroups=$schoolTotalGroups+$totalGroups;
	
	/*	
	$info = ldap_get_entries($ds, $sr);
	* */
} 

echo "\n\nTOTAL USERS: ".$schoolTotalUsers ."\n";
echo "TOTAL GROUPS: ". $schoolTotalGroups ."\n";


?>
