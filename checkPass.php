<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Смена пароля</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="/Style/mainStyle.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <style>
  #NameGame1{
      text-align:center;
      display:inline-block;
      margin-top: 20px;
      margin-bottom: 500px;
      color: white;
      font-family: 'Varela Round', sans-serif;
      font-size: 25px;
      text-decoration: none;
      position: relative;
  }
  </style>
</head>
<body>
<div class="header">
    <ul class="hr">
        <li><a href="index.html" id="NameGame1">e-Manager</a></li>
        <li><a href="account.php" id="styleLinkAccount">Личный кабинет</a></li>
    </ul>
</div>
  <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
  <label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-1"></div>
    <div class="spinner horizontal"></div>
    <div class="spinner diagonal part-2"></div>
  </label>
  <div id="sidebarMenu">
    <ul class="sidebarMenuInner">
      <li><a href="play.php" >Играть</a></li>
      <li><a href="#" >Магазин</a></li>
      <li><a href="#">Таблица лидеров</a></li>
    </ul>
  </div>

  <div class="container mt-4">
      <?php
       if ($_COOKIE['user']==''):
        ?>
        <h1 id="MainForms">Авторизуйтесь или зарегистрируйтесь</h1>
        <div class="row" id="Form_registr">
           <div class="col">
             <h1>Форма регистрации</h1>
             <form  action="check.php" method="post">
               <input type="text" class="form-control" name="login"  id="login" placeholder="Введите ваш логин"><br>

               <input type="text" class="form-control" name="name"  id="name" placeholder="Введите ваше имя"><br>

               <input type="password" class="form-control" name="pass"  id="pass" placeholder="Введите ваш пароль"><br>

               <button class="btn btn-success"  type ="submit" >Регистрация</button>
             </form>
           </div>


           <div class="col">
             <h1>Форма авторизации</h1>
             <form  action="auth.php" method="post">
               <input type="text" class="form-control" name="login" id="login" placeholder="Введите ваш логин"><br>

               <input type="password" class="form-control" name="pass"  id="pass" placeholder="Введите ваш пароль"><br>

               <button class="btn btn-success"  type ="submit" >Авторизация</button>
             </form>
           </div>
             <?php else:?>
               <p>Привет  <?php $_COOKIE['user'] ?>.Чтобы выйти нажмите  <a href="php/exit.php">здесь</a> </p>
           <?php endif; ?>


          <?php
          if($_COOKIE['user']==''):?>
        <?php else:?>
          <div class="container mt-4">
            <div align="center">
              <h2>Смена пароля</h2>
            <form  action="checkPass.php" method="post">
              <div class="form-group">
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="login"  id="login" placeholder="Введите логин"><br>
                  <input type="password" class="form-control" name="pass"  id="ChangePass" placeholder="Введите новый пароль"><br>
                  <button class="btn btn-success"  type ="submit" >Сменить</button>
                </div>
              </div>
            </form>
              </div>
            <form action="exit.php">
            <button id="ButtonExit" class="btn btn-success">Выйти</button>
            </form>
          <?php endif;?>
        </div>
    </div>
</body>
</html>




<?php
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

if (mb_strlen($login) < 3 || mb_strlen($login) > 90) {
  echo"<script>swal(\"Недопустимая длина логина!\", \"Логин содержит от 3 до 90 символов\", \"error\");</script>";
    exit();
}elseif (mb_strlen($pass) < 10 || mb_strlen($pass) > 30) {
    echo"<script>swal(\"Недопустимая длина пароля!\", \"Пароль содержит от 10 до 30 символов\", \"error\");</script>";
    exit();
}elseif ($login != $_COOKIE['nowlogin']) {
    echo"<script>swal(\"Логин не совпадает с вашим!\", \"Введите ваш логин\", \"error\");</script>";
    exit();
}

$pass = md5($pass."QafjhgjgH74");

$mysql = new mysqli('localhost', 'root', 'root', 'register-bd');
if ($mysql->connect_error) {
    die("<script>swal(\"Ошибка!\", \"Не удается установить соединение с базой данных\", \"error\");</script>");
}

$result = $mysql->query("SELECT `pass` FROM `users` WHERE `login`='$login'");
$row = $result->fetch_assoc();
if(count($row)>0){
  $mysql->query("UPDATE `users` set `pass`='$pass' WHERE `login`='$login'");
  $mysql->close();
  echo"<script>swal(\"Успешно!\", \"Вы сменили пароль\", \"success\");</script>";
}else{
  echo"<script>swal(\"Такой пользователь не существует!\", \"Поменяйте логин на существующий\", \"error\");</script>";
  $mysql->close();
  exit();
}
?>