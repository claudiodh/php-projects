<?php
//require_once realpath(__DIR__ . '/../helpers/helpers.php');
$pageTitle = $pageTitle ?? 'COMP 3015 News';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="./dist/output.css">
</head>