<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$articleRepository = new ArticleRepository('articles.json');
$articles = $articleRepository->getAllArticles();

/**
 * Fetch OpenGraph description from an article URL
 */
function fetchArticleSnippet($url) {
    $html = @file_get_contents($url);
    if ($html === false) {
        return "No preview available";
    }

    preg_match('/<meta property="og:description" content="(.*?)"/i', $html, $matches);
    return $matches[1] ?? "No preview available";
}
?>

<!doctype html>
<html lang="en">

<?php require_once 'layout/header.php'; ?>

<body>
<?php require_once 'layout/navigation.php'; ?>

<div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

    <h2 id="page-title" class="text-xl text-center font-semibold text-indigo-700 mt-10">Articles</h2>

    <div class="overflow-hidden">
        <ul role="list">
            <?php foreach ($articles as $article): ?>
                <?php $snippet = fetchArticleSnippet($article->getUrl()); ?>
                <li class="bg-gray-800 text-white rounded-lg p-4 my-2 flex flex-col">
                    <div class="flex items-center">
                        <img src="https://www.google.com/s2/favicons?sz=64&domain=<?= parse_url($article->getUrl(), PHP_URL_HOST) ?>" alt="favicon" class="w-6 h-6 mr-2">
                        <a href="<?= htmlspecialchars($article->getUrl()) ?>" class="text-indigo-400 hover:underline text-lg">
                            <?= htmlspecialchars($article->getTitle()) ?>
                        </a>
                    </div>
                    <p class="text-gray-300 text-sm mt-2"> <?= htmlspecialchars($snippet) ?> </p>
                    <div class="mt-2">
                        <a href="update_article.php?id=<?= $article->getId() ?>" class="text-yellow-400 mx-2">✏️</a>
                        <a href="delete_article.php?id=<?= $article->getId() ?>" class="text-red-400">🗑️</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
</body>
</html>


