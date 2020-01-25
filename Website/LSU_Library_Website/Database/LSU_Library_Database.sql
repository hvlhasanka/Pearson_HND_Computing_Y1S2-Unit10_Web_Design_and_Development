
-- Creating new database named 'LSULibraryDB'
CREATE DATABASE LSULibraryDB;

-- Accessing LSULibraryDB database
USE LSULibraryDB;


-- Creating Table 1 - LoginMembershipType
CREATE TABLE LoginMembershipType(
  MembershipTypeID INT AUTO_INCREMENT,
  MembershipType VARCHAR(9) NOT NULL,
  PRIMARY KEY (MembershipTypeID)
)ENGINE = INNODB;

-- Inserting records to Table 1 - LoginMembershipType
INSERT INTO LoginMembershipType (MembershipType) VALUES
('Student'),
('Professor'),
('Librarian');

-- Creating Table 2 - Login
CREATE TABLE Login(
  LoginID INT AUTO_INCREMENT,
  Username VARCHAR(15) NOT NULL,
  Password CHAR(40) NOT NULL,
  lmtMembershipTypeID INT NOT NULL,
  CreationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  EditDateTime DATETIME,
  PRIMARY KEY (LoginID),
  FOREIGN KEY (lmtMembershipTypeID) REFERENCES LoginMembershipType (MembershipTypeID)
)ENGINE = INNODB;

-- Inserting records to Table 2 - Login
INSERT INTO Login(Username, Password, lmtMembershipTypeID) VALUES
('jakeanderson52', SHA1('andRewsand_er2'), 1);

-- Creating Table 3 - MemberCity
CREATE TABLE MemberCity(
  MemberCityID INT AUTO_INCREMENT,
  City VARCHAR(30) NOT NULL,
  PRIMARY KEY (MemberCityID)
)ENGINE = INNODB;

-- Inserting records to Table 3 - MemberCity
INSERT INTO MemberCity(City) VALUES
('Battaramulla'),
('Colombo'),
('Kandy'),
('Galle'),
('Jaffna');

-- Creating Table 4 - MemberZipPostalCode
CREATE TABLE MemberZipPostalCode(
  MemberZipPostalCodeID INT AUTO_INCREMENT,
  ZipPostalCode INT(5) NOT NULL,
  PRIMARY KEY (MemberZipPostalCodeID)
)ENGINE = INNODB;

-- Inserting records to Table 4 - MemberZipPostalCode
INSERT INTO MemberZipPostalCode(ZipPostalCode) VALUES
(00500),
(00100),
(01300),
(10250),
(10230);

-- Creating Table 5 - MemberProvience
CREATE TABLE MemberProvience(
  MemberProvienceID INT AUTO_INCREMENT,
  Provience VARCHAR(12) NOT NULL,
  PRIMARY KEY (MemberProvienceID)
)ENGINE = INNODB;

-- Inserting records to Table 5 - MemberProvience
INSERT INTO MemberProvience(Provience) VALUES
('Central'),
('Eastern'),
('North Central'),
('Northern'),
('North Western'),
('Sabaragamuwa'),
('Southern'),
('Uva'),
('Western');

-- Creating Table 6 - MemberType
CREATE TABLE MemberType(
  MemberTypeID INT AUTO_INCREMENT,
  MemberType VARCHAR(9) NOT NULL,
  PRIMARY KEY (MemberTypeID)
)ENGINE = INNODB;

-- Inserting records to Table 6 - MemberType
INSERT INTO MemberType(MemberType) VALUES
('Student'),
('Professor');

-- Creating Table 7 - MembershipStatus
CREATE TABLE MembershipStatus(
  MembershipStatusID INT AUTO_INCREMENT,
  MembershipStatus VARCHAR(11) NOT NULL,
  PRIMARY KEY (MembershipStatusID)
)ENGINE = INNODB;

-- Inserting records to Table 7 - MembershipStatus
INSERT INTO MembershipStatus(MembershipStatus) VALUES
('Active'),
('Expired'),
('Cancelled'),
('Deactivated');

-- Creating Table 8 - MemberPosition
CREATE TABLE MemberPosition(
  MemberPositionID INT AUTO_INCREMENT,
  Position VARCHAR(21) NOT NULL,
  PRIMARY KEY (MemberPositionID)
)ENGINE = INNODB;

-- Inserting records to Table 8 - MemberPosition
INSERT INTO MemberPosition(Position) VALUES
('Undergraduate Student'),
('Postgraduate Student'),
('Alumni'),
('Professor'),
('Senior Professor'),
('Executive Professor');

-- Creating Table 9 - MemberFaculty
CREATE TABLE MemberFaculty(
  MemberFacultyID INT AUTO_INCREMENT,
  Faculty VARCHAR(22) NOT NULL,
  PRIMARY KEY (MemberFacultyID)
)ENGINE = INNODB;

-- Inserting records to Table 9 - MemberFaculty
INSERT INTO MemberFaculty(Faculty) VALUES
('Faculty of Engineering'),
('Faculty of Science'),
('Faculty of Computing'),
('Faculty of Business');

-- Creating Table 10 - Member
CREATE TABLE Member(
  UniversityID INT(8) NOT NULL,
  FirstName VARCHAR(30) NOT NULL,
  MiddleName VARCHAR(30),
  LastName VARCHAR(50) NOT NULL,
  Email VARCHAR(50) NOT NULL,
  StreetAddress VARCHAR(40) NOT NULL,
  mcMemberCityID INT NOT NULL,
  mzpcMemberZipPostalCodeID INT NOT NULL,
  mpMemberProvienceID INT NOT NULL,
  MobilePhoneNumber VARCHAR(11) NOT NULL,
  LandPhoneNumber VARCHAR(11),
  mtMemberTypeID INT NOT NULL,
  msMembershipStatusID INT NOT NULL,
  mpMemberPositionID INT NOT NULL,
  mfMemberFacultyID INT NOT NULL,
  RegistrationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  EditDateTime DATETIME,
  lLoginID INT NOT NULL,
  PRIMARY KEY (UniversityID),
  FOREIGN KEY (mcMemberCityID) REFERENCES MemberCity(MemberCityID),
  FOREIGN KEY (mzpcMemberZipPostalCodeID) REFERENCES MemberZipPostalCode(MemberZipPostalCodeID),
  FOREIGN KEY (mpMemberProvienceID) REFERENCES MemberProvience(MemberProvienceID),
  FOREIGN KEY (mtMemberTypeID) REFERENCES MemberType(MemberTypeID),
  FOREIGN KEY (msMembershipStatusID) REFERENCES MembershipStatus(MembershipStatusID),
  FOREIGN KEY (mpMemberPositionID) REFERENCES MemberPosition(MemberPositionID),
  FOREIGN KEY (mfMemberFacultyID) REFERENCES MemberFaculty(MemberFacultyID),
  FOREIGN KEY (lLoginID) REFERENCES Login(LoginID)
)ENGINE = INNODB;

-- Inserting records to Table 10 - Member
INSERT INTO Member
(UniversityID, FirstName, MiddleName, LastName, Email, StreetAddress, mcMemberCityID, mzpcMemberZipPostalCodeID,
  mpMemberProvienceID, MobilePhoneNumber, LandPhoneNumber, mtMemberTypeID, msMembershipStatusID, mpMemberPositionID,
  mfMemberFacultyID, lLoginID) VALUES
(10004392, 'Jake', 'Andrews', 'Anderson', 'jakeanderson12@gmail.com', '818 School Park', 1, 1, 9, '089-5874693',
  '034-1569634', 1, 1, 1, 3, 1);

-- Creating Table 11 - Student
CREATE TABLE Student(
  mUniversityID INT NOT NULL,
  DegreeProgram VARCHAR(50),
  Batch VARCHAR(20),
  PRIMARY KEY (mUniversityID),
  FOREIGN KEY (mUniversityID) REFERENCES Member(UniversityID)
)ENGINE = INNODB;

-- Inserting records to Table 11 - Student
INSERT INTO Student VALUES
(10004392, 'BSc(Hons) in Software Engineering', 'Fall 2017');

-- Creating Table 12 - Professor
-- Inserting records to Table 12 - Professor

-- Creating Table 13 - LibrarianCity
CREATE TABLE LibrarianCity(
  LibrarianCityID INT AUTO_INCREMENT,
  City VARCHAR(30) NOT NULL,
  PRIMARY KEY (LibrarianCityID)
)ENGINE = INNODB;

-- Inserting records to Table 13 - LibrarianCity
INSERT INTO LibrarianCity(City) VALUES
('Battaramulla'),
('Colombo'),
('Kandy'),
('Galle'),
('Jaffna');

-- Creating Table 14 - LibrarianZipPostalCode
CREATE TABLE LibrarianZipPostalCode(
  LibrarianZipPostalCodeID INT AUTO_INCREMENT,
  ZipPostalCode INT(5) NOT NULL,
  PRIMARY KEY (LibrarianZipPostalCodeID)
)ENGINE = INNODB;

-- Inserting records to Table 14 - LibrarianZipPostalCode
INSERT INTO LibrarianZipPostalCode(ZipPostalCode) VALUES
(00500),
(00100),
(01300),
(10250),
(10230);

-- Creating Table 15 - LibrarianProvience
CREATE TABLE LibrarianProvience(
  LibrarianProvienceID INT AUTO_INCREMENT,
  Provience VARCHAR(12) NOT NULL,
  PRIMARY KEY (LibrarianProvienceID)
)ENGINE = INNODB;

-- Inserting records to Table 15 - LibrarianProvience
INSERT INTO LibrarianProvience(Provience) VALUES
('Central'),
('Eastern'),
('North Central'),
('Northern'),
('North Western'),
('Sabaragamuwa'),
('Southern'),
('Uva'),
('Western');

-- Creating Table 16 - Librarian
CREATE TABLE Librarian(
  LibrarianID INT(8) AUTO_INCREMENT,
  FirstName VARCHAR(30) NOT NULL,
  MiddleName VARCHAR(30),
  LastName VARCHAR(50) NOT NULL,
  Email VARCHAR(50) NOT NULL,
  StreetAddress VARCHAR(40) NOT NULL,
  lcLibrarianCityID INT NOT NULL,
  lzpcLibrarianZipPostalCodeID INT NOT NULL,
  lpLibrarianProvienceID INT NOT NULL,
  MobilePhoneNumber VARCHAR(11) NOT NULL,
  LandPhoneNumber VARCHAR(11),
  RegistrationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  lLoginID INT NOT NULL,
  PRIMARY KEY (LibrarianID),
  FOREIGN KEY (lcLibrarianCityID) REFERENCES LibrarianCity(LibrarianCityID),
  FOREIGN KEY (lzpcLibrarianZipPostalCodeID) REFERENCES LibrarianZipPostalCode(LibrarianZipPostalCodeID),
  FOREIGN KEY (lpLibrarianProvienceID) REFERENCES LibrarianProvience(LibrarianProvienceID),
  FOREIGN KEY (lLoginID) REFERENCES Login(LoginID)
)ENGINE = INNODB;

-- Inserting records to Table 16 - Librarian
INSERT INTO Librarian
(FirstName, MiddleName, LastName, Email, StreetAddress, lcLibrarianCityID, lzpcLibrarianZipPostalCodeID,
  lpLibrarianProvienceID, MobilePhoneNumber, LandPhoneNumber, RegistrationDateTime, lLoginID) VALUES
('Nickie', 'Weber', 'Langham', 'nlanghame@mail.ru', '959 Golf Course Alley', 1, 1, 9, '015-8521592', '034-8521596',
  '2020-01-01 09:23:34.131', 1);


-- Creating Table 17 - LibrarianManageMember
CREATE TABLE LibrarianManageMember(
  lLibrarianID INT NOT NULL,
  mUniversityID INT(8) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLibrarianID, mUniversityID, EditDateTime),
  FOREIGN KEY (lLibrarianID) REFERENCES Librarian(LibrarianID),
  FOREIGN KEY (mUniversityID) REFERENCES Member(UniversityID)
)ENGINE = INNODB;

-- Inserting records to Table 17 - LibrarianManageMember


-- Creating Table 18 - BookAvailability
CREATE TABLE BookAvailability(
  ID INT AUTO_INCREMENT,
  Availability VARCHAR(15) NOT NULL,
  PRIMARY KEY (ID)
)ENGINE = INNODB;

-- Inserting records to Table 18 - BookAvailability
INSERT INTO BookAvailability(Availability) VALUES
('Available'),      -- BAID: 1
('Not Available'),  -- BAID: 2
('Pending'),        -- BAID: 3
('Reserved'),       -- BAID: 4
('Borrowed');       -- BAID: 5

-- Creating Table 19 - BookCatalog
CREATE TABLE BookCatalog(
  ID INT AUTO_INCREMENT,
  Name VARCHAR(40) NOT NULL,
  NoOfBooks INT DEFAULT '0',
  CreatedDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 19 - BookCatalog
ALTER TABLE BookCatalog AUTO_INCREMENT = 22450001;

-- Inserting records to Table 19 - BookCatalog
INSERT INTO BookCatalog (Name, CreatedDateTime) VALUES
('Computing', '2020-01-02 10:25:34.131'); -- ID: 22450001

-- Creating Table 20 - Book
CREATE TABLE Book(
  ISBN VARCHAR(17) NOT NULL,
  Name VARCHAR(200) NOT NULL,
  baID INT NOT NULL,
  RegisteredDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ISBN),
  FOREIGN KEY (baID) REFERENCES BookAvailability (ID)
)ENGINE = INNODB;

-- Inserting records to Table 20 - Book
INSERT INTO Book (ISBN, Name, baID, RegisteredDateTime) VALUES
('978-0984782857', 'Cracking the Coding Interview: 189 Programming Questions and Solutions 6th Edition',
  1, '2020-01-01 12:34:06.693'),
('978-1517671273', 'Elements of Programming Interviews in Java: The Insiders'' Guide 2nd Edition',
  2, '2020-01-01 12:39:23.234');

-- Creating Table 21 - BookCatalogHasBook
CREATE TABLE BookCatalogHasBook(
  bcID INT NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  PRIMARY KEY (bcID, bISBN),
  FOREIGN KEY (bcID) REFERENCES BookCatalog (ID),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN)
)ENGINE = INNODB;

-- Inserting records to Table 21 - BookCatalogHasBook
INSERT INTO BookCatalogHasBook VALUES
(22450001, '978-0984782857'),
(22450001, '978-1517671273');

-- Updating the NoOfBooks in book catalog
UPDATE BookCatalog SET NoOfBooks = 2 WHERE ID = 22450001;

-- Creating Table 22 - ReservedBook
CREATE TABLE ReservedBook(
  bISBN VARCHAR(17) NOT NULL,
  ReservedDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (bISBN, ReservedDateTime)
)ENGINE = INNODB;

-- Inserting records to Table 22 - ReservedBook
INSERT INTO ReservedBook VALUES
('978-0984782857', '2020-01-02 14:23:12.233');


-- Creating Table 23 - BookAuthor
CREATE TABLE BookAuthor(
  bISBN VARCHAR(17) NOT NULL,
  Author VARCHAR(50) NOT NULL,
  PRIMARY KEY (bISBN, Author),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN)
)ENGINE = INNODB;

-- Inserting records to Table 23 - BookAuthor
INSERT INTO BookAuthor VALUES
('978-0984782857', 'Gayle Laakmann McDowell'),
('978-1517671273', 'Adnan Aziz'),
('978-1517671273', 'Tsung-Hsien Lee');

-- Creating Table 24 - LibrarianManageBook
CREATE TABLE LibrarianManageBook(
  lLibrarianID INT NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLibrarianID, bISBN, EditDateTime),
  FOREIGN KEY (lLibrarianID) REFERENCES Librarian (LibrarianID),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN)
)ENGINE = INNODB;

-- Inserting records to Table 24 - LibrarianManageBook


-- Creating Table 25 - BorrowDetails
CREATE TABLE BorrowDetails(
  ID INT AUTO_INCREMENT,
  BorrowDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  ReturnDateTime DATETIME NOT NULL,
  LateFine FLOAT,
  PRIMARY KEY (ID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 25 - BorrowDetails
ALTER TABLE BorrowDetails AUTO_INCREMENT = 44250001;

-- Inserting records to Table 25 - BorrowDetails
INSERT INTO BorrowDetails (BorrowDateTime, ReturnDateTime) VALUES
('2020-01-03 09:12:43.233', '2020-01-05 12:52:02.233');  -- BDID: 44250001

-- Creating Table 26 - Borrow
CREATE TABLE Borrow(
  mUniversityID INT(8) NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  bdID INT NOT NULL,
  PRIMARY KEY (mUniversityID, bISBN, bdID),
  FOREIGN KEY (mUniversityID) REFERENCES Member (UniversityID),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN),
  FOREIGN KEY (bdID) REFERENCES BorrowDetails (ID)
)ENGINE = INNODB;

-- Inserting records to Table 26 - Borrow
INSERT INTO Borrow VALUES
(10004392, '978-0984782857', 44250001);

-- Creating Table 27 - LibrarianManageBorrowDetails
CREATE TABLE LibrarianManageBorrowDetails(
  lLibrarianID INT NOT NULL,
  bdID INT NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLibrarianID, bdID, EditDateTime),
  FOREIGN KEY (lLibrarianID) REFERENCES Librarian (LibrarianID),
  FOREIGN KEY (bdID) REFERENCES BorrowDetails (ID)
)ENGINE = INNODB;

-- Inserting records to Table 27 - LibrarianManageBorrowDetails

-- Creating Table 28 - LibrarianManageBookCatalog
CREATE TABLE LibrarianManageBookCatalog(
  lLibrarianID INT NOT NULL,
  bcID INT NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLibrarianID, bcID, EditDateTime),
  FOREIGN KEY (lLibrarianID) REFERENCES Librarian (LibrarianID),
  FOREIGN KEY (bcID) REFERENCES BookCatalog (ID)
)ENGINE = INNODB;

-- Inserting records to Table 28 - LibrarianManageBookCatalog
