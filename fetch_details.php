<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

header('Content-Type: application/json');

$output = array();

$searchTerm = $_GET['search'];


if ($_GET['content'] == 'fetchDetails') {
    $sql = $override->fetchDetails('clients', $searchTerm, 'firstname', 'middlename', 'lastname', 'study_id');
    if ($sql) {
        echo "<table>";
        echo "<tr><th>Column1</th><th>Column2</th><th>Column3</th></tr>";
        foreach ($sql as $value) {
            echo "<tr><td>" . $value['firstname'] . "</td><td>" . $value['firstname'] . "</td><td>" . $value['firstname'] . "</td><td>" . $value['study_id'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found";
    }

    // echo json_encode($output);

}

// $output = array();
// $searchTerm = $_GET['search'];

// if ($_GET['content'] == 'fetchDetails') {
//     $sql = $override->fetchDetails('clients', $searchTerm, 'firstname', 'middlename', 'lastname', 'study_id');
//     if ($sql) {
//         foreach ($sql as $value) {
//             $output[] = $value['firstname'];
//         }
//     } else {
//         echo "No results found";
//     }

//     echo json_encode($output);
// }
