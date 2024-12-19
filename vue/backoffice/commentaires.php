<?php
include 'C:\xampp\htdocs\web3bo33\controller\commentaireController.php';
$Cc = new commentaireController();
// Pagination parameters
$limit = 5; // Number of comments per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure the page is at least 1
$offset = ($page - 1) * $limit;
// Fetch comments and count
$commentaires = $Cc->getCommentairesWithPagination($limit, $offset);
$totalCommentaires = $Cc->getTotalCommentairesCount();
$totalPages = ceil($totalCommentaires / $limit);
// Delete a comment
if (isset($_GET['delete_id'])) {
    $Cc->deleteCommentaire($_GET['delete_id']);
    header("Location: commentaires.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
    /* Reusing styles from the original page */
    body {
        font-family: 'Quicksand', sans-serif;
        margin: 0;
        padding: 0;
        position: relative;
    }
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("assets/img/form.png");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        opacity: 0.5;
        z-index: -1;
    }
    .sidebar {
        width: 250px;
        background-color: #e4dcb2;
        color: black;
        position: fixed;
        height: 100%;
        padding-top: 20px;
    }
    .sidebar a {
        color: black;
        text-decoration: none;
        display: block;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Arial, sans-serif;
        font-weight: bold;
    }
    .sidebar a:hover {
        background-color: #fafad2;
        color: red;
    }
    .wrapper {
        display: flex;
        min-height: 100vh;
    }
    .main-panel {
        margin-left: 250px;
        padding: 20px;
        flex: 1;
    }
    table {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #bd2b2b;
        color: white;
    }
    .action-btn {
        margin-right: 5px;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        background-color: #495057;
    }
    .action-btn:hover {
        background-color: #343a40;
    }
    .delete-btn {
        background-color: #bd2b2b;
    }
    .delete-btn:hover {
        background-color: #a52323;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
    .pagination a {
        margin: 0 5px;
        padding: 10px 15px;
        text-decoration: none;
        background: #bd2b2b;
        color: white;
        border-radius: 5px;
    }
    .pagination a:hover {
        background: #a52323;
    }
    .pagination a.active {
        background: #495057;
    }
</style>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="index.html">
                <img src="assets/tounes.png" alt="Logo" height="100">
                <h2 style="color: rgb(183, 20, 20);">EL HADHRA.</h2>
            </a>
        </div>
        <a href="articles.php"><i class="fas fa-home"></i>Articles</a>
        <a href="commentaires.php"><i class="fas fa-layer-group"></i>Commentaires</a>
    </div>
    <!-- Main Panel -->
    <div class="main-panel">
    <h1>Manage Comments</h1>
    <!-- Comments Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Content</th>
                <th>Publication Date</th>
                <th>Article Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commentaires as $comment): ?>
            <tr>
                <td><?= htmlspecialchars($comment['nom']); ?></td>
                <td><?= htmlspecialchars($comment['contenu_comm']); ?></td>
                <td><?= htmlspecialchars($comment['date_pub']); ?></td>
                <td><?= htmlspecialchars($comment['article_name']); ?></td>
                <td>
                    <a href="?delete_id=<?= $comment['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure you want to delete this comment?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1; ?>">&laquo; Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>
        
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
    </div>
</div>
</body>
</html>
