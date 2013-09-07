<!doctype html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Sistema de Mala Direta - CASF</title>
<link rel="stylesheet" href="css/estilo.css" type="text/css" />
</head>

<body>
<div id="margin">
	<header>
    	<h2 class="titulo">Caixa de Assistência dos Funcionários do Banco da Amazônia<br>Sistema de Mala Direta</h2>
    </header>
    <div class="wrapper1">
<?php
//setlocale(LC_ALL, "pt_BR","BR");
//ini_set( 'default_charset', 'UFT-8');
ini_set('max_execution_time', 600);

include('processa_arquivo.php');
include_once('pdf.php');


if(isset($_POST['enviar'])){
//Arquivo Base para Importação.
$BaseNome	= $_FILES['base']['name'];
$BaseTmp	= $_FILES['base']['tmp_name'];
$BaseSize	= $_FILES['base']['size'];

//Anexo para carta.
$AnexoNome	= $_FILES['anexo']['name'];
$AnexoTmp	= $_FILES['anexo']['tmp_name'];
$AnexoSize	= $_FILES['anexo']['size'];

//Processa o arquivo base de importação
$ExtBase = explode('.',$BaseNome);
$ExtBase = end($ExtBase);
		
//Processa o anexo da carta
$ExtAnexo = explode('.',$AnexoNome);
$ExtAnexo = end($ExtAnexo);
//$extensaoFim = array_pop($extensaoInicio);



//verifica se os arquivos estão vazios caso esteja retorna um erro.
if($BaseNome == '' and $AnexoNome == ''){
	header('Location: index.php?erro=1');
	break;
}
if($BaseNome == '' xor $AnexoNome == ''){
	header('Location: index.php?erro=2');
	break;
}
//verifica se os arquivos tem a extensão correta caso não retorna um erro.
//if($ExtBase != 'csv' and $ExtAnexo != 'pdf'){
//	header('Location: index.php?erro=Erro: Verifique as extensões dos arquivos.');
//	break;
//}



//Pastas de destino
$PatchAquivoBase  = "arquivo_base/";
$PatchAquivoAnexo = "arquivo_anexo/";

//Move os arquivos para as pastas de destino
$UpBase = move_uploaded_file($BaseTmp, $PatchAquivoBase.$BaseNome);
$UpAnexo = move_uploaded_file($AnexoTmp, $PatchAquivoAnexo.$AnexoNome);

//Verifica se os arquivos foram enviados.
if($_FILES['base']['error'] xor $_FILES['anexo']['error']){
	header('Location: index.php?erro=Erro: Erro no UPLOAD, tente de novo.');
	break;
}



/*

 Começa a Montar o PDF

*/

$path = getcwd();
$arquivo = $PatchAquivoBase.$BaseNome;
$img     = $PatchAquivoAnexo.$AnexoNome;

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
    //$cont++;
}

$path .= '/cartas/';
$arquivo = $assunto. date('dmY-hi')  .'.pdf';
$pdf->Output($path . $arquivo,"F");

echo "Arquivo PDF criado com sucesso contendo $total cartas, ";
echo "<a href=cartas/".$arquivo." target="."_blank"." >".$arquivo."</a><br><br>";
echo "<input type="."button"." value=\" Voltar \" onClick=\"location.href='index.php'\" class=\"botaoEnviar\"/>";

$pdf->closeParsers();


}else{
	header('Location: index.php?erro=3.');
}
?>
</div>
</div>
</body>
</html>