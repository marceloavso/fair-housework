<?php

include "db-connector.php";
session_start();
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

if(@$_REQUEST['carregarResidencias']){
  $sql = "SELECT * FROM residencia
   INNER JOIN usuario_residencia ON residencia.id_residencia = usuario_residencia.id_residencia
   WHERE usuario_residencia.id_usuario = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$id_usuario]);
  $residencias = [];
  while($linha = $select->fetch(PDO::FETCH_ASSOC)){
    $residencias[] = $linha;
  }
  echo json_encode($residencias);
}

if(@$_REQUEST['atualizarResidencia']){
  $sql = "UPDATE residencia
   SET logradouro = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, tipo = ?
   WHERE id_residencia = ?";
   $update = $mysql->prepare($sql);
   $update->execute([$_REQUEST['logradouro'],$_REQUEST['numero'],
    $_REQUEST['bairro'], $_REQUEST['cidade'], $_REQUEST['estado'],
    $_REQUEST['tipo'], $_REQUEST['id_residencia']]);
  echo json_encode(true);
}

if(@$_REQUEST['deixarResidencia']){
  $sql = "DELETE FROM usuario_residencia WHERE id_usuario = ? AND id_residencia = ?";
   $update = $mysql->prepare($sql);
   $update->execute([$id_usuario,$_REQUEST['id_residencia']]);
  echo json_encode(true);
}
?>
