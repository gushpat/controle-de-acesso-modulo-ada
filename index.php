<?php
//includes do projeto
//importação do arquivo sidenav.php onde está o código html do menu lateral
include './src/sidenav.php';

//importação do arquivo credentials.php onde estão as credenciais para conexão do banco de dados
include './src/credentials/credentials.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Controle de Acesso - Módulo Ada</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="./assets/css/styles.css" media="screen" />


</head>
<body>

<?php


//exibe o menu lateral
echo $sidenav;

?>

<div class="content">
  <h2>Controle de Acesso - Módulo Ada</h2>
  <p>Bem vindo ao protótipo do sistema de controle de acesso.</p>
  <p>Utilize as opções ao lado para navegar pelo sistema.</p>

  <hr>

  <p>O atualmente o sistema possui 2 tabelas: usuário e acesso</p>

  <h3>Tabela Usuário</h3>
  <p>A tabela usuário possui os seguintes campos:</p>
  <ul>
    <li><b>usuarioID</b>: identificador do usuário, chave primária</li>
    <li><b>nome</b>: nome do usuário</li>
    <li><b>email</b>: email do usuário</li>
    <li><b>telefone</b>: telefone do usuário</li>
    <li><b>placaVeiculo</b>: placa do veículo do usuário</li>
    <li><b>descricaoVeiculo</b>: uma descricao do veículo</li>
    <li><b>curso</b>: curso do usuário</li>
    <li><b>tagID</b>: sequencia numerica presente na tag rfid.
      <br>O módulo de leitura rfid, enviará o código recebido pela tag,
      <br>que será comparado com este valor para verificar se o usuário está autorizado a acessar o sistema.
    </li>
    <li><b>ativo</b>: indica se o usuário está ativo ou não</li>
  </ul>

  <hr>

  <h3>Tabela Acesso</h3>
  <p>A tabela acesso possui os seguintes campos:</p>
  <ul>
    <li><b>acessoID</b>: identificador do acesso, chave primária</li>
    <li><b>usuarioID</b>: identificador do usuário, chave estrangeira da tabela usuario</li>
    <li><b>dataAcesso</b>: data e hora do acesso</li>
    <li><b>acao</b>: define se o usuário está entrando ou saindo da instituíção. Exemplo:
      <br>o leitor presente na entrada definiria a ação apenas como entrada e o 
      <br>presente na saída, definiria a ação apenas como saída.</li>
  </ul>

  <hr>

  <h3>Consulta na tabela usuário </h3>
  
  <?php 

$pdo = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);

$sql = 'select * from usuario';

$stmt = $pdo->prepare($sql); //prepara a query
$stmt->execute(); //executa a query

$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC); //pega todos os dados da query e guarda em um array

echo '<table>';

foreach($projetos as $projeto){ //percorre o array
    echo '<tr>';
    
    echo '<td> Nome: '.$projeto['nome'].'</td>';
    echo '<td> Placa do Veículo: '.$projeto['placaveiculo'].'</td>';
    
   
    echo '</tr>';

    
    
}

echo '</table>';



 ?>

  
</div>

</body>
</html>