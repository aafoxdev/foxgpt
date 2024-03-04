<!--ページが先頭に戻らない工夫!-->
<?php
$position = 0;
$msg = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$position = $_REQUEST["position"];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
  <link rel="icon" href="./img/common/favicon.ico">
  <title>FoxGPT</title>
  <meta name="description" content="はじめに">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <!--共通CSS-->
  <link href="./css/load.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/prism.css">
  <link href="./css/common.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./css/bg-move.css">
  <link rel="stylesheet" type="text/css" href="./css/wave.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

  <!--共通JS-->
  <script src="./js/load.js"></script>
  <script src="./js/prism.js"></script>
  <script src="./js/toggle-menu.js"></script>
  
  <!--選択CSS-->
  <link href="./css/tec.css" rel="stylesheet">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script>
  $(document).ready(function()
  {
  	window.onload = function (){	$(window).scrollTop(<?php echo $position; ?>);}

  	$("input[type=submit]").click(function()
  	{

  	 	var position = $(window).scrollTop();
  		$("input:hidden[name=position]").val(position);

    
  		$("#form").submit();
  	});
  });
  </script>
</head>
<body>
<!-- ロード要素 -->

<div id='particles-js'></div>
<div id='wrapper'>

 <header class="header">
  <div class="header-inner">
      <a class="header-logo" href="../index.html">
          <img src="./img/common/logo.png" alt="athenai">
      </a>
      <button class="toggle-menu-button"></button>
      <div class="header-site-menu">
          <nav class="site-menu">
              <ul>
                <li><a href="../index.html">ホーム</a></li>
                <li><a href="../#area2">アート</a></li>
                <li><a href="../#area3">お話箱</a></li>
                <li><a href="../#area4">技術系</a></li>
                <li><a href="../#area5">その他</a></li>
              </ul>
          </nav>
      </div>
  </div>
</header>
<!-- headerここまで -->

<main class="main">
   <div class="title">
      <h1>FoxGPT</h1>
      <p>お話AI</p>
   </div>
<div class="content">

<h2>はじめに</h2>
<div class="notion">
FoxGPTは、Athenaiが100万件以上の文対データから、オープンソースであるOpenNMTを用いて独自に作成した
対話AIモデルです。24時間いつでも無料で会話できるので、色々お話して下されば幸いです♪
</div>
<h2>お約束</h2>
<div class="notion">
FoxGPTは、政治や宗教等の、個人の信条や信念を否定するために、作成したものではありません。また、
仮にそのような答えを行ったとしても、それはAthenaiとは無関係であり、本サービスにより発生した、いかなる
損害に対しても、Athenaiはその責任を負わないことをご了承ください。
</div>

<form action="" method="post">

<input name="position" type="hidden" value="0">

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
         $innp="/var/www/pipe/innp";
         $outnp="/var/www/pipe/outnp";
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

<!-- footerここから -->
<div class="footer_top_img"><img src="./img/common/footer-top.jpg" width="100%" alt=""></div>
<footer class="footer">
  <nav class="site-menu">
      <ul>
        <li><a href="../index.html">ホーム</a></li>
        <li><a href="../#area2">アート</a></li>
        <li><a href="../#area3">お話箱</a></li>
        <li><a href="../#area4">技術系</a></li>
        <li><a href="../#area5">その他</a></li>
      </ul>
  </nav>
  <a class="footer-logo" href="../index.html">
      <img src="./img/common/logo.png" alt="athenai">
  </a>
  <p class="copyright"><small>&copy;athenai2020</small></p>
</footer>
<!-- footerここまで -->

<!--/wrapper--></div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="./js/bg-move.js"></script>
</body>
</html>
