<!DOCTYPE html>
<html lang="pt-br">
<?php
include_once('menu.php');
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="..\css\usuario.css"/>
</head>
<body>
      <div class="usuario">

        <div class="form">
        <form action="usuario.php" method="post">
            <label>Usuario</label></br>
            <input type="text" name="login"/></br>
            <label>Senha</label></br>
            <input type="password" name="senha" /></br>
            <input type="checkbox" name="adm"/>
            <label>Administrador</label></br>
            <input type="submit" onclick="gravar()" name="gravar" value="Gravar"/>
            <input type="submit" onclick="alterar()" name="alterar" value="Alterar" />
            <input type="submit" onclick="deletar()" name="deletar" value="Deletar"/>
        </form>
      </div>
      <fieldset class="fsusuarios">
        <legend>Usuarios</legend>
        <div class="tbusuario">
          <table>
                <?php
                    require_once("Connection.php");
                    $id_usuaio;
                    $usuario;
                    $senha;
                    $adm;
                    global $db;
                    $rs = $db->prepare("call atividade.select_usuario()");
                    $rs->execute();
                    while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                        $id_usuaio = $row->id;
                        $usuario = $row->login;
                        $senha = $row->senha;
                        $adm = $row->administrador;
                        ?>
                        <tr>
                          <td><a href="#" <?php setcookie("altUs",$id_usuaio); ?> >Usuario: <?php echo $usuario ?></a>
                        <tr>
                <?php
                    }
                    ?>
            </table>
        </div>
      </fieldset>
      </div>

</body>
</html>
