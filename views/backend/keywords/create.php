<?php
// Inclusion du fichier header qui contient le layout général et l'accès à la configuration
include '../../../header.php';
?>

<!-- Structure Bootstrap pour afficher le formulaire de création -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page -->
            <h1>Création nouveau Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire de création d'un nouveau mot-clé qui envoie les données à l'API -->
            <form action="<?php echo ROOT_URL . '/api/keywords/create.php' ?>" method="post">
                <!-- Groupe de formulaire pour le libellé du mot-clé -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Champ texte obligatoire pour saisir le libellé du mot-clé -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" autofocus="autofocus" required />
                </div>
                <br />
                <!-- Groupe de boutons : retour à la liste et confirmation de la création -->
                <div class="form-group mt-2">
                    <!-- Lien pour retourner à la liste des mots-clés -->
                    <a href="list.php" class="btn btn-primary">List</a>
                    <!-- Bouton pour soumettre le formulaire et créer le mot-clé -->
                    <button type="submit" class="btn btn-success">Confirmer create ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du fichier footer qui contient la fermeture du layout général
include '../../../footer.php';
?>