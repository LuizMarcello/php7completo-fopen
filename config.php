<?php
//spl: Standart php Library - São conjunto de funções nativas do php
//que são usadas para facilitar algumas 'lacunas', como por exemplo
//esta lacuna do 'autoload'.
//Funções 'spl': Pode ter quantas 'spl' forem nescessárias.
//função anônima nativa para autoload de classes, com uma "spl: Standart Php Library"
//Usando com uma função anônima como parâmetro:
//Esta outra 'spl'(file_exists()) verifica se a classe existe:
spl_autoload_register(function($class_name){
	$filename = "class".DIRECTORY_SEPARATOR.$class_name.".php";
	if(file_exists(($filename))){
		require_once($filename);
	}
	
	
});




?>