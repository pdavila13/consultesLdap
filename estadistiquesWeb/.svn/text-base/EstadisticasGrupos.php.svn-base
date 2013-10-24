<?php 

include "/etc/DatosLocales.php";

class Group{
  var $name;
  var $nMales;
  var $nFemales;
  var $total;
}



//Smarty configuration
// put full path to Smarty.class.php
require('/usr/share/php/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'smarty/templates';
$smarty->compile_dir = 'smarty/templates_c';
$smarty->cache_dir = 'smarty/cache';
$smarty->config_dir = 'smarty/configs';

//$smarty->assign('name', 'Ned');
//$smarty->display('index.tpl');


//Conectar a LDAP

// LDAP variables
$ldaphost = $HOST;  // your ldap servers
$ldapport = $PORT;  // your ldap server's port number
$basedn="ou=Alumnes,ou=All,dc=iesebre,dc=com";

// Connecting to LDAP
$ldapconn = ldap_connect($ldaphost, $ldapport)
          or die("Could not connect to $ldaphost");
          
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); // Para usar el protocolo 3 de LDAP

        
if ( $ldapconn ) {
//	echo "Conectado!\n";
	// binding to ldap server
	$ldaprdn=$DN;
	$ldappass=$PASS;
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) {
//        echo "Bindado!\n";
    } else {
        echo "Error en Bindado!\n";
    }
}

$sr=ldap_search($ldapconn, $basedn , "(physicalDeliveryOfficeName=*)", array("physicalDeliveryOfficeName"));

ldap_sort ( $ldapconn , $sr , "physicalDeliveryOfficeName");

$info = ldap_get_entries($ldapconn, $sr);

//echo $info["count"]." Grupos\n\n";

/*for ($i=0; $i<$info["count"]; $i++  ) { 
echo "Grupo: " . $info[$i]["physicaldeliveryofficename"][0] ."\n";
}*/

$ContadorTotal=0;

$groups= array();

for ($i=0; $i<$info["count"]; $i++  ) { 
	$group= new Group();
	//echo "Grupo: ". $info[$i]["physicaldeliveryofficename"][0] ." ( ". $info[$i]["dn"] ." )\n";
	
	$basedn2=$info[$i]["dn"];
	$sr2=ldap_search($ldapconn, $basedn2 , "(objectClass=posixaccount)", array("cn","gender"));
	$info2 = ldap_get_entries($ldapconn, $sr2);
	$Total=0;
	$Hombres=0;
	$Mujeres=0;
	for ($i2=0; $i2<$info2["count"]; $i2++  ) { 
		$Genero=$info2[$i2]["gender"][0];
		$Total++;
		$ContadorTotal++;
		//echo $info2[$i2]["dn"] ."\n";
		if ($Genero == "M") {
			$Hombres++;
		} else {
			$Mujeres++;
		}
	}
	//echo "Hombres: " . $Hombres ."\n";
	$group->name=$info[$i]["physicaldeliveryofficename"][0];
	$group->nMales=$Hombres;
	$group->nFemales=$Mujeres;
	$group->total=$Total;
	$groups[]=$group;
	//echo "Mujeres: " . $Mujeres ."\n";
	//echo "Alumnos en el grupo: " . $Total ."\n\n";
	
}

$smarty->assign('grupos',$groups);
$smarty->display('EstadisticasGrupos.tpl');

//echo "\nAlumnos Totales: " . $ContadorTotal ."\n";
//echo "Finalizado\n";
?>
