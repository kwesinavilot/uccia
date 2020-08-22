--This is the main database file for users and their activities

DROP DATABASE uccia;      #Comment out if the database is not to be deleted

CREATE DATABASE uccia
CHARACTER SET utf8
COLLATE utf8_general_ci;
USE uccia;

CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
    ucciaID VARCHAR(10) NOT NULL UNIQUE,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    picture VARCHAR(40),
    date_created TIMESTAMP
);

CREATE TABLE login (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ucciaID VARCHAR(10) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(65) NOT NULL,
    verify VARCHAR(32) UNIQUE,
    reset VARCHAR(32) UNIQUE,
    FOREIGN KEY(ucciaID)
    REFERENCES users(ucciaID)
);

CREATE TABLE classes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    class_short VARCHAR(13) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    size INT(4) NOT NULL,
    level INT(3) NOT NULL,
    degree SET("BSc", "BA", "BEd", "BCom"),
    department VARCHAR(100) NOT NULL,
    shool VARCHAR(100) NOT NULL,
    college VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    studentID VARCHAR(10) NOT NULL UNIQUE,
    class_short VARCHAR(10) NOT NULL,
    picture VARCHAR(40),
    qrfile VARCHAR(40),
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    other_names VARCHAR(30),
    index_number VARCHAR(15) NOT NULL UNIQUE,
    hall VARCHAR(20) NOT NULL,
    nationality VARCHAR(30) NOT NULL,
    pin VARCHAR(4),
    description TEXT,
    FOREIGN KEY(class_short)
    REFERENCES classes(class_short)
);

CREATE TABLE exams (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(7) NOT NULL UNIQUE,
    class_short VARCHAR(13) NOT NULL,
    date date NOT NULL,
    start_time time NOT NULL,
    close_time time NOT NULL,
    venue VARCHAR(25) NOT NULL,
    description TEXT,
    FOREIGN KEY(class_short)
    REFERENCES classes(class_short)
);

CREATE TABLE invigilators (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invigilatorID VARCHAR(10) NOT NULL UNIQUE,
    picture VARCHAR(40),
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    other_names VARCHAR(30),
    department VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE exam_and_invigilators (
    id INT PRIMARY KEY AUTO_INCREMENT,
    class_short VARCHAR(13),
    course_code VARCHAR(7),
    invigilatorID VARCHAR(10),
    FOREIGN KEY(invigilatorID) REFERENCES invigilators(invigilatorID),
    FOREIGN KEY(course_code) REFERENCES exams(course_code),
    FOREIGN KEY(class_short) REFERENCES classes(class_short)
);

CREATE TABLE halls (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL
);

INSERT INTO halls(name)
VALUES("Valco"), ("ATL"),
("Adehye"), ("Casford"),
("Ogua"), ("KNH"),
("SRC"), ("Superanuation")

GRANT SELECT, INSERT, UPDATE ON uccia.users to client@localhost;
GRANT SELECT, INSERT, UPDATE ON uccia.login to client@localhost;
GRANT SELECT, INSERT, UPDATE ON uccia.classes to client@localhost;
GRANT SELECT, INSERT, UPDATE ON uccia.students to client@localhost;
GRANT SELECT, INSERT, UPDATE ON uccia.exams to client@localhost;
GRANT SELECT, INSERT, UPDATE ON uccia.invigilators to client@localhost;

GRANT SELECT, INSERT, UPDATE, DELETE ON uccia.* to admin@localhost;
FLUSH PRIVILEGES;