<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1><?php echo $article->title ;?></h1>
<?php echo $article->text ;?>
<hr>
<a href="/news/edit/?id=<?php echo $article->id ;?>">Редактировать новость</a> || <a href="/news/delete/?id=<?php echo $article->id ; ?>">
    Удалить новость</a>
</body>
</html>