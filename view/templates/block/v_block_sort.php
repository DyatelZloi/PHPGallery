<?php
    //Шаблон выбора кол-ва статей на одной странице
    //============================
?>
<div class="page">
    Выводить статьи: <br>
    <a <?php vHelper_print_if_true(3, $_SESSION['num'], 'black') ;?> href="index.php?num=3"> по 3</a>
    <a <?php vHelper_print_if_true(5, $_SESSION['num'], 'black') ;?> href="index.php?num=5"> по 5</a>
    <a <?php vHelper_print_if_true(10, $_SESSION['num'], 'black') ;?> href="index.php?num=10"> по 10</a>
</div>