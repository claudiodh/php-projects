<?php
// Lab 1, part 2
$start = 1;
$end   = 100;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1, Part 2</title>
</head>

<body>

<?php for ($i = $start; $i <= $end; $i++): ?>
    <?php if ($i % 3 === 0 && $i % 5 === 0): ?>
        <strong>FizzBuzz</strong><br>
    <?php elseif ($i % 3 === 0): ?>
        <strong>Fizz</strong><br>
    <?php elseif ($i % 5 === 0): ?>
        <strong>Buzz</strong><br>
    <?php else: ?>
        <?= $i ?><br>
    <?php endif; ?>
<?php endfor; ?>

</body>

</html>