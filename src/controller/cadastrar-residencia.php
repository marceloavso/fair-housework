<?php

$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');
session_start();
if(@$_REQUEST['nome_residencia']){

    $sql = "SELECT id_usuario FROM usuario WHERE email = ?";
    $select = $mysql->prepare($sql);
    $select->execute([$_SESSION['login']]);
    $id_usuario = $select->fetchColumn();
    echo "$id_usuario";

    $sql = "INSERT INTO residencia (nome_residencia, logradouro, numero,
      bairro, cidade, estado, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$_REQUEST['nome_residencia'], $_REQUEST['logradouro'],
    $_REQUEST['numero'], $_REQUEST['bairro'], $_REQUEST['cidade'],
    $_REQUEST['estado'], $_REQUEST['tipo']]);

    $sql = "SELECT id_residencia FROM residencia WHERE nome_residencia = ?
     AND logradouro = ? AND numero = ? AND bairro = ? AND cidade = ?
     AND estado = ? AND tipo = ?";
    $select = $mysql->prepare($sql);
    $select->execute([$_REQUEST['nome_residencia'], $_REQUEST['logradouro'],
    $_REQUEST['numero'], $_REQUEST['bairro'], $_REQUEST['cidade'],
    $_REQUEST['estado'], $_REQUEST['tipo']]);
    $id_residencia = $select->fetchColumn();

    $sql = "INSERT INTO usuario_residencia (id_usuario, id_residencia, admin)
     VALUES(?, ?, ?)";
    $insert = $mysql->prepare($sql);
    $insert->execute([$id_usuario, $id_residencia, 1]);

    header('Location: ../view/residencias.html');
}

?>
