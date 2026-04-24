-- Run this in phpMyAdmin (http://localhost/phpmyadmin)

CREATE DATABASE IF NOT EXISTS dbstudents;

USE dbstudents;

CREATE TABLE IF NOT EXISTS students (
    id             INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(100) NOT NULL,
    surname        VARCHAR(100) NOT NULL,
    middlename     VARCHAR(100),
    address        TEXT,
    contact_number VARCHAR(20)
);
