<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chat</title>
    
    <!-- inserindo captcha para verificar expertinhos -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
    <!-- 
          AJAX is a developer's dream, because you can:
          Update a web page without reloading the page
          Request data from a server - after the page has loaded
          Receive data from a server - after the page has loaded
          Send data to a server - in the background 
    -->
    
    <script>
      function ajax(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function (){
          if(req.readyState == 4 && req.status == 200){
            //essa função irá atualizar a div chat assim que um request for feito
            //irá atualizar com a resposta do request, que é o spam
            document.getElementById('chat').innerHTML = req.responseText;
          }
        }
        req.open('GET','chat.php',true);
        req.send();
      }
      
      //atualizar o request a cada 1000ms (1 seg)
      setInterval(function(){ajax();},1000);
    </script>
  </head>
  
  <link rel="stylesheet" href="estilos.css">
  
  <!-- Invocando função AJAX -->
  <body onload="ajax();">
    
    <!-- Backend -->
    <div class="container">
              <h1> Últimas mensagens: </h1>
      <div class="chat-data">
         <!-- Local onde aparecerá as querys -->
        <div id="chat"></div>
      </div>
      
      <!-- Input do usuário -->
      <div class='entrada'>
        <form class="chat" action="index.php" method="post">
          <input type="text" name="nome" value="" placeholder="Insira seu nome"><br>
          <textarea name="msg" rows="5" cols="63"></textarea><br>
          <div class="g-recaptcha" data-sitekey="KEY-CAPTCHA"></div>
          <input class="enviar" type="submit" name="submit" value="Enviar mensagem.">
        </form>
      </div>
      
      <?php
      include 'db.php';
      if(isset($_POST['submit'])){
        $nome = $_POST['nome'];
        $msg = $_POST['msg'];
        // configurando captcha
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha_data = $_POST['g-recaptcha-response'];
        }

        if (!$captcha_data) {
            echo "Por favor, confirme o captcha.";
            exit;
        }
        
        //verificando resposta do captcha
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
