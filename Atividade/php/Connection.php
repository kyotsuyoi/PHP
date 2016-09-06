<?php
try {
    $db = new PDO("mysql:dbname=atividade;host=localhost:3305;charset=utf8", "root", "mysql");
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
