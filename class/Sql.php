<?php
//De dentro do método, para referenciar um atributo ou método():
//Estando dentro da mesma classe, usa-se o $this->.
//Não precisa do '$' no nome do atributo.
//Estando fora da classe, usa-se objeto->.
//'$this': Variável interna do php que serve
//para referenciar $atributos e metodos().

//Criando um atributo dentro da classe, mas fora de
//qualquer método, usa o '$' normalmente.

//extendendo a classe nativa PDO.
class Sql extends PDO {
	
	private $conn;
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	//Método construtor que executa automaticamente na criação do objeto/instânca desta classe.
	//Conectará automaticamente no banco de dados.
	public function __construct(){
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7","root",""); 
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	private function setParams($statment,$parameters=array()){
	//É recriada a variável '$key' para cada índice de posição do array '$parameters'.
    //É recriada a variável '$value' para cada valor de cada indice de posição do array '$parameters'.
		foreach($parameters as $key => $value){
			$this->setParam($statment,$key,$value);
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	private function setParam($statment,$key,$value){
		$statment->bindParam($key,$value);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	public function query($rawQuery,$params=array()){
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt,$params);
		$stmt->execute();
		return $stmt;
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function select($rawQuery,$params=array()):array{
		$stmt = $this->query($rawQuery,$params);
		return $stmt->fetchALL(PDO::FETCH_ASSOC);
	}
}



?>