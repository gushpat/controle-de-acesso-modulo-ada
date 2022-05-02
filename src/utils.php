
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


function acaoStatus($ativo) //função que recebe um bool e retorna seu valor em string
{
    if ($ativo == 0)
    {
        return 'Saída';
    }
    else
    {
        return 'Entrada';
    }
}

function formatDate($dateTime) //função que recebe uma data no formato YYYY-MM-DD e retorna no formato DD/MM/YYYY
{
    //2022-05-04 22:21:32

    $dateTime = explode(" ", $dateTime); //separa a data da hora

    $date = $dateTime[0]; //pega a data
    $date = explode('-', $date);

    $time = $dateTime[1]; //pega a hora


    return $date[2].'/'.$date[1].'/'.$date[0].' '.$time; //retorna a data no formato DD/MM/YYYY + hora

}


}

?>