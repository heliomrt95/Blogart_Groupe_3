<?php
include '../../../header.php';

// Charger tous les membres avec leur statut
$query = "SELECT m.*, s.libStat 
          FROM MEMBRE m 
          LEFT JOIN STATUT s ON m.numStat = s.numStat 
          ORDER BY m.numMemb";
          
global $DB;
if(!$DB) sql_connect();
$membres = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-4">
    <!-- TITRE avec lignes -->
    <h1 class="text-center mb-4" style="border-top: 3px solid #000; border-bottom: 3px solid #000; padding: 20px 0; font-weight: bold;">
        Membres
    </h1>
    
    <!-- TABLEAU -->
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>Id</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Pseudo</th>
                <th>eMail</th>
                <th>Accord RGPD</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($membres) > 0): ?>
                <?php foreach($membres as $membre): ?>
                    <tr>
                        <td><?php echo $membre['numMemb']; ?></td>
                        <td><?php echo htmlspecialchars($membre['prenomMemb']); ?></td>
                        <td><?php echo htmlspecialchars($membre['nomMemb']); ?></td>
                        <td><?php echo htmlspecialchars($membre['pseudoMemb']); ?></td>
                        <td><?php echo htmlspecialchars($membre['eMailMemb']); ?></td>
                        <td><?php echo ($membre['accordMemb'] == 1) ? 'Oui' : 'Non'; ?></td>
                        <td><?php echo htmlspecialchars($membre['libStat']); ?></td>
                        <td>
                            <a href="edit.php?numMemb=<?php echo $membre['numMemb']; ?>" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?numMemb=<?php echo $membre['numMemb']; ?>" 
                               class="btn btn-outline-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Aucun membre</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- BOUTON CREATE -->
    <a href="create.php" class="btn btn-outline-success">Create</a>
</div>

<?php include '../../../footer.php'; ?>