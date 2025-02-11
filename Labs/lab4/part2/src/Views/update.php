<?php

require_once './../Repositories/PostRepository.php';

use src\Models\Post;
use src\Repositories\PostRepository;

$postRepository = new PostRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $post = $postRepository->findById($id);

    $body = $_POST['body'];
    $title = $_POST['title'];

    $post->setBody($body);
    $post->setTitle($title);

    $postRepository->update($post);

    // TODO: We're currently missing error handling + session flash messages here

    header("Location: post.php?id=$id");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $post = $postRepository->findById($_GET['id']);
        if (!$post) {
            // ID passed in, but no post has the ID
            // We'll just redirect and kill the script if there's no post with the given ID
            header('Location: index.php');
            exit();
        }
    } else {
        // No ID passed in
        header('Location: index.php');
        exit();
    }
} else {
    // In any cases other than GET/POST requests.
    header('Location: index.php');
    exit();
}

?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">

<?php require_once 'layout/header.php' ?>

<body class="h-full">
    <?php require_once 'navigation/navigation_header.php' ?>

    <!-- conditionally render if $post exists -->
    <?php if (isset($post)): ?>
    <div>
        <div class="mt-10">
            <div class="mx-auto max-w-2xl bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="update.php" method="POST">
                    <input type="hidden" name="id"
                        value="<?= $post->getId() ?>">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700"> Post Title </label>
                        <div class="mt-1">
                            <input placeholder="A title for your post"
                                value="<?= $post->getTitle() ?>"
                                id="title" name="title" type="text"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700"> Body </label>
                        <div class="mt-1">
                            <textarea placeholder="Anything you like here!" rows="3" id="body" name="body"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= $post->getBody() ?></textarea>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php endif; ?>


</body>

</html>