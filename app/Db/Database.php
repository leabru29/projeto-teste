<?php 

namespace App\Db;

use \PDO;
use \PDOException;

class Database{

	const HOST = 'localhost';
	const DB   = 'bd-zr-system';
	const USER = 'root';
	const PASS = '';

	private $tabela;

	private $conexao;

	public function __construct($tabela = null)
	{
		$this->tabela = $tabela;

		$this->setConexao(); 
	}

	private function setConexao()
	{
		try
		{
			$this->conexao = new PDO('mysql:host='.self::HOST.';dbname='.self::DB,self::USER,self::PASS);
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE,PDO_ERRMODE_EXCEPTION);

		}
		catch(PDOException $e)
		{
			die('Erro ao se conectar no banco de dados! '.$e->getMessage());
		}
	}

	public function execucao($query,$parametros = []){

		try{
			$statement = $this->conexao->prepare($query);
			$statement->execute($parametros);
			return $statement;
		}
		catch(PDOException $e)
		{
			die('Erro ao se conectar no banco de dados! '.$e->getMessage());
		}
	}

	public function insert($values){
		$colunas = array_keys($values);
		$valores = array_pad([], count($values), '?');
		$query = 'INSERT INTO '.$this->tabela.' ('.implode(',', $colunas).') VALUES ('.implode(',', $valores).')';
		$this->execucao($query,array_values($values));
		return true;
	}

	public function select($where,$order,$limit,$campos = '*'){

		$where = strlen($where) ? 'WHERE '.$where : '';
		$order = strlen($order) ? 'ORDER BY '.$order : '';
		$limit = strlen($limit) ? 'LIMIT '.$limit : '';

		$query = 'SELECT '.$campos.' FROM '.$this->tabela.' '.$where.' '.$order.' '.$limit;
		
		return $this->execucao($query);
	}

	public function update($id,$values){
		
		$colunas = array_keys($values);
		$query = 'UPDATE '.$this->tabela.' SET '.implode('=?,',$colunas).'=? WHERE '.$id;
		$this->execucao($query,array_values($values));
		return true;
	}

	public function delete($where){
		$query = 'DELETE FROM '.$this->tabela.' WHERE '.$where;
		$this->execucao($query.array_values($where));
		return true;
	}

}