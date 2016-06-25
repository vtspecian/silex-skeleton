<?php

include('BaseModel.php');

class ProdutoModel extends BaseModel{

	public function findAll(){
		$sql = "SELECT * FROM produtos";
		$produtos = $this->db->fetchAll($sql);
		return $produtos;
	}
}