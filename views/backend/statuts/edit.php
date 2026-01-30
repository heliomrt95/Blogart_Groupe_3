<?php
include '../../../header.php';

// Récupération du statut à modifier
if(isset($_GET['numStat'])){
    $numStat = $_GET['numStat'];
    $statut = sql_select("STATUT", "*", "numStat = $numStat")[0];
    $libStat = $statut['libStat'];
}
?>

<!-- Bootstrap form to edit a statut -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Statut</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit a statut -->
            <form action="<?php echo ROOT_URL . '/api/statuts/update.php' ?>" method="post">
                <!-- Hidden input for numStat -->
                <input id="numStat" name="numStat" type="hidden" value="<?php echo($numStat); ?>" />
                
                <div class="form-group">
                    <label for="libStat">Nom du statut</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo($libStat); ?>" autofocus="autofocus" required />
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