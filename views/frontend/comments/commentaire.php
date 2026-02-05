<?php 
session_start();
require_once '../../../header.php';

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-warning'>Vous devez être connecté pour commenter.</div>";
    echo "<a href='../security/login.php' class='btn btn-primary'>Se connecter</a>";
    exit;
}

// Récupérer l'article depuis l'URL
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;

if($numArt == 0) {
    echo "<div class='alert alert-danger'>Article introuvable.</div>";
    exit;
}

// Récupérer les informations de l'article
$article = sql_select("ARTICLE", "*", "numArt = $numArt");
if(count($article) == 0) {
    echo "<div class='alert alert-danger'>Article introuvable.</div>";
    exit;
}
$article = $article[0];

// Récupérer les commentaires validés de cet article
$query = "SELECT c.*, m.pseudoMemb 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          WHERE c.numArt = $numArt 
          AND c.attModOK = 1 
          AND c.delLogiq = 0
          ORDER BY c.dtCreaCom DESC";
          
global $DB;
if(!$DB){
    sql_connect();
}
$comments = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <!-- Titre de l'article -->
    <h1><?php echo htmlspecialchars($article['libTitrArt']); ?></h1>
    <p class="lead"><?php echo htmlspecialchars($article['libChapoArt']); ?></p>
    <hr>
    
    <!-- Formulaire de commentaire -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>Ajouter un commentaire</h3>
            <small>Connecté en tant que : <strong><?php echo $_SESSION['user_pseudo']; ?></strong></small>
        </div>
        <div class="card-body">
            <?php
            // Messages
            if(isset($_SESSION['comment_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['comment_success'] . '</div>';
                unset($_SESSION['comment_success']);
            }
            if(isset($_SESSION['comment_error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['comment_error'] . '</div>';
                unset($_SESSION['comment_error']);
            }
            ?>
            
            <form action="<?php echo ROOT_URL . '/api/comments/create.php' ?>" method="post">
                <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">
                <input type="hidden" name="numMemb" value="<?php echo $_SESSION['user_id']; ?>">
                
                <div class="form-group mb-3">
                    <label for="libCom">Votre commentaire *</label>
                    <textarea id="libCom" name="libCom" class="form-control" rows="4" maxlength="600" required></textarea>
                    <small>Maximum 600 caractères. Soumis à modération.</small>
                </div>
                
                <button type="submit" class="btn btn-success">Poster</button>
            </form>
        </div>
    </div>
    
    <!-- Affichage des commentaires -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3>Commentaires (<?php echo count($comments); ?>)</h3>
        </div>
        <div class="card-body">
            <?php if(count($comments) > 0) { ?>
                <?php foreach($comments as $comment) { ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo htmlspecialchars($comment['pseudoMemb']); ?></strong>
                            <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($comment['dtCreaCom'])); ?></small>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted">Aucun commentaire. Soyez le premier !</p>
            <?php } ?>
        </div>
    </div>
</div>

<?php require_once '../../../footer.php'; ?>