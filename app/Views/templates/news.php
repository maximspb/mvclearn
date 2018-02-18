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
<?php foreach ($news as $article) : ?>
    <h3><a href="/news/read/<?php echo $article->id ?>"><?= $article->title ?></a></h3>
    <div class="text"><?= $article->title ?></div>
<?php endforeach; ?>
</body>
</html>