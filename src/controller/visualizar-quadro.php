<?php
include "db-connector.php";
session_start();

$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

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

if(@$_REQUEST['carregarQuadroGeral']){
  $sql = "SELECT a_fazer.*, tarefa.nome_tarefa FROM a_fazer
   INNER JOIN tarefa ON a_fazer.id_tarefa = tarefa.id_tarefa
   WHERE a_fazer.id_residencia = ?";
  $selectAfazer = $mysql->prepare($sql);
  $selectAfazer->execute([$_REQUEST['carregarQuadroGeral']]);
  $afazer = [];
  while($linha = $selectAfazer->fetch(PDO::FETCH_ASSOC)){
    $afazer[] = $linha;
  }
  echo json_encode($afazer);
}

if(@$_REQUEST['carregarMeuQuadro']){
  $sql = "SELECT a_fazer.*, tarefa.nome_tarefa FROM a_fazer
   INNER JOIN tarefa ON a_fazer.id_tarefa = tarefa.id_tarefa
   WHERE a_fazer.id_residencia = ? AND a_fazer.id_usuario = ?";
  $selectAfazer = $mysql->prepare($sql);
  $selectAfazer->execute([$_REQUEST['carregarMeuQuadro'], $id_usuario]);
  $afazer = [];
  while($linha = $selectAfazer->fetch(PDO::FETCH_ASSOC)){
    $afazer[] = $linha;
  }
  echo json_encode($afazer);
}

if(@$_REQUEST['responsavelTarefa']){
  $sql = "SELECT usuario.nome_usuario, usuario.sobrenome_usuario,
   usuario.email FROM usuario
   INNER JOIN a_fazer ON a_fazer.id_usuario = usuario.id_usuario
   WHERE a_fazer.id_afazer = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['responsavelTarefa']]);
  $usuario = $select->fetch(PDO::FETCH_ASSOC);
  echo json_encode($usuario);
}

if(@$_REQUEST['infoTarefa']){
  $sql = "SELECT * FROM a_fazer WHERE id_afazer = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['infoTarefa']]);
  $tarefa = $select->fetch(PDO::FETCH_ASSOC);
  echo json_encode($tarefa);
}

if(@$_REQUEST['atualizarTarefa']){
  $sql = "UPDATE a_fazer SET descricao = ? WHERE id_afazer = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$_REQUEST['descricao'], $_REQUEST['atualizarTarefa']]);
}

if(@$_REQUEST['trocarTarefa']){
  /*
  if(mail($_REQUEST['email_resp'],
  "[Fair Housework] Solicitação de Troca de Tarefa",
  $_REQUEST['nome_resp']." deseja trocar a tarefa ".$_REQUEST['nome_tarefa']." com você. Para aceitar, click no link a seguir: ".$_REQUEST['link'])){
    echo json_encode(true);
  }
  else{
    echo json_encode(false);
  }
  */
  echo json_encode($_REQUEST['link']);
}

if(@$_REQUEST['aceitarTrocaTarefa']){
  $sql = "UPDATE a_fazer SET id_usuario = ? WHERE id_afazer = ?";
  $update = $mysql->prepare($sql);
  $update->execute([$id_usuario, $_REQUEST['tarefa']]);
  echo "<script>window.location.replace('../view/quadro-tarefas.html')</script>";
}

if(@$_REQUEST['shareResidencia']){
  $link = $_REQUEST['link'];
  echo json_encode($link);
}

if(@$_REQUEST['entrarResidencia']){
  $sql =  "INSERT INTO usuario_residencia (id_usuario, id_residencia, admin) VALUES( ?,  ?, 0) ";
  $insert = $mysql->prepare($sql);
  $insert->execute([$id_usuario, $_REQUEST['nResidencia']]);
  echo "<script>window.location.replace('../view/quadro-tarefas.html')</script>";
}

if(@$_REQUEST['gerarQuadro']){
  function diasToArray($string){
    $string = html_entity_decode($string);
    $string = json_decode($string);
    return($string);

  }

  //select tarefas
  $sql = "SELECT * FROM tarefa WHERE id_residencia = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['gerarQuadro']]);
  $tarefas = [];
  while($linha = $select->fetch(PDO::FETCH_ASSOC)){
    $tarefas[] = $linha;
  }
  $nTarefas = count($tarefas);
  for($i = 0; $i < $nTarefas; $i++){
    //Transforma campo dia_semana(string) em array novamente
    $tarefas[$i]['dia_semana'] = diasToArray($tarefas[$i]['dia_semana']);

    //Multiplica tarefa em função dos dias da semana
    if(($tarefas[$i]['dia_semana'] != null) && (count($tarefas[$i]['dia_semana'])>1)){
      $nDias = count($tarefas[$i]['dia_semana']);
      for($j = 0; $j < $nDias; $j++ ) {
        $t = [];
        $t['id_tarefa'] = $tarefas[$i]['id_tarefa'];
        $t['id_residencia'] = $tarefas[$i]['id_residencia'];
        $t['nome_tarefa'] = $tarefas[$i]['nome_tarefa'];
        $t['frequencia'] = $tarefas[$i]['frequencia'];
        $t['dia_semana'] = intval($tarefas[$i]['dia_semana'][$j]);
        $tarefas[] = $t;
      }
      unset($tarefas[$i]);
    }
    //Multiplica tarefa em função da frequência
    if(@$tarefas[$i]['dia_semana'] == null){
      $r = new \Random\Randomizer();
      @$freq = $tarefas[$i]['frequencia'];
      $dias = [1, 2, 3, 4, 5, 6, 7];
      shuffle($dias);
      //Define os dias da semana para a tarefa conforme o número de frequência
      for($j = 0; $j < $freq; $j++ ) {
        $t = [];
        $t['id_tarefa'] = $tarefas[$i]['id_tarefa'];
        $t['id_residencia'] = $tarefas[$i]['id_residencia'];
        $t['nome_tarefa'] = $tarefas[$i]['nome_tarefa'];
        $t['frequencia'] = $tarefas[$i]['frequencia'];
        $t['dia_semana'] = array_pop($dias);
        $tarefas[] = $t;
      }
      unset($r);
    }
    unset($tarefas[$i]);
  }



  //select usuários
  $sql = "SELECT * FROM usuario_residencia WHERE id_residencia = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_REQUEST['gerarQuadro']]);
  $usuarios = [];
  while($linha = $select->fetch(PDO::FETCH_ASSOC)){
    $usuarios[] = $linha;
  }


  //Limpeza do Quadro de Tarefas

  $sql = "DELETE FROM a_fazer WHERE id_residencia = ?";
  $delete = $mysql->prepare($sql);
  $delete->execute([$_REQUEST['gerarQuadro']]);


  //Sorteio de tarefas

  shuffle($tarefas);

  function sortear($tarefas, $key, $usuarios, $mysql){
    $sql = "INSERT INTO a_fazer (id_usuario,
      id_tarefa, id_residencia, dia_semana, feita)
      VALUES(?, ?, ?, ?, ?)";
    $insert = $mysql->prepare($sql);

    $r = new \Random\Randomizer();
    $id = $r->pickArrayKeys($usuarios, 1);

    $insert->execute([
      $usuarios[$id[0]]['id_usuario'],
      $tarefas[$key]['id_tarefa'],
      $tarefas[$key]['id_residencia'],
      $tarefas[$key]['dia_semana'],
      0]);

    unset($r);
  }
  for($i=0; $i < count($tarefas); $i++){
    sortear($tarefas, $i, $usuarios, $mysql);
  }
  echo json_encode(true);
}

?>
