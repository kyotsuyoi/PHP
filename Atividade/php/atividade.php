<?php
include_once('menu.php');
if(isset($_GET['idATV'])){
  require_once("Connection.php");
  global $db;
  $rs = $db->prepare("call atividade.select_atividade(".$_GET['idATV'].")");
  $rs->execute();
  while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
      $nomeATV = $row->nome;
      $data_atividadeATV = $row->data_atividade;
      $descricaoATV = $row->descricao;
    }
    $valnome = 'value="'.$nomeATV.'"';
    $valdesc= $descricaoATV;
  }else{
    $valnome = 'value=""';
    $valdesc= "";
  }
 ?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/atividade.css"/>
    <script type="text/javascript">
    function gravar(){
      <?php
      if(isset($_POST['salvar'])){
        date_default_timezone_set('America/Sao_Paulo');
        require_once("Connection.php");
        global $db;
        $sql = "call atividade.nova_atividade('".$_POST['nome']."', '".date('d/m/y H:i')."', '".$_POST['descricao']."', ".$_COOKIE['idgrupo'].", ".$_COOKIE['id'].")";
        $stmt = $db->prepare($sql);
        header('Location:/Atividade/php/atividade.php?id='.$_COOKIE['id']);
        $stmt->execute();
      }
       ?>
    }
    function delete(){
      <?php
      if(isset($_POST['deletar'])){
        require_once("Connection.php");
        global $db;
        $sql = "call atividade.delete_atividade(".$_COOKIE['idatv'].")";
        $stmt = $db->prepare($sql);
        header('Location:/Atividade/php/atividade.php?id='.$_COOKIE['id']);
        $stmt->execute();
      }
       ?>
    }
    function finalizar(){
      <?php
      if(isset($_POST['finalizar'])){
        require_once("Connection.php");
        global $db;
        $sql = "call atividade.update_finalizado(".$_COOKIE['idatv'].")";
        $stmt = $db->prepare($sql);
        header('Location:/Atividade/php/atividade.php?id='.$_COOKIE['id']);
        $stmt->execute();
      }
       ?>
    }
    </script>
</head>
<body>
<div class="atividade">
      <fieldset class="fsAtividade">
        <legend>Atividade</legend>
        <div class="form">
          <form action="atividade.php" class="formatv" method="post">
              <label>Nome</label></br>
              <input type="text" name="nome" <?php echo $valnome; ?>/></br>
              <label>Descrição</label></br>
              <textarea class="descricao" name="descricao"><?php echo $valdesc; ?></textarea>
              <input class="btn" type="submit" value="Salvar" onclick="gravar()" name="salvar"/>
              <input class="btn" type="submit" value="Finalizar" onclick="finalizar()" name="finalizar"/>
              <input class="btn" type="submit" value="Deletar" onclick="delete()" name="deletar"/>
          </form>
        </div>
      </fieldset>
        <fieldset class="fsGrupo">
          <legend>Grupo</legend>
        <div class="tbgrupos">
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
                    <td><a href="/Atividade/php/atividade.php?id=<?php echo $_COOKIE ['id'] ?>&idgrupo=<?php echo $codigo ?>&nome=<?php echo $nome ?>"><?php echo $nome ?></a></td>
                  </tr>
            <?php
                }
            ?>
          </table>
        </div>
      </fieldset>
        <fieldset class="fsAtividades">
          <legend>Atividades<?php if(isset($_GET['idgrupo'])){ echo " do grupo ".$_GET['nome']; setcookie('idgrupo',$_GET['idgrupo']);  } ?></legend>
        <div class="tbatividades">
          <table>
              <?php
              if(isset($_GET['idgrupo'])){
              require_once("Connection.php");
              global $db;
              $rs = $db->prepare("call atividade.select_atividades(".$_GET['idgrupo'].")");
              $rs->execute();
              while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                  $id =$row->id;
                  $nome = $row->nome;
                  $data_atividade = $row->data_atividade;
                  $descricao = $row->descricao;
                  $finalizado = $row->finalizado;
                  $cbfinalizado;
                        if ($finalizado == 1) {
                            $cbfinalizado = 'checked="checked"';
                        } else {
                            $cbfinalizado = '';
                        }
                  ?>
                  <tr>
                    <td><a href="/Atividade/php/atividade.php?id=<?php echo $_COOKIE['id'] ?>&idgrupo=<?php echo $_GET['idgrupo'] ?>&nome=<?php echo $_GET['nome'] ?>&idATV=<?php echo $id; setcookie('idatv',$id); ?> "><?php echo $nome; ?></a></td>
                    <td><input class="cbfinalizado" name="cbFinalizado" disabled readonly type="checkbox"<?php echo $cbfinalizado; ?>/></td>
                  </tr>
            <?php
                }
              }
            ?>
          </table>
        </div>
      </fieldset>
</div>
</body>
</html>
