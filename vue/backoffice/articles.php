<?php
// Include the controller
include 'C:\xampp\htdocs\web3bo33\controller\articleController.php';
// Instantiate the controller
$Pc = new articlesController();
// Pagination parameters
$limit = 5; // Number of articles per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure the page is at least 1
$offset = ($page - 1) * $limit;
// Search parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'ASC' : 'DESC'; // Sorting by date
// Fetch articles with pagination, search, and sort
$articles = $Pc->getArticlesWithSearchAndSort($search, $sort, $limit, $offset);
$totalArticles = $Pc->getTotalArticlesCount($search);
$totalPages = ceil($totalArticles / $limit);
// Delete an article
if (isset($_GET['delete_id'])) {
    try {
        $Pc->deleteArticles($_GET['delete_id']);
        header("Location: articles.php");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de la suppression de l'article : " . $e->getMessage();
    }
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
        <h1>Manage Articles</h1>
        <form method="GET" action="articles.php" class="mb-4">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search by title, content, or category" value="<?= htmlspecialchars($search); ?>">
            </div>
            <div class="form-group">
                <label for="sort">Sort by Date:</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="desc" <?= $sort === 'DESC' ? 'selected' : ''; ?>>Newest First</option>
                    <option value="asc" <?= $sort === 'ASC' ? 'selected' : ''; ?>>Oldest First</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <a href="AjoutArticles.php" class="action-btn">Add New Article</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date Published</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['titre']); ?></td>
                    <td><?= htmlspecialchars($article['contenu']); ?></td>
                    <td><?= htmlspecialchars($article['date_publication']); ?></td>
                    <td><?= htmlspecialchars($article['categorie']); ?></td>
                    <td>
                        <a href="edit_article.php?id=<?= $article['id']; ?>" class="action-btn">Edit</a>
                        <a href="?delete_id=<?= $article['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&sort=<?= urlencode($sort); ?>">&laquo; Previous</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&sort=<?= urlencode($sort); ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&sort=<?= urlencode($sort); ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>