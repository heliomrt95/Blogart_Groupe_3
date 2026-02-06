<?php
// Inclusion du header commun : initialise l'environnement, sessions, et charge le layout
include '../../../header.php';

// Vérifie si l'identifiant du mot-clé est présent dans la query string
if(isset($_GET['numMotCle'])){
    // Récupération et utilisation brute de la valeur GET (cast possible côté API)
    $numMotCle = $_GET['numMotCle'];
    // Récupère le libellé du mot-clé via la fonction utilitaire `sql_select`
    // On suppose que `sql_select` renvoie un tableau de résultats ; on prend le premier élément
    $libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $numMotCle")[0]['libMotCle'];
}
?>

<!-- Conteneur Bootstrap principal pour la page de suppression -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Titre de la page de suppression -->
            <h1>Suppression Mot-clé</h1>
        </div>
        <div class="col-md-12">
            <!-- Formulaire POST vers l'API de suppression des mots-clés -->
            <form action="<?php echo ROOT_URL . '/api/keywords/delete.php' ?>" method="post">
                <!-- Affiche le libellé du mot-clé et contient l'ID en champ caché -->
                <div class="form-group">
                    <label for="libMotCle">Libellé du mot-clé</label>
                    <!-- Champ caché contenant l'ID : envoyé à l'API pour identifier l'enregistrement -->
                    <input id="numMotCle" name="numMotCle" class="form-control" style="display: none" type="text" value="<?php echo($numMotCle); ?>" readonly="readonly" />
                    <!-- Champ affichant le libellé en lecture seule pour confirmation visuelle -->
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" readonly="readonly" disabled />
                </div>
                <br />
                <!-- Actions : retour ou confirmation de la suppression -->
                <div class="form-group mt-2">
                    <!-- Retour à la liste des mots-clés sans effectuer d'action -->
                    <a href="list.php" class="btn btn-primary">Liste</a>
                    <!-- Envoi du formulaire : l'API doit traiter la suppression côté serveur -->
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Inclusion du footer commun : ferme le layout et charge les scripts JS partagés
include '../../../footer.php';
?>