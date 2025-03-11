<?php require_once 'header.php'; ?>

<body class="bg-gray-900 text-white min-h-screen">
<?php require_once 'nav.php'; ?>

<!-- Wider card with extra spacing -->
<div class="card w-11/12 max-w-2xl bg-black mx-auto mt-20 p-8">
    <div class="card-body">
        <h2 class="card-title text-white mx-auto">Settings</h2>

        <!-- Flash message styled like register.view.php -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="<?= str_contains($_SESSION['flash'], 'updated') ? 'text-green-500' : 'text-red-500' ?> text-center">
                <?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8') ?>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <!-- Settings form -->
        <form method="POST" action="/settings" enctype="multipart/form-data" class="space-y-6 py-8">
            <!-- Email field (readonly and greyed out) -->
            <div class="flex items-center space-x-4">
                <label for="email" class="w-1/3 text-white">Email (cannot be changed)</label>
                <input id="email" type="email" name="email"
                       value="<?= htmlspecialchars($userEmail ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                       class="input input-bordered w-full bg-gray-200 cursor-not-allowed"
                       readonly disabled />
            </div>

            <!-- Username field -->
            <div class="flex items-center space-x-4">
                <label for="username" class="w-1/3 text-white">Username</label>
                <input id="username" type="text" name="username"
                       value="<?= htmlspecialchars($userName ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                       class="input input-bordered w-full text-gray-800" />
            </div>

            <!-- Profile picture field -->
            <div class="flex items-center space-x-4">
                <label for="profile_picture" class="w-1/3 text-white">Photo</label>
                <div class="flex items-center space-x-4 w-full">
                    <?php if (!empty($profilePicture)): ?>
                        <img src="/images/<?= htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="Profile Picture" class="w-16 h-16 object-cover rounded-full" />
                    <?php else: ?>
                        <img src="/images/default.jpg"
                             alt="Default Profile Picture" class="w-16 h-16 object-cover rounded-full" />
                    <?php endif; ?>
                    <!-- Removed max-w-xs so the file input can expand more -->
                    <input type="file" name="profile_picture" id="profile_picture"
                           class="file-input file-input-bordered w-full bg-white text-gray-800" />
                </div>
            </div>

            <!-- Submit button -->
            <div class="flex items-center justify-end">
                <button type="submit" class="py-2 px-4 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
</body>