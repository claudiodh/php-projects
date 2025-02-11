<?php

require_once './../Repositories/PostRepository.php';

use src\Models\Post;
use src\Repositories\PostRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = $_POST['body'];
    $title = $_POST['title'];

    try {
        $post = new Post(title: $title, body: $body);
        (new PostRepository())->save($post);
        $_SESSION['flash_message'] = 'Post added successfully.';
        header("Location: post.php?id=" . $post->getId());
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'An error occurred: ' . $e->getMessage();
        header("Location: add.php");
    }
    exit();
}

?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">

<?php require_once 'layout/header.php' ?>

<body class="h-full">
    <?php require_once 'navigation/navigation_header.php' ?>
    <div>

        <div class="mt-10">
            <div class="mx-auto max-w-2xl bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="add.php" method="POST">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700"> Post Title </label>
                        <div class="mt-1">
                            <input placeholder="A title for your post" id="title" name="title" type="text"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700"> Body </label>
                        <div class="mt-1">
                            <textarea placeholder="Anything you like here!" rows="3" id="body" name="body"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Post!
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>


</body>

</html>