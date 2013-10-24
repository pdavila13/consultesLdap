<html>
<head>
<title>Dades usuaris</title>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>

<table border="1">
<tr>
<th>Usuari</th>
<th>Logon</th>
<th>Home</th>   
</tr>

{foreach from = $Datos item = dada}
    <tr>
{if $dada->dcolor eq "red"}
	<td><font color="red">{$dada->name}</td>
     <td><font color="red">{$dada->dlogon}</td>
     <td><font color="red">{$dada->dhome}</td>
{else}
	<td>{$dada->name}</td>
     <td>{$dada->dlogon}</td>
     <td>{$dada->dhome}</td>
{/if}
     </tr>
{/foreach}

</table> 


</body>
</html>
