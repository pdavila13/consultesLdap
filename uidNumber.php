<?php

//NOTA: Instal·leu el paquet apt-get install php5-ldap!!!

#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/etc/paraulesdepas.php";


$ldapconfig['host'] = 'localhost';
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = NULL;
$ldapconfig['basedn'] = 'ou=Sistemes,ou=All,dc=iesebre,dc=com';

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=$PASSWD;
$dn="cn=admin,dc=iesebre,dc=com";

$basedn=$ldapconfig['basedn'];

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct\n");
} else {
  # Error
}

$sr=ldap_search($ds, $basedn , "(&(objectClass=posixaccount))", array("uidNumber","gidNumber"));

$info = ldap_get_entries($ds, $sr);

echo $info["count"]." equipos\n\n";

$ContadorTotal=0;

//codigo que encuentra equipos
for ($i=0,$j=60000; $i<$info["count"]; $i++,$j++) { 
	$dn = $info[$i]["dn"];
	$uidNumber = $info[$i]["uidnumber"][0];
	$gidNumber = $info[$i]["gidnumber"][0];

	echo " Adding uidNumber (" . $j . ") to machine " . $uidNumber . " DN: " . $dn . ".\n";

	$entry=array();
	$entry["uidnumber"][0]=$j;

	$result = ldap_modify ($ds, $dn, $entry);

	if ($result) {
		echo "OK\n";
	} else {
		echo "LDAP ERROR: ". ldap_error($ds) ."\n";
	}		

}
 
ldap_close($ds);

?>