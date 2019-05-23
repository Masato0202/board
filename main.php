<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="board.css" rel="stylesheet" type="text/css" media="all">
    <title>掲示板</title>
</head>
<body>
    <!-- PHP START -->
    <?php

      $dataFile = 'board.dat';

      $posts = file($dataFile, FILE_IGNORE_NEW_LINES);
      $posts = array_reverse($posts);

      function h($s){
          return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
      }

      if($_SERVER['REQUEST_METHOD'] == 'POST' &&
          isset($_POST['message']) &&
          isset($_POST['user'])){
          $message = trim($_POST['message']);
          $user = trim($_POST['user']);

          if($message !== ""){
              $user = ($user === "") ? "anoymous" : $user;

              $message = str_replace("\t","",$message);
              $user = str_replace("\t","",$user);

              date_default_timezone_set("Asia/Tokyo");
              $postdate = date("Y-m-d H:i:s");

              $newData = $message."\t".$user."\t".$postdate."\n";
              $fp = fopen($dataFile, 'a');
              fwrite($fp,$newData);
              fclose($fp);
          }

      }
    ?>
  <!-- PHP END -->

    <!-- header始まり -->
    <!-- wrap始まり -->
    <header>
        <h1>掲示板</h1>
    </header>
        
    <form action="" method="POST">
        <div><span class="label">user:</span><input class="user" type="text" name="user"><br></div>
        <div><span class="label">message:</span><textarea class="message" name="message" cols="30" rows="6" maxlength="80" wrap="hard" placeholder="write something here"></textarea><br></div>
        <input type="submit" value="投稿">
    </form>
    
    <div class="post">
        <h2>post(<?php echo count($posts);?>)</h2>
        <ul>
            <?php if(count($posts)):?>
                <?php foreach($posts as $post):?>
                <?php list($message,$user,$postdate) = explode("\t",$post);?>
                    <li><?php echo h($message);?>(<?php echo h($user);?>)<br>-<?php echo h($postdate);?></li><hr>
                <?php endforeach;?>
            <?php else:?>
                <li>There are no posts yet</li>
            <?php endif;?>
        </ul>
    </div>
        
  <footer>
    <small>(C)2019 Copyright</small>
  </footer>

</body>

</html>
