<?php
include('erro.php');
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="ISO-8859-1">
<meta name="author" content="Mackliver Roll" />
<meta name="robots" content="none" />
<meta name="robots" content="noindex,nofollow" />
<title>CASF - Sistema de Mala Direta</title>
<link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>

<body>
<div id="margin">
	<header>
    	<h2 class="titulo">Caixa de Assist�ncia dos Funcion�rios do Banco da Amaz�nia<br>Sistema de Mala Direta</h2>
    </header>
    <div class="wrapper">
    	<form action="validar.php" method="post" enctype="multipart/form-data" name="formEnvio" id="formEnvio">
        	<fieldset>
            <legend>Formul�rio</legend>
            <legend class="legendIn">Base de Importa��o: </legend><input type="file" name="base" id="base"/>
            <legend class="legendIn">Anexo da Carta: </legend><input type="file" name="anexo" id="anexo"/>
			<legend class="legendIn">Observa��es: </legend><textarea name="observacoes" rows="9" cols="75" placeholder=" Texto para Observa��es no verso da carta."></textarea>
  			<input type="submit" name="enviar" id="enviar" value=" Enviar " class="botaoEnviar" /><label id="erro" ><?php if(isset($_GET['erro'])){ echo $erro; } ?></label>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>