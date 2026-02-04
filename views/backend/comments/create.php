<?php 
require_once '../../../header.php';
require_once '../../../config.php';
sql_connect();

// Vérifier que l'utilisateur est connecté et modérateur
if (!isset($_SESSION['logged_in']) || $_SESSION['user_statut_nom'] !== 'Modérateur') {
    header('Location: /index.php');
    exit;
}

// Récupérer la liste des articles
$queryArticles = "SELECT numArt, libTitrArt FROM ARTICLE ORDER BY dtCreaArt DESC";
global $DB;
$articles = $DB->query($queryArticles)->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la liste des membres
$queryMembres = "SELECT numMemb, pseudoMemb FROM MEMBRE ORDER BY pseudoMemb ASC";
$membres = $DB->query($queryMembres)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 fw-bold mb-0">Créer un commentaire</h1>
                <a href="/views/backend/comments/list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
            </div>
            
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="/api/comments/create.php">
                        
                        <!-- Article -->
                        <div class="mb-3">
                            <label for="numArt" class="form-label fw-semibold">Article</label>
                            <select class="form-select" id="numArt" name="numArt" required>
                                <option value="">-- Sélectionner un article --</option>
                                <?php foreach ($articles as $article): ?>
                                    <option value="<?php echo $article['numArt']; ?>">
                                        <?php echo htmlspecialchars($article['libTitrArt']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Membre -->
                        <div class="mb-3">
                            <label for="numMemb" class="form-label fw-semibold">Auteur du commentaire</label>
                            <select class="form-select" id="numMemb" name="numMemb" required>
                                <option value="">-- Sélectionner un membre --</option>
                                <?php foreach ($membres as $membre): ?>
                                    <option value="<?php echo $membre['numMemb']; ?>">
                                        <?php echo htmlspecialchars($membre['pseudoMemb']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Commentaire -->
                        <div class="mb-3">
                            <label for="libCom" class="form-label fw-semibold">Commentaire</label>
                            <textarea class="form-control" 
                                      id="libCom" 
                                      name="libCom" 
                                      rows="6" 
                                      maxlength="600" 
                                      required 
                                      placeholder="Contenu du commentaire..."></textarea>
                            <small class="text-muted">Maximum 600 caractères</small>
                        </div>
                        
                        <!-- Statut de modération -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Statut de modération</label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="attModOK" 
                                       id="attModOK1" 
                                       value="1" 
                                       checked>
                                <label class="form-check-label" for="attModOK1">
                                    Validé (visible publiquement)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="attModOK" 
                                       id="attModOK0" 
                                       value="0">
                                <label class="form-check-label" for="attModOK0">
                                    En attente de modération
                                </label>
                            </div>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Créer le commentaire
                            </button>
                            <a href="/views/backend/comments/list.php" class="btn btn-secondary">
                                Annuler
                            </a>
                        </div>
                        
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php require_once '../../../footer.php'; ?>