<?php
include_once('menu.php');
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/grupo.css"/>
    <script src="../js/openpage.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>
  <script type="text/javascript">
  function gravar(){
    <?php
          if(isset($_POST['gravar'])){
            require_once("Connection.php");
            global $db;
            $adm;
            $sql = "call atividade.novo_grupo('".$_POST['nomeGrupo']."', ".$_COOKIE['id'].")";
            $stmt = $db->prepare($sql);
            if(isset($_POST['nomeGrupo'])){
              header('Location:/Atividade/php/grupo.php?id='.$_COOKIE['id']);
              $stmt->execute();
            }
          }
    ?>
  }
  function alterar(){
    <?php
          if(isset($_POST['alterar'])){
            require_once("Connection.php");
            global $db;
            $sql = "call atividade.update_grupo('".$_POST['nomeGrupo']."', ".$_COOKIE['grupo'].")";
            $stmt = $db->prepare($sql);
            if(isset($_POST['nomeGrupo'])){
              header('Location:/Atividade/php/grupo.php?id='.$_COOKIE['id']);
              $stmt->execute();
            }
          }
    ?>
  }
  function deletar(){
    <?php
          if(isset($_POST['deletar'])){
            require_once("Connection.php");
            global $db;
            $sql = "call atividade.delete_grupo(".$_COOKIE['grupo'].")";
            $stmt = $db->prepare($sql);
            if(isset($_POST['nomeGrupo'])){
              header('Location:/Atividade/php/grupo.php?id='.$_COOKIE['id']);
              $stmt->execute();
            }
          }
    ?>
  }
  function add(){
    <?php
    if (isset($_GET['idAdd'])){
      require_once("Connection.php");
      global $db;
      $sql = "call atividade.add_usuario(".$_GET['idgrupo'].", ".$_GET['idusuario'].")";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      header("Location:/Atividade/php/grupo.php?id=".$_GET['id']."&idgrupo=".$_GET['idgrupo']."&nome=".$_GET['nome']);
    }
    ?>
  }
  function rr(){
    <?php
    if (isset($_GET['idRR'])){
      require_once("Connection.php");
      global $db;
      $sql = "call atividade.delete_usuario_grupo(".$_GET['idgrupo'].", ".$_GET['idusuario'].")";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      header("Location:/Atividade/php/grupo.php?id=".$_GET['id']."&idgrupo=".$_GET['idgrupo']."&nome=".$_GET['nome']);
    }
    ?>
  }
  </script>
  <div class="fundo">
  <div class="conteudoGrupo">
    <form action="grupo.php" method="post">
      <fieldset class="fdGrupo">
        <legend>Grupo</legend>
      <label>Nome</label></br>
      <input type="text" class="inputGrupo" name="nomeGrupo" value="<?php if(isset($_GET['nome'])){ echo $_GET['nome']; } ?>"/>
      <div class="tbGrupo">
        <table>
            <?php
            require_once("Connection.php");
            global $db;
            $rs = $db->prepare("call atividade.select_grupos(".$_COOKIE['id'].", ".$_COOKIE['adm'].");");
            $rs->execute();
            while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                $codigo =$row->id_grupo;
                $nome = $row->nome;
                ?>
                <tr>
                  <td><a href="/Atividade/php/grupo.php?id=<?php echo $_COOKIE ['id'] ?>&idgrupo=<?php echo $codigo ?>&nome=<?php echo $nome ?>"><?php echo $nome ?></a></td>
                </tr>
          <?php
              }
          ?>
        </table>
      </div>
      <input type="submit" value="Gravar"  name="gravar"  class="btGrupo"/>
      <input type="submit" value="Alterar" name="alterar" class="btGrupo"/>
      <input type="submit" value="Deletar" name="deletar" class="btGrupo"/>
    </fieldset>
    <fieldset class="fdUsuario">
      <legend>Usuarios</legend>
      <div class="tbUsuario">
        <table>
            <?php
                if (isset($_GET['idgrupo'])){

                require_once("Connection.php");
                $id_usuario;
                $usuario;
                global $db;
                $rs = $db->prepare("call atividade.select_usuario()");
                $rs->execute();
                while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $id_usuario = $row->id;
                    $usuario = $row->login;
                    ?>
                    <tr>
                        <td><a href="/Atividade/php/grupo.php?id=<?php echo $_GET['id'] ?>&idgrupo=<?php echo $_GET['idgrupo'] ?>&nome=<?php echo $_GET['nome'] ?>&idusuario=<?php echo $id_usuario ?>"><?php echo $usuario ?></a>
                    <tr>
            <?php
                }
              }
                ?>
        </table>
      </div>
    </fieldset>
      <fieldset class="fdUsGrupo">
        <legend>Usuarios do grupo <?php
        if (isset($_GET['nome'])){
          echo $_GET['nome'];
          setcookie('grupo',$_GET['idgrupo']);
        } ?></legend>
      <div class="tbUsGr">
        <table>
            <?php
                if (isset($_GET['nome'])){
                require_once("Connection.php");
                global $db;
                $rs = $db->prepare("call atividade.select_usuarios_grupo(".$_GET['idgrupo'].")");
                $rs->execute();
                while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $id_usuario = $row->id;
                    $usuario = $row->login;
                    ?>
                    <tr>
                      <td><a href="/Atividade/php/grupo.php?id=<?php echo $_GET['id'] ?>&idgrupo=<?php echo $_GET['idgrupo'] ?>&nome=<?php echo $_GET['nome'] ?>&idusuario=<?php echo $id_usuario ?>"><?php echo $usuario ?></a>
                    <tr>
            <?php
                }
              }
                ?>
        </table>
      </div>
    </fieldset>

  <a class="btAdd" href="
  <?php
  if (isset($_GET['idgrupo'])&&isset($_GET['idusuario'])){
    $link = '/Atividade/php/grupo.php?id='.$_GET['id'].'&idgrupo='.$_GET['idgrupo'].'&nome='.$_GET['nome'].'&idusuario='.$_GET['idusuario'].'&idAdd=1';
    echo $link;
  }else{
    echo "#";
  }
  ?>
  "><img src="/Atividade/imagens/add.png"></img></a>

  <a class="btRR" href="
  <?php
  if (isset($_GET['idgrupo'])&&isset($_GET['idusuario'])){
    $link = '/Atividade/php/grupo.php?id='.$_GET['id'].'&idgrupo='.$_GET['idgrupo'].'&nome='.$_GET['nome'].'&idusuario='.$_GET['idusuario'].'&idRR=1';
    echo $link;
  }else{
    echo "#";
  }
  ?>
  "><img src="/Atividade/imagens/rr.png"></img></a>
  </div>
</div>
</body>
</html>
