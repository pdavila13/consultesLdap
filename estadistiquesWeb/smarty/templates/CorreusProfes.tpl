<html>
<head>
<title>Correus de Professors</title>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>

<table border="1">
<tr>
<th>Codi</th>
<th>Professor</th>
<th>Correu electrònic</th> 
</tr>

{foreach from = $Correus item = correu}
    <tr>
    <td>{$correu->codi}</td>
	<td>{$correu->name}</td>
	<td><a href="mailto:{$correu->mail}" >{$correu->mail}</a></td>
     </tr>
{/foreach}

</table> 


</body>
</html>
