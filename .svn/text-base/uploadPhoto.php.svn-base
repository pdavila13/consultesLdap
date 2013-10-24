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

$USERDN="cn=Tur AsAdmin Sergi,ou=people,ou=maninfo,ou=Personal,ou=All,dc=iesebre,dc=com";

$attrs=array();

if(class_exists('Imagick')){

	$im = new Imagick('/home/sergi/Escriptori/SergiTurGosa.jpeg');
	$im->setImageOpacity(1.0);
	//$im->resizeImage(147,200,Imagick::FILTER_UNDEFINED,0.5,TRUE);
	//$im->setCompressionQuality(90);
	$im->setImageFormat('jpeg'); 
	$attrs['jpegphoto']=$im->getImageBlob();

} else {
	echo "ERROR!";
}
$ret1=ldap_mod_add($ds,$USERDN,$attrs);	
	
if (!$ret1) {
	echo "Error at ldap_mod_add: $ret1\n";
}

?>
