<?php
include '../../../header.php';

$numCom = isset($_GET['numCom']) ? (int)$_GET['numCom'] : 0;

// Récupérer le commentaire
$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          WHERE c.numCom = $numCom";
          
global $DB;
if(!$DB) sql_connect();
$comment = $DB->query($query)->fetch(PDO::FETCH_ASSOC);

if(!$comment) {
    echo "<script>alert('Commentaire introuvable.'); window.location.href='list.php';</script>";
    exit;
}
?>

<div class="container">
    <h1>Modération Commentaire</h1>
    
    <div class="card mb-3">
        <div class="card-header bg-info text-white">Article</div>
        <div class="card-body">
            <strong><?php echo $comment['libTitrArt']; ?></strong>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-header bg-warning">Commentaire</div>
        <div class="card-body">
            <p><strong>Auteur :</strong> <?php echo $comment['pseudoMemb']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
        </div>
    </div>
    
    <form action="<?php echo ROOT_URL . '/api/comments/update.php' ?>" method="post">
        <input type="hidden" name="numCom" value="<?php echo $comment['numCom']; ?>">
        
        <div class="form-check">
            <input class="form-check-input" type="radio" name="attModOK" id="valOui" value="1" required>
            <label for="valOui"><strong>Valider</strong> (sera visible)</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="attModOK" id="valNon" value="0" checked>
            <label for="valNon"><strong>Refuser</strong></label>
        </div>
        
        <div class="form-group mt-3">
            <label for="notifComKOAff">Raison du refus (optionnel)</label>
            <textarea id="notifComKOAff" name="notifComKOAff" class="form-control" rows="2"></textarea>
        </div>
        
        <div class="mt-3">
            <a href="list.php" class="btn btn-primary">Retour</a>
            <button type="submit" class="btn btn-success">Confirmer</button>
        </div>
    </form>
</div>

<?php include '../../../footer.php'; ?>