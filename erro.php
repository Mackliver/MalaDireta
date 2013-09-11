<?php
if(isset($_GET['erro'])){
	
	$valor = $_GET['erro'];
	
	switch($valor){
		case 1;
		$erro = "Erro: Sem arquivos selecionados.";
		break;
		
		case 2;
		$erro = "Erro: Um ou mais campos estгo vazios.";
		break;
		
		case 3;
		$erro = "Base de importaзгo sу permite arquivos CSV ou TXT.";
		break;
		
		case 4;
		$erro = "Anexo da carta sу permite arquivos JPG ou PNG.";
		break;
		
		case 5;
		$erro = "Erro no Upload, verifique o caminho de destinho.";
		break;
		
		case 6;
		$erro = "Erro Fatal: Nгo foi possivel criar o PDF, chame o administrador do sistema";
		break;
		
		default;
		$erro = "Um erro inesperado parou o sistema!";
		break;
	}
}
?>