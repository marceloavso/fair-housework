<?php
include "db-connector.php";
session_start();
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

if(@$_REQUEST['carregarTarefas']){
  $sql = "SELECT * FROM tarefa WHERE tarefa.id_residencia = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['carregarTarefas']]);
  $tarefas = [];
  while($linha = $select->fetch(PDO::FETCH_ASSOC)){
    $tarefas [] = $linha;
  }
  echo json_encode($tarefas);
}

if(@$_REQUEST['selResidencia']){
  $sql = "SELECT residencia.id_residencia, residencia.nome_residencia
   FROM residencia
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

if(@$_REQUEST['infoTarefa']){
  $sql = "SELECT * FROM tarefa WHERE id_tarefa = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['infoTarefa']]);
  $tarefa = $select->fetch(PDO::FETCH_ASSOC);
  echo json_encode($tarefa);
}

if(@$_REQUEST['atualizarTarefaFreq']){
  $sql = "UPDATE tarefa SET nome_tarefa = ?, frequencia = ?, dia_semana = null
    WHERE id_tarefa = ? AND id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['nome_tarefa'], $_REQUEST['frequencia'],
   $_REQUEST['id_tarefa'], $_REQUEST['id_residencia']]);
   echo json_encode(true);
}

if(@$_REQUEST['atualizarTarefaDia']){
  $sql = "UPDATE tarefa SET nome_tarefa = ?, frequencia = ?, dia_semana = ?
    WHERE id_tarefa = ? AND id_residencia = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['nome_tarefa'], $_REQUEST['frequencia'],
   $_REQUEST['dia_semana'], $_REQUEST['id_tarefa'],
   $_REQUEST['id_residencia']]);
   echo json_encode(true);
}

if(@$_REQUEST['deletarTarefa']){
  $sql =  "DELETE FROM tarefa WHERE id_tarefa = ? AND id_residencia = ?";
  $delete = $mysql->prepare($sql);
  $delete->execute([$_REQUEST['id_tarefa'], $_REQUEST['id_residencia']]);
  echo json_encode(true);
}

?>
