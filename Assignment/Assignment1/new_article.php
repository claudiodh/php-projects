<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);

    if (!filter_var($url, FILTER_VALIDATE_URL) || empty($title)) {
        $error = "Invalid input. Please provide a valid URL and a non-empty title.";
    } else {
        $article = new Article((int) time(), $title, $url);
        $articleRepository->saveArticle($article);
        header("Location: index.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<?php require_once 'layout/header.php' ?>

<body>
<?php require_once 'layout/navigation.php' ?>
<div class="flex min-h-full items-center justify-center px-4 mt-16 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl space-y-8">
        <h2 class="text-center text-2xl font-bold">Submit New Article</h2>

        <?php if (!empty($error)) : ?>
            <p style="color: red;"> <?= htmlspecialchars($error) ?> </p>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <label for="title" class="block">Title:</label>
            <input type="text" id="title" name="title" class="w-full p-2 border rounded" required>

            <label for="url" class="block">URL:</label>
            <input type="url" id="url" name="url" class="w-full p-2 border rounded" required>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Submit Article</button>
        </form>
    </div>
</div>
</body>

</html>