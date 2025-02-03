<?php
require_once './helpers/helpers.php';
require_once './src/ArticleRepository.php';
$hasArticles = hasArticles(new ArticleRepository('articles.json'));
?>

    <nav class="bg-black border-b-4 border-yellow-500 pixelated">
        <div class="mx-auto max-w-7xl px-4 py-2 flex justify-between items-center">
            <h2 class="text-yellow-500 font-extrabold text-lg pixel-font">
                <a href="index.php">🕹️ COMP 3015 News</a>
            </h2>
            <div class="flex space-x-4">
                <a href="index.php" class="<?php echo ($_SERVER['SCRIPT_NAME'] == '/index.php') ? 'bg-yellow-500 text-black' : 'bg-blue-500 text-white'; ?> px-4 py-2 border-4 border-black pixel-btn">🏠 Home</a>
                <a href="new_article.php" class="<?php echo ($_SERVER['SCRIPT_NAME'] == '/new_article.php') ? 'bg-yellow-500 text-black' : 'bg-green-500 text-white'; ?> px-4 py-2 border-4 border-black pixel-btn">📝 New Article</a>
            </div>
        </div>
    </nav>

<?php if (!$hasArticles): ?>
    <p class="text-center text-red-500 font-bold pixel-font mt-4">⚠️ No articles available! Be the first to post. ⚠️</p>
<?php endif; ?>