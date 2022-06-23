<?php

namespace App\Db;

class Paginacao{
    private $limite;
    private $resultadosTotais;
    private $paginaAtual;
    private $quantPaginas;

    public function __construct($resultadosTotais,$paginaAtual = 1,$limite=10)
    {
        $this->resultadosTotais = $resultadosTotais;
        $this->limite = $limite;
        $this->paginaAtual = (is_numeric($paginaAtual) and $paginaAtual > 0) ? $paginaAtual : 1;
        $this->calculo();
    }

    private function calculo(){
        $this->quantPaginas = $this->resultadosTotais > 0 ? ceil($this->resultadosTotais / $this->limite) : 1;
        $this->paginaAtual = $this->paginaAtual <= $this->quantPaginas ? $this->paginaAtual : $this->quantPaginas;    
    }

    public function getLimite(){
        $offset = ($this->limite * ($this->paginaAtual - 1));
        return $offset.','.$this->limite;
    }

    public function getPagina(){
        if($this->quantPaginas == 1) return [];

        $paginas = [];

        for($i=1;$i<=$this->quantPaginas;$i++){
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->paginaAtual
            ];
        }

        return $paginas;
    }
}