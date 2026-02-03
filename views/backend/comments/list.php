<?php
include '../../../header.php';

// Charger tous les commentaires
$query = "SELECT c.*, m.pseudoMemb, a.libTitrArt 
          FROM COMMENT c 
          LEFT JOIN MEMBRE m ON c.numMemb = m.numMemb 
          LEFT JOIN ARTICLE a ON c.numArt = a.numArt 
          ORDER BY c.dtCreaCom DESC";
          
global $DB;
if(!$DB) sql_connect();
$comments = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Commentaires</h1>
    
    <!-- Filtres -->
    <div class="mb-3">
        <button class="btn btn-sm btn-primary" onclick="filterComments('all')">Tous</button>
        <button class="btn btn-sm btn-warning" onclick="filterComments('pending')">En attente</button>
        <button class="btn btn-sm btn-success" onclick="filterComments('validated')">Validés</button>
    </div>
    
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
                // Déterminer le statut
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
                <tr data-status="<?php echo $status; ?>">
                    <td><?php echo date('d/m/Y', strtotime($comment['dtCreaCom'])); ?></td>
                    <td><?php echo substr($comment['libTitrArt'], 0, 30) . '...'; ?></td>
                    <td><?php echo $comment['pseudoMemb']; ?></td>
                    <td><?php echo substr($comment['libCom'], 0, 50) . '...'; ?></td>
                    <td><?php echo $statusLabel; ?></td>
                    <td>
                        <?php if($status == 'pending'): ?>
                            <a href="update.php?numCom=<?php echo $comment['numCom']; ?>" 
                               class="btn btn-warning btn-sm">Valider</a>
                        <?php endif; ?>
                        <a href="delete.php?numCom=<?php echo $comment['numCom']; ?>" 
                           class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filterComments(filter) {
    document.querySelectorAll('#commentsTable tbody tr').forEach(row => {
        row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
}
</script>

<?php include '../../../footer.php'; ?>