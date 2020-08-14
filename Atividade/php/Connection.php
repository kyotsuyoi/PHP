<?php
try {
    $db = new PDO("mysql:dbname=atividade;host=localhost:XXX;charset=utf8", "XXXX", "XXXX");
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
