<?php
include '../../../header.php'; // contains the header and call to config.php

//Load all articles with their thematique
$query = "SELECT a.*, t.libThem 
          FROM ARTICLE a 
          LEFT JOIN THEMATIQUE t ON a.numThem = t.numThem 
          ORDER BY a.dtCreaArt DESC";
          
// Utilisation d'une requête personnalisée
global $DB;
if(!$DB){
    sql_connect();
}
$articles = $DB->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Bootstrap default layout to display all articles in table -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Articles</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Date création</th>
                        <th>Titre</th>
                        <th>Chapeau</th>
                        <th>Accroche</th>
                        <th>Thématique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $article){ ?>
                        <tr>
                            <td><?php echo($article['numArt']); ?></td>
                            <td><?php echo(date('d/m/Y H:i', strtotime($article['dtCreaArt']))); ?></td>
                            <td><?php echo(substr($article['libTitrArt'], 0, 30) . '...'); ?></td>
                            <td><?php echo(substr($article['libChapoArt'], 0, 50) . '...'); ?></td>
                            <td><?php echo(substr($article['libAccrochArt'], 0, 30) . '...'); ?></td>
                            <td><?php echo($article['libThem'] ?? 'N/A'); ?></td>
                            <td>
                                <a href="edit.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer
?>