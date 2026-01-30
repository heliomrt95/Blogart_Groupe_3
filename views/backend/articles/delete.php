<?php
// Include the main header/navigation file
include '../../../header.php';

// Vérifier si un ID d'article est fourni via l'URL (GET)
if(isset($_GET['numArt'])){
    $numArt = $_GET['numArt'];
    // Récupérer TOUS les champs de l'article depuis la base de données
    $article = sql_select("ARTICLE", "*", "numArt = $numArt")[0];
    // Récupérer la thématique associée à l'article
    $thematique = sql_select("THEMATIQUE", "*", "numThem = " . $article['numThem'])[0];
    // Récupérer tous les mots-clés associés à cet article
    $motscles_associes = sql_select("MOTCLEARTICLE", "*", "numArt = $numArt");
}
?>

<!-- Page de suppression d'un article affichant tous ses détails en lecture seule -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Alerte d'avertissement rouge pour informer de l'irréversibilité -->
            <div class="alert alert-danger" role="alert">
                <strong>Attention !</strong> Cette action est irréversible. Vous êtes sur le point de supprimer cet article.
            </div>

            <!-- Numéro de l'article (lecture seule) -->
            <div class="form-group">
                <label for="numArt">Numéro</label>
                <input id="numArt" name="numArt" class="form-control" type="text" value="<?php echo($numArt); ?>" readonly />
            </div>

            <!-- Titre de l'article (lecture seule) -->
            <div class="form-group">
                <label for="libTitrArt">Titre de l'article</label>
                <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" readonly />
            </div>

            <!-- Date de création (lecture seule) -->
            <div class="form-group">
                <label for="dtCreaArt">Date création</label>
                <input id="dtCreaArt" name="dtCreaArt" class="form-control" type="text" value="<?php echo($article['dtCreaArt']); ?>" readonly />
            </div>

            <!-- Chapeau / résumé (lecture seule) -->
            <div class="form-group">
                <label for="libChapoArt">Chapeau (résumé)</label>
                <textarea id="libChapoArt" name="libChapoArt" class="form-control" rows="3" readonly><?php echo htmlspecialchars($article['libChapoArt']); ?></textarea>
            </div>

            <!-- Accroche du premier paragraphe (lecture seule) -->
            <div class="form-group">
                <label for="libAccrochArt">Accroche paragraphe 1</label>
                <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libAccrochArt']); ?>" readonly />
            </div>

            <!-- Contenu du premier paragraphe (lecture seule) -->
            <div class="form-group">
                <label for="parag1Art">Paragraphe 1</label>
                <textarea id="parag1Art" name="parag1Art" class="form-control" rows="4" readonly><?php echo htmlspecialchars($article['parag1Art']); ?></textarea>
            </div>

            <!-- Titre du premier sous-titre (lecture seule) -->
            <div class="form-group">
                <label for="libSsTitr1Art">Titre sous-titre 1</label>
                <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libSsTitr1Art']); ?>" readonly />
            </div>

            <!-- Contenu du deuxième paragraphe (lecture seule) -->
            <div class="form-group">
                <label for="parag2Art">Paragraphe 2</label>
                <textarea id="parag2Art" name="parag2Art" class="form-control" rows="4" readonly><?php echo htmlspecialchars($article['parag2Art']); ?></textarea>
            </div>

            <!-- Titre du deuxième sous-titre (lecture seule) -->
            <div class="form-group">
                <label for="libSsTitr2Art">Titre sous-titre 2</label>
                <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libSsTitr2Art']); ?>" readonly />
            </div>

            <!-- Contenu du troisième paragraphe (lecture seule) -->
            <div class="form-group">
                <label for="parag3Art">Paragraphe 3</label>
                <textarea id="parag3Art" name="parag3Art" class="form-control" rows="4" readonly><?php echo htmlspecialchars($article['parag3Art']); ?></textarea>
            </div>

            <!-- Conclusion de l'article (lecture seule) -->
            <div class="form-group">
                <label for="libConclArt">Conclusion</label>
                <textarea id="libConclArt" name="libConclArt" class="form-control" rows="3" readonly><?php echo htmlspecialchars($article['libConclArt']); ?></textarea>
            </div>

            <!-- Thématique associée à l'article (lecture seule) -->
            <div class="form-group">
                <label for="numThem">Thématique</label>
                <input id="numThem" name="numThem" class="form-control" type="text" value="<?php echo htmlspecialchars($thematique['libThem']); ?>" readonly />
            </div>

            <!-- Section affichant les mots-clés associés à l'article -->
            <div class="form-group">
                <label>Mots-clés associés :</label>
                <!-- Select multiple désactivé pour affichage en lecture seule -->
                <select id="motscles_associes" class="form-control" multiple disabled style="height: 150px;">
                    <?php 
                    // Vérifier s'il y a des mots-clés associés
                    if(!empty($motscles_associes)){
                        // Boucler sur chaque association motclé-article
                        foreach($motscles_associes as $mc){
                            // Récupérer le libellé complet du mot-clé
                            $motcle = sql_select("MOTCLE", "*", "numMotCle = " . $mc['numMotCle'])[0];
                            // Afficher l'option avec protection XSS
                            echo '<option>' . htmlspecialchars($motcle['libMotCle']) . '</option>';
                        }
                    } else {
                        // Cas où aucun mot-clé n'est associé
                        echo '<option disabled>Aucun mot-clé</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Formulaire caché pour la suppression (POST sécurisé) -->
            <form action="<?php echo ROOT_URL . '/api/articles/delete.php' ?>" method="post">
                <!-- Champ caché contenant l'ID de l'article à supprimer -->
                <input type="hidden" name="numArt" value="<?php echo $numArt; ?>" />
                
                <br />
                <!-- Boutons d'action -->
                <div class="form-group mt-2">
                    <!-- Bouton "List" qui redirige vers la liste des articles -->
                    <a href="list.php" class="btn btn-primary">List</a>
                    
                    <!-- Bouton de suppression avec confirmation JavaScript -->
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Confirmer delete ?</button>
                </div>
            </form>
        </div>
    </div>
</div>
