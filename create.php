<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <div class="container">
            <div clas="span10 offset1">
                <div class="row">
                    <h3 class="well"> Adicionar Item </h3>
                    <form class="form-horizontal" action="create.php" method="post">
                        
                        <div class="control-group <?php echo !empty($nomeErro)?'error ' : '';?>">
                            <label class="control-label">Cód. Item</label>
                            <div class="controls">
                                <input size= "50" name="item" type="text" placeholder="Item" required="" value="<?php echo !empty($item)?$item: '';?>">
                                <?php if(!empty($itemErro)): ?>
                                    <span class="help-inline"><?php echo $itemErro;?></span>
                                <?php endif;?>
                            </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($descricaoErro)?'error ': '';?>">
                            <label class="control-label">Descrição do Item</label>
                            <div class="controls">
                                <input size="80" name="descricao" type="text" placeholder="descricao" required="" value="<?php echo !empty($descricao)?$descricao: '';?>">
                                <?php if(!empty($descricaoErro)): ?>
                                <span class="help-inline"><?php echo $descricaoErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        
                        <div class="control-group <?php echo !empty($unErro)?'error ': '';?>">
                            <label class="control-label">Unidade de Medida</label>
                            <div class="controls">
                                <input size="35" name="un" type="text" placeholder="Unidade de Medida" required="" value="<?php echo !empty($un)?$un: '';?>">
                                <?php if(!empty($unErro)): ?>
                                <span class="help-inline"><?php echo $unErro;?></span>
                                <?php endif;?>
                        </div>
                        </div>
                        <div class="form-actions">
                            <br/>
                
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                        
                        </div>
                    </form>
                </div>
        </div>
    </body>
</html>


<?php
    require 'banco.php';
    
    if(!empty($_POST))
    {
        //Acompanha os erros de validação
        $itemErro = null;
        $descricaoErro = null;
        $unErro = null;
        
        $item = $_POST['item'];
        $descricao = $_POST['descricao'];
        $un = $_POST['un'];
        
        //Validaçao dos campos:
        $validacao = true;
        if(empty($item))
        {
            $itenErro = 'Por favor digite o código do item!';
            $validacao = false;
        }
        
        if(empty($descricao))
        {
            $descricaoErro = 'Por favor digite a descricão do item!';
            $validacao = false;
        }
        
        if(empty($un))
        {
            $unErro = 'Por favor digite a unidade de medida!';
            $validacao = false;
        }
                
        //Inserindo no Banco:
        if($validacao)
        {
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO item (cditem, nmitem, nmum) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($item,$descricao,$un));
            Banco::desconectar();
            header("Location: index.php");
        }
    }
?>
