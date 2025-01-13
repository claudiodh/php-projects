<?php

// Lab 1, part 1

/**
 * Remove invalid shows from the assoc. array that is passed as a parameter, 
 * and return an array which contains only valid entries.
 * 
 * Hint: look into https://www.php.net/manual/en/function.unset.php
 * 
 * @param array $shows: an associative array of shows in a format following: 
 *              ['name' => '<date string>', ...]
 * @return array: an associative array containing shows that don't have 
 *                empty strings or null values for their names and dates
 */
function filterInvalidShows(array $shows): array {
    $validShows = [];
    foreach ($shows as $name => $date) {
        if (!empty($name) && !empty($date)) {
            $validShows[$name] = $date;
        }
    }
    return $validShows;
}

/**
 * Prints the show data in a "name: <aired dates>" format.
 * 
 * @param array $shows: the shows to print
 * @return void
 */
function displayShowInfo(array $shows): void {
    echo '<ul>';
    foreach ($shows as $name => $date) {
        echo '<li><strong>' . htmlspecialchars($name) . '</strong>: ' . htmlspecialchars($date) . '</li>';
    }
    echo '</ul>';
}

// An associative array of show names and associated dates when the shows aired
$shows = [
    // Add some more shows you like to the array
    'Pokémon' => 'April 1st, 1997 - March 24th, 2023',
    'What We Do in the Shadows' => 'March 27th, 2019 - December 16th, 2024',
    'Dan Da Dan' => 'October 3rd, 2024 - December 17th, 2024',
    'Curb Your Enthusiasm' => 'October 15th, 2000 - Current',
    'Invalid data1' => '',
    'Invalid data2' => null,
    null => 'December 17, 1999 - Current',
    '' => 'December 30, 1999 - Current',
];

// Filter the shows to remove invalid entries
$filteredShows = filterInvalidShows($shows);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1, Part 1</title>
</head>

<body>

    <?php
    displayShowInfo($filteredShows);// Here, you should call your functions in order to filter and then output the show info.
    ?>

</body>

</html>