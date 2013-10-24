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

//Search al Unix Accounts
$filter="(ObjectClass=posixaccount)";
$sr=ldap_search($ds,$basedn, $filter);   

$totalUsers=ldap_count_entries($ds,$sr); 

echo "Total Users:".$totalUsers."\n";

$info = ldap_get_entries($ds, $sr); 
echo "Data for ".$info["count"]." items returned:<p>"; 

$dns= array();
$gidnumbers= array();

for ($i=0; $i<$info["count"]; $i++  ) { 
	/*echo "dn is: ". $info[$i]["dn"] ."\n"; 
	echo "gidnumber: ". $info[$i]["gidnumber"][0] ."\n"; 
    echo "i:"+$i."\n";
    */
    $dns[]=$info[$i]["dn"];
    $gidnumbers[]=$info[$i]["gidnumber"][0];
} 

$counter=0;
foreach ($gidnumbers as $gidnumber) {
	echo "***********************************************\n";
	echo "Searching gidnumber $gidnumber...";
    echo " dn: ". $dns[$counter] . " ";
    
	if ($gidnumber<1000){
		echo "Skipping special accounts (sambaMachineAccounts, privileges users...)\n";
		$counter++;
		continue;
	}
    
    $filter1="(&(objectclass=posixgroup)(gidnumber=".$gidnumber."))";
    //echo "filter1: $filter1\n";
	$sr=ldap_search($ds,$basedn1, $filter1);   
	
	$found=ldap_count_entries($ds,$sr); 
	
	$info = ldap_get_entries($ds, $sr);
    
	switch ($found) {
		case 0:
			echo "GIDNUMBER NOT FOUND! \n";
			break;
		case 1:
			echo "GIDNUMBER FOUND! \n";
			
			//Comparar els DN sense ou=people ni ou=group
			echo "Group dn : ". $info[0]["dn"] ."\n"; 
			echo "User dn : ". $dns[$counter] ."\n"; 

			if (substr_count($info[0]["dn"], 'ou=group')!=1) {
				echo "ALERT: Group outside ou=group -> " . $info[0]["dn"] . " ";
				continue;
			}
			
			if (substr_count($dns[$counter], 'ou=people')!=1) {
				echo "ALERT: User outside ou=people -> $dns[$counter] ";
				continue;
			}

			
			$arraygroubBaseDN=explode(",ou=groups,",$info[0]["dn"]);
			$arrayuserBaseDN=explode(",ou=people,",$dns[$counter]);
			
			$groubBaseDN=$arraygroubBaseDN[1];
			$userBaseDN=$arrayuserBaseDN[1];
			
			echo "Group dn base: ". $groubBaseDN . "\n"; 
			echo "User dn base: ". $userBaseDN . "\n";
			
			if ($groubBaseDN===$userBaseDN) {
				echo "GIDNUMBER OK! \n";
			} else {
				echo "GIDNUMBER NOT OK! \n";
				//Move group object to correct folder
				//Does ou=groups exists in correct folder?
				
				//echo "----------------\n";
				//echo "Search base: ". $userBaseDN . "\n"; 
				$sr1=ldap_list($ds,$userBaseDN, "ou=groups"); 
				$found1=ldap_count_entries($ds,$sr1); 
				echo "trobats: $found1\n";
				if ( $found1 != 1 ) {
					echo "ou=groups,$userBaseDN not found...";
					//Create ou=groups
					$data['ou'] = "groups";
					$data['objectClass'][0] = "top";
					$data['objectClass'][1] = "organizationalUnit";
					
					echo "prova: ou=groups,".$userBaseDN ."\n";
					$addresult = ldap_add($ds, "ou=groups,".$userBaseDN, $data);
					
					/*
					$info['ou'] = "groups";
					$info['objectClass'][0] = "top";
					$info['objectClass'][1] = "organizationalUnit";
					//							ou=groups,ou=Grup A,ou=Curs 1,ou=Sistemes microinformàtics i xarxes,ou=Informàtica,ou=Alumnes,ou=All,dc=iesebre,dc=com
					//$addresult = ldap_add($ds, "ou=groups,ou=Grup A,ou=Curs 1,ou=Sistemes microinformàtics i xarxes,ou=Informàtica,ou=Alumnes,ou=All,dc=iesebre,dc=com", $info);
					*/
					if ($addresult) {
						echo "ou=groups added correctly\n";
					} else {
						echo "error adding ou=groups: ".ldap_error($ds)."\n";
						
					}
					
				}	else {
					//Move object
					echo "newrdn: ". $groubBaseDN=$arraygroubBaseDN[0] . "\n";
					echo "source: ". $info[0]["dn"] . "\n";
					echo "basedestination: ". "ou=groups,".$userBaseDN . "\n";
					echo "rdndestination: ". $groubBaseDN=$arraygroubBaseDN[0] . "\n";
					$result= ldap_rename ( $ds , $info[0]["dn"] , $groubBaseDN=$arraygroubBaseDN[0] , "ou=groups,".$userBaseDN , TRUE );
					if ($result) {
						echo "GROUP MOVED OK\n";
					} else {
						echo "ERROR MOVING OBJECT:".ldap_error($ds)."\n";
						
					}
				}
			}
			echo "**********************************************\n\n";
			break;
		default:
			echo "MULTIPLE RESULTS FOUND! \n";
			break;
	}
    
    $counter++;
}





echo "Closing connection"; 
ldap_close($ds); 

?>
