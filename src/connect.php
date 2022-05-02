

<?php

//importa credenciais de acesso ao banco de dados
include './credentials/credentials.php';

echo "PÁGINA DE TESTES";
//conexão com banco de dados

$pdo = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);

$sql = 'select * from usuario';

$stmt = $pdo->prepare($sql); //prepara a query
$stmt->execute(); //executa a query

$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC); //pega todos os dados da query e guarda em um array

echo '<table>';

foreach($projetos as $projeto){ //percorre o array
    echo '<tr>';
    
    echo '<td>'.$projeto['nome'].'</td>';
    echo '<td>|</td>';
    echo '<td>'.$projeto['placaveiculo'].'</td>';
    
   
    echo '</tr>';

    
    
}

echo '</table>';












?>