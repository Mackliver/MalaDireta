<?php
  class ProcessaArquivo{
  
      private $dados;
      private $boletos;
            
      function __construct($arquivo) {
        $this->dados = file_get_contents($arquivo);
        $this->boletos = $this->processar($this->dados);
      }
      
      private function processar($dados){
          $aDados = explode("\n", $dados);
          for($i=0;$i<sizeof($aDados);$i++){
            $temp[$i] = explode(";",$aDados[$i]);            
            $aBoleto[$i]['titular']         = $temp[$i][0];
            $aBoleto[$i]['cep']             = str_ireplace("-","",$temp[$i][1]);
            $aBoleto[$i]['tipologradouro']  = $temp[$i][2];
            $aBoleto[$i]['logradouro']      = $temp[$i][3];
            $aBoleto[$i]['numero']          = $temp[$i][4];
            $aBoleto[$i]['complemento']     = $temp[$i][5];			
            $aBoleto[$i]['bairro']          = $temp[$i][6];
            $aBoleto[$i]['cidade']          = $temp[$i][7];
            $aBoleto[$i]['uf']       		= $temp[$i][8];	
          }          
          return $aBoleto;
      }
            
      function getBoletos(){          
          return $this->boletos;
      }
  
  }
?>