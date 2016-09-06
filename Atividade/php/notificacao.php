<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/alerta.css"/>
    <script src="../js/alertify.min.js"></script>
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
<?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once("Connection.php");
    $ultimaAtividade;
    global $db;
    $rs = $db->prepare("call atividade.notificacao(".$_COOKIE['id'].")");
    //SELECT nome FROM atividade.atividades where data_atividade like'".date('d/m/y')."%' and id_grupo = '".$_COOKIE['grupo']."'
    //SELECT nome FROM atv_atividade where data_atividade like '".date('d/m/y')."%' and ".$_COOKIE['departamento']."='1' order by id desc limit 1
    $rs->execute();
    while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
        $ultimaAtividade = "";
        $ultimaAtividade = $row->nome;
            if($_COOKIE['atv']===$ultimaAtividade){
            //  echo $_COOKIE['grupo'];
            }else {
              echo '<script type="text/javascript">alertify.success("Nova atividade adicionada: </br>'.$ultimaAtividade.'")</script>';
          /*    echo "else agr pode"."</br>";
            echo $_COOKIE['atv']."</br>";
            echo $ultimaAtividade."</br>"; */
            setcookie('atv',$ultimaAtividade);
            }

    }
// echo '<script type="text/javascript">var notificacao = new Notification("'.$ultimaAtividade.'",{icon:"../imagens/login.png",autoHideDelay:100});</script>';
// echo '<script type="text/javascript">var notificacao = new Notification("tese");</script>';
?>
</body>
</html>
