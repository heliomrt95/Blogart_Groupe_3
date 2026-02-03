<?php
include '../../../header.php';

// Charger tous les likes avec infos
$query = "SELECT l.numMemb, l.numArt, l.likeA,
                 m.pseudoMemb, 
                 a.libTitrArt, a.libChapoArt
          FROM LIKEART l
          LEFT JOIN MEMBRE m ON l.numMemb = m.numMemb
          LEFT JOIN ARTICLE a ON l.numArt = a.numArt
          ORDER BY m.pseudoMemb, a.libTitrArt";

global $DB;
if(!$DB) sql_connect();
$likes = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Compter les membres
$membresCount = array();
foreach($likes as $like) {
    if(!isset($membresCount[$like['pseudoMemb']])) {
        $membresCount[$like['pseudoMemb']] = 0;
    }
    $membresCount[$like['pseudoMemb']]++;
}
?>

<div class="container my-4">
    <h1 class="mb-4">Articles (Un)Likes</h1>
    
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>Membre</th>
                <th>Titre Article</th>
                <th>Chapeau Article</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($likes) > 0): ?>
                <?php 
                $currentMembre = '';
                $numero = 0;
                foreach($likes as $like): 
                    // Numérotation des articles par membre
                    if($currentMembre != $like['pseudoMemb']) {
                        $currentMembre = $like['pseudoMemb'];
                        $numero = 1;
                    } else {
                        $numero++;
                    }
                    
                    $statusClass = ($like['likeA'] == 1) ? 'text-danger' : 'text-warning';
                    $statusText = ($like['likeA'] == 1) ? 'like' : 'unlike';
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($like['pseudoMemb']) . ' (' . $numero . ')'; ?></td>
                        <td><?php echo htmlspecialchars($like['libTitrArt']); ?></td>
                        <td><?php echo substr(htmlspecialchars($like['libChapoArt']), 0, 150) . '...'; ?></td>
                        <td><em class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></em></td>
                        <td>
                            <a href="edit.php?numMemb=<?php echo $like['numMemb']; ?>&numArt=<?php echo $like['numArt']; ?>" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?numMemb=<?php echo $like['numMemb']; ?>&numArt=<?php echo $like['numArt']; ?>" 
                               class="btn btn-outline-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php 
                    $numero++;
                endforeach; 
                ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Aucun like pour le moment</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <a href="create.php" class="btn btn-success">Create</a>
</div>

<?php include '../../../footer.php'; ?>