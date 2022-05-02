<!-- 
  Autor: Gustavo Patricio
  Data de criação: 01/05/2022
  Data de modificação: 01/05/2022
  Versão: 0.01
-->

<?php
//includes do projeto

//importação do arquivo sidenav.php onde está o código html do menu lateral
include './src/sidenav.php';

//importação do arquivo credentials.php onde estão as credenciais para conexão do banco de dados
include './src/credentials/credentials.php';

//include da classe de utilidades
include './src/utils.php';

//include rodapé
include './src/footer.php';

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
    <li><b>usuarioID (PK)</b>: identificador do usuário, chave primária</li>
    <li><b>nome</b>: nome do usuário</li>
    <li><b>RA (UK)</b>: Codigo do registro do aluno</li>
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
    <li><b>acessoID (PK)</b>: identificador do acesso, chave primária</li>
    <li><b>usuarioID (FK)</b>: identificador do usuário, chave estrangeira da tabela usuario</li>
    <li><b>dataAcesso</b>: data e hora do acesso</li>
    <li><b>acao</b>: define se o usuário está entrando ou saindo da instituíção. Exemplo:
      <br>o leitor presente na entrada definiria a ação apenas como entrada e o 
      <br>presente na saída, definiria a ação apenas como saída.</li>
  </ul>

  <hr>

  <h3>Consulta na tabela usuário </h3>
  
  <?php 



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



echo '<details>';
  echo  '<summary>Clique aqui para visualizar a tabela usuário!</summary>';
    
  echo '<table>';

  echo '<tr>
    <th>ID</th>
    <th>Nome do Usuário</th>
    <th>Registro do Aluno</th>
    <th>Placa do Veículo</th>
    <th>Descrição</th>
    <th>Curso</th>
    <th>Tag ID</th>
    <th>Ativo</th>
  </tr>';
  
  $utils = new utils(); //instancia a classe utils
  
  foreach($consulta as $projeto){ //percorre o array
      
   
      echo '<tr>';
      echo '<td>'.$projeto['usuarioID'].'</td>';
      echo '<td>'.$projeto['nome'].'</td>';
      echo '<td>'.$projeto['RA'].'</td>';
      echo '<td>'.$projeto['placaVeiculo'].'</td>';
      echo '<td>'.$projeto['descricaoVeiculo'].'</td>';
      echo '<td>'.$projeto['curso'].'</td>';
      echo '<td>'.$projeto['tagID'].'</td>';
      echo '<td>'.$utils->ativoStatus($projeto['ativo']).'</td>';  //chama a função ativoStatus da classe utils, retornando uma string ao invés de um bool
      echo '</tr>';
  
      
  }
  
  echo '</table>';

echo '</details>';



}
 ?>

<h3>Consulta na tabela acesso </h3>
  
  <?php

//não precisa criar a variavel pdo pois ela já foi criada no arquivo credenciais.php

$sql = '
SELECT acesso.acessoID, acesso.dataAcesso, acesso.acao, usuario.nome, usuario.RA 
FROM acesso 
INNER JOIN usuario 
ON acesso.usuarioID = usuario.usuarioID
ORDER BY acesso.acessoID ASC';

$stmt = $pdo->prepare($sql); //prepara a query
$stmt->execute(); //executa a query

$consulta = $stmt->fetchAll(PDO::FETCH_ASSOC); //pega todos os dados da query e guarda em um array

if ($consulta == null)
{
  echo "Nenhum resultado encontrado.";
  echo "<br>";
}

else {

  
echo '<details>';
  echo  '<summary>Clique aqui para visualizar a tabela acesso!</summary>';


echo '<table>';

echo '<tr>
  <th>ID</th>
  <th>Nome do Usuário</th>
  <th>Registro do Aluno</th>
  <th>Data de Acesso</th>
  <th>Ação</th>
</tr>';

foreach($consulta as $projeto){ //percorre o array
    
  
    echo '<tr>';
    echo '<td>'.$projeto['acessoID'].'</td>';
  //  echo '<td>'.$projeto['usuarioID'].'</td>';
    echo '<td>'.$projeto['nome'].'</td>';
    echo '<td>'.$projeto['RA'].'</td>';
    echo '<td>'.$utils->formatDate($projeto['dataAcesso']).'</td>';
    echo '<td>'.$utils->acaoStatus($projeto['acao']).'</td>';
    echo '</tr>';

    
    
}

echo '</table>';

echo '</details>';

}

?>


<br>
<hr>

<h3>Registrando Acesso</h3>
<p>Para registrar o acesso, preencha os campos abaixo e clique no botão.</p>

<div class="container">
  <form action="./src/validate/validateacess.php" method="POST">
    <label for="fid">Tag ID</label>
    <input type="text" id="tagID" name="tagID" placeholder="id">
    <br>
    <br>
    <label for="acao">Escolha a ação:</label>
<br>
    <input type="radio" id="acao" name="acao" value="1">
  <label for="acao">Entrada</label><br>
  <input type="radio" id="acao" name="acao" value="0">
  <label for="acao">Saída</label><br>
    <br>
    <br>
    <input type="submit" value="Registrar novo acesso">
  </form>
</div>



<hr>

<h3>Utilizando a API do ADA</h3>

<p>Para poder realizar qualquer ação dentro da api, você precisará de um token de acesso.</p>
<details>
    <summary>Clique aqui para visualizar o token!</summary>
    <p>204863</p>
</details>

<br>

<p>O token de acesso serve para que você possa realizar qualquer ação dentro da API,
  <br>como por exemplo, cadastrar um novo usuário, ou atualizar um usuário já cadastrado.</p>

<p> Caso o token não seja inserido na requisição, o sistema não permitirá que o usuário realizar qualquer ação.</p>

<h4> Como funciona a API? </h4>

<p> Explicando de uma maneira simples, o modulo que fará a leitura do sensor, irá enviar uma requisição para a API,
  <br>que irá verificar se o código recebido pela tag rfid é válido e se o usuário está ativo. Caso seja válido e o usuário esteja ativo,
  <br>o sistema irá retornar uma resposta com o status de sucesso, caso contrário, o sistema irá retornar uma resposta com o status de erro.
  <br>baseado na resposta recebida pela api, o sistema irá liberar a catraca ou não.
</p>


<ul>
<li> Acessar <b>ada/api/v1.0/api.php?token=""&usuarioid=""&acao=""</b> </li>
<li> Informar o <b>token de acesso</b></li>
<li> Informar o <b>id do usuario</b></li>
<li> Informar o <b>acao</b>, no caso 1 para "entrada" ou 0 para "saida" </li>

<li> Ao preencher todos os parametros, a url ficará da seguinte maneira: 
  <br><b>ada/api/v1/api.php?token="204863"&usuarioid=1&dataacesso="2022-05-04 22:21:32"&acao="1"</b> </li>
  <br>
<li> No final, a API retornará um JSON com o resultado da operação.</li>
<li> Caso o token de acesso não seja válido, a API retornará um JSON com a mensagem "Token inválido"</li>
<li> Caso o usuário não exista, a API retornará um JSON com a mensagem "Usuário não existe"</li>


</ul>


<?php
echo $footer;
?>
  
</div>




</body>
</html>