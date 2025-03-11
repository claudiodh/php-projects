<?php require_once 'header.php' ?>

<body>
<div class="card w-96 bg-black mx-auto mt-20">
    <div class="card-body">
        <h2 class="card-title text-white mx-auto">Register</h2>

        <!--  messages -->
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="<?= str_contains($_SESSION['flash'], 'success') ? 'text-green-500' : 'text-red-500' ?> text-center">
                <?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8') ?>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <form class="space-y-6 py-8" action="/register" method="POST">
            <div>
                <label for="name" class="text-white">Name</label>
                <input
                        id="name"
                        name="name"
                        type="text"
                        placeholder="Your name"
                        class="input input-bordered w-full max-w-xs text-gray-800"
                        value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
                        required
                >
            </div>

            <div>
                <label for="email" class="text-white">Email address</label>
                <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Your email"
                        class="input input-bordered w-full max-w-xs text-gray-800"
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                        required
                >
            </div>

            <div>
                <label for="password" class="text-white">Password</label>
                <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Your password"
                        class="input input-bordered w-full max-w-xs text-gray-800"
                        required
                >
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                Register
            </button>

            <div class="flex justify-center mt-4 text-white">
                Already have an account?&nbsp;
                <a href="/login" class="text-indigo-600 hover:text-indigo-500">
                    Login
                </a>
            </div>
        </form>
    </div>
</div>
</body>