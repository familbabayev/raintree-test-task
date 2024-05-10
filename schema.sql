CREATE DATABASE IF NOT EXISTS raintreetask;
USE raintreetask;

CREATE TABLE patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL,
    PRIMARY KEY (_id) 
);

CREATE TABLE insurance (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT(10) UNSIGNED NOT NULL, 
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (patient_id) REFERENCES patient(_id)
);

INSERT INTO patient (pn, first, last, dob) VALUES
    ('12345678901', 'John', 'Doe', '1980-01-01'),
    ('23456789012', 'Jane', 'Smith', '1992-07-15'),
    ('34567890123', 'Alice', 'Johnson', '1975-05-20'),
    ('45678901234', 'Bob', 'Lee', '1988-11-30'),
    ('00000000005', 'Carol', 'White', '1990-12-25');

INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES
    (1, 'United HealthCare', '2022-03-15', '2026-03-14'),
    (1, 'Blue Cross Blue Shield', '2021-03-15', NULL),
    (2, 'Aetna', '2018-06-01', '2020-05-31'),
    (2, 'Cigna', '2020-06-01', NULL),
    (3, 'Kaiser Permanente', '2021-01-10', '2023-01-09'),
    (3, 'Humana', '2023-01-10', '2025-01-09'),
    (4, 'Anthem', '2016-08-20', '2018-08-19'),
    (4, 'Blue Shield of California', '2025-08-20', '2027-08-19'),
    (5, 'Health Net', '2019-11-05', '2024-05-10'),
    (5, 'Molina Healthcare', '2024-05-10', '2028-05-11');
