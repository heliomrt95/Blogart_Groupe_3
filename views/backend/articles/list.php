<?php
include '../../../header.php'; // contains the header and call to config.php

// Charger tous les articles
$articles = sql_select("ARTICLE", "*");
?>

<!-- Bootstrap default layout to display all articles in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Articles</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Titre</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $article){ ?>
                        <tr>
                            <td><?php echo($article['numArt']); ?></td>
                            <td><?php echo($article['libTitrArt']); ?></td>
                            <td><?php echo($article['dtCreaArt']); ?></td>
                            <td>
                                <a href="edit.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-danger">Delete</a>
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
