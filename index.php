<?php
//includes do projeto
//importação do arquivo sidenav.php onde está o código html do menu lateral
include './src/sidenav.php';

//importação do arquivo credentials.php onde estão as credenciais para conexão do banco de dados
include './src/credentials/credentials.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
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
    <li><b>ativo</b>: indica se o usuário está ativo ou não.</li>
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

$consulta = $stmt->fetchAll(PDO::FETCH_ASSOC); //pega todos os dados da query e guarda em um array

if ($consulta == null)
{
  echo "Nenhum resultado encontrado.";
  echo "<br>";
}

else {

echo '<table>';

echo '<tr>
  <th>Nome</th>
  <th>Placa do Veículo</th>
  <th>Descrição</th>
  <th>Curso</th>
</tr>';

foreach($consulta as $projeto){ //percorre o array
    
 
    echo '<tr>';
    echo '<td>'.$projeto['nome'].'</td>';
    echo '<td>'.$projeto['placaVeiculo'].'</td>';
    echo '<td>'.$projeto['descricaoVeiculo'].'</td>';
    echo '<td>'.$projeto['curso'].'</td>';
    echo '</tr>';

    
    
}

echo '</table>';

}
 ?>

<h3>Consulta na tabela acesso </h3>
  
  <?php

//não precisa criar a variavel pdo pois ela já foi criada na consulta anterior

$sql = 'select * from acesso';

$stmt = $pdo->prepare($sql); //prepara a query
$stmt->execute(); //executa a query

$consulta = $stmt->fetchAll(PDO::FETCH_ASSOC); //pega todos os dados da query e guarda em um array

if ($consulta == null)
{
  echo "Nenhum resultado encontrado.";
  echo "<br>";
}

else {


echo '<table>';

foreach($consulta as $projeto){ //percorre o array
    echo '<tr>';
    
    echo '<td> ID: '.$projeto['acessoID'].'</td>';
    echo '<td> Usuario ID: '.$projeto['ususarioID'].'</td>';
    echo '<td> Data de Acesso: '.$projeto['dataAcesso'].'</td>';
    echo '<td> Ação: '.$projeto['acao'].'</td>';
    
    
   
    echo '</tr>';

    
    
}

echo '</table>';

}

?>


<br>
<hr>

<h3>Utilizando a API do ADA</h3>

<p>Para poder realizar qualquer ação dentro da api, você precisará de um token de acesso.</p>
<details>
    <summary>Clique aqui para visualizar o token!</summary>
    204863
</details>

<br>

<p>O token de acesso serve para que você possa realizar qualquer ação dentro da API,
  <br>como por exemplo, cadastrar um novo usuário, ou atualizar um usuário já cadastrado.</p>

<p> Caso o token não seja inserido na requisição, o sistema não permitirá que o usuário realizar qualquer ação.</p>

<p> Por enquanto o token de acesso está sendo enviado pelo método GET, mas futuramente será enviado pelo método POST.</p>

<h4> Criando um novo acesso </h4>

<p> Para gerar um novo acesso na tabela <b>acesso</b> você deve seguir os seguintes passos:</p>
<ul>
<li> Acessar <b>ada/api/v1.0/api.php?token=""&usuarioid=""&dataacesso=""&acao=""</b> </li>
<li> Informar o <b>token de acesso</b>, no caso "204863" </li>
<li> Informar o <b>id do usuario</b>, no caso "1" </li>
<li> Informar o <b>data de acesso</b></li>
<li> Informar o <b>acao</b>, no caso "entrada" ou "saida" </li>

<li> Ao preencher todos os parametros, a url ficará da seguinte maneira: 
  <br><b>ada/api/v1.0/api.php?token=204863&usuarioid=1&dataacesso=2018-12-12&acao=entrada</b> </li>
  <br>
<li> No final, a API retornará um JSON com o resultado da operação.</li>
<li> Caso o token de acesso não seja válido, a API retornará um JSON com a mensagem "Token inválido"</li>
<li> Caso o usuário não exista, a API retornará um JSON com a mensagem "Usuário não existe"</li>
<li> Caso o usuário já tenha feito a ação, a API retornará um JSON com a mensagem "Usuário já fez a ação"</li>
<li> Caso o usuário não tenha feito a ação, a API retornará um JSON com a mensagem "Usuário não fez a ação"</li>



</ul>



  
</div>

</body>
</html>