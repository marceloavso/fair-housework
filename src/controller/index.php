<?php
session_start();
if((isset($_SESSION['login'])) && (isset($_SESSION['senha']))){
  header('Location: ../view/quadro-tarefas.html');
}
else{
  header('Location: ../view/login.html');
}

?>
