<?php
 if(isset($_POST["Import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");

        //importação do arquivo credentials.php onde estão as credenciais para conexão do banco de dados
        include '../credentials/credentials.php';

        

          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {

          try {
            //insere nome, ra e define ativo como 0 por padrão
            $sql = "INSERT into usuario (nome,RA, ativo) 
                   values ('".$getData[0]."','".$getData[1]."', 0)";
             
            $stmt = $pdo->prepare($sql); //prepara a query
            $stmt->execute(); 

            
          } 
          
          catch(PDOException $e) {
            echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"../upload.php\"
              </script>";
          }

        }
          
          echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"index.php\"
          </script>";


           fclose($file);  
     }
  }   
 ?>
