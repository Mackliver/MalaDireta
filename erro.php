<?php
if(isset($_GET['erro'])){
	
	$valor = $_GET['erro'];
	
	switch($valor){
		case 1;
		$erro = "Erro: Sem arquivos selecionados.";
		break;
		
		case 2;
		$erro = "Erro: Um ou mais campos est�o vazios.";
		break;
		
		case 3;
		$erro = "Base de importa��o s� permite arquivos CSV ou TXT.";
		break;
		
		case 4;
		$erro = "Anexo da carta s� permite arquivos JPG ou PNG.";
		break;
		
		case 5;
		$erro = "Erro no Upload, verifique o caminho de destinho.";
		break;
		
		case 6;
		$erro = "Erro Fatal: N�o foi possivel criar o PDF, chame o administrador do sistema";
		break;
		
		default;
		$erro = "Um erro inesperado parou o sistema!";
		break;
	}
}
?>