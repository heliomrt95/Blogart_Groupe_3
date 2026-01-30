<?php
include '../../../header.php';

// Récupération de la thématique à modifier
if(isset($_GET['numThem'])){
    $numThem = $_GET['numThem'];
    $thematique = sql_select("THEMATIQUE", "*", "numThem = $numThem")[0];
    $libThem = $thematique['libThem'];
}
?>

<!-- Bootstrap form to edit a thematique -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Thématique</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit a thematique -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/update.php' ?>" method="post">
                <!-- Hidden input for numThem -->
                <input id="numThem" name="numThem" type="hidden" value="<?php echo($numThem); ?>" />
                
                <div class="form-group">
                    <label for="libThem">Nom de la thématique</label>
                    <input id="libThem" name="libThem" class="form-control" type="text" value="<?php echo($libThem); ?>" autofocus="autofocus" required />
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