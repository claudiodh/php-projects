<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No article ID provided.");
}

$articleId = (int) $_GET['id'];
$article = $articleRepository->getArticleById($articleId);

if (!$article) {
    die("Article not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleRepository->deleteArticleById($articleId);
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<?php require_once 'layout/header.php' ?>

<body>
<?php require_once 'layout/navigation.php' ?>
<div class="flex min-h-full items-center justify-center px-4 mt-16 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl space-y-8">
        <h2 class="text-center text-2xl font-bold">Delete Article</h2>

        <p class="text-center">Are you sure you want to delete "<?= htmlspecialchars($article->getTitle()) ?>"?</p>

        <form method="POST" class="text-center space-y-4">
            <button type="submit" class="bg-red-500 text-white p-2 rounded">Yes, Delete</button>
            <a href="index.php" class="bg-gray-500 text-white p-2 rounded">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>