<?php
include "db-connector.php";

session_start();
$_SESSION['teste'] = 1;
if(@$_REQUEST['email']){
  $loginEmail = $_REQUEST['email'];
  $loginSenha = md5($_REQUEST['senha']);
  $sql = "SELECT senha FROM usuario WHERE email = ?";
  $select = $mysql->prepare($sql);
  $select->execute([$loginEmail]);
  $bdSenha = $select->fetchColumn();
  if($bdSenha == $loginSenha){
    $_SESSION['login'] = $loginEmail;
    $_SESSION['senha'] = $loginSenha;
    header('Location: ../view/quadro-tarefas.html');
  }
  else{
    unset ($_SESSION['login']);
    unset ($_SESSION['senha']);
    header('Location: ../index.html');
  }

}



?>
