<?php
require_once ('config.php');
if(!empty($_SESSION['id']))
{
    header("location: index.php");
}
if(!empty($_POST['goLog']))
{
    $_POST['goLog'] = null;
    header("location: login.php");
}
$errors = [];
if(!empty($_POST['submit']))
{
    $validator = new Valid(new DB());
    foreach ($_POST as $k => $v)
    {
        $validator->checkEmpty($k, $v);
    }
    $validator->checkMaxLen('user_name', $_POST['user_name'], 'users', 'username');
    $validator->checkMaxLen('first_name', $_POST['first_name'], 'users', 'first_name');
    $validator->checkMaxLen('last_name', $_POST['last_name'], 'users', 'last_name');
    $validator->checkMinLen('password', $_POST['password'], 6);
    $validator->checkMatch('password', $_POST['password'], 'confirm_password', $_POST['confirm_password']);
    $errors = $validator->errors;
    if(empty($errors))
    {
        $user = new User();
        $user->userName = $_POST['user_name'];
        $user->email = $_POST['email'];
        $user->password = sha1($_POST['password'].SALT);
        $user->firstName = $_POST['first_name'];
        $user->lastName = $_POST['last_name'];
        $user->save();
        header('location: login.php');
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forum by Munaev</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/ico.jpg" type="image/png">
</head>
<body id="wrapper" style="max-width: 920px; width: 100%;">
<h1 style="padding-left: 30px ;">Страница регистрации</h1>
<div>
    <div class="errors">
        <?php
        foreach ($errors as $error) :?>
        <div style="color: white; font-weight:bold; background-color: firebrick; font-size: 10px; height: 20px; padding-top: 5px; text-align: center; " class="info alert alert-info">
        <p><?php echo $error;?></p>
        </div>
        <?php endforeach;?>
    </div>
    <form method="post">
        <div style="width: 400px; padding-left: 30px ;">
            <label>Логин пользователя:</label>
            <br/>
            <input type="text" name="user_name" id="user_name" class="form-control"  value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name']: ''); ?>"/>
            <span id="username_error" style="color: red;"></span>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <label>Email:</label>
            <br/>
            <input type="email" name="email" id="email" class="form-control"  value="<?php echo (!empty($_POST['email']) ? $_POST['email']: ''); ?>"/>
            <span id="email_error" style="color: red;"></span>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <label>Имя пользователя:</label>
            <br/>
            <input type="text" name="first_name" class="form-control" value="<?php echo (!empty($_POST['first_name']) ? $_POST['first_name']: ''); ?>"/>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <label>Фамилия пользователя:</label>
            <br/>
            <input type="text" name="last_name" class="form-control"  value="<?php echo (!empty($_POST['last_name']) ? $_POST['last_name']: ''); ?>"/>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <label>Пароль:</label>
            <br/>
            <input type="password" name="password" class="form-control"  value=""/>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <label>Повторите Ваш пароль:</label>
            <br/>
            <input type="password" name="confirm_password" class="form-control" value=""/>
        </div>
        <div style="width: 400px; padding-left: 30px ;">
            <br/>
            <input type="submit" name="submit"  id="submit" class="btn btn-info btn-block" value="Зарегистрироваться!" />
            <input type="submit" name="goLog" class="btn btn-info btn-block" value="Вернуться на страницу авторизации!" />
        </div>
    </form>
</div>
<script type="text/javascript" src="js/checker.js"></script>
</body>
</html>