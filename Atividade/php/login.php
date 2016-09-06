<?php
require_once("Connection.php");
session_start();
global $db;
$rs = $db->prepare("call atividade.login('".$_POST['login']."', '".$_POST['password']."')");
$rs->execute();
while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
    $codigo =$row->id;
    $login = $row->login;
    $senha = $row->senha;
    $adm = $row->administrador;
}
if ($login!="" and $senha!=""){
    $_SESSION['logado']=$login;
    setcookie('logado',$login);
    setcookie('id',$codigo);
    setcookie('adm',$adm);
    setcookie('atv','inicio');
    header("Location: home.php?id=".$codigo);
} else {
    $_SESSION['logado']="";
    header("Location: ../../index.php");
}

?>
