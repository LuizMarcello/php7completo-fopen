<?php

//'fopen()'Função nativa que cria/abre/acessa arquivos.
//Ela espera 2 parâmetros, 2 strings:
//1º) O caminho e o nome do arquivo
//2º) Como vai ser controlado este arquivo.
//A variável '$file' será a manipuladora do arquivo 'log.txt'.
//'w+': Cria um arquivo novo 'log.txt', e escreve nele, do começo.
//'a+': O ponteiro vai pro final do arquivo e acrescenta mais conteúdo.
//$file = fopen("log.txt","w+");
$file = fopen("log.txt","a+");
//O arquivo 'log.txt' será aberto e sua referência será
//colocada na variável manipuladora '$file'.
//Esta variável '$file', será um 'resource', que faz 
//refência a um arquivo externo à linguagem php. 

//Variável nativa 'fwrite()' escreve no arquivo.
//Ela espera 2 parâmetros:
//1º) Um 'resource'(manipulador):
//2º) Os dados a serem inseridos.
fwrite($file, date("Y-m-d H:i:s")."\r\n");

//Liberando da memória e fechando o manipulador,
//com a função nativa 'fclose()':
fclose($file);

//echo "Arquivo criado com sucesso!!!"
echo "Novo conteúdo acrescentado com sucesso!!!"


?>