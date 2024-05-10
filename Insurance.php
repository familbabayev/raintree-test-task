<?php

require_once 'PatientRecord.php';

class Insurance implements PatientRecord {
    private int $_id;
    private string $pn;
    private string $iname;
    private string $fromDate;
    private ?string $toDate;

    public function __construct(int $id, string $pn, string $iname, 
                                string $fromDate, ?string $toDate = null) {
        $this->_id = $id;
        $this->_pn = $pn;
        $this->iname = $iname;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return $this->pn;
    }

    public function getInsuranceName(): string {
        return $this->iname;
    }

    public function isDateCovered(string $compareDate): bool {
        // Validate and convert input date format
        $compareDateObj = DateTime::createFromFormat('m-d-y', $compareDate);
        $compareDateObj->setTime(0, 0, 0); // Set time to midnight for accurate comparison

        $fromDateObj = new DateTime($this->fromDate);

        // Handle infinite 'toDate' case
        if ($this->toDate !== null) {
            $toDateObj = new DateTime($this->toDate);

            // Date is covered if it falls within the fromDate-toDate range
            return $compareDateObj >= $fromDateObj && $compareDateObj <= $toDateObj;
        } else {
            // No end date means coverage is ongoing from 'fromDate'
            return $compareDateObj >= $fromDateObj;
        }
    }
}
