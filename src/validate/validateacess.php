<?php 

//este arquivo valida as informações recebidas pelo form de registro de acesso

if(!empty($_POST['tagID'])) //se tagID não é nulo
    {
        $tagID = $_POST['tagID']; // obtem a variavel phrase do formulario

        if(isset($tagID)){ // se a variavel tagID não está vazia
            
            //echo "tagID: ".$tagID;

            include '../credentials/credentials.php'; //importa arquivo de validação

            //não precisa da variavel pdo
            //ela está sendo passada pelo arquivo credentials

            // busca o usuario com a tagID

            $sql = 'select * from usuario where tagID = :tagID'; //query para buscar o usuário
            $stmt = $pdo->prepare($sql); //prepara a query
            $stmt->bindParam(':tagID', $tagID); //passa o valor da variavel tagID para a query
            $stmt->execute(); //executa a query

            $row = $stmt->fetch();

            //se a variavel row não está vazia, significa que o usuário existe
            if ($row > 0)
            {
                //verificação do campo "ativo". Se o usuario estiver desativado, o registro não pode ser feito
                if ($row ["ativo"] == 0)
                {
                    echo "Usuário desativado. Não é possível registrar o acesso.";
                }
                else
                {
                    date_default_timezone_set('America/Sao_Paulo'); //define o timezone
                    $data = date("Y-m-d H:i:s"); //pega a data e hora atual

                   
                    //2022-05-02 13:37:17

                    $acao = $_POST['acao'];

                    //se o usuario estiver ativo, registra o acesso
                    $sql = 'insert into acesso (acessoID, usuarioID, dataAcesso, acao) values (NULL, :usuarioID, :dataAcesso, :acao)'; //query para registrar o acesso
                    $stmt = $pdo->prepare($sql); //prepara a query
                    $stmt->bindParam(':usuarioID', $row['usuarioID']); //passa o valor da variavel row['usuarioID'] para a query
                    $stmt->bindParam(':dataAcesso', $data); //passa o valor da variavel data para a query
                    $stmt->bindParam(':acao', $acao); //passa o valor da variavel acao para a query
                    $stmt->execute(); //executa a query

                    //echo "Registro de acesso realizado com sucesso!";

                    // echo "Data e hora atual: ".$data;
                    // echo "<br>";
                    // echo "Ação: ".$_POST['acao'];
                    // echo "<br>";
                    // echo "Usuario ID: ".$row['usuarioID'];
                    header("Location: ../../index.php"); //redireciona para a página de login
                }

                


            }
            else
            {
                echo "Usuário não encontrado!";
            }
            
            //echo $row ["tagID"];
            //echo "<tr>";
           // echo $row ["usuarioID"];
            
            
            
        }
        else //se o campo estiver vazio
        {
            echo 'ERRO! você deve preencher o campo Tag ID para registrar o acesso.';
        }

    }







?>