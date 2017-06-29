<?php
$id = $_GET['id'];
$subcat = $_GET['sub'];
?>

<select class="form-control" name="subCat<?=$subcat?>" id="subCat<?=$subcat?>">
    <option disabled="disabled" selected="selected">Selecione a Sub-Categoria</option>
    <?php
/*    $con = new PDO('mysql:host=localhost;dbname=disk', 'root', 'twincept');*/
    $con = new PDO('mysql:host=localhost;dbname=diskbras_site', 'diskbras_admin', '6o.@DdCLQq&J');
    $con->exec('set names utf8');
    $dados = $con->query("SELECT * FROM subcategorias WHERE idCat =".$id." ORDER by titulo");

    while($row = $dados->fetch(PDO::FETCH_OBJ)){
        echo '<option value="'.$row->id.'">'.$row->titulo.'</option>';
    }

    ?>
</select>