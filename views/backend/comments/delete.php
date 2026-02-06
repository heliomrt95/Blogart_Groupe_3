<?php
// Inclusion du header commun (affiche l'entête et initialise l'environnement)
include '../../../header.php';

// Récupère l'identifiant du commentaire depuis la query string
// On force le cast en int pour éviter l'injection SQL via l'URL
$numCom = isset($_GET['numCom']) ? (int)$_GET['numCom'] : 0;

// Prépare la requête pour récupérer le commentaire ainsi que
// le pseudo de l'auteur (table MEMBRE) et le titre de l'article (table ARTICLE)
// LEFT JOINs utilisés pour s'assurer que l'on récupère le commentaire
// même si la relation membre/article est manquante.
$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          WHERE c.numCom = $numCom";

// Utilisation de la connexion globale PDO
global $DB;
// Si la connexion n'existe pas encore, l'ouvrir
if(!$DB) sql_connect();
// Exécute la requête et récupère le premier résultat sous forme de tableau associatif
$comment = $DB->query($query)->fetch(PDO::FETCH_ASSOC);
?>

<!-- Conteneur principal de la page de suppression -->
<div class="container">
    <!-- Titre de la page -->
    <h1>Suppression Commentaire</h1>
    <!-- Message d'alerte pour prévenir que l'action est irréversible -->
    <div class="alert alert-danger">Action irréversible !</div>
    
    <!-- Carte affichant un aperçu du commentaire à supprimer -->
    <div class="card mb-3">
        <div class="card-body">
            <!-- Affiche le titre de l'article lié au commentaire -->
            <p><strong>Article :</strong> <?php echo $comment['libTitrArt']; ?></p>
            <!-- Affiche le pseudo de l'auteur (peut être vide si membre supprimé) -->
            <p><strong>Auteur :</strong> <?php echo $comment['pseudoMemb']; ?></p>
            <!-- Contenu du commentaire : on échappe les caractères HTML puis on transforme les sauts de ligne -->
            <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
        </div>
    </div>
    
    <!-- Formulaire qui enverra la requête de suppression vers l'API -->
    <form action="<?php echo ROOT_URL . '/api/comments/delete.php' ?>" method="post">
        <!-- Champ caché contenant l'ID du commentaire à supprimer -->
        <input type="hidden" name="numCom" value="<?php echo $comment['numCom']; ?>">
        <!-- Lien pour annuler et revenir à la liste -->
        <a href="list.php" class="btn btn-primary">Annuler</a>
        <!-- Bouton pour confirmer la suppression. `onclick` affiche une confirmation côté client -->
        <button type="submit" class="btn btn-danger" 
                onclick="return confirm('Supprimer définitivement ?');">
            Confirmer suppression
        </button>
    </form>
</div>

<?php // Inclusion du footer commun (pied de page, scripts) ?>
<?php include '../../../footer.php'; ?>