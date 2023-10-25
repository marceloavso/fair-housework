<?php

$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');

if(@$_REQUEST['id_residencia']){
    $sql = "INSERT INTO tarefa (id_residencia, nome_tarefa, frequencia, dia_semana) VALUES (?, ?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$_REQUEST['id_residencia'], $_REQUEST['nome_tarefa'], $_REQUEST['frequencia'], $_REQUEST['dia_semana']]);
    header('Location: ../view/tarefas.html');
}

?>
