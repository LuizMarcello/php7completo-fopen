<?php

class Usuario{
	
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

//Métodos geter´s e seter´s dos atributos acima:
public function getIdusuario(){
	return $this->idusuario;
}
public function setIdusuario($value){
	$this->idusuario=$value;
}


public function getDeslogin(){
	return $this->deslogin;
}
public function setDeslogin($value){
	$this->deslogin=$value;
}


public function getDessenha(){
	return $this->dessenha;
}
public function setDessenha($value){
	$this->dessenha=$value;
}


public function getDtcadastro(){
	return $this->dtcadastro;
}
public function setDtcadastro($value){
	$this->dtcadastro=$value;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//Este método confirma se no ID do parâmetro existe um usuário.
//Se houver, invoca o método 'setData' para alimentar os set´s dos campos, na tabela.
public function loadById($id){
	$sql = new Sql();
	$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));
	//Se existe algum valor no indice '0', ou seja, se existe pelo menos um registro.
	if(isset($results[0])){
		
		$this->setData($results[0]);
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Método que lista todos na tabela:
public static function getList(){
	$sql = new Sql();
	return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//Método que busca um usuário pelo login, ou parte dele, conforme parâmetro:
public static function search($login){
	$sql = new Sql();
	return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(':SEARCH'=>"%".$login."%"));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//Carrega um usuário usando o login e a senha do parâmetro:
public function login($login,$password){
	$sql = new Sql();
	$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(":LOGIN"=>$login,":PASSWORD"=>$password));
	//Se existe algum valor no indice '0', ou seja, se existe pelo menos um registro.
	if(isset($results[0])){
		
		$this->setData($results[0]);
		
		
	} else {
		throw new Exception("Login e/ou senha inválidos");
		
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Este método somente pegará as informações que vieram dos registros
//do banco de dados e alimentará os atributos 'set' acima.
public function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Este método insere o login e senha do usuário na tabela, no próximo ID da sequência.
//Os novos 'login' e 'senha' são inseridos como parâmetros, no ato da criação do objeto
//da classe 'Usuario', através do construtor mágico '__construct', da mesma.
public function insert(){
	$sql = new Sql();
	$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)",array(':LOGIN'=>$this->getDeslogin(),':PASSWORD'=>$this->getDessenha()));
		if(isset($results[0])){
		$this->setData($results[0]);
		
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Altera o login e a senha do usuario referente ao ID do parâmetro, na invocação do método 'loadById()',
//pelo login e senha que constam no parâmetro, na invocação deste método 'update()':
public function update($login,$password){
	$this->setDeslogin($login);
	$this->setDessenha($password);
	
	$sql = new Sql();
	
	$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
		':LOGIN'=>$this->getDeslogin(),
		':PASSWORD'=>$this->getDessenha(),
		':ID'=>$this->getIdusuario()	
	));
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Método que deleta os dados referente ao ID 
public function delete(){
	$sql = new Sql();
	$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
		':ID'=>$this->getIdusuario()
	));
	
	$this->setIdusuario(0);
	$this->setDeslogin("");
	$this->setDessenha("");
	$this->setDtcadastro(new DateTime);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Com o acréscimo de ="", os parâmetros deixam de ser obrigatórios,
	//ou seja, posso instanciar esta classe com os parâmetros, ou não.
public function __construct($login="", $password=""){
	$this->setDeslogin($login);
	$this->setDessenha($password);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//Método mágico 'toString' que imprimirá os campos do
//usuário, usando json, quando instanciando esta
//classe e dando um 'echo' no objeto:
public function __toString(){
	
	return json_encode(array(
		"idusuario"=>$this->getIdusuario(),
		"deslogin"=>$this->getDeslogin(),
		"dessenha"=>$this->getDessenha(),
		"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
	));
}
	


}
	


?>