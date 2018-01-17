<?php 

require 'banco.php';

if (!empty($_POST['login'])) {
		
	$pdo = Banco::conectar();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Preparando statement 
	$sql = "SELECT * FROM user INNER JOIN estabelecimento ON estabelecimento.id = user.estabelecimento_id WHERE nmuser = ? AND password = ?";
	
	
	$q = $pdo->prepare($sql);
	$q->execute(array($_POST['login'], md5($_POST['senha'])));

	// Obter linha consultada 
	$obj = $q->fetchObject(); 
	
	
}

?> 

<form action="login.php" method="post"> 
Login: 
<input type="text" name="login" /> 
Senha: 
<input type="password" name="senha" /> 
<input name="submit" type="submit" value="Enviar" /> 
</form>