<?php
include '../../../header.php';
?>

<!-- Bootstrap form to create a new thematic -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouvelle Thématique</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new thematic -->
            <form action="<?php echo ROOT_URL . '/api/thematiques/create.php' ?>" method="post">
                <div class="form-group">
                    <label for="libStat">Libellé</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" autofocus="autofocus" />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Confirmer create ?</button>
                </div>
            </form>
        </div>
    </div>
</div>