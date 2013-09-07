<?php
include_once('pdfb/pdfb.php');

class PDF extends PDFB {
	var $headerData = null;
	var $footerData = null;
	var $reciboSacado = null;

	function __construct($orientation='P', $unit='mm', $format='A4') {
        setlocale(LC_ALL,'pt_BR','BR');
		$this->set($orientation, $unit, $format);
	}

	function set($orientation='P', $unit='mm', $format='A4') {
		parent::PDFB($orientation, $unit, $format);
	}
    
 
     function cobranca($pdf, $cuidados, $caminho){    
		$pdf->Image($caminho, 12, 0,186,297);
    }   

   
    function versoMalaDireta($pdf, $oBoleto) {
		$pdf->Image("img/verso_boleto.jpg", 12, 0,186,297);
		$pdf->SetFont("Helvetica", "B", 10);
		$pdf->Text(20,6,'Observações');
		
		
		if(isset($obs)){
			
			$contaObs = count($obs);
			
			
			$pdf->SetFont("Helvetica", "", 10);
			$pdf->Text(22,20,".");
			$pdf->Text(23,25,".");
		}
		
		
		
		$yTopo = 116;
		$xTopo = 65;
		$pdf->SetFont("Helvetica", "B", 10);
		$pdf->Text($xTopo,$yTopo,'CAIXA DE ASSISTÊNCIA DOS FUNCIONÁRIOS');
		$pdf->Text($xTopo,$yTopo+6,'DO BANCO DA AMAZÔNIA - CASF');
		//$pdf->Text($xTopo,$yTopo+12,'AMAZÔNIA - CASF');
		
		$pdf->SetFont("Helvetica", "B", 20);
		$pdf->SetTextColor(255,255,255);
		$yBoletoBancario = 151.7;
		$xBoletoBancario = 130;
		$pdf->Text($xBoletoBancario,$yBoletoBancario,'COMUNICADO');
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont("Helvetica", "B", 10);
		$yText = 165;
		$x = 36;
		
		$pdf->Text($x,$yText,$oBoleto['titular']);
		
		$pdf->SetFont("Helvetica", "", 10);
			
		if(trim($oBoleto['tipologradouro']) == ''){			
            if(trim($oBoleto['complemento']) == ''){
                 if(trim($oBoleto['numero']) == ''){
                    $pdf->Text($x,$yText+4,trim($oBoleto['logradouro']));
                 }else{
                    $pdf->Text($x,$yText+4,trim($oBoleto['logradouro']) .', '. $oBoleto['numero']);
                 }
            }else{
                 if(trim($oBoleto['numero']) == ''){
                    $pdf->Text($x,$yText+4,trim($oBoleto['logradouro']) . ' - ' . $oBoleto['complemento']);
                 }else{
                    $pdf->Text($x,$yText+4,trim($oBoleto['logradouro']) . ','. $oBoleto['numero'] .' - ' . $oBoleto['complemento']);
                 }
            }
		} else {
            if(trim($oBoleto['complemento']) == ''){
                $pdf->Text($x,$yText+4,trim(trim($oBoleto['tipologradouro']) . ' ' .$oBoleto['logradouro']) . ', ' . $oBoleto['numero']);
            }else{
                $pdf->Text($x,$yText+4,trim(trim($oBoleto['tipologradouro']) . ' ' .$oBoleto['logradouro']) . ', ' . $oBoleto['numero'] . ' - ' . $oBoleto['complemento']);
            }
		}
		
        if(trim($oBoleto['bairro']) == ''){
            if(strlen(trim($oBoleto['cep'])) == 8) {
                $pdf->Text($x,$yText+8,substr($oBoleto['cep'],0,5) . '-' . substr($oBoleto['cep'],5,3). ' ' . $oBoleto['cidade'] . ' - ' . $oBoleto['uf']);
            } else {
                $pdf->Text($x,$yText+8,substr($oBoleto['cep'],0,5) . '-' . substr($oBoleto['cep'],6,3). ' ' . $oBoleto['cidade'] . ' - ' . $oBoleto['uf']);
            }
        }else{
            $pdf->Text($x,$yText+8,$oBoleto['bairro']);
            if(strlen(trim($oBoleto['cep'])) == 8) {
                $pdf->Text($x,$yText+12,substr($oBoleto['cep'],0,5) . '-' . substr($oBoleto['cep'],5,3). ' ' . $oBoleto['cidade'] . ' - ' . $oBoleto['uf']);
            } else {
                $pdf->Text($x,$yText+12,substr($oBoleto['cep'],0,5) . '-' . substr($oBoleto['cep'],6,3). ' ' . $oBoleto['cidade'] . ' - ' . $oBoleto['uf']);
            }
        }        
		
		$xRemetente = 15;
		$yRemetente = 220;
		$pdf->SetFont("Helvetica", "B", 10);
		$pdf->Text($xRemetente,$yRemetente,'REMETENTE:');
		$pdf->SetFont("Helvetica", "", 10);
		$pdf->Text($xRemetente,$yRemetente+5,'CAIXA DE ASSISTÊNCIA DOS FUNCIONÁRIOS');
		$pdf->Text($xRemetente,$yRemetente+10,'DO BANCO DA AMAZÔNIA');
		$pdf->Text($xRemetente,$yRemetente+15,"AV. GENTIL BITTENCOURT, 886");
		$pdf->Text($xRemetente,$yRemetente+20,"66040-000 BELEM-PA");
		
		
		$xCorreioColuna1 = 115;
		$yCorreio = 252.5; 
		
		$pdf->SetFont("Helvetica", "B", 8);
		$pdf->Text(137,245,'Para Uso do Correio');
		$pdf->SetFont("Helvetica", "", 7);
		$pdf->Text($xCorreioColuna1,$yCorreio+0.5,'MUDOU-SE');
		$pdf->Text($xCorreioColuna1,$yCorreio+5,'ENDEREÇO INSUFICIENTE');
		$pdf->Text($xCorreioColuna1,$yCorreio+9.5,'NÃO EXISTE Nº INDICADO');
		$pdf->Text($xCorreioColuna1,$yCorreio+13.5,'DESCONHECIDO');
		$pdf->Text($xCorreioColuna1,$yCorreio+17.5,'RECUSADO');
		
		$xCorreioColuna2 = 159;
		$pdf->Text($xCorreioColuna2,$yCorreio+0.5,'AUSENTE');
		$pdf->Text($xCorreioColuna2,$yCorreio+5,'FALECIDO');
		$pdf->Text($xCorreioColuna2,$yCorreio+9.5,'Nº NÃO PROCURADO');
		$pdf->Text($xCorreioColuna2,$yCorreio+13.5,'INF. ESCRITA PELO');
		$pdf->Text($xCorreioColuna2,$yCorreio+17.5,'PORTEIRO / SINDICO');
		
		$pdf->Text(128,$yCorreio+22,'REINTEGRADO AO SERVIÇO POSTAL EM:');
		
		$pdf->SetFont("Helvetica", "", 7);
		//$pdf->SetFont("Times", "B", 11.5);
		$pdf->Text(120,$yCorreio+38,'Data');
		$pdf->Text(160,$yCorreio+38,'Responsável');
	}
	
	private function pad($val, $start, $length) {
		if(strlen($val) == 4) {
			$left = $start + strlen(str_pad("", ($length + 2) - strlen(number_format($val, 2, ',', '.')), '0', STR_PAD_LEFT));
			return $left+0.5;
		} else if(strlen($val) == 5) {
			$left = $start + strlen(str_pad("", ($length + 2) - strlen(number_format($val, 2, ',', '.')), '0', STR_PAD_LEFT));
			return $left;
		} else if(strlen($val) == 6) {
			$left = $start + strlen(str_pad("", ($length + 1) - strlen(number_format($val, 2, ',', '.')), '0', STR_PAD_LEFT));
			return $left+0.5;
		} else if(strlen($val) == 7) {
			$left = $start + strlen(str_pad("", ($length+1) - strlen(number_format($val, 2, ',', '.')), '0', STR_PAD_LEFT));
			return $left;
		}  else if(strlen($val) == 8) {
			$left = $start + strlen(str_pad("", $length - strlen(number_format($val, 2, ',', '.')), '0', STR_PAD_LEFT));
			return $left;
		}

		return $start;
	}

	private function formataEndereco($endereco, $size) {
		$aEndereco = split(" ", $endereco);

		$aNovoEndereco = array();

		$texto = '';
		$cont = 0;
		$i = 0;

		foreach($aEndereco as $end) {
			if(strlen($texto. ' ' .$end) > $size) {
				$aNovoEndereco[$cont] = $texto;
				$texto = $end;
				$cont++;
			} else {
				$texto .= ' ' . $end;
			}
			$i++;
		}

		$aNovoEndereco[$cont] = $texto;

		return $aNovoEndereco;
	}
    private function getData(){        
        $diasemana = gmstrftime("%A", time());
        $dia = date('d');
        $mes = gmstrftime("%B", time());
        $ano = date('Y');       
        $diacorrente = "Belém(PA), " . $dia . " de " .ucfirst($mes). " de " .$ano. ".";
        return $diacorrente;
    }
}
?>