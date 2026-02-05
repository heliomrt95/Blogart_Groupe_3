<?php 
require_once '../../header.php';
sql_connect();

// Récupérer l'ID de l'article
$articleId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($articleId > 0) {
    // Charger l'article
    $query = "SELECT a.*, t.libThem 
              FROM ARTICLE a 
              LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
              WHERE a.numArt = :id";
    
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute(['id' => $articleId]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Charger les mots-clés
    $queryTags = "SELECT mk.libMotCle 
                  FROM MOTCLE mk 
                  INNER JOIN MOTCLEARTICLE ma ON mk.numMotCle = ma.numMotCle 
                  WHERE ma.numArt = :id";
    $stmtTags = $DB->prepare($queryTags);
    $stmtTags->execute(['id' => $articleId]);
    $tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);
    
    // Compter les LIKES
    $queryLikes = "SELECT COUNT(*) as total_likes FROM LIKEART WHERE numArt = :id";
    $stmtLikes = $DB->prepare($queryLikes);
    $stmtLikes->execute(['id' => $articleId]);
    $likesData = $stmtLikes->fetch(PDO::FETCH_ASSOC);
    $totalLikes = $likesData['total_likes'];
    
    // Vérifier si l'utilisateur a liké
    $userHasLiked = false;
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['user_id'])) {
        $queryUserLike = "SELECT likeA FROM LIKEART WHERE numArt = :artId AND numMemb = :userId";
        $stmtUserLike = $DB->prepare($queryUserLike);
        $stmtUserLike->execute(['artId' => $articleId, 'userId' => $_SESSION['user_id']]);
        $userLike = $stmtUserLike->fetch(PDO::FETCH_ASSOC);
        if ($userLike) {
            $userHasLiked = true;
        }
    }
    
    // Charger les COMMENTAIRES
    $queryComments = "SELECT c.*, m.pseudoMemb, c.dtCreaCom
                      FROM COMMENT c
                      INNER JOIN MEMBRE m ON c.numMemb = m.numMemb
                      WHERE c.numArt = :id 
                        AND c.attModOK = 1 
                        AND c.delLogiq = 0
                      ORDER BY c.dtCreaCom DESC";
    $stmtComments = $DB->prepare($queryComments);
    $stmtComments->execute(['id' => $articleId]);
    $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
    
} else {
    $article = null;
}
?>

<?php if ($article): ?>

<!-- PAGE ARTICLE DÉTAIL -->
<section class="page-article-detail">
    <div class="container-fluid px-0">
        <!-- Image Hero -->
        <div class="article-hero">
            <?php if(!empty($article['urlPhotArt'])): ?>
                <img src="/src/uploads/<?php echo htmlspecialchars($article['urlPhotArt']); ?>" 
                     class="img-fluid w-100" alt="<?php echo htmlspecialchars($article['libTitrArt']); ?>">
            <?php else: ?>
                <img src="https://images.unsplash.com/photo-1590479773265-7464e5d48118?w=1600" 
                     class="img-fluid w-100" alt="Article">
            <?php endif; ?>
            
            <!-- Bouton retour -->
            <a href="/views/frontend/articles.php" class="btn-retour">
                <i class="bi bi-arrow-left"></i>
            </a>
        </div>
    </div>
    
    <!-- Contenu article -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="article-content">
                    <!-- Titre -->
                    <h1 class="article-detail-title">
                        <?php echo htmlspecialchars($article['libTitrArt']); ?>
                    </h1>
                    
                    <!-- Chapô -->
                    <p class="article-detail-chapo">
                        <?php echo nl2br(bbcode_to_html($article['libChapoArt'])); ?>
                    </p>
                    
                    <!-- Meta auteur -->
                    <div class="article-meta-author">
                        <div class="d-flex align-items-center">
                            <div class="author-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <strong>Rédaction LEKÉ</strong>
                                <span class="text-muted ms-3">
                                    <?php echo date('M d, Y', strtotime($article['dtCreaArt'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Corps -->
                    <div class="article-body">
                        <?php if (!empty($article['libAccrochArt'])): ?>
                        <h2><?php echo nl2br(bbcode_to_html($article['libAccrochArt'])); ?></h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['parag1Art'])): ?>
                        <p><?php echo nl2br(bbcode_to_html($article['parag1Art'])); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['libSsTitr1Art'])): ?>
                        <h2><?php echo nl2br(bbcode_to_html($article['libSsTitr1Art'])); ?></h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['parag2Art'])): ?>
                        <p><?php echo nl2br(bbcode_to_html($article['parag2Art'])); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['libSsTitr2Art'])): ?>
                        <h2><?php echo nl2br(bbcode_to_html($article['libSsTitr2Art'])); ?></h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['parag3Art'])): ?>
                        <p><?php echo nl2br(bbcode_to_html($article['parag3Art'])); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($article['libConclArt'])): ?>
                        <p><strong><?php echo nl2br(bbcode_to_html($article['libConclArt'])); ?></strong></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Tags -->
                    <?php if (count($tags) > 0): ?>
                    <div class="article-tags mt-4 pt-4 border-top">
                        <?php foreach ($tags as $tag): ?>
                            <span class="tag"><?php echo htmlspecialchars($tag['libMotCle']); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- LIKES -->
                    <div class="article-likes mt-4 py-4 border-top border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                                <button type="button" 
                                        class="btn btn-like" 
                                        id="likeBtn"
                                        data-article-id="<?php echo $articleId; ?>"
                                        data-user-id="<?php echo $_SESSION['user_id']; ?>"
                                        data-liked="<?php echo $userHasLiked ? '1' : '0'; ?>"
                                        style="background-color: <?php echo $userHasLiked ? '#2F509E' : '#f8f9fa'; ?>; 
                                               color: <?php echo $userHasLiked ? 'white' : '#6c757d'; ?>; 
                                               border: 2px solid <?php echo $userHasLiked ? '#2F509E' : '#dee2e6'; ?>;">
                                    <i class="bi <?php echo $userHasLiked ? 'bi-heart-fill' : 'bi-heart'; ?> me-2"></i>
                                    <span id="likeText"><?php echo $userHasLiked ? 'J\'aime' : 'Aimer'; ?></span>
                                </button>
                            <?php else: ?>
                                <a href="/views/backend/security/login.php" class="btn" style="background-color: #f8f9fa; color: #6c757d; border: 2px solid #dee2e6;">
                                    <i class="bi bi-heart me-2"></i>
                                    Connectez-vous pour aimer
                                </a>
                            <?php endif; ?>
                            
                            <span class="text-muted">
                                <strong id="likeCount"><?php echo $totalLikes; ?></strong> 
                                <span id="likeLabel"><?php echo $totalLikes > 1 ? 'personnes aiment cet article' : 'personne aime cet article'; ?></span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- COMMENTAIRES -->
                    <div class="article-comments mt-5">
                        <h3 class="h4 fw-bold mb-4">
                            Commentaires (<span id="commentCount"><?php echo count($comments); ?></span>)
                        </h3>
                        
                        <div id="commentMessages"></div>
                        
                        <!-- Formulaire -->
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <div class="card mb-4" style="border: 2px solid #f8f9fa;">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold mb-3">Ajouter un commentaire</h5>
                                    <form id="commentForm">
                                        <input type="hidden" name="numArt" value="<?php echo $articleId; ?>">
                                        <input type="hidden" name="numMemb" value="<?php echo $_SESSION['user_id']; ?>">
                                        <div class="mb-3">
                                            <label for="libCom" class="form-label fw-semibold">Votre commentaire</label>
                                            <textarea class="form-control" 
                                                      id="libCom" 
                                                      name="libCom" 
                                                      rows="4" 
                                                      maxlength="600" 
                                                      required 
                                                      placeholder="Partagez votre avis..."></textarea>
                                            <small class="text-muted">Maximum 600 caractères</small>
                                        </div>
                                        <button type="submit" class="btn" id="submitCommentBtn" style="background-color: #2F509E; color: white;">
                                            <i class="bi bi-send-fill me-2"></i>Publier
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <a href="/views/backend/security/login.php">Connectez-vous</a> pour commenter.
                            </div>
                        <?php endif; ?>
                        
                        <!-- Liste -->
                        <div id="commentsList">
                            <?php if (count($comments) > 0): ?>
                                <?php foreach ($comments as $comment): ?>
                                    <div class="card mb-3" style="background-color: #f8f9fa;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person-fill text-white"></i>
                                                </div>
                                                <div class="flex-fill">
                                                    <strong><?php echo htmlspecialchars($comment['pseudoMemb']); ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y à H:i', strtotime($comment['dtCreaCom'])); ?>
                                                    </small>
                                                    <p class="mt-2 mb-0">
                                                        <?php echo nl2br(htmlspecialchars($comment['libCom'])); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-secondary">
                                    <i class="bi bi-chat-dots-fill me-2"></i>
                                    Aucun commentaire. Soyez le premier !
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </article>
            </div>
        </div>
    </div>
</section>

<!-- JAVASCRIPT AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // LIKES
    const likeBtn = document.getElementById('likeBtn');
    if (likeBtn) {
        likeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const articleId = this.dataset.articleId;
            const userId = this.dataset.userId;
            const isLiked = this.dataset.liked === '1';
            
            this.disabled = true;
            
            const formData = new FormData();
            formData.append('numArt', articleId);
            formData.append('numMemb', userId);
            formData.append('ajax', '1');
            
            const url = isLiked ? '/api/likes/delete.php' : '/api/likes/create.php';
            
            fetch(url, { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    const text = document.getElementById('likeText');
                    const count = document.getElementById('likeCount');
                    const label = document.getElementById('likeLabel');
                    
                    if (data.liked) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                        text.textContent = 'J\'aime';
                        this.style.backgroundColor = '#2F509E';
                        this.style.color = 'white';
                        this.style.borderColor = '#2F509E';
                        this.dataset.liked = '1';
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                        text.textContent = 'Aimer';
                        this.style.backgroundColor = '#f8f9fa';
                        this.style.color = '#6c757d';
                        this.style.borderColor = '#dee2e6';
                        this.dataset.liked = '0';
                    }
                    
                    count.textContent = data.totalLikes;
                    label.textContent = data.totalLikes > 1 ? 'personnes aiment cet article' : 'personne aime cet article';
                }
                this.disabled = false;
            })
            .catch(error => {
                console.error('Erreur:', error);
                this.disabled = false;
            });
        });
    }
    
    // COMMENTAIRES
    const commentForm = document.getElementById('commentForm');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitCommentBtn');
            const textarea = document.getElementById('libCom');
            const messagesDiv = document.getElementById('commentMessages');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi...';
            
            const formData = new FormData(this);
            formData.append('ajax', '1');
            
            fetch('/api/comments/create.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messagesDiv.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    textarea.value = '';
                    messagesDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    messagesDiv.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                }
                
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Publier';
            })
            .catch(error => {
                console.error('Erreur:', error);
                messagesDiv.innerHTML = `
                    <div class="alert alert-danger">Une erreur est survenue.</div>
                `;
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Publier';
            });
        });
    }
});
</script>

<?php else: ?>
    <div class="container py-5">
        <div class="alert alert-warning">Article introuvable.</div>
        <a href="/views/frontend/articles.php" class="btn btn-primary" style="background-color: #2F509E;">
            Retour aux articles
        </a>
    </div>
<?php endif; ?>

<?php require_once '../../footer.php'; ?>