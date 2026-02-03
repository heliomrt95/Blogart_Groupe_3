<?php
// Inclusion du fichier header qui contient le layout général et l'accès à la configuration
include '../../../header.php';

// Vérification que l'ID du mot-clé est présent en paramètre GET
if(isset($_GET['numMotCle'])){
    // Récupération de l'ID du mot-clé à partir de l'URL
    $numMotCle = $_GET['numMotCle'];
    // Requête pour récupérer le mot-clé correspondant à cet ID
    $motcle = sql_select("MOTCLE", "*", "numMotCle = $numMotCle")[0];
    // Extraction du libellé du mot-clé pour le pré-remplir dans le formulaire
    $libMotCle = $motcle['libMotCle'];
}
?>

<!-- Structure Bootstrap pour afficher le formulaire de modification -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page -->
            <h1>Modification Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire d'édition d'un mot-clé qui envoie les données à l'API -->
            <form action="<?php echo ROOT_URL . '/api/keywords/update.php' ?>" method="post">
                <!-- Champ caché pour transmettre l'ID du mot-clé à l'API -->
                <input id="numMotCle" name="numMotCle" type="hidden" value="<?php echo($numMotCle); ?>" />
                
                <!-- Groupe de formulaire pour le libellé du mot-clé -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Champ texte pré-rempli avec la valeur actuelle du mot-clé -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" autofocus="autofocus" required />
                </div>
                <br />
                <!-- Groupe de boutons : retour à la liste et confirmation de la modification -->
                <div class="form-group mt-2">
                    <!-- Lien pour retourner à la liste des mots-clés -->
                    <a href="list.php" class="btn btn-primary">List</a>
                    <!-- Bouton pour soumettre le formulaire et mettre à jour le mot-clé -->
                    <button type="submit" class="btn btn-warning">Confirmer modification ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du fichier footer qui contient la fermeture du layout général
include '../../../footer.php';
?>