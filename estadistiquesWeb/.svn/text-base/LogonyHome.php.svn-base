<?php 

include "/etc/DatosLocales.php";

class data{
  var $name;
  var $dlogon;
  var $dhome;
  var $dcolor;
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
$basedn="ou=All,dc=iesebre,dc=com";

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

$sr=ldap_search($ldapconn, $basedn , "(objectClass=posixaccount)", array("cn","sambaLogonScript","homeDirectory"));

$info = ldap_get_entries($ldapconn, $sr);
$info2 = ldap_get_entries($ldapconn, $sr);

echo $info["count"]." usuarios\n";

$Dades= array();

for ($i=0; $i<$info["count"]; $i++  ) { 
	if ((substr($info[$i]["cn"][0],-1)) == "$") {
	} else {
		$data= new data();
		//echo $info[$i]["cn"][0] . "\n";
		$data->name=$info[$i]["cn"][0];
		//echo $info[$i]["homedirectory"][0] . "\n";
		$data->dhome=$info[$i]["homedirectory"][0];
		if ($info[$i]["homedirectory"][0]=="/home/alumnenou"){
			$data->dcolor="red";
		} else {
			$data->dcolor="black";
		}
		if (isset( $info[$i]["sambalogonscript"][0])) {
			$logon=$info[$i]["sambalogonscript"][0];
			//echo $logon . "\n";
			$data->dlogon=$logon;
		} else {
			//echo "Sin Logon \n";	
			$data->dlogon="Buit";
		}
	$Dades[]=$data;
	}
}

$smarty->assign('Datos',$Dades);
$smarty->display('LogonyHome.tpl');	
?>
