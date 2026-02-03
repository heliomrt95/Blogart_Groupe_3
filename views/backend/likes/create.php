<?php
include '../../../header.php';

// Charger tous les membres (ORDER BY avec requête directe)
global $DB;
if(!$DB) sql_connect();
$membres = $DB->query("SELECT * FROM MEMBRE ORDER BY pseudoMemb")->fetchAll(PDO::FETCH_ASSOC);

// Si un membre est sélectionné, charger les articles non encore likés par ce membre
$articles = array();
$selectedMemb = isset($_GET['numMemb']) ? (int)$_GET['numMemb'] : 0;

if($selectedMemb > 0) {
    // Articles NON likés par ce membre
    $query = "SELECT a.*
              FROM ARTICLE a
              WHERE a.numArt NOT IN (
                  SELECT numArt FROM LIKEART WHERE numMemb = $selectedMemb
              )
              ORDER BY a.libTitrArt";
    
    $articles = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container my-4">
    <h1 class="mb-4">Liker Article</h1>
    
    <form action="<?php echo ROOT_URL . '/api/likes/create.php'; ?>" method="post">
        
        <!-- Membre -->
        <div class="form-group mb-3">
            <label for="numMemb">Membre :</label>
            <select id="numMemb" name="numMemb" class="form-control" required 
                    onchange="window.location.href='create.php?numMemb=' + this.value;">
                <option value="">- - - Choisissez un membre - - -</option>
                <?php foreach($membres as $membre): ?>
                    <option value="<?php echo $membre['numMemb']; ?>" 
                            <?php echo ($selectedMemb == $membre['numMemb']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($membre['pseudoMemb']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Article -->
        <div class="form-group mb-3">
            <label for="numArt">Article :</label>
            <select id="numArt" name="numArt" class="form-control" required 
                    <?php echo ($selectedMemb == 0) ? 'disabled' : ''; ?>>
                <option value="">- - - Choisissez un article - - -</option>
                <?php foreach($articles as $article): ?>
                    <option value="<?php echo $article['numArt']; ?>">
                        <?php echo htmlspecialchars($article['libTitrArt']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <p class="text-danger">
            <strong>Remarque :</strong> Dès le membre sélectionné, seuls les articles non encore likés par ce membre s'afficheront.
        </p>
        
        <div class="mt-3">
            <a href="list.php" class="btn btn-primary">List</a>
            <button type="submit" class="btn btn-success" 
                    <?php echo ($selectedMemb == 0) ? 'disabled' : ''; ?>>
                Create
            </button>
        </div>
    </form>
</div>

<?php include '../../../footer.php'; ?>