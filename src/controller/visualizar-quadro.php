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
<?php
$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');
session_start();

$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

$sql = "SELECT COUNT(id_residencia) FROM usuario_residencia WHERE id_usuario = ?";
$selectCount = $mysql->prepare($sql);
$selectCount->execute([$id_usuario]);
$countResidencias = $selectCount->fetchColumn();

$sql = "SELECT residencia.id_residencia, residencia.nome_residencia
 FROM residencia
 INNER JOIN usuario_residencia ON residencia.id_residencia = usuario_residencia.id_residencia
 WHERE usuario_residencia.id_usuario = ?";
$select = $mysql->prepare($sql);
$select->execute([$id_usuario]);

for($i=0 ; $i<$countResidencias ; $i++){
  $residencias = $select->fetch(PDO::FETCH_ASSOC);
  $todasResidencias[$i] = $residencias;
}

$sql = "SELECT COUNT(id_tarefa) FROM tarefa WHERE id_residencia = ?";
$selectCount = $mysql->prepare($sql);
$selectCount->execute([$residencias['id_residencia']]);
$countTarefas = $selectCount->fetchColumn();

$sql = "SELECT a_fazer.*, tarefa.nome_tarefa FROM a_fazer
 INNER JOIN tarefa ON a_fazer.id_tarefa = tarefa.id_tarefa
 WHERE a_fazer.id_residencia = ? AND a_fazer.dia_semana = ?";
$selectAfazer = $mysql->prepare($sql);

function quadroDia($dia, $selectAfazer, $residencias){
  $selectAfazer->execute([$residencias, $dia]);
  while($afazer = $selectAfazer->fetch(PDO::FETCH_ASSOC)){
    echo "<ul class='list-group'>
              <li class='list-group-item'>$afazer[nome_tarefa]</li>
          </ul>";
  }
}

function seletorResidencia($todasResidencias, $countResidencias){
  for($i = 0 ; $i < $countResidencias ; $i++){
    $id_residencia = $todasResidencias[$i]["id_residencia"];
    $nome_residencia = $todasResidencias[$i]["nome_residencia"];
    echo "<option value='$id_residencia'>$nome_residencia</option>";
  }
}
?>
    <div class="row w-50 ms-2">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <select id="selRes" class="col d-inline-block w-25 form-select form-select-sm" name="selResidencia">
          <?php seletorResidencia($todasResidencias, $countResidencias); ?>
        </select>
        <button class="col d-inline-block btn btn-secondary fundo mt-2 w-25" type="submit" >Selecionar</button>
      </form>
    </div>
    <div class="row">
        <!-- Quadro de Dias da Semana -->
        <div class="col-md-12">
            <div class="d-sm-flex justify-content-around">
                <div class="quadro">
                    <h5>Domingo</h5>
                    <!-- Tarefas de domingo serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(1, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Segunda</h5>
                    <!-- Tarefas de segunda-feira serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(2, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Terça</h5>
                    <!-- Tarefas de terça-feira serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(3, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Quarta</h5>
                    <!-- Tarefas de quarta-feira serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(4, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Quinta</h5>
                    <!-- Tarefas de quinta-feira serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(5, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Sexta</h5>
                    <!-- Tarefas de sexta-feira serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(6, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
                <div class="quadro">
                    <h5>Sábado</h5>
                    <!-- Tarefas de sábado serão adicionadas aqui -->
                    <?php if(@$_REQUEST['selResidencia']){quadroDia(7, $selectAfazer, $_REQUEST['selResidencia']);} ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

</script>

</html>
