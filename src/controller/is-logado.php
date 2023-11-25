<?php
session_start();
if(@$_REQUEST['isLogado']){
  if((isset($_SESSION['login'])) && (isset($_SESSION['senha']))){
    echo json_encode(true);
  }
  else{
    echo json_encode(false);
  }
}
?>
