<?php
    //Шаблон постраничной навигации
    //============================
    //$n - переменная равная отношению кол-ва статей в БД к требуемому кол-ву статей на одной странице
?>
<?php if($n > 1): ?>
    <div class="page">
        <a <?php vHelper_print_if_true(0, $_GET['page'], 'green'); ?> href="index.php">1</a>
        <?php for($i = 1; $i++ < $n;): ?>
            <a <?php vHelper_print_if_true($i, $_GET['page'], 'green'); ?> href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>