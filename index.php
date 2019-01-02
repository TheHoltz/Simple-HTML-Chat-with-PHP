<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chat</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
      function ajax(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function (){
          if(req.readyState == 4 && req.status == 200){
            document.getElementById('chat').innerHTML = req.responseText;
          }
        }
        req.open('GET','chat.php',true);
        req.send();
      }
      setInterval(function(){ajax();},1000);
    </script>
  </head>
  <link rel="stylesheet" href="estilos.css">
  <body onload="ajax();">
    <div class="container">
              <h1> Últimas mensagens: </h1>
      <div class="chat-data">
        <div id="chat"></div>
      </div>
      <div class='entrada'>
      <form class="chat" action="index.php" method="post">
        <input type="text" name="nome" value="" placeholder="Insira seu nome"><br>
        <textarea name="msg" rows="5" cols="63"></textarea><br>
        <div class="g-recaptcha" data-sitekey="KEY-CAPTCHA"></div>
        <input class="enviar" type="submit" name="submit" value="Enviar mensagem.">
      </form>
    </div>
      <?php
      if(isset($_POST['submit'])){
        $nome = $_POST['nome'];
        $msg = $_POST['msg'];
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha_data = $_POST['g-recaptcha-response'];
        }

        if (!$captcha_data) {
            echo "Por favor, confirme o captcha.";
            exit;
        }
        $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=KEY-CAPTCHA&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if ($resposta.success) {
          $query = "INSERT INTO data (name, msg) VALUES ('$nome','$msg')";
          $run = $con->query($query);
        } else {
          echo "Meu caro usuário, refaça o captcha.";
          exit;
        }
      }
       ?>
    </div>
  </body>
</html>
