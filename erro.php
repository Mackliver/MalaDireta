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
		
		default;
		$erro = "Um erro inesperado parou o sistema!";
		break;
	}
}
?>