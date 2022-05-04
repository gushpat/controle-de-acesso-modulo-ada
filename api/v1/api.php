<?php

class API{

    function cors() {
    
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
        
    }

    function registraAcesso(){

        $code = "505"; //código de retorno de erro na chave da api

        include '../../src/credentials/token.php'; //incluindo o token de acesso ($tk)
        
        if ($_GET['token'] == $tk) { //se o token for o mesmo que o token de acesso

           if(!empty($_GET['tagid'])) //se tagID não é nulo
            {
                $tagID = $_GET['tagid']; // obtem a variavel tagid do get
                
                $acao = $_GET['acao']; // obtem a variavel acao do get

                if(isset($tagID) && isset($acao)){ // se a variavel tagID e ação não está vazia
                    
    
                    include '../../src/credentials/credentials.php'; //incluindo as credenciais de acesso ao banco de dados
        
                    //não precisa da variavel pdo
                    //ela está sendo passada pelo arquivo credentials
        
                    // busca o usuario com a tagID
        
                    $sql = 'SELECT * FROM usuario WHERE tagID = :tagID LIMIT 1'; //query para buscar o usuário
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
                            //echo "Usuário desativado. Não é possível registrar o acesso."; //codigo 502
                            $code = "502";
                        }
                        else
                        {
                            date_default_timezone_set('America/Sao_Paulo'); //define o timezone
                            $data = date("Y-m-d H:i:s"); //pega a data e hora atual
        
                            //se o usuario estiver ativo, registra o acesso
                            $sql = 'insert into acesso (acessoID, usuarioID, dataAcesso, acao) values (NULL, :usuarioID, :dataAcesso, :acao)'; //query para registrar o acesso
                            $stmt = $pdo->prepare($sql); //prepara a query
                            $stmt->bindParam(':usuarioID', $row['usuarioID']); //passa o valor da variavel row['usuarioID'] para a query
                            $stmt->bindParam(':dataAcesso', $data); //passa o valor da variavel data para a query
                            $stmt->bindParam(':acao', $acao); //passa o valor da variavel acao para a query
                            $stmt->execute(); //executa a query
        
                            //echo "Registro de acesso realizado com sucesso!"; //codigo 109
                            $code = "109";
                        }
        

                    }
                    else
                    {
                        //echo "Usuário não encontrado!"; //codigo 503
                        $code = "503";
                    }
                    
                }
                else //se o campo estiver vazio
                {
                    //echo 'ERRO! Tag ID não pôde ser obtida! Tente novamente.'; //codigo 504
                    $code = "504";
                }
        
            }
            



        }
        




        //Criação do array de retorno em json 

        $response["Response"][] = array('code' => $code);
        return json_encode($response);

    }//function


} //api

$API = new API; //instancia a classe API
echo $API->cors(); //executa a função responsável por permitir o acesso a API
header('Content-Type: application/json; charset=utf-8'); //define o tipo de conteúdo que será retornado
echo $API->registraAcesso(); //executa a função responsável por selecionar os dados do banco de dados
die; //encerra a execução do script


?>