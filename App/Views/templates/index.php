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
<h1>Новости</h1>

<?php foreach ($news as $article) : ?>
<a href="/news/read/?id=<?php echo $article->id ; ?>">
    <h3>
    <?php echo $article->title ; ?>
    </h3>
</a>
<?php endforeach; ?>
</body>
</html>