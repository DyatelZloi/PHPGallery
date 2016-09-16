<section>
    <b><a href="index.php?c=user&act=upload">Загрузить картинку</a></b>
    <br>
    <div class="article">
        <?php foreach ($images as $image): ?>
            <div class = 'images'>
                <a href=<?php echo 'index.php?act=image&id='.$image['id_image']?>>
                    <img class="img-thumbnail" src="<?php echo '/img/mini/'.$image['name']?>">
                    <br>
                    <small><?php echo $image['name']?></small>
                </a>
                <br>
                <a class="btn btn-danger" href=<?php echo'index.php?c=user&act=index&delete='.$image['id_image'].'&name='.$image['name']?>>Удалить</a>
            </div>
        <?php endforeach; ?>
    </div>
    <b class="green"><?php echo vHelper_flashMessage('notice'); ?></b>
</section>
