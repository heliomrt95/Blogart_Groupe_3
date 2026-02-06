<?php
// Inclusion du header commun : initialise l'environnement, sessions, et charge le layout
include '../../../header.php';

// Vérifie si l'identifiant du mot-clé est présent dans la query string
if(isset($_GET['numMotCle'])){
    // Récupération de l'ID depuis l'URL (doit être validé côté API lors de la soumission)
    $numMotCle = $_GET['numMotCle'];
    // Requête utilitaire pour obtenir l'enregistrement complet du mot-clé
    $motcle = sql_select("MOTCLE", "*", "numMotCle = $numMotCle")[0];
    // Pré-remplit le libellé pour l'afficher dans le formulaire d'édition
    $libMotCle = $motcle['libMotCle'];
}
?>

<!-- Conteneur Bootstrap principal pour le formulaire d'édition -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page d'édition -->
            <h1>Modification Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire POST vers l'API de mise à jour des mots-clés -->
            <form action="<?php echo ROOT_URL . '/api/keywords/update.php' ?>" method="post">
                <!-- Champ caché contenant l'ID du mot-clé : nécessaire pour l'update côté serveur -->
                <input id="numMotCle" name="numMotCle" type="hidden" value="<?php echo($numMotCle); ?>" />
                
                <!-- Champ pour modifier le libellé du mot-clé -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Input texte pré-rempli avec la valeur actuelle ; `required` empêche l'envoi vide -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" autofocus="autofocus" required />
                </div>
                <br />
                <!-- Actions : retour à la liste ou confirmation de la modification -->
                <div class="form-group mt-2">
                    <!-- Lien pour revenir à la liste sans sauvegarder -->
                    <a href="list.php" class="btn btn-primary">Liste</a>
                    <!-- Bouton pour soumettre le formulaire et appeler l'API d'update -->
                    <button type="submit" class="btn btn-warning">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du footer commun : fermetures HTML, scripts partagés
include '../../../footer.php';
?>