<?php

include "db-connector.php";

if(@$_REQUEST['cadDia']){
    $sql = "INSERT INTO tarefa (id_residencia, nome_tarefa, frequencia, dia_semana) VALUES (?, ?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$_REQUEST['id_residencia'], $_REQUEST['nome_tarefa'], $_REQUEST['frequencia'], $_REQUEST['dia_semana']]);
    echo json_encode(true);
}

if(@$_REQUEST['cadFreq']){
    $sql = "INSERT INTO tarefa (id_residencia, nome_tarefa, frequencia) VALUES (?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$_REQUEST['id_residencia'], $_REQUEST['nome_tarefa'], $_REQUEST['frequencia']]);
    echo json_encode(true);
}

?>
