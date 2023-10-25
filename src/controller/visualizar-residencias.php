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
  <div class="d-sm-flex justify-content-around">


<?php

$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');
session_start();
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$select = $mysql->prepare($sql);
$select->execute([$_SESSION ['login']]);
$id_usuario = $select->fetchColumn();

$sql = "SELECT * FROM residencia
 INNER JOIN usuario_residencia ON residencia.id_residencia = usuario_residencia.id_residencia
 WHERE usuario_residencia.id_usuario = ?";
$select = $mysql->prepare($sql);
$select->execute([$id_usuario]);
while($residencias = $select->fetch(PDO::FETCH_ASSOC)){
  echo "<div class='w-25 d-inline-block'>
          <h5>$residencias[nome_residencia]</h5>
          <!-- Informações da Residencia -->
          <form>
            <div class='d-none row'>
                <label class='col'>Id Residência:</label>
                <div class='col'>
                    <input type='text' name='id_residencia' class='d-inline form-control' value='$residencias[id_residencia]'
                        disabled>
                </div>
            </div>
            <div class='row'>
                <label class='col'>Logradouro:</label>
                <div class='col'>
                    <input type='text' name='logradouro' class='d-inline form-control' placeholder='$residencias[logradouro]'
                        disabled>
                </div>
            </div>
            <div class='row'>
                <label class='col'>Nº:</label>
                <div class='col'>
                    <input type='text' name='numero' class='d-inline form-control' placeholder='$residencias[numero]' disabled>
                </div>
            </div>
            <div class='row'>
                <label class='col'>Bairro:</label>
                <div class='col'>
                    <input type='text' name='bairro' class='d-inline form-control' placeholder='$residencias[bairro]'
                        disabled>
            </div>
            <div class='row'>
            </div>
                <label class='col'>Cidade:</label>
                <div class='col'>
                    <input type='text' name='cidade' class='d-inline form-control' placeholder='$residencias[cidade]'
                        disabled>
                </div>
            </div>
            <div class='row'>
                <label class='col'>Estado:</label>
                <div class='col'>
                    <input type='text' name='estado' class='d-inline form-control' placeholder='$residencias[estado]'
                        disabled>
                </div>
            </div>
            <div class='row'>
                <label class='col'>Tipo:</label>
                <div class='col'>
                    <input type='text' name='tipo' class='d-inline form-control' placeholder='$residencias[tipo]'
                        disabled>
                </div>
            </div>


          <!-- Botões -->
          <div class='row'>
              <div class='col'>
                  <button class='btn btn-secondary fundo mt-2' type='button' onclick='editar(this.parentNode.parentNode.parentNode)'
                  >Editar</button>
              </div>

              <div class='col'>
                  <button class='hide d-none btn btn-secondary fundo mt-2' type='submit' formmethod='post'
                   formaction='atualizar-residencia.php'>
                   Salvar</button>
              </div>

              <div class='col'>
                  <button class=' hide d-none btn btn-danger mt-2' type='submit' formmethod='post'
                   formaction='deixar-residencia.php'>Deixar</button>
              </div>
          </form>
          </div>
        </div>";
}

?>
  </div>

</body>
<script>
  function editar(residencia){
    var campo = residencia.getElementsByTagName('input');
    for(var i=0;i<7;i++){
      campo[i].disabled = false;
    }
    var salvar = residencia.getElementsByClassName('hide');
    for( i in salvar){
      salvar[i].classList.remove('d-none');
    }
  }
</script>
</html>
