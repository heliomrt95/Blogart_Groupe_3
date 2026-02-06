<?php
// Inclusion du header commun (affiche l'entête et initialise l'environnement)
include '../../../header.php';

// Requête principale : récupérer tous les commentaires
// - On joint la table MEMBRE pour obtenir le pseudo de l'auteur
// - On joint la table ARTICLE pour obtenir le titre lié
// - Tri décroissant sur la date de création pour afficher les plus récents en premier
$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          ORDER BY c.dtCreaCom DESC";
          
// Utilisation de la connexion PDO globale
global $DB;
if(!$DB) sql_connect();
// Exécute la requête et récupère tous les résultats sous forme de tableaux associatifs
$comments = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Conteneur principal pour la liste des commentaires -->
<div class="container">
    <h1>Commentaires</h1>
    
    <!-- Zone de filtres côté client : boutons qui appellent la fonction JS `filterComments` -->
    <div class="mb-3">
        <button class="btn btn-sm btn-primary" onclick="filterComments('all')">Tous</button>
        <button class="btn btn-sm btn-warning" onclick="filterComments('pending')">En attente</button>
        <button class="btn btn-sm btn-success" onclick="filterComments('validated')">Validés</button>
    </div>
    
    <!-- Tableau affichant les commentaires -->
    <table class="table table-striped" id="commentsTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Article</th>
                <th>Membre</th>
                <th>Commentaire</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($comments as $comment): ?>
                <?php
                // Déterminer le statut d'affichage du commentaire
                // - `delLogiq` = 1 : commentaire archivé
                // - `attModOK` = 1 : commentaire validé
                // - sinon : en attente de validation
                if($comment['delLogiq'] == 1) {
                    $status = 'archived';
                    $statusLabel = '<span class="badge bg-danger">Archivé</span>';
                } elseif($comment['attModOK'] == 1) {
                    $status = 'validated';
                    $statusLabel = '<span class="badge bg-success">Validé</span>';
                } else {
                    $status = 'pending';
                    $statusLabel = '<span class="badge bg-warning">En attente</span>';
                }
                ?>
                <!-- Chaque ligne contient un attribut data-status pour le filtrage JS -->
                <tr data-status="<?php echo $status; ?>">
                    <!-- Affiche la date au format français jour/mois/année -->
                    <td><?php echo date('d/m/Y', strtotime($comment['dtCreaCom'])); ?></td>
                    <!-- On tronque le titre pour garder une colonne compacte -->
                    <td><?php echo substr($comment['libTitrArt'], 0, 30) . '...'; ?></td>
                    <!-- Pseudo du membre (éventuellement vide si membre supprimé) -->
                    <td><?php echo $comment['pseudoMemb']; ?></td>
                    <!-- Aperçu du commentaire (tronqué) -->
                    <td><?php echo substr($comment['libCom'], 0, 50) . '...'; ?></td>
                    <!-- Badge indiquant le statut (HTML déjà sécurisé côté serveur) -->
                    <td><?php echo $statusLabel; ?></td>
                    <td>
                        <?php if($status == 'pending'): ?>
                            <!-- Lien vers la page `update.php` pour valider le commentaire -->
                            <a href="update.php?numCom=<?php echo $comment['numCom']; ?>" 
                               class="btn btn-warning btn-sm">Valider</a>
                        <?php endif; ?>
                        <!-- Lien vers la page de suppression (confirmation côté UI sur la page de delete) -->
                        <a href="delete.php?numCom=<?php echo $comment['numCom']; ?>" 
                           class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Script JS minimal pour filtrer les lignes du tableau sans recharger la page -->
<script>
function filterComments(filter) {
    // Parcourt chaque ligne et compare son attribut `data-status` au filtre demandé
    document.querySelectorAll('#commentsTable tbody tr').forEach(row => {
        row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
}
</script>

<?php // Inclusion du footer commun (pied de page, scripts) ?>
<?php include '../../../footer.php'; ?>