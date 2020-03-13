<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">
	
    <title>Приложение-задачник</title>
</head>
<body>
<div class="wrap">
    <!-- Классы navbar и navbar-default (базовые классы меню) -->
<nav class="navbar navbar-default">
<div class="container">
  <!-- Контейнер (определяет ширину Navbar) -->
  <div class="container-fluid">
    <!-- Заголовок -->
    <div class="navbar-header">
      <!-- Кнопка «Гамбургер» отображается только в мобильном виде (предназначена для открытия основного содержимого Navbar) -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- Бренд или название сайта (отображается в левой части меню) -->
      <a class="navbar-brand" href="/">Главная</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-main">
    <ul class="nav navbar-nav">
        <li><?php if(!$_SESSION['user']['isLogin']){?>
                        <a class="nav-link" href="/login">Вход</a>
                    <?php } else {?>
                        <a class="nav-link" href="/logout">Выход (<?=$_SESSION['user']['name']?>)</a>
                    <?php } ?></li>

    </ul>
    </div>
    
  </div>
  </div>
</nav>

    <div class="container">
		<?php include "{$_SERVER['DOCUMENT_ROOT']}/app/views/$contentView"; ?>	
    </div>
</div>

<footer class="footer">
</footer>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/taskbookfunc.js"></script>
<script src="/assets/js/validate.js"></script>
<script src="/assets/js/main.js"></script>

</body>
</html>