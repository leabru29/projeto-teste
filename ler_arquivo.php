<?php 

require __DIR__.'/vendor/autoload.php';

use \App\arquivos\Csv;
use \App\Db\Database;

$dadosCsv = Csv::lerArquivoCsv(__DIR__.'/csvs-importacao-original/dfp-cadastro_fabricantes.csv',true,',');

$bd = new Database('imagenet_fabricante');
foreach ($dadosCsv as $key => $value) {
    $dadosTabela = $bd->insert($value);
}


?>