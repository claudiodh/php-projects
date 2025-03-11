<?php require_once 'header.php'?>
<?php require_once 'nav.php'?>

<body class="bg-gray-900 text-white min-h-screen">
<!-- Tailwind CSS (adjust path if needed) -->
<link href="/dist/output.css" rel="stylesheet">

<div class="card w-96 bg-slate-900 mx-auto mt-20">
    <div class="card-body p-8">
        <h2 class="card-title text-white mx-auto">Edit Article</h2>

        <!-- Flash message handling -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash-message <?= (str_contains($_SESSION['flash'], 'Invalid URL') ? 'bg-red-600' : 'bg-green-500') ?> text-white p-2 rounded mb-4">
                <?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php unset($_SESSION['flash']); ?>
            <script>
                setTimeout(() => {
                    const flashMessage = document.querySelector('.flash-message');
                    if (flashMessage) {
                        flashMessage.style.transition = 'opacity 1s ease';
                        flashMessage.style.opacity = '0';
                        setTimeout(() => {
                            flashMessage.remove();
                        }, 1000);
                    }
                }, 5000);
            </script>
        <?php endif; ?>

        <!-- Update form -->
        <form method="POST" action="/articles/update" class="space-y-6 py-4">
            <?php
            $articleId = $articleId ?? '';
            $articleTitle = $articleTitle ?? '';
            $articleUrl = $articleUrl ?? '';
            ?>
            <!-- Hidden ID Field -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($articleId, ENT_QUOTES, 'UTF-8'); ?>">

            <!-- Title Field -->
            <div class="flex items-center space-x-4">
                <label for="title" class="w-1/3 text-white">Title</label>
                <input
                        id="title"
                        name="title"
                        type="text"
                        value="<?= htmlspecialchars($articleTitle, ENT_QUOTES, 'UTF-8'); ?>"
                        class="input input-bordered w-full text-gray-800 placeholder-gray-500"
                        required
                />
            </div>

            <!-- URL Field -->
            <div class="flex items-center space-x-4">
                <label for="url" class="w-1/3 text-white">URL</label>
                <input
                        id="url"
                        name="url"
                        type="url"
                        value="<?= htmlspecialchars($articleUrl, ENT_QUOTES, 'UTF-8'); ?>"
                        class="input input-bordered w-full text-gray-800 placeholder-gray-500"
                        required
                />
            </div>

            <!-- Submit Button -->
            <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 mt-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Update Article
            </button>
        </form>
    </div>
</div>
</body>