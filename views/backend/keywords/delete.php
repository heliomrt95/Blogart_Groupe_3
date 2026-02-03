<?php
// Inclusion du fichier header qui contient le layout général et l'accès à la configuration
include '../../../header.php';

// Vérification que l'ID du mot-clé est présent en paramètre GET
if(isset($_GET['numMotCle'])){
    // Récupération de l'ID du mot-clé à partir de l'URL
    $numMotCle = $_GET['numMotCle'];
    // Requête pour récupérer le libellé du mot-clé correspondant à cet ID
    $libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $numMotCle")[0]['libMotCle'];
}
?>

<!-- Structure Bootstrap pour afficher le formulaire de suppression -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page -->
            <h1>Suppression Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire de suppression d'un mot-clé qui envoie les données à l'API -->
            <form action="<?php echo ROOT_URL . '/api/keywords/delete.php' ?>" method="post">
                <!-- Groupe de formulaire affichant le mot-clé à supprimer -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Champ caché contenant l'ID du mot-clé à supprimer -->
                    <input id="numMotCle" name="numMotCle" class="form-control" style="display: none" type="text" value="<?php echo($numMotCle); ?>" readonly="readonly" />
                    <!-- Champ affichant le libellé du mot-clé en lecture seule -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" readonly="readonly" disabled />
                </div>
                <br />
                <!-- Groupe de boutons : retour à la liste et confirmation de la suppression -->
                <div class="form-group mt-2">
                    <!-- Lien pour retourner à la liste des mots-clés -->
                    <a href="list.php" class="btn btn-primary">List</a>
                    <!-- Bouton pour soumettre le formulaire et supprimer le mot-clé -->
                    <button type="submit" class="btn btn-danger">Confirmer delete ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du fichier footer qui contient la fermeture du layout général
include '../../../footer.php';
?>