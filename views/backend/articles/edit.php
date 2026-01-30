<?php
// Include the main header/navigation file
include '../../../header.php';

// Vérifier si un ID d'article est fourni via l'URL (GET)
if(isset($_GET['numArt'])){
    $numArt = $_GET['numArt'];
    // Récupérer TOUS les champs de l'article depuis la base de données pour pré-remplir le formulaire
    $article = sql_select("ARTICLE", "*", "numArt = $numArt")[0];
}

// Charger toutes les thématiques disponibles pour le select dropdown
$thematiques = sql_select("THEMATIQUE", "*");
// Charger tous les mots-clés disponibles dans la base de données
$motscles = sql_select("MOTCLE", "*");
// Charger les mots-clés associés à CET article spécifique
$motscles_article = sql_select("MOTCLEARTICLE", "*", "numArt = $numArt");
// Extraire les IDs des mots-clés associés pour les exclure de la colonne de gauche
$motscles_ids = array_map(function($mc) { return $mc['numMotCle']; }, $motscles_article);
?>

<!-- Page d'édition d'un article avec interface similaire au formulaire de création -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Édition Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire d'édition enctype="multipart/form-data" pour gérer les uploads de fichiers -->
            <form action="<?php echo ROOT_URL . '/api/articles/edit.php' ?>" method="post" enctype="multipart/form-data">
                
                <!-- Champ caché contenant l'ID de l'article à éditer -->
                <input type="hidden" name="numArt" value="<?php echo $numArt; ?>" />
                
                <!-- Titre de l'article (champ requis) -->
                <div class="form-group">
                    <label for="libTitrArt">Titre de l'article *</label>
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" required />
                </div>

                <!-- Chapeau / résumé de l'article (champ requis) -->
                <div class="form-group">
                    <label for="libChapoArt">Chapeau (résumé) *</label>
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" rows="3" required><?php echo htmlspecialchars($article['libChapoArt']); ?></textarea>
                </div>

                <!-- Accroche du premier paragraphe -->
                <div class="form-group">
                    <label for="libAccrochArt">Accroche paragraphe 1</label>
                    <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libAccrochArt']); ?>" />
                </div>

                <!-- Contenu du premier paragraphe -->
                <div class="form-group">
                    <label for="parag1Art">Paragraphe 1</label>
                    <textarea id="parag1Art" name="parag1Art" class="form-control" rows="4"><?php echo htmlspecialchars($article['parag1Art']); ?></textarea>
                </div>

                <!-- Titre du premier sous-titre -->
                <div class="form-group">
                    <label for="libSsTitr1Art">Titre sous-titre 1</label>
                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libSsTitr1Art']); ?>" />
                </div>

                <!-- Contenu du deuxième paragraphe -->
                <div class="form-group">
                    <label for="parag2Art">Paragraphe 2</label>
                    <textarea id="parag2Art" name="parag2Art" class="form-control" rows="4"><?php echo htmlspecialchars($article['parag2Art']); ?></textarea>
                </div>

                <!-- Titre du deuxième sous-titre -->
                <div class="form-group">
                    <label for="libSsTitr2Art">Titre sous-titre 2</label>
                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libSsTitr2Art']); ?>" />
                </div>

                <!-- Contenu du troisième paragraphe -->
                <div class="form-group">
                    <label for="parag3Art">Paragraphe 3</label>
                    <textarea id="parag3Art" name="parag3Art" class="form-control" rows="4"><?php echo htmlspecialchars($article['parag3Art']); ?></textarea>
                </div>

                <!-- Conclusion de l'article -->
                <div class="form-group">
                    <label for="libConclArt">Conclusion</label>
                    <textarea id="libConclArt" name="libConclArt" class="form-control" rows="3"><?php echo htmlspecialchars($article['libConclArt']); ?></textarea>
                </div>

                <!-- Gestion de la photo de l'article -->
                <div class="form-group">
                    <label for="urlPhotArt">Photo de l'article</label>
                    <!-- Afficher l'image actuelle si elle existe -->
                    <?php if($article['urlPhotArt']): ?>
                        <div class="mb-2">
                            <p><strong>Image actuelle :</strong></p>
                            <img src="<?php echo htmlspecialchars($article['urlPhotArt']); ?>" style="max-width: 300px;" alt="Article image" />
                        </div>
                    <?php endif; ?>
                    <!-- Input file pour uploader une nouvelle photo (optionnel) -->
                    <input id="urlPhotArt" name="urlPhotArt" class="form-control" type="file" accept="image/*" />
                </div>

                <!-- Sélection de la thématique associée à l'article -->
                <div class="form-group">
                    <label for="numThem">Thématique *</label>
                    <select id="numThem" name="numThem" class="form-control" required>
                        <option value="">-- Sélectionner une thématique --</option>
                        <?php foreach($thematiques as $thematique){ ?>
                            <!-- Pré-sélectionner la thématique de l'article actuel -->
                            <option value="<?php echo($thematique['numThem']); ?>" <?php echo $thematique['numThem'] == $article['numThem'] ? 'selected' : ''; ?>>
                                <?php echo($thematique['libThem']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Section de gestion des mots-clés de l'article -->
                <!-- Utilise deux colonnes : disponibles (gauche) et sélectionnés (droite) -->
                <div class="form-group">
                    <label>Choisissez les mots clés liés à l'article :</label>
                    <div class="row">
                        <!-- COLONNE GAUCHE : Mots-clés disponibles (non encore associés) -->
                        <div class="col-md-4">
                            <label for="motscles_disponibles"><strong>Liste Mots clés</strong></label>
                            <!-- Select multiple (hauteur 200px) pour afficher plusieurs mots-clés -->
                            <select id="motscles_disponibles" class="form-control" style="height: 200px;" multiple size="10">
                                <option disabled>-- Choisissez un mot clé --</option>
                                <!-- Boucle sur TOUS les mots-clés -->
                                <?php foreach($motscles as $motcle){ 
                                    // Filtrer : ne pas afficher les mots-clés déjà associés à cet article
                                    if(!in_array($motcle['numMotCle'], $motscles_ids)) { ?>
                                    <option value="<?php echo($motcle['numMotCle']); ?>">
                                        <?php echo($motcle['libMotCle']); ?>
                                    </option>
                                <?php } } ?>
                            </select>
                        </div>

                        <!-- COLONNE CENTRE : Boutons bidirectionnels de déplacement -->
                        <div class="col-md-4 d-flex flex-column justify-content-center">
                            <!-- Bouton pour ajouter un mot-clé de la gauche vers la droite -->
                            <button type="button" class="btn btn-secondary mb-2" onclick="ajouterMotCle()">
                                Ajoutez >>
                            </button>
                            <!-- Bouton pour supprimer un mot-clé de la droite vers la gauche -->
                            <button type="button" class="btn btn-secondary" onclick="supprimerMotCle()">
                                << Supprimez
                            </button>
                        </div>

                        <!-- COLONNE DROITE : Mots-clés sélectionnés pour cet article -->
                        <div class="col-md-4">
                            <label for="motscles_choisis"><strong>Mots clés ajoutés</strong></label>
                            <!-- Select multiple avec name="motscles_choisis[]" pour envoi en tableau au serveur -->
                            <select id="motscles_choisis" name="motscles_choisis[]" class="form-control" style="height: 200px;" multiple size="10">
                                <!-- Pré-populate avec les mots-clés ACTUELLEMENT associés à cet article -->
                                <?php foreach($motscles_article as $mc){
                                    // Pour chaque association, récupérer le label du mot-clé
                                    $motcle = sql_select("MOTCLE", "*", "numMotCle = " . $mc['numMotCle'])[0];
                                    echo '<option value="' . $motcle['numMotCle'] . '">' . htmlspecialchars($motcle['libMotCle']) . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br />
                <!-- Boutons de contrôle du formulaire -->
                <div class="form-group mt-2">
                    <!-- Lien pour retourner à la liste des articles -->
                    <a href="list.php" class="btn btn-primary">List</a>
                    <!-- Bouton pour soumettre le formulaire d'édition -->
                    <button type="submit" class="btn btn-warning">Confirmer Edit ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ========== GESTION BIDIRECTIONNELLE DES MOTS-CLÉS ==========
// Ces deux fonctions gèrent le transfert de mots-clés entre la liste disponible et la liste sélectionnée

/**
 * ajouterMotCle() - Ajoute les mots-clés sélectionnés de GAUCHE (disponibles) vers DROITE (choisis)
 * - Récupère les options sélectionnées dans la liste de gauche (motscles_disponibles)
 * - Ajoute chaque option à la liste de droite (motscles_choisis) SI elle n'existe pas déjà
 * - Supprime l'option de la liste de gauche après ajout (nettoyage)
 * - Prévention des doublons : vérifie via Array.some() que l'option n'existe pas en droite
 */
function ajouterMotCle() {
    const selectDisponibles = document.getElementById('motscles_disponibles');
    const selectChoisis = document.getElementById('motscles_choisis');
    
    // Boucler sur les options SÉLECTIONNÉES dans la colonne gauche
    Array.from(selectDisponibles.selectedOptions).forEach(option => {
        // Vérifier si ce mot-clé existe déjà dans la colonne de droite pour éviter les doublons
        const exists = Array.from(selectChoisis.options).some(opt => opt.value === option.value);
        
        if (!exists) {
            // Créer une nouvelle option avec le même texte et valeur
            const newOption = new Option(option.text, option.value);
            // Ajouter à la liste de droite (sélectionnés)
            selectChoisis.appendChild(newOption);
        }
        // Supprimer l'option de la colonne gauche
        option.remove();
    });
}

/**
 * supprimerMotCle() - Enlève les mots-clés sélectionnés de DROITE (choisis) vers GAUCHE (disponibles)
 * - Récupère les options sélectionnées dans la liste de droite (motscles_choisis)
 * - Ajoute chaque option à la liste de gauche (motscles_disponibles) SI elle n'existe pas déjà
 * - Supprime l'option de la liste de droite après ajout (nettoyage)
 * - Prévention des doublons : vérifie via Array.some() que l'option n'existe pas en gauche
 */
function supprimerMotCle() {
    const selectDisponibles = document.getElementById('motscles_disponibles');
    const selectChoisis = document.getElementById('motscles_choisis');
    
    // Boucler sur les options SÉLECTIONNÉES dans la colonne droite
    Array.from(selectChoisis.selectedOptions).forEach(option => {
        // Vérifier si ce mot-clé existe déjà dans la colonne de gauche pour éviter les doublons
        const exists = Array.from(selectDisponibles.options).some(opt => opt.value === option.value);
        
        if (!exists) {
            // Créer une nouvelle option avec le même texte et valeur
            const newOption = new Option(option.text, option.value);
            // Ajouter à la liste de gauche (disponibles)
            selectDisponibles.appendChild(newOption);
        }
        // Supprimer l'option de la colonne droite
        option.remove();
    });
}
</script>

<?php
include '../../../footer.php';
?>
