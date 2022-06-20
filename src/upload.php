
<!DOCTYPE html>
<html lang="pt-br">
    
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="wrap">
        <div class="container">
            <div class="row">
             <br>
            <div class="column">
                <p>Esta função ainda não está finalizada!</p>
            </div>
            <br>

                <form class="form-horizontal" action="./upload/uploadnewdatabase.php" method="post" name="upload_excel" enctype="multipart/form-data">

                    <fieldset>
                        <!-- Form Name -->
                        <legend>Upload de Nova Base de Dados</legend>
                        <!-- File Button -->
                        <div class="form-group">
                            
                            <label class="col-md-4 control-label" for="filebutton">Selecionar Arquivo CSV</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Importar Base de Dados</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
              // get_all_records();
            ?>
        </div>
    </div>
</body>
</html>





