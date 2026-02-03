<?php
include '../../../header.php';

// Récupération de l'article à modifier
if(isset($_GET['numArt'])){
    $numArt = $_GET['numArt'];
    $article = sql_select("ARTICLE", "*", "numArt = $numArt")[0];
}

// Charger toutes les thématiques pour la listbox
$thematiques = sql_select("THEMATIQUE", "*");
?>

<!-- Bootstrap form to edit an article -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit an article -->
            <form action="<?php echo ROOT_URL . '/api/articles/update.php' ?>" method="post" enctype="multipart/form-data">
                <!-- Hidden input for numArt -->
                <input id="numArt" name="numArt" type="hidden" value="<?php echo($article['numArt']); ?>" />
                
                <!-- Titre -->
                <div class="form-group mb-3">
                    <label for="libTitrArt">Titre de l'article <span class="text-danger">*</span></label>
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" maxlength="100" value="<?php echo($article['libTitrArt']); ?>" autofocus="autofocus" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Chapeau -->
                <div class="form-group mb-3">
                    <label for="libChapoArt">Chapeau <span class="text-danger">*</span></label>
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" rows="4" maxlength="500" required><?php echo($article['libChapoArt']); ?></textarea>
                    <small class="form-text text-muted">Maximum 500 caractères</small>
                </div>

                <!-- Accroche -->
                <div class="form-group mb-3">
                    <label for="libAccrochArt">Accroche <span class="text-danger">*</span></label>
                    <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" maxlength="100" value="<?php echo($article['libAccrochArt']); ?>" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 1 -->
                <div class="form-group mb-3">
                    <label for="parag1Art">Paragraphe 1 <span class="text-danger">*</span></label>
                    <textarea id="parag1Art" name="parag1Art" class="form-control" rows="6" maxlength="1200" required><?php echo($article['parag1Art']); ?></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Sous-titre 1 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr1Art">Sous-titre 1 <span class="text-danger">*</span></label>
                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" maxlength="100" value="<?php echo($article['libSsTitr1Art']); ?>" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 2 -->
                <div class="form-group mb-3">
                    <label for="parag2Art">Paragraphe 2 <span class="text-danger">*</span></label>
                    <textarea id="parag2Art" name="parag2Art" class="form-control" rows="6" maxlength="1200" required><?php echo($article['parag2Art']); ?></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Sous-titre 2 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr2Art">Sous-titre 2 <span class="text-danger">*</span></label>
                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" maxlength="100" value="<?php echo($article['libSsTitr2Art']); ?>" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 3 -->
                <div class="form-group mb-3">
                    <label for="parag3Art">Paragraphe 3 <span class="text-danger">*</span></label>
                    <textarea id="parag3Art" name="parag3Art" class="form-control" rows="6" maxlength="1200" required><?php echo($article['parag3Art']); ?></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Conclusion -->
                <div class="form-group mb-3">
                    <label for="libConclArt">Conclusion <span class="text-danger">*</span></label>
                    <textarea id="libConclArt" name="libConclArt" class="form-control" rows="4" maxlength="800" required><?php echo($article['libConclArt']); ?></textarea>
                    <small class="form-text text-muted">Maximum 800 caractères</small>
                </div>

                <!-- Thématique (Listbox) -->
                <div class="form-group mb-3">
                    <label for="numThem">Thématique <span class="text-danger">*</span></label>
                    <select id="numThem" name="numThem" class="form-control" required>
                        <option value="">-- Choisissez une thématique --</option>
                        <?php foreach($thematiques as $thematique){ ?>
                            <option value="<?php echo($thematique['numThem']); ?>" 
                                <?php echo ($thematique['numThem'] == $article['numThem']) ? 'selected' : ''; ?>>
                                <?php echo($thematique['libThem']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Image actuelle -->
                <?php if(!empty($article['urlPhotArt'])){ ?>
                <div class="form-group mb-3">
                    <label>Image actuelle :</label><br>
                    <img src="<?php echo ROOT_URL . '/src/uploads/' . $article['urlPhotArt']; ?>" 
                         alt="Image article" 
                         class="img-thumbnail" 
                         style="max-width: 300px;">
                    <input type="hidden" name="oldImage" value="<?php echo($article['urlPhotArt']); ?>">
                </div>
                <?php } ?>

                <!-- Upload nouvelle Image (optionnel en modification) -->
                <div class="form-group mb-3">
                    <label for="urlPhotArt">Nouvelle image (laisser vide pour conserver l'actuelle)</label>
                    <input id="urlPhotArt" name="urlPhotArt" class="form-control" type="file" accept="image/jpeg,image/jpg,image/png,image/gif" />
                    <small class="form-text text-muted">Formats acceptés : JPG, JPEG, PNG, GIF</small>
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