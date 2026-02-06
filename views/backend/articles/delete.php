<?php
include '../../../header.php';

// Récupération de l'article à supprimer
if(isset($_GET['numArt'])){
    $numArt = $_GET['numArt'];
    
    // Récupération article avec thématique
    $article = sql_select("ARTICLE a 
              LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem",
               "a.*, t.libThem", "a.numArt = $numArt");
    $article = $article[0];
}

?>

<!-- Bootstrap form to delete an article -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to delete an article -->
            <form action="<?php echo ROOT_URL . '/api/articles/delete.php' ?>" method="post">
                <input id="numArt" name="numArt" type="hidden" value="<?php echo($article['numArt']); ?>" />
                <input id="urlPhotArt" name="urlPhotArt" type="hidden" value="<?php echo($article['urlPhotArt']); ?>" />
                
                <!-- Titre -->
                <div class="form-group mb-3">
                    <label for="libTitrArt">Titre de l'article</label>
                    <input id="libTitrArt" class="form-control" type="text" value="<?php echo($article['libTitrArt']); ?>" disabled />
                </div>

                <!-- Chapeau -->
                <div class="form-group mb-3">
                    <label for="libChapoArt">Chapeau</label>
                    <textarea id="libChapoArt" class="form-control" rows="4" disabled><?php echo($article['libChapoArt']); ?></textarea>
                </div>

                <!-- Accroche -->
                <div class="form-group mb-3">
                    <label for="libAccrochArt">Accroche</label>
                    <input id="libAccrochArt" class="form-control" type="text" value="<?php echo($article['libAccrochArt']); ?>" disabled />
                </div>

                <!-- Paragraphe 1 -->
                <div class="form-group mb-3">
                    <label for="parag1Art">Paragraphe 1</label>
                    <textarea id="parag1Art" class="form-control" rows="6" disabled><?php echo($article['parag1Art']); ?></textarea>
                </div>

                <!-- Sous-titre 1 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr1Art">Sous-titre 1</label>
                    <input id="libSsTitr1Art" class="form-control" type="text" value="<?php echo($article['libSsTitr1Art']); ?>" disabled />
                </div>

                <!-- Paragraphe 2 -->
                <div class="form-group mb-3">
                    <label for="parag2Art">Paragraphe 2</label>
                    <textarea id="parag2Art" class="form-control" rows="6" disabled><?php echo($article['parag2Art']); ?></textarea>
                </div>

                <!-- Sous-titre 2 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr2Art">Sous-titre 2</label>
                    <input id="libSsTitr2Art" class="form-control" type="text" value="<?php echo($article['libSsTitr2Art']); ?>" disabled />
                </div>

                <!-- Paragraphe 3 -->
                <div class="form-group mb-3">
                    <label for="parag3Art">Paragraphe 3</label>
                    <textarea id="parag3Art" class="form-control" rows="6" disabled><?php echo($article['parag3Art']); ?></textarea>
                </div>

                <!-- Conclusion -->
                <div class="form-group mb-3">
                    <label for="libConclArt">Conclusion</label>
                    <textarea id="libConclArt" class="form-control" rows="4" disabled><?php echo($article['libConclArt']); ?></textarea>
                </div>

                <!-- Thématique -->
                <div class="form-group mb-3">
                    <label for="libThem">Thématique</label>
                    <input id="libThem" class="form-control" type="text" value="<?php echo($article['libThem']); ?>" disabled />
                </div>

                <!-- Image -->
                <?php if(!empty($article['urlPhotArt'])){ ?>
                <div class="form-group mb-3">
                    <label>Image de l'article :</label><br>
                    <img src="<?php echo ROOT_URL . '/src/uploads/' . $article['urlPhotArt']; ?>" 
                         alt="Image article" 
                         class="img-thumbnail" 
                         style="max-width: 300px;">
                </div>
                <?php } ?>

                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-danger">Confirmer delete ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../../footer.php';
?>