<?php

require_once 'connect_to_db.php';
require_once 'Patient.php';
require_once 'Insurance.php';

$conn = connect_to_db();

// Function to load all patients 
function loadPatients(mysqli $conn): array {
    $patients = []; // Array to store loaded patient objects

    $sql = "SELECT * FROM patient ORDER BY pn ASC"; // Query to fetch all patient data
    $result = $conn->query($sql);

    // Iterate through query results
    while ($row = $result->fetch_assoc()) {
        $patient = new Patient($row['_id'], $row['pn'], $row['first'], $row['last'], $row['dob']);

        // Fetch insurance records for this patient
        $insuranceRecords = loadInsuranceRecords($conn, $row['_id']);

        // Add insurance records to the patient object
        foreach ($insuranceRecords as $record) {
            $patient->addInsuranceRecord($record);
        }

        // Add the completed patient object to the array
        $patients[] = $patient;
    }

    return $patients;
}

// Function to load insurance records for a patient
function loadInsuranceRecords(mysqli $conn, int $patientId): array {
    $insuranceRecords = [];

    // Query to fetch insurances for specific patient
    $sql = "SELECT * FROM insurance WHERE patient_id = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i", $patientId); // Bind the patient ID as a parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Iterate through insurance results
    while ($row = $result->fetch_assoc()) {
        $insuranceRecords[] = new Insurance($row['_id'], $row['patient_id'], $row['iname'], 
                                            $row['from_date'], $row['to_date']);
    }

    $stmt->close(); // Close the prepared statement
    return $insuranceRecords;
}

// Get today's date for comparison
$today = date('m-d-y');

// Load patients from the database
$patients = loadPatients($conn);

// Generate insurance reports for each patient
foreach ($patients as $patient) {
    try {
        $patient->generateInsuranceReport($today);
    } catch (Exception $e) {
        echo "Error occurred: " . $e->getMessage(); 
    }
}

// Close the database connection
mysqli_close($conn);
