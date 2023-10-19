<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
  <title>FoxGPT</title>
</head>
<body>
<!-- ロード要素 -->

<!-- headerここまで -->


<h1>FoxGPT</h1>
<p>お話AI</p>


<h2>はじめに</h2>

FoxGPTは、Athenaiが100万件以上の文対データから、オープンソースであるOpenNMT-pyを用いて独自に作成した<br>
対話AIモデルです。本ページはpythonプログラムとPHPでプロセス間通信をするための重要部分を抜き出した<br>
サンプルコードです。これにより、ApacheにPythonの拡張機能を導入しなくても、疑似的にPythonの処理を行うことが可能です。<br>
プロセス間通信は並列処理等色々応用が利くすばらしい技術です。

<h2>導入にあたって</h2>

本コードにより対話を行う場合、バックグラウンドで通信先のPythonプログラムを動作せる必要(foxgpt.py)があります。<br>
また、名前付きpipeを2つ777で作成しておいてください。内部処理の概要はReadMeをご覧ください。<br>
<a href="https://aafox.net/fgpt/"> 実際に動作しているページを紹介しておきます。</a>
<form action="" method="post">



<dl class="content-area">
<dt>お話内容</dt>
   <dd>
    <?php
    if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
    echo "
    <textarea type='text' class='message2' name='inmessage' required maxlength='30' 
    placeholder='お話ししたい内容を入力してください。
30文字以内でお願いします!'></textarea><br>";}
    else{
      $inmessage=htmlspecialchars($_POST['inmessage']);
      echo "
      <textarea type='text' class='message2' name='inmessage' required maxlength='30' 
      placeholder=$inmessage></textarea><br>";
    }
   ?>
   </dd>
   </dl>
   
<?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $innp="/var/www/pipetest/innp";
         $outnp="/var/www/pipetest/outnp";
         $inmessage=htmlspecialchars($_POST['inmessage']);
         $f = fopen($innp,"w");
         fwrite($f, $inmessage);  //block until there is a reader
         fclose($f); 
         if(!file_exists($outnp)) {
            echo "I am not blocked!";
         }
         else {
            //block and read from the pipe
            $f2 = fopen($outnp,"r");
            //echo fread($f2,100);
            $outmessage = fread($f2,100);
            echo 
            "<dl class='content-area'>
            <dt>FoxGPTよりお返事</dt>
            <dd>
            <div class='message'>
            $outmessage</div>
            </dd>
            </dl>";
            fclose($f2); 
         }
         //echo $_POST['inmessage'];
      }
      else{
         echo 
         '<dl class="content-area">
         <dt>FoxGPTよりお返事</dt>
         <dd>
         <div class="message">こんにちは、わたしはFoxGPTです。<br>まだまだ、ふつつかものですがたくさんおはなししてください♪</div>
         </dd>
         </dl>';
      }
      
    ?>

<div class="link-button">
    <input type="submit" class="link" value="お話しする" name="send"><br>
   </div>

</form>


</div>
</main>

</body>
</html>
