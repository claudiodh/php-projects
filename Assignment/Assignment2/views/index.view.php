<?php require_once 'header.php'; ?>

<body class="bg-gray-900 text-white min-h-screen">
<?php require_once 'nav.php'; ?>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash-message bg-green-500 text-white p-2 rounded mb-4 text-center max-w-xl mx-auto">
        <?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php unset($_SESSION['flash']); ?>
    <script>
        // Hide flash msg
        setTimeout(() => {
            const flashMessage = document.querySelector('.flash-message');
            if (flashMessage) flashMessage.style.display = 'none';
        }, 30000);
    </script>
<?php endif; ?>

<div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
    <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10">Articles</h1>

    <!-- Search Bar -->
    <form method="GET" class="flex mb-6 space-x-2">
        <label>
            <input
                    type="text"
                    name="search"
                    placeholder="Search..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    class="flex-grow border p-2 rounded text-gray-700"
            >
        </label>
        <button type="submit" class="bg-indigo-500 text-white p-2 rounded">Search</button>
    </form>

    <?php
    require_once __DIR__ . '/../src/Repositories/ArticleRepository.php';
    $articleRepo = new \src\Repositories\ArticleRepository();

    // Get search term
    $search = $_GET['search'] ?? '';

    if ($search !== '') {
        // Search articles
        $allArticles = $articleRepo->getArticles();
        $foundArticle = null;

        // Loop to find match
        foreach ($allArticles as $article) {
            if (stripos($article['title'], $search) !== false) {
                // Use getArticleById for full article
                $foundArticle = $articleRepo->getArticleById($article['id']);
                break;
            }
        }
        if ($foundArticle !== null) {
            // Show found article
            ?>
            <div class="card bg-gray-800 p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-white">
                    <?= htmlspecialchars($foundArticle->getTitle(), ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <p class="text-gray-400">
                    <?= htmlspecialchars($foundArticle->getUrl(), ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>
            <?php
        } else {
            echo "<p class='text-center text-gray-500'>No article found matching '$search'.</p>";
        }
    } else {
        // Pagination settings
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Get total articles and pages
        $totalArticles = $articleRepo->getCount('');
        $totalPages = ceil($totalArticles / $limit);

        // Get articles for current page
        $articles = $articleRepo->getArticles();
        $articles = array_slice($articles, $offset, $limit);

        if (empty($articles)) {
            echo "<p class='text-center text-gray-500'>No articles found.</p>";
        } else {
            // Show article cards
            echo '<div class="space-y-4">';
            foreach ($articles as $article) {
                ?>
                <div class="card bg-gray-800 p-4 rounded-lg shadow-md relative">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="text-xl font-semibold text-white flex-1">
                            <a href="<?= htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8'); ?>"
                               target="_blank" class="text-blue-400 hover:underline">
                                <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h3>
                        <p class="text-gray-400 text-sm sm:ml-4 flex-1">
                            <?= htmlspecialchars($article['description'] ?? 'No description available.', ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                    <p class="text-gray-400 text-sm flex items-center space-x-2 mt-2">
                        <span>Posted by</span>
                        <?php
                        $profilePicturePath = '/images/' . htmlspecialchars($article['profile_picture'] ?? 'default.jpg', ENT_QUOTES, 'UTF-8');
                        ?>
                        <img src="<?= $profilePicturePath; ?>" alt="Author Picture" class="w-6 h-6 rounded-full">
                        <span>
                                    <?= htmlspecialchars($article['author_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8'); ?>
                                    on <?= isset($article['created_at']) ? date('l, F jS Y, g:i A', strtotime($article['created_at'])) : 'Unknown Date'; ?>
                                </span>
                    </p>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $article['author_id']) : ?>
                        <div class="absolute top-3 right-3 flex space-x-2">
                            <a href="/articles/edit?id=<?= $article['id']; ?>" class="text-yellow-400 hover:text-yellow-300">✏️</a>
                            <form method="POST" action="/articles/delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="hidden" name="title" value="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this article?')" class="text-red-500 hover:text-red-400 cursor-pointer">🗑️</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            }
            echo '</div>';

            // Pagination links
            ?>
            <div class="pagination flex items-center justify-between mt-6">
                <a href="?page=<?= $page - 1 ?>" class="bg-indigo-500 text-white p-2 rounded <?php if ($page <= 1) echo 'opacity-50 pointer-events-none'; ?>">
                    Previous
                </a>
                <span class="text-gray-300">
                            Page <?= $page ?> of <?= $totalPages ?>
                        </span>
                <a href="?page=<?= $page + 1 ?>" class="bg-indigo-500 text-white p-2 rounded <?php if ($page >= $totalPages) echo 'opacity-50 pointer-events-none'; ?>">
                    Next
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>
</body>