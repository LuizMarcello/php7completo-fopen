<?php
//Através da classe 'config.php' vai ser possível
//localizar a classe 'sql.php', para instanciá-la.
require_once("config.php");

$sql = new Sql();


$usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

//Função nativa 'print_r()' para imprimir o array da variável no parâmetro:
//print_r($usuarios);

//Criando um arquivo 'csv' do conteúdo da tabela tb_usuarios:

$headers = array();

//Função nativa 'array_push()': Coloca um array em outro array.
//Função nativa 'ucfirst()':Deixa a 1ª letra maiúscula.
//'foreach' quer dizer 'para cada'.
foreach($usuarios[0] as $key => $value){
	array_push($headers, ucfirst($key));
}

//Função nativa 'print_r()' para imprimir o array da variável no parâmetro:
//print_r($headers);

//'fopen()'Função nativa que cria/abre/acessa arquivos.
//Ela espera 2 parâmetros, 2 strings:
//1º) O caminho e o nome do arquivo
//2º) Como vai ser controlado este arquivo.
//A variável '$file' será a resource/manipuladora do arquivo 'usuarios.csv'.
//'w+': Cria um arquivo novo 'usuarios.csv', e escreve nele, do começo.
$file = fopen("usuarios.csv", "w+");
//O arquivo 'usuarios.csv' será aberto e sua referência será
//colocada na variável manipuladora '$file'.
//Esta variável '$file', será um 'resource', que faz 
//refência a um arquivo externo à linguagem php.

//Variável nativa 'fwrite()' escreve no arquivo.
//Ela espera 2 parâmetros:
//1º) Um 'resource'(manipulador):
//2º) Os dados a serem inseridos.

//Função nativa 'implode()' para colocar o separador, no caso, a vírgula:
//Ela espera 2 parâmetros:
//1º) Uma string que será o separador entre os ítens, no array.
//2º) O array para o qual será aplicada esta regra do separador.
fwrite($file, implode(",", $headers) . "\r\n");
//'foreach' quer dizer 'para cada'.
foreach($usuarios as $row){//foreach das linhas
	
	$data = array();
	
	foreach($row as $key => $value){//foreach das colunas
		
		array_push($data,$value);
		
	}
	
//Variável nativa 'fwrite()' escreve no arquivo.
//Ela espera 2 parâmetros:
//1º) Um 'resource'(manipulador):
//2º) Os dados a serem inseridos.
	
//Função nativa 'implode()' para colocar o separador, no caso, a vírgula:
//Ela espera 2 parâmetros:
//1º) Uma string que será o separador entre os ítens, no array.
//2º) O array para o qual será aplicada esta regra do separador
	fwrite($file, implode(",", $data) . "\r\n");
	
}

//Liberando da memória e fechando o manipulador,
//com a função nativa 'fclose()':
fclose($file);

?>