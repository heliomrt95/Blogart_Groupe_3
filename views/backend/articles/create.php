<?php
include '../../../header.php';

// Charger toutes les thématiques pour le select
$thematiques = sql_select("THEMATIQUE", "*");
// Charger tous les mots-clés disponibles
$motscles = sql_select("MOTCLE", "*");
?>

<!-- Bootstrap form to create a new article -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouvel Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new article -->
            <form action="<?php echo ROOT_URL . '/api/articles/create.php' ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="libTitrArt">Titre de l'article *</label>
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" required />
                </div>

                <div class="form-group">
                    <label for="libChapoArt">Chapeau (résumé) *</label>
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="libAccrochArt">Accroche paragraphe 1</label>
                    <input id="libAccrochArt" name="libAccrochArt" class="form-control" type="text" />
                </div>

                <div class="form-group">
                    <label for="parag1Art">Paragraphe 1</label>
                    <textarea id="parag1Art" name="parag1Art" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="libSsTitr1Art">Titre sous-titre 1</label>
                    <input id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" type="text" />
                </div>

                <div class="form-group">
                    <label for="parag2Art">Paragraphe 2</label>
                    <textarea id="parag2Art" name="parag2Art" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="libSsTitr2Art">Titre sous-titre 2</label>
                    <input id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" type="text" />
                </div>

                <div class="form-group">
                    <label for="parag3Art">Paragraphe 3</label>
                    <textarea id="parag3Art" name="parag3Art" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label for="libConclArt">Conclusion</label>
                    <textarea id="libConclArt" name="libConclArt" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="urlPhotArt">Photo de l'article</label>
                    <input id="urlPhotArt" name="urlPhotArt" class="form-control" type="file" accept="image/*" />
                </div>

                <div class="form-group">
                    <label for="numThem">Thématique *</label>
                    <select id="numThem" name="numThem" class="form-control" required>
                        <option value="">-- Sélectionner une thématique --</option>
                        <?php foreach($thematiques as $thematique){ ?>
                            <option value="<?php echo($thematique['numThem']); ?>">
                                <?php echo($thematique['libThem']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Gestion des mots-clés -->
                <div class="form-group">
                    <label>Choisissez les mots clés liés à l'article :</label>
                    <div class="row">
                        <!-- Colonne gauche : Liste des mots-clés disponibles -->
                        <div class="col-md-4">
                            <label for="motscles_disponibles"><strong>Liste Mots clés</strong></label>
                            <select id="motscles_disponibles" class="form-control" style="height: 200px;" multiple size="10">
                                <option disabled>-- Choisissez un mot clé --</option>
                                <?php foreach($motscles as $motcle){ ?>
                                    <option value="<?php echo($motcle['numMotCle']); ?>">
                                        <?php echo($motcle['libMotCle']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Colonne centre : Boutons de déplacement -->
                        <div class="col-md-4 d-flex flex-column justify-content-center">
                            <button type="button" class="btn btn-secondary mb-2" onclick="ajouterMotCle()">
                                Ajoutez >>
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="supprimerMotCle()">
                                << Supprimez
                            </button>
                        </div>

                        <!-- Colonne droite : Mots-clés ajoutés -->
                        <div class="col-md-4">
                            <label for="motscles_choisis"><strong>Mots clés ajoutés</strong></label>
                            <select id="motscles_choisis" name="motscles_choisis[]" class="form-control" style="height: 200px;" multiple size="10">
                                <!-- Les mots-clés sélectionnés s'afficheront ici -->
                            </select>
                        </div>
                    </div>
                </div>

                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Créer l'article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fonction pour ajouter les mots-clés sélectionnés de la colonne gauche vers la droite
function ajouterMotCle() {
    const selectDisponibles = document.getElementById('motscles_disponibles');
    const selectChoisis = document.getElementById('motscles_choisis');
    
    // Récupérer les options sélectionnées dans la colonne de gauche
    Array.from(selectDisponibles.selectedOptions).forEach(option => {
        // Vérifier que le mot n'existe pas déjà dans la colonne de droite
        const exists = Array.from(selectChoisis.options).some(opt => opt.value === option.value);
        if (!exists) {
            // Ajouter à la colonne de droite
            const newOption = new Option(option.text, option.value);
            selectChoisis.appendChild(newOption);
        }
        // Supprimer de la colonne de gauche
        option.remove();
    });
}

// Fonction pour retirer les mots-clés sélectionnés de la colonne droite vers la gauche
function supprimerMotCle() {
    const selectDisponibles = document.getElementById('motscles_disponibles');
    const selectChoisis = document.getElementById('motscles_choisis');
    
    // Récupérer les options sélectionnées dans la colonne de droite
    Array.from(selectChoisis.selectedOptions).forEach(option => {
        // Vérifier que le mot n'existe pas déjà dans la colonne de gauche
        const exists = Array.from(selectDisponibles.options).some(opt => opt.value === option.value);
        if (!exists) {
            // Ajouter à la colonne de gauche
            const newOption = new Option(option.text, option.value);
            selectDisponibles.appendChild(newOption);
        }
        // Supprimer de la colonne de droite
        option.remove();
    });
}
</script>

<script>
// Fonction pour supprimer un mot-clé de la liste des mots-clés disponibles (colonne de gauche)
function supprimerMotCle() {
    const selectDisponibles = document.getElementById('motscles_disponibles');
    
    // Supprimer les options sélectionnées dans la colonne de gauche
    Array.from(selectDisponibles.selectedOptions).forEach(option => {
        option.remove();
    });
}
</script>
<?php
include '../../../footer.php';