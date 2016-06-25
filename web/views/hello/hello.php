<?php echo $view->render('header.php') ?>

Olá <?= $nome; ?>
<br>
<br>
Veja os produtos cadastrados:
<br>
<?php
foreach($produtos as $val){
	echo $val['id']." - ".$val['nome']."<br>";
}
?>

<?php echo $view->render('footer.php') ?>