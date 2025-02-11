<?php

use src\Repositories\PostRepository;

require_once '../Repositories/PostRepository.php';

$post = (new PostRepository())->findById((int)$_GET['id']);
?>
<!doctype html>
<html lang="en">
<?php require_once 'layout/header.php' ?>
<?php require_once 'navigation/navigation_header.php' ?>

<body>

    <div class="mx-auto max-w-2xl mt-10">
        <?php if ($post): ?>
        <div class="bg-white shadow sm:rounded-lg">
            <div class="inline-block float-right mr-4 mt-5">
                <a href="update.php?id=<?= $post->getId() ?>"
                    class="inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="black" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </a>

                <a href="delete.php?id=<?= $post->getId() ?>"
                    class="inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="red" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </a>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-lg font-medium leading-6 text-gray-900">
                    <?= $post->getTitle(); ?></h2>
                <p class="mt-10"><?= $post->getBody(); ?></p>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <small>Posted
                        <?= $post->getCreatedAtFmt(); ?></small>
                    <?php if ($post->getUpdatedAt() !== null): ?>
                    <div>
                        <small>Edited on
                            <?= $post->getUpdatedAtFmt(); ?></small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mt-3 text-sm">
                    <a href="/" class="font-medium text-indigo-600 hover:text-indigo-500">
                        <span aria-hidden="true">&larr;</span>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</body>

</html>