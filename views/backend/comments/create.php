<?php
// Inclusion du header commun (affiche l'entête, initialise l'environnement)
include '../../../header.php';

// Récupère toutes les thématiques depuis la table THEMATIQUE
// Utilisé ensuite pour remplir la liste déroulante des thématiques
$thematiques = sql_select("THEMATIQUE", "*");

// Récupère tous les mots-clés (MOTCLE) triés par libellé
// Ces mots-clés seront affichés en cases à cocher
$motscles = sql_select("MOTCLE", "*", "", "libMotCle ASC");
?>

<!-- Bootstrap form to create a new article -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Création nouvel Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire POST vers l'API de création d'article
                 - `action` : URL de l'API qui traitera la création
                 - `enctype="multipart/form-data"` : requis pour l'upload d'images -->
            <form action="<?php echo ROOT_URL . '/api/articles/create.php' ?>" method="post" enctype="multipart/form-data">
                
                <!-- Titre -->
                <div class="form-group mb-3">
                    <label for="libTitrArt">Titre de l'article <span class="text-danger">*</span></label>
                    <!-- Input texte pour le titre, 100 caractères max, champ requis -->
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" maxlength="100" autofocus="autofocus" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Chapeau -->
                <div class="form-group mb-3">
                    <label for="libChapoArt">Chapeau <span class="text-danger">*</span></label>
                    <!-- Textarea pour le chapeau, court résumé affiché en haut de l'article -->
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" rows="4" maxlength="500" required></textarea>
                    <small class="form-text text-muted">Maximum 500 caractères</small>
                </div>

                <!-- Accroche -->
                <div class="form-group mb-3">
                    <label for="libAccrochArt">Accroche <span class="text-danger">*</span></label>
                    <!-- Brève phrase d'accroche de l'article -->
                    <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" maxlength="100" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 1 -->
                <div class="form-group mb-3">
                    <label for="parag1Art">Paragraphe 1 <span class="text-danger">*</span></label>
                    <!-- Premier paragraphe de contenu principal -->
                    <textarea id="parag1Art" name="parag1Art" class="form-control" rows="6" maxlength="1200" required></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Sous-titre 1 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr1Art">Sous-titre 1 <span class="text-danger">*</span></label>
                    <!-- Sous-titre lié au paragraphe 1 -->
                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" maxlength="100" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 2 -->
                <div class="form-group mb-3">
                    <label for="parag2Art">Paragraphe 2 <span class="text-danger">*</span></label>
                    <!-- Deuxième paragraphe de contenu principal -->
                    <textarea id="parag2Art" name="parag2Art" class="form-control" rows="6" maxlength="1200" required></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Sous-titre 2 -->
                <div class="form-group mb-3">
                    <label for="libSsTitr2Art">Sous-titre 2 <span class="text-danger">*</span></label>
                    <!-- Sous-titre lié au paragraphe 2 -->
                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" maxlength="100" required />
                    <small class="form-text text-muted">Maximum 100 caractères</small>
                </div>

                <!-- Paragraphe 3 -->
                <div class="form-group mb-3">
                    <label for="parag3Art">Paragraphe 3 <span class="text-danger">*</span></label>
                    <!-- Troisième paragraphe de contenu principal -->
                    <textarea id="parag3Art" name="parag3Art" class="form-control" rows="6" maxlength="1200" required></textarea>
                    <small class="form-text text-muted">Maximum 1200 caractères</small>
                </div>

                <!-- Conclusion -->
                <div class="form-group mb-3">
                    <label for="libConclArt">Conclusion <span class="text-danger">*</span></label>
                    <!-- Conclusion ou résumé final de l'article -->
                    <textarea id="libConclArt" name="libConclArt" class="form-control" rows="4" maxlength="800" required></textarea>
                    <small class="form-text text-muted">Maximum 800 caractères</small>
                </div>

                <!-- Thématique (Listbox) -->
                <div class="form-group mb-3">
                    <label for="numThem">Thématique <span class="text-danger">*</span></label>
                    <label for="numThem">Thématique <span class="text-danger">*</span></label>
                    <!-- Liste déroulante : on propose les thématiques chargées plus haut -->
                    <select id="numThem" name="numThem" class="form-control" required>
                        <option value="">-- Choisissez une thématique --</option>
                        <?php // Boucle PHP pour afficher chaque thématique disponible
                        foreach($thematiques as $thematique){ ?>
                            <option value="<?php echo($thematique['numThem']); ?>">
                                <?php echo($thematique['libThem']); // Libellé affiché de la thématique ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- ✅ MOTS-CLÉS (Checkboxes) -->
                <div class="form-group mb-3">
                    <label class="form-label fw-semibold">Mots-clés</label>
                    <small class="form-text text-muted d-block mb-3">
                        Sélectionnez un ou plusieurs mots-clés pour cet article
                    </small>
                    
                    <?php // Si des mots-clés existent, on affiche une grille de checkbox
                    if (count($motscles) > 0) { ?>
                        <div class="row">
                            <?php foreach($motscles as $motcle) { // Pour chaque mot-clé : afficher une case à cocher ?>
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="form-check">
                                        <!-- Checkbox : name `motscles[]` pour obtenir un tableau côté serveur -->
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="motscles[]" 
                                               value="<?php echo $motcle['numMotCle']; ?>" 
                                               id="motcle_<?php echo $motcle['numMotCle']; ?>">
                                        <label class="form-check-label" for="motcle_<?php echo $motcle['numMotCle']; ?>">
                                            <?php echo htmlspecialchars($motcle['libMotCle']); // Affiche le libellé sécurisé ?>
                                        </label>
                                    </div>
                                </div>
                            <?php } // fin foreach mots-clés ?>
                        </div>
                    <?php } else { // Aucun mot-clé trouvé : afficher un message d'alerte ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Aucun mot-clé disponible. Créez-en d'abord dans la gestion des mots-clés.
                        </div>
                    <?php } ?>
                </div>

                <!-- Upload Image -->
                <div class="form-group mb-3">
                    <label for="urlPhotArt">Image de l'article <span class="text-danger">*</span></label>
                    <label for="urlPhotArt">Image de l'article <span class="text-danger">*</span></label>
                    <!-- Input fichier pour l'image principale de l'article
                         - `accept` limite les types MIME acceptés côté client -->
                    <input id="urlPhotArt" name="urlPhotArt" class="form-control" type="file" accept="image/jpeg,image/jpg,image/png,image/gif" required />
                    <small class="form-text text-muted">Formats acceptés : JPG, JPEG, PNG, GIF</small>
                </div>

                <br />
                <div class="form-group mt-2">
                    <!-- Bouton retour vers la liste des articles -->
                    <a href="list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                    <!-- Bouton de soumission du formulaire (envoie les données à l'API) -->
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-2"></i>Créer l'article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du footer commun (pied de page, scripts) et fin du template
include '../../../footer.php';
?>