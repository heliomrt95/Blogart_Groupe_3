<?php
// Inclusion du header commun : entête, navigation et initialisation
include '../../../header.php';

// Récupère l'ID du commentaire passé en paramètre GET
// Cast en int pour limiter les risques d'injection via l'URL
$numCom = isset($_GET['numCom']) ? (int)$_GET['numCom'] : 0;

// Requête pour récupérer le commentaire et ses informations associées
// - c.* : toutes les colonnes du commentaire
// - m.pseudoMemb : pseudo de l'auteur depuis la table MEMBRE
// - a.libTitrArt : titre de l'article lié depuis la table ARTICLE
// LEFT JOINs utilisés pour ne pas perdre le commentaire si membre/article manquant
$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          WHERE c.numCom = $numCom";
          
// Utilisation de la connexion PDO globale
global $DB;
if(!$DB) sql_connect(); // ouvre la connexion si nécessaire
// Exécute la requête et récupère un seul enregistrement (ou false si introuvable)
$comment = $DB->query($query)->fetch(PDO::FETCH_ASSOC);

// Si aucun commentaire trouvé, on redirige vers la liste avec une alerte
if(!$comment) {
    echo "<script>alert('Commentaire introuvable.'); window.location.href='list.php';</script>";
    exit;
}
?>

<!-- Conteneur principal de la page de modération -->
<div class="container">
    <h1>Modération Commentaire</h1>
    
    <!-- Carte affichant le titre de l'article lié au commentaire -->
    <div class="card mb-3">
        <div class="card-header bg-info text-white">Article</div>
        <div class="card-body">
            <!-- Affiche le titre récupéré dans la requête -->
            <strong><?php echo $comment['libTitrArt']; ?></strong>
        </div>
    </div>
    
    <!-- Carte affichant le commentaire et son auteur -->
    <div class="card mb-3">
        <div class="card-header bg-warning">Commentaire</div>
        <div class="card-body">
            <!-- Pseudo de l'auteur (peut être vide si membre supprimé) -->
            <p><strong>Auteur :</strong> <?php echo $comment['pseudoMemb']; ?></p>
            <!-- Contenu du commentaire : échappement HTML + conversion des sauts de ligne -->
            <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
        </div>
    </div>
    
    <!-- Formulaire de modération qui envoie les choix à l'API update.php -->
    <form action="<?php echo ROOT_URL . '/api/comments/update.php' ?>" method="post">
        <!-- Champ caché contenant l'ID du commentaire à modifier -->
        <input type="hidden" name="numCom" value="<?php echo $comment['numCom']; ?>">
        
        <!-- Option pour valider le commentaire (sera rendu public) -->
        <div class="form-check">
            <input class="form-check-input" type="radio" name="attModOK" id="valOui" value="1" required>
            <label for="valOui"><strong>Valider</strong> (sera visible)</label>
        </div>
        <!-- Option pour refuser le commentaire (ne sera pas publié) -->
        <div class="form-check">
            <input class="form-check-input" type="radio" name="attModOK" id="valNon" value="0" checked>
            <label for="valNon"><strong>Refuser</strong></label>
        </div>
        
        <!-- Motif facultatif affiché à l'utilisateur si le commentaire est refusé -->
        <div class="form-group mt-3">
            <label for="notifComKOAff">Raison du refus (optionnel)</label>
            <textarea id="notifComKOAff" name="notifComKOAff" class="form-control" rows="2"></textarea>
        </div>
        
        <!-- Actions : retour à la liste ou confirmation de la modération -->
        <div class="mt-3">
            <a href="list.php" class="btn btn-primary">Retour</a>
            <button type="submit" class="btn btn-success">Confirmer</button>
        </div>
    </form>
</div>

<?php // Inclusion du footer commun (pied de page, scripts) ?>
<?php include '../../../footer.php'; ?>