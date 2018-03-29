<?php
  if ($_POST['login'] && $_POST['oldpw'] && $_POST['newpw'] && ($_POST['submit'] === 'OK')){
    if (!(file_exists("../ex01/private"))) // verifie si un fichier ou un dossier existe
      mkdir("../ex01/private", 0777);
    if (file_exists("../ex01/private/passwd")){
      $content = file_get_contents("../ex01/private/passwd");
      $content = unserialize($content);
    }
    else
    {
      $empty = 1;
      file_put_contents("../ex01/private/passwd", "");
      $content = array();
    }
    $exist = -1;
    if ($empty != 1){
      foreach ($content as $key => $value) {
        if ($value['login'] === $_POST['login'])
          $exist = $key;
      }
    }
    if ($exist != -1){
      $hash = hash("whirlpool", $_POST['oldpw']); // permet de generer le mot de passe hash
      if ($hash === $content[$exist]['passwd']){
        $content[$exist]['passwd'] = hash("whirlpool", $_POST['newpw']);
        file_put_contents("../ex01/private/passwd", serialize($content));
        echo "OK\n";
      }
      else
        echo "ERROR\n";
    }
    else {
      echo "ERROR\n";
    }
  }
  else {
    echo "ERROR\n";
  }
?>
