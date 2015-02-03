<?php
#IMPORTANT: no poseu les paraules de pas a aquest fitxer:
include "/etc/paraulesdepas.php";


$ldapconfig['host'] = 'localhost';
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

$info['ou'] = "groups";
$info['objectclass'][0] = "top";
$info['objectclass'][1] = "organizationalUnit";

$addresult = ldap_add($ds, "ou=groups,ou=Grup A,ou=Curs 1,ou=Sistemes microinformàtics i xarxes,ou=Informàtica,ou=Alumnes,ou=All,dc=iesebre,dc=com", $info);

if ($addresult) {
	echo "OK\n";
} else {
	echo "LDAP ERROR: ". ldap_error($ds) ."\n";
}
 

?>
