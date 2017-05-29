<?php
try{
	new \PDO('mysql:host=localhost;dbname=php_test','root','root');
	echo "Conexao efetuada com sucesso!";
}catch(\PDOException $ex){
	echo $ex->getMessage();
}
