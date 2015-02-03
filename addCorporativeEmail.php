<?php

//NOTA: Instal·leu el paquet apt-get install php5-ldap!!!

#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/etc/paraulesdepas.php";


$ldapconfig['host'] = 'localhost';
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = NULL;
$ldapconfig['basedn'] = 'ou=Alumnes,ou=All,dc=iesebre,dc=com';

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

$sr=ldap_search($ds, $basedn , "(&(objectClass=posixaccount))", array("cn","uid"));

$info = ldap_get_entries($ds, $sr);

echo $info["count"]." alumnes\n\n";

$ContadorTotal=0;

for ($i=0; $i<$info["count"]; $i++  ) { 
	//echo $info[$i]["dn"] ."\n";
	$dn = $info[$i]["dn"];
	$uid = $info[$i]["uid"][0];
	$corporativeEmail = $uid . "@iesebre.com";
	echo " Adding corporative email ( " . $corporativeEmail . " ) attribute ( mail) to user " . $uid . " DN: " . $dn . "...\n";

	$entry=array();
	$entry["mail"][0]=$corporativeEmail;

	$result = ldap_modify ( $ds , $dn , $entry);

	if ($result) {
		echo "OK\n";
	} else {
		echo "LDAP ERROR: ". ldap_error($ds) ."\n";
	}
}
 
ldap_close($ds);

?>
