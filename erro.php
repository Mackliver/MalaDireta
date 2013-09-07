<?php
if(isset($_GET['erro'])){
	
	$valor = $_GET['erro'];
	
	switch($valor){
		case 1;
		$erro = "Erro: Sem arquivos selecionados.";
		break;
		
		case 2;
		$erro = "Erro: Um ou mais campos estão vazios.";
		break;
		
		case 3;
		$erro = "Um grave erro ocorreu no processo, impossivél continuar.<br/>Contate o administrador do sistema.";
		break;
		
		case 4;
		$erro = "Erro 4";
		break;
		
		case 5;
		$erro = "Erro 5";
		break;
		
		default;
		$erro = "Um erro inesperado parou o sistema!";
		break;
	}
}
?>
