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
  # Error
}

$dn="cn=albertmestres,ou=groups,ou=Informàtica,ou=Alumnes,ou=All,ou=201011,dc=iesebre,dc=com";
$newrdn="cn=albertmestres";
$newparent="ou=201011,dc=iesebre,dc=com";

$result= ldap_rename ( $ds , $dn , $newrdn , $newparent , TRUE );

if ($result) {
	echo "OK\n";
} else {
	echo "ERROR\n";
}
 

?>
