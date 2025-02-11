<?php
// Database Connection
$dsn = "mysql:host=localhost;dbname=c3015_lab4;charset=utf8mb4";
$pdo = new PDO($dsn, "root", "totodile", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Handle Adding Items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $itemName = trim($_POST['item_name']);
    $quantity = intval($_POST['quantity']);

    if (!empty($itemName) && $quantity > 0) {
        $stmt = $pdo->prepare("INSERT INTO inventory (item_name, quantity) VALUES (:item_name, :quantity)");
        $stmt->execute(['item_name' => $itemName, 'quantity' => $quantity]);
    }
    header("Location: index.php"); // Redirect to prevent duplicate submissions
    exit;
}

// Handle Deleting Items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_item'])) {
    $id = intval($_POST['id']);
    $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: index.php");
    exit;
}

// Handle Search
$searchQuery = "";
$items = [];
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE item_name LIKE :search");
    $stmt->execute(['search' => "%$searchQuery%"]);
    $items = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT * FROM inventory");
    $items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">

<h1 class="text-2xl font-bold text-center mb-6">Grocery Store Inventory</h1>

<!-- Add Item Form -->
<form method="POST" class="mb-6 bg-white p-4 rounded shadow-md">
    <label>Grocery: <input type="text" name="item_name" placeholder="eg. Pineapples" required class="p-2 border rounded w-full mb-2"></label>
    <label>Quantity: <input type="number" name="quantity" placeholder="" required class="p-2 border rounded w-full mb-2"></label>
    <button type="submit" name="add_item" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Add</button>
</form>

<!-- Search Form -->
<form method="GET" class="mb-6 bg-white p-4 rounded shadow-md">
    <input type="text" name="search" placeholder="Search Inventory" value="<?= htmlspecialchars($searchQuery) ?>" class="p-2 border rounded w-full mb-2">
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Search</button>
    <a href="index.php" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded">Reset</a>
</form>

<!-- Inventory List -->
<div class="bg-white p-4 rounded shadow-md">
    <h2 class="font-bold text-lg mb-3">Inventory</h2>
    <?php if (empty($items)) : ?>
        <p class="text-center text-gray-500">No items found.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($items as $item) : ?>
                <li class="flex justify-between items-center p-2 border-b">
                    <span><?= htmlspecialchars($item['item_name']) ?> - <?= $item['quantity'] ?></span>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" name="delete_item" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>