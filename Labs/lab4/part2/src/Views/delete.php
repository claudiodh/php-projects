<?php

require_once __DIR__ . '/../Repositories/PostRepository.php';

use src\Repositories\PostRepository;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $postRepository = new PostRepository();

        try {
            $post = $postRepository->findById($_GET['id']);

            if ($post) {
                $postRepository->delete($post);
                $_SESSION['flash_message'] = 'Post deleted successfully.';
            } else {
                $_SESSION['flash_message'] = 'Post not found.';
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = 'An error occurred: ' . $e->getMessage();
        }
    } else {
        $_SESSION['flash_message'] = 'No post ID provided.';
    }
    header('Location: index.php');
    exit();
}
