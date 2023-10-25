<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../view/styles/style.css">
</head>

<body>
  <div class='col-md-12'>
      <div class='d-sm-flex justify-content-around'>
<?php
$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');
session_start();
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

$sql = "SELECT residencia.id_residencia, residencia.nome_residencia
 FROM residencia
 INNER JOIN usuario_residencia ON residencia.id_residencia = usuario_residencia.id_residencia
 WHERE usuario_residencia.id_usuario = ?";
$select = $mysql->prepare($sql);
$select->execute([$id_usuario]);

$sql = "SELECT * FROM tarefa WHERE tarefa.id_residencia = ?";
$selectTarefas = $mysql->prepare($sql);

$sql = "SELECT COUNT(id_tarefa) FROM tarefa WHERE id_residencia = ?";
$selectCount = $mysql->prepare($sql);


while($residencias = $select->fetch(PDO::FETCH_ASSOC)){
$selectTarefas->execute([$residencias['id_residencia']]);
$selectCount->execute([$residencias['id_residencia']]);
$countTarefas = $selectCount->fetchColumn();
  if($countTarefas > 0){
    echo "

          <div class='d-inline-block quadro'>
              <h5>$residencias[nome_residencia]</h5>
              <ul class='list-group'>";
              while($tarefas = $selectTarefas->fetch(PDO::FETCH_ASSOC)){
                echo "<li class='list-group-item'>$tarefas[nome_tarefa]</li>";
              }
    echo "
              </ul>
          </div>";
  }
}

?>
    </div>
  </div>
</body>
</html>
