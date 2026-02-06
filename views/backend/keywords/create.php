<?php
// Inclusion du header commun
// Ce fichier inclut généralement l'initialisation, les sessions, le menu, et les CSS/JS partagés
include '../../../header.php';
?>

<!-- Conteneur principal (Bootstrap) pour le formulaire de création d'un mot-clé -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre principal de la page -->
            <h1>Création nouveau Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire HTML envoyant les données en POST vers l'API de création
                 - `action` : URL complète construite à partir de la constante ROOT_URL
                 - `method="post"` : envoie des données de manière non exposée dans l'URL -->
            <form action="<?php echo ROOT_URL . '/api/keywords/create.php' ?>" method="post">
                <!-- Champ pour saisir le libellé du mot-clé -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Input texte :
                         - `id`/`name` utilisés côté serveur pour récupérer la valeur
                         - `autofocus` positionne le curseur automatiquement
                         - `required` empêche la soumission si vide -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" autofocus="autofocus" required />
                </div>
                <br />
                <!-- Boutons d'action : retour à la liste ou soumission du formulaire -->
                <div class="form-group mt-2">
                    <!-- Lien vers la page list.php qui affiche tous les mots-clés -->
                    <a href="list.php" class="btn btn-primary">Liste</a>
                    <!-- Bouton pour soumettre le formulaire. Texte clair pour confirmer la création -->
                    <button type="submit" class="btn btn-success">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du footer commun : contient généralement la fermeture des balises, scripts JS et autres éléments partagés
include '../../../footer.php';
?>