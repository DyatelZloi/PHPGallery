<?php
?>
<section>
    <div class="article">
        <?php foreach ($images as $image): ?>
            <div class="images">
                <a href=<?php echo 'index.php?act=image&id='.$image['id_image']?>>
                    <img src="<?php echo '/img/mini/'.$image['name']?>">
                    <br>
                    <small><?php echo $image['name']?></small>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <b class="green"><?php echo vHelper_flashMessage('notice'); ?></b>
</section>
