<?php

use Guestbook\Classes\Comment;
use Guestbook\Classes\User;

require_once ('config.php');

if(empty($_SESSION['id']))
{
    header("location: login.php");
}
if(!empty($_POST['exit']))
{
    unset($_SESSION['id']);
    header("location: login.php");
}

$qp = 5;
$errors = [];
if(!empty($_POST)) {
    if(!empty($_POST['clear']))
    {
       $cleaning = (new Comment())->clean();
        header("location: index.php");
    }
    elseif(!empty($_POST['save'])) {
        if (empty($_POST['text'])) {$errors[] = "Пожалутса, введите Ваш отзыв!";}
        if (empty($errors)) {
            $comment = new Comment();
            $comment->text = $_POST['text'];
            $comment->userId = $_SESSION['id'];
            $comment->save();
            header('location: index.php');
        }

    }
}
$_POST['page'] = (int)$_POST['page'];
$pageCount = (new Comment())->lenPage();
if(empty($_POST['page'] )) {$_POST['page'] = 1;}
if (!empty($_POST['end'])) {$_POST['page'] = (int)$pageCount; }
if (!empty($_POST['beginning'])) {$_POST['page'] = 1; }

if(empty($_POST['page'])) {$_POST['page'] = 1;}

$coms = (new Comment())->pagin($_POST['page']);
$creator1=(new User())->find($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Forum by Munaev</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="img/ico.jpg" type="image/png">
</head>
<body  id="wrapper" style="max-width: 920px; width: 100%;">
    <div>
        <h1>Гостевая книга</h1>
        <h2>Вы вошли как <?= $creator1->firstName.' '.$creator1->lastName; ?> </h2>
        <form method="post">
            <div  style="display: flex; justify-content: space-evenly;">
                <p><input name="beginning" type="submit" class="btn btn-info btn-block" style="width: 50px;" value="«"></p>
                <?php for ($i = 1; $i<=$pageCount; $i++): ?>
                    <?php echo"<p><input name=\"page\" type=\"submit\" class=\"btn btn-info btn-block\" style=\"width: 50px;\" value=\"$i\"></p>";?>
                <?php endfor ?>
                <p><input name="end" type="submit" class="btn btn-info btn-block" style="width: 50px;" value="»"></p>
            </div>
        </form>
        <?php if(!empty($errors)):?>
            <?php foreach ($errors as $error): ?>
                <div style="color: red; font-weight:bold; background-color: firebrick " class="info alert alert-info">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
        <?php if(!empty($_COOKIE['clear'])):?>
            <div style="background-color: #4cae4c; color: #2b542c; font-weight:bold;" class="info alert alert-info">
                <?php echo 'Ваши отзывы успешно удалены!';
                ?>
            </div>
        <?php endif;?>
        <?php if(!empty($_COOKIE['saved'])):?>
                <div class="info alert alert-info" style=" font-weight: bold;">
                    <?php echo 'Ваш отзыв успешно добавлен!'; ?>
                </div>
        <?php endif;?>
        <?php foreach ($coms as $comment): ?>
           <?php $creator= (new User())->find($comment['user_id']); ?>
        <div class="note">
            <p>
                <span class="date"><?php echo $comment['created_at'];?></span>
                <?php if ($comment['user_id'] == $_SESSION['id']): ?>
                <span class="date">
                    <?= 'Вы'.' ('.$creator1->firstName.' '.$creator1->lastName.')'; ?>
                </span>
                <?php else: ?>

                    <span class="date"><?php echo $creator->lastName.' '.$creator->firstName; ?></span>
                <?php endif;?>
            </p>
            <p>
                <?php echo $comment['text'];?>
            </p>
            </p>
        </div>
        <?php endforeach; ?>
        <div id="form">
            <form method="POST">
                <p><textarea name="text" class="form-control" placeholder="Ваш отзыв"><?php echo (!empty($_POST['text']) ? $_POST['text']: ''); ?></textarea></p>
                <p><input name="save" type="submit" class="btn btn-info btn-block" value="Отправить"></p>
                <p><input name="clear" type="submit" class="btn btn-info btn-block" style="background-color: #4cae4c; color: #2b542c; font-weight:bold;" value="Очистить"></p>
                <p><input name="exit" type="submit" class="btn btn-info btn-block" style=" font-weight:bold; background-color: firebrick " value="Выйти"></p>
            </form>
        </div>
    </div>
</body>
</html>