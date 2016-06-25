<?php $view->extend('layout.php') ?>

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
