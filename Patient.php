<?php

require_once 'PatientRecord.php';

class Patient implements PatientRecord {
    private int $_id;
    private string $pn;
    private string $first;
    private string $last;
    private string $dob;
    private array $insuranceRecords = [];

    public function __construct(int $id, string $pn, string $first, string $last, string $dob) {
        $this->_id = $id;
        $this->pn = $pn;
        $this->first = $first;
        $this->last = $last;
        $this->dob = $dob;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return $this->pn;
    }

    public function getFullName(): string {
        return $this->first . ' ' . $this->last;
    }

    public function getInsuranceRecords(): array {
        return $this->insuranceRecords;
    }

    public function addInsuranceRecord(Insurance $insuranceRecord): void {
        $this->insuranceRecords[] = $insuranceRecord;
    }

    // Method to generate a report of active insurance coverage for a target date
    public function generateInsuranceReport(string $targetDate): void {
        // Validate and convert input date format
        $targetDateObj = DateTime::createFromFormat('m-d-y', $targetDate);
        if (!$targetDateObj) {
            throw new InvalidArgumentException("Invalid date format. Please use 'm-d-y' format.");
        }

        // Iterate through each insurance record
        foreach ($this->insuranceRecords as $insuranceRecord) {
            // Check if the target date is covered by the insurance
            $isValid = $insuranceRecord->isDateCovered($targetDate) ? 'Yes' : 'No';
            
            // Output patient information and insurance status 
            echo $this->getPatientNumber() . ", " . $this->getFullName() . ", " .
                $insuranceRecord->getInsuranceName() . ", " . $isValid . "\n";
        }
    }

}