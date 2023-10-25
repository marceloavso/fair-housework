<?php
$mysql = new PDO('mysql:host=localhost;dbname=fair-housework', 'root', '');
session_start();

if(@$_REQUEST['id_residencia']){
  $sql = "SELECT usuario_residencia.id_usuario, usuario_residencia.id_residencia,
   usuario_residencia.admin FROM usuario
   JOIN usuario_residencia on usuario.id_usuario = usuario_residencia.id_usuario
   WHERE email = ? AND usuario_residencia.id_residencia = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$_SESSION ['login'], $_REQUEST['id_residencia']]);
  $usuario = $select->fetch(PDO::FETCH_ASSOC);

  if($usuario['admin'] == 1){
    $sql = "DELETE FROM usuario_residencia WHERE id_residencia = ?
     AND id_usuario = ?";
    $delete = $mysql->prepare($sql);
    $delete->execute([$_REQUEST['id_residencia'], $usuario['id_usuario']]);

    header('Location: visualizar-residencias.php');
  }
  else{
    echo "Não é permitido deixar a residência sem passar o cargo de administrador para outro morador.";
  }

}

?>
