<?php
include '../../../header.php';

// Récupération du like
$numMemb = isset($_GET['numMemb']) ? (int)$_GET['numMemb'] : 0;
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;

if($numMemb == 0 || $numArt == 0) {
    echo "<script>alert('Erreur : paramètres manquants'); window.location.href='list.php';</script>";
    exit;
}

// Charger le like
$like = sql_select("LIKEART", "*", "numMemb = $numMemb AND numArt = $numArt");
if(count($like) == 0) {
    echo "<script>alert('Like introuvable'); window.location.href='list.php';</script>";
    exit;
}
$like = $like[0];

// Charger infos membre et article
$membre = sql_select("MEMBRE", "*", "numMemb = $numMemb")[0];
$article = sql_select("ARTICLE", "*", "numArt = $numArt")[0];
?>

<div class="container my-4">
    <h1 class="mb-4">Modification Article (un)Liké</h1>
    
    <form action="<?php echo ROOT_URL . '/api/likes/update.php'; ?>" method="post">
        <input type="hidden" name="numMemb" value="<?php echo $numMemb; ?>">
        <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">
        
        <!-- Membre (disabled) -->
        <div class="form-group mb-3">
            <label for="membre">Membre</label>
            <input type="text" id="membre" class="form-control" 
                   value="<?php echo htmlspecialchars($membre['pseudoMemb']) . ' (numéro ' . $membre['numMemb'] . ')'; ?>" 
                   disabled>
        </div>
        
        <!-- Article (disabled) -->
        <div class="form-group mb-3">
            <label for="article">Article</label>
            <input type="text" id="article" class="form-control" 
                   value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" 
                   disabled>
        </div>
        
        <!-- Like / Unlike -->
        <div class="form-group mb-3">
            <label>Article (un)Liké ?</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="likeA" id="like" value="1" 
                       <?php echo ($like['likeA'] == 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="like">Like</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="likeA" id="unlike" value="0" 
                       <?php echo ($like['likeA'] == 0) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="unlike">Unlike</label>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="list.php" class="btn btn-primary">List</a>
            <button type="submit" class="btn btn-warning">Confirmer Edit ?</button>
        </div>
    </form>
</div>

<?php include '../../../footer.php'; ?>