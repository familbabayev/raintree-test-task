<?php

require_once "connect_to_db.php";

$conn = connect_to_db();

// Prepare the SQL query
$sql = "SELECT
			patient.pn, 
			patient.last,
			patient.first,
			insurance.iname,
			DATE_FORMAT(insurance.from_date, '%m-%d-%y') AS from_date,
			DATE_FORMAT(insurance.to_date, '%m-%d-%y') AS to_date
		FROM insurance
		JOIN patient 
			ON insurance.patient_id = patient._id 
		ORDER BY insurance.from_date ASC, patient.last ASC";

// Prepare a statement for secure execution
$stmt = mysqli_prepare($conn, $sql);

// Check if preparation was successful 
if (!mysqli_stmt_execute($stmt)) {
    die("Query execution failed: " . mysqli_stmt_error($stmt));
}

// Retrieve the results of the query
$result = mysqli_stmt_get_result($stmt);

// Loop through results and output each row with comma separation
while ($row = mysqli_fetch_assoc($result)) {
    $values = [];
    foreach($row as $key => $value) {
        $values[] = isset($value) ? $value : "N/A";
    }

    echo implode(", ", $values) . "\n"; 
}


// Release resources
mysqli_free_result($result);
mysqli_close($conn);
