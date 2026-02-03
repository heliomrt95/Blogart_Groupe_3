<?php
include '../../../header.php';

$numCom = isset($_GET['numCom']) ? (int)$_GET['numCom'] : 0;

$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          WHERE c.numCom = $numCom";
          
global $DB;
if(!$DB) sql_connect();
$comment = $DB->query($query)->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Suppression Commentaire</h1>
    <div class="alert alert-danger">Action irréversible !</div>
    
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Article :</strong> <?php echo $comment['libTitrArt']; ?></p>
            <p><strong>Auteur :</strong> <?php echo $comment['pseudoMemb']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
        </div>
    </div>
    
    <form action="<?php echo ROOT_URL . '/api/comments/delete.php' ?>" method="post">
        <input type="hidden" name="numCom" value="<?php echo $comment['numCom']; ?>">
        <a href="list.php" class="btn btn-primary">Annuler</a>
        <button type="submit" class="btn btn-danger" 
                onclick="return confirm('Supprimer définitivement ?');">
            Confirmer suppression
        </button>
    </form>
</div>

<?php include '../../../footer.php'; ?>