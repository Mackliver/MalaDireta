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
    	<h2 class="titulo">Caixa de Assistência dos Funcionários do Banco da Amazônia<br>Sistema de Mala Direta</h2>
    </header>
    <div class="wrapper1">
<?php
ini_set('memory_limit', '128M');
ini_set('max_execution_time', 100);

include('processa_arquivo.php');
include_once('pdf.php');


if(isset($_POST['enviar'])){
//Arquivo Base para Importação.
$baseNome	= $_FILES['base']['name'];
$baseTmp	= $_FILES['base']['tmp_name'];

//Anexo para carta.
$anexoNome	= $_FILES['anexo']['name'];
$anexoTmp	= $_FILES['anexo']['tmp_name'];

//Processa os arquivos para saber sua extensão
$exBase = pathinfo($baseNome, PATHINFO_EXTENSION);
$exAnexo = pathinfo($anexoNome, PATHINFO_EXTENSION);

//verifica se os arquivos estão vazios caso esteja retorna um erro.
if(empty($baseNome) and empty($anexoNome)){
	header('Location: index.php?erro=1');
	break;
}elseif(empty($baseNome) xor empty($anexoNome)){
	header('Location: index.php?erro=2');
	break;
}

//Verifica as extenções dos arquivos, caso não estaja correto retorna um erro.
if($exBase != "csv" and $exBase != "txt"){
	header('Location: index.php?erro=3');
	break;
}elseif($exAnexo != "jpg" and $exAnexo != "jpeg" and $exAnexo != "png"){
	header('Location: index.php?erro=4');
	break;
}

// Renomeia os arquivos
$novoNomeBase  = md5($baseNome).".".$exBase;
$novoNomeAnexo = md5($anexoNome).".".$exAnexo;


//Pastas de destino
$patchAquivoBase  = "arquivo_base/";
$patchAquivoAnexo = "arquivo_anexo/";

//Move os arquivos para as pastas de destino
$upBase = move_uploaded_file($baseTmp, $patchAquivoBase.$novoNomeBase);
$upAnexo = move_uploaded_file($anexoTmp, $patchAquivoAnexo.$novoNomeAnexo);

//Verifica se os arquivos foram enviados.
if((!$upBase) xor (!$upAnexo)){
	header('Location: index.php?erro=5');
	break;
}


/*
 Caso os arquvos passem pela válidação o sistema começa a Montar o PDF.
*/

$path = getcwd();
$arquivo = $patchAquivoBase.$novoNomeBase;
$img     = $patchAquivoAnexo.$novoNomeAnexo;


$oDados = new ProcessaArquivo($arquivo);        
$aBoletos = $oDados->getBoletos();

$pdf  = new PDF("P","mm","A4");
$pdf->Open();
$pdf->set('P', 'mm', 'A4');

$pdf->SetMargins(0.0, 0.0);
$pdf->SetFont("Helvetica", "", 9.5);
$pdf->SetAutoPageBreak(true);

$cont = 1;
$total = count($aBoletos);
foreach($aBoletos as $endereco) {    
    $pdf->AddPage('P');
    $pdf->cobranca($pdf, $destinatario, $img);
	
    $pdf->AddPage('P');
    $pdf->versoMalaDireta($pdf, $endereco);
	
		$pdf->SetFont("Helvetica", "", 10);
		if(!empty($_POST['observacoes'])){
			
			$observacoes = $_POST['observacoes'];
			$quebratexto = wordwrap($observacoes,100, "\n");
			$arr = explode("\n",$quebratexto);
			$xObs = 22;
			$yObs = 17;
			
			$pdf->Text(32,$yObs,trim(strip_tags($arr[0])));
			
			$yObs = 22;
			$contArr = count($arr);

			for($i = 1;$i <= $contArr;$i++){
				$pdf->Text($xObs,$yObs,trim(strip_tags($arr[$i])));
				$yObs = $yObs+5; 
					
			}
		}
		
    //$cont++;
}

$path .= '/cartas/';
$arquivo = $assunto. date('d-m-Y-Hi').'.pdf';
$pdf->Output($path . $arquivo,"F");

echo "Arquivo PDF criado com sucesso contendo $total cartas: ";
echo "Arquivo: "."<a href=cartas/".$arquivo." target="."_blank"." >".$arquivo."</a><br><br>";
echo "<input type="."button"." value=\" Voltar \" onClick=\"location.href='index.php'\" class=\"botaoEnviar\"/>";

$pdf->closeParsers();

}else{
	header('Location: index.php?erro=6');
}
?>
</div>
</div>
</body>
</html>