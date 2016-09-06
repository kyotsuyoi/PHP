<?php
require_once('zipar.php');
session_start();
if($_SESSION['logado']==""){
  header('Location:/index.php');
}else{
  $com = "";
 ?>
<!DOCTYPE html>
<meta charset="utf-8">
<?php
include_once('menu.php');
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="..\css\home.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function() {
         atualiza();
        });
        function atualiza(){
         $.get("notificacao.php", function(resultado){
           $('#not').html(resultado);
         })
         setTimeout('atualiza()', 10000);
        }

    function comentar(){
        <?php
        if(isset($_POST['coment']) && $_POST['txtcomentario']!=""){
          if (isset($_FILES['arquivo']['name'])){
        	$arq = $_FILES['arquivo']['name'];
        	$arq = 	str_replace(" ","_",$arq);
        	$arq = 	str_replace("ç","c",$arq);
        		if (file_exists("../anexos/$arq.zip")){
        		$a = 1;
        		while(file_exists("../anexos/$a-$arq.zip")){
        		$a++;
        }
        	$arq = $a."-".$arq;
        }
        				if (move_uploaded_file($_FILES['arquivo']['tmp_name'],"../anexos/".$arq)){
        					$zip = new zipar();
        					$zip->ziparArquivos($arq,$arq.".zip","../anexos/");
        					unlink("../anexos/$arq");
                    /*
        						echo '<script type="text/javascript">
        								alert("Upload realizado !");
        								</script>';
                        */
        				}else{
        				 echo '<script type="text/javascript">
        								alert("Erro !");
        								</script>';
        				}
              }
          date_default_timezone_set('America/Sao_Paulo');
          require_once("Connection.php");
          global $db;
          $sql = "call atividade.comentar('".$_POST['txtcomentario']."', '".date('d/m/y H:i')."', ".$_COOKIE['idAtividade'].", ".$_COOKIE['id'].",'".$arq."')";
          $stmt = $db->prepare($sql);
          header('Location:/Atividade/php/home.php?id='.$_COOKIE['id'].'&idgrupo='.$_COOKIE['idgrupo'].'&nome='.$_COOKIE['nome'].'&idAtividade='.$_COOKIE['idAtividade']);
          $stmt->execute();
          ///Atividade/php/home.php?id=14&idgrupo=17&nome=new&idAtividade=58
        }elseif(isset($_POST['coment']) && $_POST['txtcomentario']==""){
          header('Location:/Atividade/php/home.php?id='.$_COOKIE['id'].'&idgrupo='.$_COOKIE['idgrupo'].'&nome='.$_COOKIE['nome'].'&idAtividade='.$_COOKIE['idAtividade']);
        }
         ?>
    }
    function descer(){
      var height = 0;
      $("#tbcom").each(function(i, value){
    height += parseInt($(this).height());
  });
  height += '';
  $("#comentarios").animate({scrollTop: height});
    }
    </script>
  </head>
  <body onload="descer()">
      <div class="home">
        <div class="posts">
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
                    $login = $row->login;
            ?>
            <tr>
              <td><a href="/Atividade/php/home.php?id=<?php echo $_COOKIE['id']; ?>&idgrupo=<?php echo $_GET['idgrupo']; ?>&nome=<?php echo $_GET['nome'] ?>&idAtividade=<?php echo $id; ?>"><?php echo $nome; ?></a></td>
            </tr>
            <?php
              }
              ?>
            <!--  <a href="/Atividade/php/home.php?id=<?php echo $_COOKIE['id']; ?>" class="voltar">Voltar<a> -->
            <?php
            }else{
             ?>
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
                    <td><a href="/Atividade/php/home.php?id=<?php echo $_COOKIE ['id'] ?>&idgrupo=<?php echo $codigo ?>&nome=<?php echo $nome ?>"><?php echo $nome ?></a></td>
                  </tr>
            <?php
                }
              }
            ?>
          </table>
        </div>
        <div class="comentarios" id="comentarios">
          <table id="tbcom">
                      <?php
                      if (isset($_GET['idAtividade'])) {
                          setcookie('idgrupo',$_GET['idgrupo']);
                          setcookie('nome',$_GET['nome']);
                          setcookie('idAtividade',$_GET['idAtividade']);
                          require_once("Connection.php");
                          global $db;
                          $rs = $db->prepare("call atividade.info_comentario(".$_GET['idAtividade'].")");
                          $rs->execute();
                          while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                              $nomeAtividade = $row->nome;
                              $dataAtividade = $row->data_atividade;
                              $descAtividade = $row->descricao;
                              $criado = $row->login;
                          }
                          echo "Nome: " . $nomeAtividade . " " . $dataAtividade . "</br>";
                          echo "Criado por: " . $criado . "</br>";
                          echo "Obs: " . $descAtividade . "</br>";
                      }
                      ?>
                      <?php
                      if (isset($_GET['idAtividade'])) {
                          require_once("Connection.php");
                          global $db;
                          $rs = $db->prepare("call atividade.select_comentarios(".$_GET['idAtividade'].")");
                          $rs->execute();
                          while ($row = $rs->fetch(PDO::FETCH_OBJ)) {
                              $usuario = $row->login;
                              $data = $row->data_comentario;
                              $comentario = $row->comentario;
                              $anexo = $row->anexo;
                            //<?php echo '<img src="data:image/jpeg;base64,'.base64_encode($anexo).'"/>';
                            ?>
                                <tr>
                                  <td><?php echo $usuario . " " . $data; ?>: <?php echo $comentario; ?> <?php if($anexo!=""){ ?><a href="..\anexos\<?php echo $anexo ?>"><img src="..\imagens\clip.png"></a></img> <?php } ?> </td>
                                </tr>
                              <?php
                          }
                      }
                      ?>
                  </table>
        </div>
        <?php
        if(isset($_GET['idAtividade'])){
         ?>
        <form action="home.php" method="post" enctype="multipart/form-data">
        <textarea class="txtcomentario" name="txtcomentario"></textarea>
        <input type="submit" onclick="comentar()" value="Comentar" name="coment" class="btncomentar" />
        <input type="file" name="arquivo" size="100" class="upload" />
      </form>
      </div>
      <div id="not" style="background-color: aqua;position: absolute;height:30px;hidth:30px"></div>
      <?php
    }
       ?>

  </body>
  </html>
  <?php
}
   ?>
