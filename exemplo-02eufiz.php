<?php

require_once("config.php");

$sql = new Sql();

$usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

//print_r($usuarios);

//Criando um arquivo 'csv' do conteúdo da tabela tb_usuarios:

$headers = array();

//Aqui varre somente a linha 0 e alimenta o array '$headers'
//somente com os titulos das colunas: 
foreach($usuarios[0] as $key => $value){
	array_push($headers, ucfirst($key));
}

//print_r($headers);

//Aqui cria o arquivo 'usuarios2.csv'
//$file será o resource/manipulador dele.
$file = fopen("usuarios2.csv", "w+");

//Aqui escreve nele somente os titulos das colunas, já separados por virgula.
fwrite($file, implode(",", $headers) . "\r\n");

//Aqui varre a tabela toda e extrai todas as linhas:
foreach($usuarios as $row){//foreach das linhas
	
	$data = array();
	
	//Aqui, para cada linha acima, extrai todas as suas colunas e valores:
	foreach($row as $key => $value){//foreach das colunas
		
		//Aqui, coloca um array em outro array:
		array_push($data, $value);
		
	}
	
	//Aqui, escreve todos os dados do array '$data' no arquivo do manipulador 
	//'$file', a saber. no arquivo 'usuarios2.csv':
	fwrite($file, implode(",", $data) . "\r\n");
}

//Aqui, fecha/encerra o resource/manipulador '$file':
fclose($file);



?>