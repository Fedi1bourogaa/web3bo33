<?php
session_start();
include '../../config.php';

$pdo = config::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $interface_rating = $_POST['interface_rating'];
    $performance_rating = $_POST['performance_rating'];
    $content_rating = $_POST['content_rating'];
    $general_comment = $_POST['general_comment'];

    // Vérifier si l'utilisateur a déjà évalué le site
    $checkQuery = $pdo->prepare("SELECT id FROM evaluations WHERE user_id = ?");
    $checkQuery->execute([$userId]);

    if ($checkQuery->rowCount() > 0) {
        // Mise à jour de l'évaluation existante
        $updateQuery = $pdo->prepare("
            UPDATE evaluations 
            SET interface_rating = ?, performance_rating = ?, content_rating = ?, general_comment = ?, created_at = CURRENT_TIMESTAMP 
            WHERE user_id = ?
        ");
        $updateQuery->execute([$interface_rating, $performance_rating, $content_rating, $general_comment, $userId]);
        $_SESSION['notification'] = "Votre évaluation a été mise à jour !";
    } else {
        // Insertion d'une nouvelle évaluation
        $insertQuery = $pdo->prepare("
            INSERT INTO evaluations (user_id, interface_rating, performance_rating, content_rating, general_comment) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $insertQuery->execute([$userId, $interface_rating, $performance_rating, $content_rating, $general_comment]);
        $_SESSION['notification'] = "Merci pour votre évaluation !";
    }

    $_SESSION['notification_type'] = "success";
    header('Location: indextemplate.php');
    exit();
}

// Récupérer l'évaluation actuelle (si elle existe)
$userId = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT interface_rating, performance_rating, content_rating, general_comment FROM evaluations WHERE user_id = ?");
$query->execute([$userId]);
$userEvaluation = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluation du site</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background-image: url('rating2.jpg'); /* Remplacez par le chemin de votre image */
    background-size: cover; /* L'image couvre toute la zone */
    background-position: center center; /* L'image est centrée */
    background-repeat: no-repeat; /* L'image ne se répète pas */
    color: #333;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    color: #c0392b;
    margin-top: 40px;
    font-size: 2.5rem;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    border-radius: 10px;
    background-color: rgba(244, 244, 244, 0.9); /* Fond plus opaque avec opacité ajustée */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    font-size: 1.1rem;
    color: #333;
}

select, textarea {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

select:focus, textarea:focus {
    border-color: #c0392b;
}

.emoji {
    font-size: 1.5rem;
    margin-right: 10px;
}

.rating {
    display: flex;
    align-items: center;
}

.rating label {
    margin-right: 10px;
}

.rating span {
    display: inline-block;
    width: 40px;
    height: 40px;
    text-align: center;
    line-height: 40px;
    font-size: 1.8rem;
    margin: 0 5px;
    background-color: #ddd;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s;
}

.rating span:hover {
    background-color: #e74c3c;
}

.rating span.selected {
    background-color: #e74c3c;
    color: #fff;
}

.button {
    background-color: #e74c3c;
    color: white;
    padding: 15px;
    border: none;
    border-radius: 10px;
    font-size: 1.2rem;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #c0392b;
}

.message {
    text-align: center;
    margin-top: 20px;
    font-size: 1.2rem;
    color: #27ae60;
}

.message.error {
    color: #e74c3c;
}

    </style>
</head>
<body>

    <h2>💬 Évaluez votre expérience sur notre site 🌐</h2>
    
    <div class="container">
        <form action="evaluationsite.php" method="POST">
            
            <!-- Évaluation de l'interface -->
            <div class="form-group">
                <label for="interface_rating">💻 Interface utilisateur</label>
                <div class="rating">
                    <span class="emoji" onclick="selectRating('interface', 1)">😡</span>
                    <span class="emoji" onclick="selectRating('interface', 2)">😕</span>
                    <span class="emoji" onclick="selectRating('interface', 3)">😐</span>
                    <span class="emoji" onclick="selectRating('interface', 4)">😊</span>
                    <span class="emoji" onclick="selectRating('interface', 5)">😍</span>
                </div>
                <input type="hidden" name="interface_rating" id="interface_rating" value="<?= $userEvaluation['interface_rating'] ?? '' ?>" required>
            </div>

            <!-- Évaluation de la performance -->
            <div class="form-group">
                <label for="performance_rating">⚡ Performance du site</label>
                <div class="rating">
                    <span class="emoji" onclick="selectRating('performance', 1)">🐢</span>
                    <span class="emoji" onclick="selectRating('performance', 2)">👶</span>
                    <span class="emoji" onclick="selectRating('performance', 3)">🚶‍♂️</span>
                    <span class="emoji" onclick="selectRating('performance', 4)">🏃‍♀️</span>
                    <span class="emoji" onclick="selectRating('performance', 5)">🚀</span>
                </div>
                <input type="hidden" name="performance_rating" id="performance_rating" value="<?= $userEvaluation['performance_rating'] ?? '' ?>" required>
            </div>

            <!-- Évaluation du contenu -->
            <div class="form-group">
                <label for="content_rating">📚 Qualité du contenu</label>
                <div class="rating">
                    <span class="emoji" onclick="selectRating('content', 1)">🤮</span>
                    <span class="emoji" onclick="selectRating('content', 2)">👎</span>
                    <span class="emoji" onclick="selectRating('content', 3)">👌</span>
                    <span class="emoji" onclick="selectRating('content', 4)">👍</span>
                    <span class="emoji" onclick="selectRating('content', 5)">🌟</span>
                </div>
                <input type="hidden" name="content_rating" id="content_rating" value="<?= $userEvaluation['content_rating'] ?? '' ?>" required>
            </div>

            <!-- Commentaire général -->
            <div class="form-group">
                <label for="general_comment">💭 Votre commentaire</label>
                <textarea name="general_comment" id="general_comment" rows="4"><?= htmlspecialchars($userEvaluation['general_comment'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="button">Soumettre mon évaluation</button>
        </form>

        <?php if (isset($_SESSION['notification'])): ?>
            <div class="message <?= $_SESSION['notification_type'] ?>">
                <?= $_SESSION['notification'] ?>
                <?php unset($_SESSION['notification']); ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function selectRating(type, value) {
            document.getElementById(type + '_rating').value = value;

            const emojis = document.querySelectorAll('.' + type + ' .emoji');
            emojis.forEach(emoji => {
                emoji.classList.remove('selected');
            });
            emojis[value - 1].classList.add('selected');
        }
    </script>

</body>
</html>
