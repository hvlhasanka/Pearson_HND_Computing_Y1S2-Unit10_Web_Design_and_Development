
-- Creating new database named 'LSULibraryDB'
CREATE DATABASE LSULibraryDB;

-- Accessing LSULibraryDB database
USE LSULibraryDB;


-- ||

-- Creating Table 1 - User
CREATE TABLE UserCity(
  CityID INT(8) AUTO_INCREMENT,
  City VARCHAR(50),
  PRIMARY KEY (CityID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 1 - UserCity
ALTER TABLE UserCity AUTO_INCREMENT = 22120001;

-- Inserting records into Table 1 - User
INSERT INTO UserCity (City) VALUES
('Battaramulla'), -- CityID: 22120001
('Colombo'),      -- CityID: 22120002
('Kandy'),        -- CityID: 22120003
('Galle'),        -- CityID: 22120004
('Jaffna');       -- CityID: 22120005

-- ||

-- Creating Table 2 - UserZipPostalCode
CREATE TABLE UserZipPostalCode(
  ZPCID INT(8) AUTO_INCREMENT,
  ZipPostalCode INT(5),
  PRIMARY KEY (ZPCID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 2 - UserZipPostalCode
ALTER TABLE UserZipPostalCode AUTO_INCREMENT = 23130001;

-- Inserting records into Table 2 - UserZipPostalCode
INSERT INTO UserZipPostalCode (ZipPostalCode) VALUES
(00500),  -- ZPCID: 23130001
(00100),  -- ZPCID: 23130002
(01300),  -- ZPCID: 23130003
(10250),  -- ZPCID: 23130004
(10230);  -- ZPCID: 23130005

-- ||

-- Creating Table 3 - UserProvience
CREATE TABLE UserProvience(
  ProvienceID INT(8) AUTO_INCREMENT,
  Provience VARCHAR(12),
  PRIMARY KEY (ProvienceID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 3 - UserProvience
ALTER TABLE UserProvience AUTO_INCREMENT = 24140001;

-- Inserting records into Table 3 - UserProvience
INSERT INTO UserProvience (Provience) VALUES
('Central'),        -- ProvienceID: 24140001
('Eastern'),        -- ProvienceID: 24140002
('North Central'),  -- ProvienceID: 24140003
('Northern'),       -- ProvienceID: 24140004
('North Western'),  -- ProvienceID: 24140005
('Sabaragamuwa'),   -- ProvienceID: 24140006
('Southern'),       -- ProvienceID: 24140007
('Uva'),            -- ProvienceID: 24140008
('Western');        -- ProvienceID: 24140009

-- ||

-- Creating Table 4 - User
CREATE TABLE User(
  UserID INT(8) AUTO_INCREMENT,
  FirstName VARCHAR(30) NOT NULL,
  MiddleName VARCHAR(30),
  LastName VARCHAR(50) NOT NULL,
  EmailAddress VARCHAR(50) NOT NULL,
  StreetAddress VARCHAR(40) NOT NULL,
  ucCityID INT(8) NOT NULL,
  uzpcZPCID INT(8) NOT NULL,
  upProvienceID INT(8) NOT NULL,
  MobileNumber CHAR(11) NOT NULL,
  TelePhoneNumber CHAR(11) NOT NULL,
  RegistrationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  lLoginID INT NOT NULL, -- This will become a foreign key after Login table is created
  PRIMARY KEY (UserID),
  FOREIGN KEY (ucCityID) REFERENCES UserCity(CityID),
  FOREIGN KEY (uzpcZPCID) REFERENCES UserZipPostalCode(ZPCID),
  FOREIGN KEY (upProvienceID) REFERENCES UserProvience(ProvienceID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 4 - User
ALTER TABLE User AUTO_INCREMENT = 45150001;

-- Inserting records into Table 4 - User
INSERT INTO User (FirstName, MiddleName, LastName, EmailAddress, StreetAddress, ucCityID, uzpcZPCID, upProvienceID,
  MobileNumber, TelePhoneNumber, RegistrationDateTime) VALUES
  ('Nickie', 'Weber', 'Langham', 'nlanghame@mail.ru', '959 Golf Course Alley', 22120001, 23130001, 24140009, '015-8521592', '034-8521596',
    '2020-01-01 09:23:34.131'),  -- UserID: 45150001
  ('Jake', 'Andrews', 'Anderson', 'jakeanderson12@gmail.com', '818 School Park',  22120001, 23130001, 24140009, '089-5874693','034-1569634',
    '2020-01-01 10:32:12.132');  -- UserID: 45150002

-- ||

-- Creating Table 5 - Librarian
CREATE TABLE Librarian(
  uUserID INT(8) NOT NULL,
  PRIMARY KEY (uUserID),
  FOREIGN KEY (uUserID) REFERENCES User (UserID)
)ENGINE = INNODB;

-- Inserting records into Table 5 - Librarian
INSERT INTO Librarian VALUES
(45150001);

--||

-- Creating Table 6 - MemberMemberType
CREATE TABLE MemberMemberType(
  MemberTypeID INT AUTO_INCREMENT,
  MemberType VARCHAR(9),
  PRIMARY KEY (MemberTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 6 - MemberMemberType
ALTER TABLE MemberMemberType AUTO_INCREMENT = 44120001;

-- Inserting records into Table 6 - MemberMemberType
INSERT INTO MemberMemberType (MemberType) VALUES
('Student'),        -- MemberTypeID: 44120001
('Professor');      -- MemberTypeID: 44120002

-- ||

-- Creating Table 7 - MemberFaculty
CREATE TABLE MemberFaculty(
  FacultyID INT(8) AUTO_INCREMENT,
  Faculty VARCHAR(12),
  PRIMARY KEY (FacultyID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 7 - MemberFaculty
ALTER TABLE MemberFaculty AUTO_INCREMENT = 91120001;

-- Inserting records into Table 7 - MemberFaculty
INSERT INTO MemberFaculty (MemberType) VALUES
('Faculty of Engineering'),   -- FacultyID: 91120001
('Faculty of Science'),       -- FacultyID: 91120002
('Faculty of Computing'),     -- FacultyID: 91120003
('Faculty of Business');      -- FacultyID: 91120004

-- ||

-- Creating Table 8 - MemberPosition
CREATE TABLE MemberPosition(
  PositionID INT(8) AUTO_INCREMENT,
  Position VARCHAR(25),
  PRIMARY KEY (PositionID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 8 - MemberPosition
ALTER TABLE MemberPosition AUTO_INCREMENT = 92130001;

-- Inserting records into Table 8 - MemberPosition
INSERT INTO MemberPosition (Position) VALUES
('Undergraduate Student'),   -- PositionID: 92130001
('Postgraduate Student'),    -- PositionID: 92130002
('Alumni'),                  -- PositionID: 92130003
('Professor'),               -- PositionID: 92130004
('Senior Professor'),        -- PositionID: 92130005
('Executive Professor');     -- PositionID: 92130006

-- ||

-- Creating Table 9 - MemberMemberStatus
CREATE TABLE MemberMemberStatus(
  MemberStatusID INT(8) AUTO_INCREMENT,
  MemberStatus VARCHAR(15),
  PRIMARY KEY (MemberStatusID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 9 - MemberMemberStatus
ALTER TABLE MemberMemberStatus AUTO_INCREMENT = 93140001;

-- Inserting records into Table 9 - MemberMemberStatus
INSERT INTO MemberMemberStatus (MemberStatus) VALUES
('Active'),       -- MemberStatusID: 93140001
('Expired'),      -- MemberStatusID: 93140002
('Cancelled'),    -- MemberStatusID: 93140003
('Deactivated');  -- MemberStatusID: 93140004

-- ||

-- Creating Table 10 - Member
CREATE TABLE Member(
  UserID INT(8) NOT NULL,
  UniversityID INT(8) NOT NULL,
  mmtMemberTypeID INT(8) NOT NULL,
  mmsMemberStatusID INT(8) NOT NULL,
  mfFacultyID INT(8) NOT NULL,
  mpPositionID INT(8) NOT NULL,
  EditDateTime DATETIME,
  PRIMARY KEY (UserID, UniversityID),
  FOREIGN KEY (mmtMemberTypeID) REFERENCES MemberType(MemberTypeID),
  FOREIGN KEY (mmsMemberStatusID) REFERENCES MembershipStatus(MembershipStatusID),
  FOREIGN KEY (mfFacultyID) REFERENCES MemberFaculty(MemberFacultyID),
  FOREIGN KEY (mpPositionID) REFERENCES MemberPosition(MemberPositionID)
)ENGINE = INNODB;

-- Inserting records into Table 10 - Member
INSERT INTO Member
(UserID, UniversityID, mmtMemberTypeID, mmsMemberStatusID, mfFacultyID, mpPositionID) VALUES
(45150002, 10004392, 44120001, 93140001, 91120001, 92130003);

-- ||

-- Creating Table 11 - StudentBatch
CREATE TABLE StudentBatch(
  BatchID INT(8) AUTO_INCREMENT,
  Batch VARCHAR(20),
  PRIMARY KEY (BatchID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 11 - StudentBatch
ALTER TABLE StudentBatch AUTO_INCREMENT = 55760001;

-- Inserting records into Table 11 - MemberMemberStatus
INSERT INTO StudentBatch (Batch) VALUES
('Fall 2017'),  -- BatchID: 55760001
('Spring 2018');  -- BatchID: 55760002

-- ||

-- Creating Table 12 - StudentDegreeProgram
CREATE TABLE StudentBatch(
  DegreeProgramID INT(8) AUTO_INCREMENT,
  DegreeProgram VARCHAR(60),
  PRIMARY KEY (DegreeProgramID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 12 - StudentDegreeProgram
ALTER TABLE StudentBatch AUTO_INCREMENT = 56770001;

-- Inserting records into Table 12 - StudentDegreeProgram
INSERT INTO StudentBatch (DegreeProgram) VALUES
('BSc(Hons) in Software Engineering'),  -- DegreeProgramID: 56770001
('BSc(Hons) in Civil Engineering');     -- DegreeProgramID: 56770002

-- ||

-- Creating Table 13 - Student
CREATE TABLE Student(
  UserID INT(8) NOT NULL,
  UniversityID INT(8) NOT NULL,
  sbBatchID INT(8) NOT NULL,
  sdpDegreeProgramID INT(8) NOT NULL,
  PRIMARY KEY (UserID, UniversityID)
  FOREIGN KEY (sbBatchID) REFERENCES StudentBatch (BatchID),
  FOREIGN KEY (sdpDegreeProgramID) REFERENCES StudentDegreeProgram (DegreeProgramID)
)ENGINE = INNODB;

-- Inserting records into Table 13 - Student
INSERT INTO Student VALUES
(45150002, 10004392, 55760001, 56770001);

-- ||





-- Creating Table 1 - LoginMembershipType
CREATE TABLE LoginMembershipType(
  MembershipTypeID INT AUTO_INCREMENT,
  MembershipType VARCHAR(9) NOT NULL,
  PRIMARY KEY (MembershipTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 1 - LoginMembershipType
ALTER TABLE LoginMembershipType AUTO_INCREMENT = 65350001;

-- Inserting records into Table 1 - LoginMembershipType
INSERT INTO LoginMembershipType (MembershipType) VALUES
('Student'),    -- MembershipTypeID: 65350001
('Professor'),  -- MembershipTypeID: 65350002
('Librarian');  -- MembershipTypeID: 65350003

-- Creating Table 2 - Login
CREATE TABLE Login(
  LoginID INT AUTO_INCREMENT,
  Username VARCHAR(15) NOT NULL,
  Password VARCHAR(150) NOT NULL,
  lmtMembershipTypeID INT NOT NULL,
  CreationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  EditDateTime DATETIME,
  PRIMARY KEY (LoginID),
  FOREIGN KEY (lmtMembershipTypeID) REFERENCES LoginMembershipType (MembershipTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 2 - Login
ALTER TABLE Login AUTO_INCREMENT = 11250001;

-- Inserting records to Table 2 - Login
-- Password encryption: password_hash (php function)
INSERT INTO Login(Username, Password, lmtMembershipTypeID) VALUES
('jakeanderson52', '$2y$10$xb8OmUOyNtbCV.q99/p/j.xbeEs/pK0M1dSN2XZrQO7uPKmXReICm', 65350001), -- Password: andRewsand_er2 | LoginID: 11250001 | MembershipType: Student
('NickieLangham22', '$2y$10$3gNWnpV5nw0LMrBsSAV/rev2YRwB8tYJkZwbLDfmmZHuJglmwIBy6', 65350003); -- Password: WeLannick4_k33 | LoginID: 11250002 |  MembershipType: Librarian











-- Creating Table 7 - MembershipStatus
CREATE TABLE MembershipStatus(
  MembershipStatusID INT AUTO_INCREMENT,
  MembershipStatus VARCHAR(11) NOT NULL,
  PRIMARY KEY (MembershipStatusID)
)ENGINE = INNODB;



-- Creating Table 8 - MemberPosition
CREATE TABLE MemberPosition(
  MemberPositionID INT AUTO_INCREMENT,
  Position VARCHAR(21) NOT NULL,
  PRIMARY KEY (MemberPositionID)
)ENGINE = INNODB;



-- Creating Table 9 - MemberFaculty
CREATE TABLE MemberFaculty(
  MemberFacultyID INT AUTO_INCREMENT,
  Faculty VARCHAR(22) NOT NULL,
  PRIMARY KEY (MemberFacultyID)
)ENGINE = INNODB;





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
(10004392, );

-- Creating Table 12 - Professor
-- Inserting records to Table 12 - Professor

-- Creating Table 13 - LibrarianCity
CREATE TABLE LibrarianCity(
  LibrarianCityID INT AUTO_INCREMENT,
  City VARCHAR(30) NOT NULL,
  PRIMARY KEY (LibrarianCityID)
)ENGINE = INNODB;



-- Creating Table 14 - LibrarianZipPostalCode
CREATE TABLE LibrarianZipPostalCode(
  LibrarianZipPostalCodeID INT AUTO_INCREMENT,
  ZipPostalCode INT(5) NOT NULL,
  PRIMARY KEY (LibrarianZipPostalCodeID)
)ENGINE = INNODB;



-- Creating Table 15 - LibrarianProvience
CREATE TABLE LibrarianProvience(
  LibrarianProvienceID INT AUTO_INCREMENT,
  Provience VARCHAR(12) NOT NULL,
  PRIMARY KEY (LibrarianProvienceID)
)ENGINE = INNODB;



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
(, 11250002);


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

-- Alterting table to change the starting point of the ID in Table 18 - BookAvailability
ALTER TABLE BookAvailability AUTO_INCREMENT = 55240001;

-- Inserting records to Table 18 - BookAvailability
INSERT INTO BookAvailability(Availability) VALUES
('Available'),      -- BAID: 55240001
('Not Available'),  -- BAID: 55240002
('Pending'),        -- BAID: 55240003
('Reserved'),       -- BAID: 55240004
('Borrowed');       -- BAID: 55240005

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

-- Creating Table 20 - BookCategory
CREATE TABLE BookCategory(
  ID INT AUTO_INCREMENT,
  Category VARCHAR(50) NOT NULL,
  PRIMARY KEY (ID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 20 - BookCategory
ALTER TABLE BookCategory AUTO_INCREMENT = 75330001;

-- Inserting crecords to Table 120 - BookCategory
INSERT INTO BookCategory (Category) VALUES
('Novels'),     -- ID: 75330001
('Fictions'),   -- ID: 75330002
('Textbook');   -- ID: 75330003


-- Creating Table 20 - Book
CREATE TABLE Book(
  ISBN VARCHAR(17) NOT NULL,
  Name VARCHAR(200) NOT NULL,
  bkcID INT NOT NULL,
  baID INT NOT NULL,
  RegisteredDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ISBN),
  FOREIGN KEY (bkcID) REFERENCES BookCategory (ID),
  FOREIGN KEY (baID) REFERENCES BookAvailability (ID)
)ENGINE = INNODB;

-- Inserting records to Table 20 - Book
INSERT INTO Book (ISBN, Name, baID, bkcID, RegisteredDateTime) VALUES
('978-0984782857', 'Cracking the Coding Interview: 189 Programming Questions and Solutions 6th Edition',
  55240001, 75330003, '2020-01-01 12:34:06.693'),
('978-1517671273', 'Elements of Programming Interviews in Java: The Insiders'' Guide 2nd Edition',
  55240002, 75330003, '2020-01-01 12:39:23.234');

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
