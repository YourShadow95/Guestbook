<?php

use Guestbook\Classes\User;

require_once ('config.php');

if (!empty($_POST['goRegist']))
{
    unset($_SESSION['id']);
    header("location: regist.php");
}
if(!empty($_SESSION['id']))
{
    header("location: index.php");
}
$errors = [];
if(!empty($_POST))
{
    if (empty($_POST['user_name']))
    {
        $errors[]='Введите, пожалуйста, Ваш логин или Email!';
    }
    if (empty($_POST['password']))
    {
        $errors[]='Введите, пожалуйста, Ваш пароль!';
    }
    if(empty($errors) and !empty($_POST['login']))
    {
        $user = new User();
        $user = $user->checkLogin($_POST['user_name'], sha1($_POST['password'].SALT));
        if (!empty($user->id))
        {
            $_SESSION['id'] = $user->id;
            header('location: index.php');
        } else { $errors[] = 'Введение Вами логин и пароль не верный!';}
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
<h1>Страница авторизации</h1>
<?php if(!empty($_COOKIE['isRegist'])):?>
    <div style="background-color: #4cae4c; color: #2b542c; font-weight:bold;" class="info alert alert-info">
        <?php echo 'Вы успешно зарегестрировались!<br/> Используйте Ваши данные для авторизации!';
        ?>
    </div>
<?php endif;?>
<div>
    <form method="post">
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <div style="color: red; font-weight:bold; background-color: firebrick " class="info alert alert-info">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <label>Ваш логин или Email:</label>
            <div>
                <input type="text" name="user_name" class="form-control"  value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name']: ''); ?>"/>
            </div>
        </div>
        <div>
            <label>Пароль:</label>
            <div>
                <input type="password" name="password" class="form-control" value=""/>
            </div>
        </div>
        <div>
            <br/>
            <input type="submit" name="login" class="btn btn-info btn-block" value="Войти"/>
        </div>
        <div>
            <br/>
            <input type="submit" name="goRegist" class="btn btn-info btn-block" value="Зарегестрироваться"/>
        </div>
    </form>
</div>
</body>
</html>
