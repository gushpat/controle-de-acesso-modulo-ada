<!-- 
  Autor: Gustavo Patricio
  Data de criação: 01/05/2022
  Data de modificação: 01/05/2022
  Versão: 0.01
-->

<?php

//ESTE ARQUIVO POSSUI TODAS AS CREDENCIAIS QUE SERÃO UTILIZADAS PELO SISTEMA
//Credenciais de acesso ao banco de dados
//para acessar basta alterar o valor de $host, $user, $pass e $db


$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ada_api";

// Create connection with the database using PDO
$pdo = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);


?>