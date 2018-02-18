<form action="" method="post">
    <input type="text" name="title" placeholder="Название" value="<?php echo $article->title ;?>"><br>
    <input type="text" name="text" placeholder="Текст" value="<?php echo $article->text ;?>">
    <button type="submit" name="submit">редактировать</button>
</form>