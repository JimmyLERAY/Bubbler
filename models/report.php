<?php

if(isset($_POST) && !empty($_POST['report'])){
  extract($_POST);
  // On envoit un mail pour rapporter le bug :
  require '../mails/report.php';
  echo 'send';
}else{echo false;}