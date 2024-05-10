<?php

interface PatientRecord {
    public function getId(): int;

    public function getPatientNumber(): string;
}