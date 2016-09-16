<?php
    //Шаблон главной страницы
    //============================
    //$nav = выбор кол-ва статей на одной странице
    //$sort - постраничная навигация
    //$articles - статьи в виде превью
    //id_article - идентифицатор
    //title - заголовок
    //content - текст
    //date_time - дата загрузки статьи
?>
<?php echo $sort; ?>
<?php echo $nav; ?>
<section>
    <div class="article">
        <?php foreach ($images as $image): ?>
            <div class="images">
                <a href="index.php?act=image&id=<?php echo $image['id_image']; ?>">
                    <article>
                        <img class="img-thumbnail" src="<?php echo 'img/mini/'.$image['name']; ?>">
                        <!--<small>Название : <?php echo $image['name']; ?> </small>-->
                    </article>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <!--
        <?php if(isset($usersOnline)): ?>
            <div>
                <b><?php echo $usersOnline; ?></b>
            </div>
        <?php endif; ?>
    -->
</section>