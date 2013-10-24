<?php 

include "/etc/DatosLocales.php";

class mails{
  var $name;
  var $mail;
  var $codi;
}

require('/usr/share/php/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'smarty/templates';
$smarty->compile_dir = 'smarty/templates_c';
$smarty->cache_dir = 'smarty/cache';
$smarty->config_dir = 'smarty/configs';

//Conectar a LDAP

// LDAP variables
$ldaphost = $HOST;  // your ldap servers
$ldapport = $PORT;  // your ldap server's port number
$basedn="ou=Profes,ou=All,dc=iesebre,dc=com";

// Connecting to LDAP
$ldapconn = ldap_connect($ldaphost, $ldapport)
          or die("Could not connect to $ldaphost");
          
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); // Para usar el protocolo 3 de LDAP

        
if ( $ldapconn ) {
	//echo "Conectado!\n";
	// binding to ldap server
	$ldaprdn=$DN;
	$ldappass=$PASS;
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) {
        //echo "Bindado!\n";
    } else {
        echo "Error en Bindado!\n";
    }
}

$sr=ldap_search($ldapconn, $basedn , "(objectClass=posixaccount)", array("sn","email","givenName","employeeNumber"));

ldap_sort ( $ldapconn , $sr , "sn");

$info = ldap_get_entries($ldapconn, $sr);

//echo $info["count"]." professors\n";

$Correos= array();

for ($i=0; $i<$info["count"]; $i++  ) {
	if ($info[$i]["email"][0] == "%uid@iesebre.com") {
	} else { 
		$mails= new mails();
		//echo $info[$i]["cn"][0] . "\n";
		$mails->name=$info[$i]["sn"][0] . ", " . $info[$i]["givenname"][0];
		$mails->codi=$info[$i]["employeenumber"][0];
		//echo $info[$i]["homedirectory"][0] . "\n";
		$mails->mail=$info[$i]["email"][0];
	$Correos[]=$mails;
	}
}

$smarty->assign('Correus',$Correos);
$smarty->display('CorreusProfes.tpl');	
?>
