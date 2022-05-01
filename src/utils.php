<!-- 
  Autor: Gustavo Patricio
  Data de criação: 01/05/2022
  Data de modificação: 01/05/2022
  Versão: 0.01
-->
<?php
class utils
{

    function ativoStatus($ativo) //função que recebe um bool e retorna seu valor em string
{
    if ($ativo == 0)
    {
        return 'Não';
    }
    else
    {
        return 'Sim';
    }
} 


}

?>