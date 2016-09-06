<!DOCTYPE html>
<meta charset="utf-8">
<html>
  <head>
    <title>GIPP</title>
    <link rel="stylesheet" type="text/css" href="..\css\menu.css"/>
    <script src="..\js\comandos.js"></script>
  </head>
  <body>
      <div class="menu">
      <div class="barTop">
        <img src="\Atividade\imagens\perfil\<?php echo $_COOKIE['id']; ?>" style="width:100px;height:90px;margin-top:5px;margin-left:5px;border-radius:5px;"></img>
        <?php echo $_COOKIE['logado']; ?>
      </div>
      <div class="barLeft">
        <?php
        if(isset($_GET['id'])){
        ?>
        <button onclick="home(<?php echo $_COOKIE['id'] ?>)" class="btnmenu">Home</button>
        <button onclick="atividade(<?php echo $_COOKIE['id']  ?>)" class="btnmenu">Atividades</button>
        <button onclick="usuario(<?php echo $_COOKIE['id']  ?>)" class="btnmenu" <?php if($_COOKIE['adm']==0){echo "disabled";} ?>>Usuario</button>
        <button onclick="grupo(<?php echo $_COOKIE['id']  ?>)" class="btnmenu">Grupo</button>
        <button onclick="sair()" class="btnmenu">Sair</button>
        <?php
        }
         ?>
      </div>
      </div>
  </body>
  </html>
