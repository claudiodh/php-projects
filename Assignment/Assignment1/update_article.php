<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');
$article = null;

if (isset($_GET['id'])) {
    $article = $articleRepository->getArticleById((int) $_GET['id']);
}

if (!$article) {
    die("Article not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);

    if (!filter_var($url, FILTER_VALIDATE_URL) || empty($title)) {
        $error = "Invalid input. Please provide a valid URL and a non-empty title.";
    } else {
        $updatedArticle = new Article($article->getId(), $title, $url);
        $articleRepository->updateArticle($article->getId(), $updatedArticle);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
</head>
<body>
<h2>Edit Article</h2>

<?php if (!empty($error)) : ?>
    <p style="color: red;"> <?= htmlspecialchars($error) ?> </p>
<?php endif; ?>

<form method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($article->getTitle()) ?>" required>

    <label for="url">URL:</label>
    <input type="url" id="url" name="url" value="<?= htmlspecialchars($article->getUrl()) ?>" required>

    <button type="submit">Update Article</button>
</form>
</body>
</html>
