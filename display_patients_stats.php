<?php

require_once "connect_to_db.php";

$conn = connect_to_db();

// Fetches patient full names from the database
function get_patient_names(mysqli $conn): mysqli_result {
    $sql = "SELECT CONCAT(UPPER(first), ' ', UPPER(last)) AS full_name FROM patient";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Calculates statistics about letter occurrences in the names
function calculate_letter_stats(mysqli_result $names): array {
    $letterCounts = array_fill_keys(range('A', 'Z'), 0); // Initialize letter counts
    $totalLetters = 0; 

    while ($row = mysqli_fetch_assoc($names)) {
        $fullName = preg_replace("/[^A-Z]/", "", $row['full_name']); // Filter non-letters
        $letters = str_split($fullName); // Split name into an array of letters

        // Count letter occurrences in the current name
        $currentNameCounts = array_count_values($letters);

        foreach ($currentNameCounts as $letter => $count) {
            $letterCounts[$letter] += $count; // Update the total letter counts
        }

        $totalLetters += count($letters); // Update total number of letters
    }

    return ['letterCounts' => $letterCounts, 'totalLetters' => $totalLetters];
}

// Displays the calculated letter statistics in a tabular format
function display_statistics(array $stats): void {
    foreach ($stats['letterCounts'] as $letter => $count) {
        if ($count > 0) { // Only display letters with a non-zero count
            $percentage = number_format(($count / $stats['totalLetters']) * 100, 2); 
            echo "$letter\t$count\t$percentage %\n";
        }
    }
}

// Main execution
$names = get_patient_names($conn);
$stats = calculate_letter_stats($names);
display_statistics($stats);


// Release resources
mysqli_free_result($names);
mysqli_close($conn);
