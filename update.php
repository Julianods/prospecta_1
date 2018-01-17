<?php 
	
	require 'banco.php';

	$id = null;
	if ( !empty($_GET['id'])) 
            {
		$id = $_REQUEST['id'];
            }
	
	if ( null==$id ) 
            {
		header("Location: index.php");
            }
	
	if ( !empty($_POST)) 
            {
		
		$itemErro = null;
		$descricaoErro = null;
		$unErro = null;
		
		$item = $_POST['item'];
		$descricao = $_POST['descricao'];
		$un = $_POST['un'];
        
		//Validação
		$validacao = true;
		if (empty($item)) 
                {
                    $itemErro = 'Por favor digite o cód. do item!';
                    $validacao = false;
                }
				
		if (empty($descricao)) 
                {
                    $descricaoErro = 'Por favor digite descrição do item!';
                    $validacao = false;
		}
                
                if (empty($un)) 
                {
                    $unErro = 'Por favor digite a unidade de medida!';
                    $validacao = false;
		}
               
		// update data
		if ($validacao) 
                {
                    $pdo = Banco::conectar();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE item  set cditem = ?, nmitem = ?, nmum = ? WHERE id = ?";
                    $q = $pdo->prepare($sql);
                    $q->execute(array($item, $descricao, $un, $id));
                    Banco::desconectar();
                    header("Location: index.php");
		}
	} 
        else 
            {
                $pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM item where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$item = $data['cditem'];
		$descricao = $data['nmitem'];
		$un = $data['nmum'];
		Banco::desconectar();
	}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3 class="well"> Atualizar Item </h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                        
                      <div class="control-group <?php echo !empty($itemErro)?'error':'';?>">
                        <label class="control-label">Cód. Item</label>
                        <div class="controls">
                            <input name="item" size="50" type="text"  placeholder="item" value="<?php echo !empty($item)?$item:'';?>">
                            <?php if (!empty($itemErro)): ?>
                                <span class="help-inline"><?php echo $itemErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                       <div class="control-group <?php echo !empty($descricaoErro)?'error':'';?>">
                        <label class="control-label">Descrição do Item</label>
                        <div class="controls">
                            <input name="descricao" size="80" type="text"  placeholder="descricao" value="<?php echo !empty($descricao)?$descricao:'';?>">
                            <?php if (!empty($descricaoErro)): ?>
                                <span class="help-inline"><?php echo $descricaoErro;?></span>
                            <?php endif; ?>
                        </div>
                       </div>
                        
                       <div class="control-group <?php echo !empty($unErro)?'error':'';?>">
                        <label class="control-label">Unidade de Medida</label>
                        <div class="controls">
                            <input name="un" size="30" type="text"  placeholder="un" value="<?php echo !empty($un)?$un:'';?>">
                            <?php if (!empty($unErro)): ?>
                                <span class="help-inline"><?php echo $unErro;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                        <br/>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Atualizar</button>
                          <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>                 
    </div> 
  </body>
</html>

