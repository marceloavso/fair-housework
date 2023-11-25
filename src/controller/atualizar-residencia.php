<?php
include "db-connector.php";
session_start();
if(@$_REQUEST['logradouro']){
  $sql = "UPDATE residencia SET logradouro = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['logradouro'], $_REQUEST['id_residencia']]);
}
else if(@$_REQUEST['numero']){
  $sql = "UPDATE residencia SET numero = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['numero'], $_REQUEST['id_residencia']]);
}
else if(@$_REQUEST['bairro']){
  $sql = "UPDATE residencia SET bairro = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['bairro'], $_REQUEST['id_residencia']]);
}
else if(@$_REQUEST['cidade']){
  $sql = "UPDATE residencia SET cidade = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['cidade'], $_REQUEST['id_residencia']]);
}
if(@$_REQUEST['estado']){
  $sql = "UPDATE residencia SET estado = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['estado'], $_REQUEST['id_residencia']]);
}
if(@$_REQUEST['tipo']){
  $sql = "UPDATE residencia SET tipo = ? WHERE id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['tipo'], $_REQUEST['id_residencia']]);
}
header('Location: visualizar-residencias.php');
?>
