<html>
<head>
<title>Estadistiques de Grups</title>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
</head>
<body>

<table border="1">
<tr>
<th>Grup</th>
<th>Homes</th>
<th>Dones</th>   
<th>Total</th>   
</tr>

{foreach from = $grupos item = grupo}
    <tr>
     <td>{$grupo->name}</td>
     <td>{$grupo->nMales}</td>
     <td>{$grupo->nFemales}</td>
     <td>{$grupo->total}</td>
    </tr>   
{/foreach}

</table> 


</body>
</html>
