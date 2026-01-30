<?php
include '../../../header.php';

// Récupération du mot-clé à modifier
if(isset($_GET['numMotCle'])){
    $numMotCle = $_GET['numMotCle'];
    $motcle = sql_select("MOTCLE", "*", "numMotCle = $numMotCle")[0];
    $libMotCle = $motcle['libMotCle'];
}
?>

<!-- Bootstrap form to edit a mot-clé -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit a mot-clé -->
            <form action="<?php echo ROOT_URL . '/api/keywords/update.php' ?>" method="post">
                <!-- Hidden input for numMotCle -->
                <input id="numMotCle" name="numMotCle" type="hidden" value="<?php echo($numMotCle); ?>" />
                
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" autofocus="autofocus" required />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-warning">Confirmer modification ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../../footer.php';
?>