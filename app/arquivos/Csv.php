<?php 

namespace App\arquivos;

use App\Db\Database;

class Csv{

    /**
     * Método para fazer a leitura do arquivo CSV
     * @param string $arquivo
     * @param boolean $cabecalho
     * @param string $delimitador
     * @return array
     */
    public static function lerArquivoCsv($arquivo,$cabecalho = true, $delimitador = ','){
        //Validação da existencia do arquivo
        if (!file_exists($arquivo)) {
            die("Arquivo não existe");
        }

        //Dados do arquivo
        $dados = [];

        //Abrindo o arquivo CSV
        $csv = fopen($arquivo,'r');

        //Verifica cabeçalho
        $cabecalhoDados = $cabecalho ? fgetcsv($csv,0,$delimitador) : [];

        while ($linha = fgetcsv($csv,0,$delimitador)) {
            $dados [] = $cabecalho ? array_combine($cabecalhoDados,$linha) : $linha;
        }

        return $dados;

    }
}
?>