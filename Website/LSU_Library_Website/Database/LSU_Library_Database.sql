-- Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka



-- Creating new database named 'LSULibraryDB'
CREATE DATABASE LSULibraryDB;

-- Accessing LSULibraryDB database
USE LSULibraryDB;



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




-- Creating Table 3 - UserProvience
CREATE TABLE UserProvience(
  ProvienceID INT(8) AUTO_INCREMENT,
  Provience VARCHAR(15),
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




-- Creating Table 4 - User
CREATE TABLE User(
  UserID INT(8) AUTO_INCREMENT,
  FirstName VARCHAR(30) NOT NULL,
  MiddleName VARCHAR(30),
  LastName VARCHAR(50) NOT NULL,
  EmailAddress VARCHAR(50) NOT NULL,
  StreetAddress VARCHAR(40) NOT NULL,
  ucCityID INT(8),
  uzpcZPCID INT(8),
  upProvienceID INT(8) NOT NULL,
  MobileNumber CHAR(10) NOT NULL,
  TelephoneNumber CHAR(10),
  RegistrationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  lLoginID INT NOT NULL, -- This will become a foreign key after Table 23 - Login is created
  PRIMARY KEY (UserID),
  FOREIGN KEY (ucCityID) REFERENCES UserCity(CityID),
  FOREIGN KEY (uzpcZPCID) REFERENCES UserZipPostalCode(ZPCID),
  FOREIGN KEY (upProvienceID) REFERENCES UserProvience(ProvienceID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 4 - User
ALTER TABLE User AUTO_INCREMENT = 45150001;

-- Inserting records into Table 4 - User
INSERT INTO User (FirstName, MiddleName, LastName, EmailAddress, StreetAddress, ucCityID, uzpcZPCID, upProvienceID,
  MobileNumber, TelePhoneNumber, RegistrationDateTime, lLoginID) VALUES
  ('Nickie', 'Weber', 'Langham', 'nlanghame@mail.ru', '959 Golf Course Alley', 22120001, 23130001, 24140009, '0158521592', '0348521596',
    '2020-01-01 09:23:34.131', NULL),  -- UserID: 45150001
  ('Jake', 'Andrews', 'Anderson', 'jakeanderson12@gmail.com', '818 School Park',  22120001, 23130001, 24140009, '0895874693','0341569634',
    '2020-01-01 10:32:12.132', NULL),  -- UserID: 45150002
  ('Peter', 'Andy', 'Jackson', 'JacksonAny42@gmail.com', 'A23 Palace Lane',  22120001, 23130001, 24140009, '0235316489','0425268313',
    '2020-01-01 11:23:13.342', NULL);  -- UserID: 45150003




-- Creating Table 5 - Librarian
CREATE TABLE Librarian(
  uUserID INT(8) NOT NULL,
  PRIMARY KEY (uUserID),
  FOREIGN KEY (uUserID) REFERENCES User (UserID)
)ENGINE = INNODB;

-- Inserting records into Table 5 - Librarian
INSERT INTO Librarian VALUES
(45150001);




-- Creating Table 6 - MemberMembershipType
CREATE TABLE MemberMembershipType(
  MembershipTypeID INT AUTO_INCREMENT,
  MembershipType VARCHAR(9),
  PRIMARY KEY (MembershipTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 6 - MemberMembershipType
ALTER TABLE MemberMembershipType AUTO_INCREMENT = 44120001;

-- Inserting records into Table 6 - MemberMembershipType
INSERT INTO MemberMembershipType (MembershipType) VALUES
('Student'),        -- MemberTypeID: 44120001
('Professor');      -- MemberTypeID: 44120002




-- Creating Table 7 - MemberFaculty
CREATE TABLE MemberFaculty(
  FacultyID INT(8) AUTO_INCREMENT,
  Faculty VARCHAR(50),
  PRIMARY KEY (FacultyID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 7 - MemberFaculty
ALTER TABLE MemberFaculty AUTO_INCREMENT = 91120001;

-- Inserting records into Table 7 - MemberFaculty
INSERT INTO MemberFaculty (Faculty) VALUES
('Faculty of Engineering'),   -- FacultyID: 91120001
('Faculty of Science'),       -- FacultyID: 91120002
('Faculty of Computing'),     -- FacultyID: 91120003
('Faculty of Business');      -- FacultyID: 91120004




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




-- Creating Table 10 - UniversityMember
CREATE TABLE UniversityMember(
  uUserID INT(8) NOT NULL,
  UniversityNo INT(8) NOT NULL,
  mmtMembershipTypeID INT(8) NOT NULL,
  mmsMemberStatusID INT(8) NOT NULL,
  mfFacultyID INT(8) NOT NULL,
  mpPositionID INT(8) NOT NULL,
  EditDateTime DATETIME,
  PRIMARY KEY (uUserID, UniversityNo),
  FOREIGN KEY (uUserID) REFERENCES User(UserID),
  FOREIGN KEY (mmtMembershipTypeID) REFERENCES MemberMembershipType(MembershipTypeID),
  FOREIGN KEY (mmsMemberStatusID) REFERENCES MemberMemberStatus(MemberStatusID),
  FOREIGN KEY (mfFacultyID) REFERENCES MemberFaculty(FacultyID),
  FOREIGN KEY (mpPositionID) REFERENCES MemberPosition(PositionID)
)ENGINE = INNODB;

-- Inserting records into Table 10 - UniversityMember
INSERT INTO UniversityMember
(uUserID, UniversityNo, mmtMembershipTypeID, mmsMemberStatusID, mfFacultyID, mpPositionID) VALUES
(45150002, 10004392, 44120001, 93140001, 91120001, 92130003),
(45150003, 10003242, 44120002, 93140001, 91120003, 92130005);




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




-- Creating Table 12 - StudentDegreeProgram
CREATE TABLE StudentDegreeProgram(
  DegreeProgramID INT(8) AUTO_INCREMENT,
  DegreeProgram VARCHAR(60),
  PRIMARY KEY (DegreeProgramID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 12 - StudentDegreeProgram
ALTER TABLE StudentDegreeProgram AUTO_INCREMENT = 56770001;

-- Inserting records into Table 12 - StudentDegreeProgram
INSERT INTO StudentDegreeProgram (DegreeProgram) VALUES
('BSc(Hons) in Software Engineering'),  -- DegreeProgramID: 56770001
('BSc(Hons) in Civil Engineering');     -- DegreeProgramID: 56770002




-- Creating Table 13 - Student
CREATE TABLE Student(
  umUserID INT(8) NOT NULL,
  umUniversityNo INT(8) NOT NULL,
  sbBatchID INT(8),
  sdpDegreeProgramID INT(8),
  PRIMARY KEY (umUserID, umUniversityNo),
  FOREIGN KEY (umUserID, umUniversityNo) REFERENCES UniversityMember (uUserID, UniversityNo),
  FOREIGN KEY (sbBatchID) REFERENCES StudentBatch (BatchID),
  FOREIGN KEY (sdpDegreeProgramID) REFERENCES StudentDegreeProgram (DegreeProgramID)
)ENGINE = INNODB;

-- Inserting records into Table 13 - Student
INSERT INTO Student VALUES
(45150002, 10004392, 55760001, 56770001);




-- Creating Table 14 - ProfessorSpecialization
CREATE TABLE ProfessorSpecialization(
  SpecializationID INT(8) AUTO_INCREMENT,
  Specialization VARCHAR(50),
  PRIMARY KEY (SpecializationID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 14 - ProfessorSpecialization
ALTER TABLE ProfessorSpecialization AUTO_INCREMENT = 33110001;

-- Inserting records into Table 14 - ProfessorSpecialization
INSERT INTO ProfessorSpecialization (Specialization) VALUES
('Computing'),  -- SpecializationID: 33110001
('Business');   -- SpecializationID: 33110001




-- Creating Table 15 - Professor
CREATE TABLE Professor(
  umUserID INT(8) NOT NULL,
  umUniversityNo INT(8) NOT NULL,
  psSpecializationID INT(8) NOT NULL,
  PRIMARY KEY (umUserID, umUniversityNo),
  FOREIGN KEY (umUserID, umUniversityNo) REFERENCES UniversityMember (uUserID, UniversityNo),
  FOREIGN KEY (psSpecializationID) REFERENCES ProfessorSpecialization (SpecializationID)
)ENGINE = INNODB;

-- Inserting records into Table 15 - Professor
INSERT INTO Professor VALUES
(45150003, 10003242, 33110001);




-- Creating Table 16 - BookCategory
CREATE TABLE BookCategory(
  CategoryID INT AUTO_INCREMENT,
  Category VARCHAR(50) NOT NULL,
  PRIMARY KEY (CategoryID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 16 - BookCategory
ALTER TABLE BookCategory AUTO_INCREMENT = 75330001;

-- Inserting crecords into Table 16 - BookCategory
INSERT INTO BookCategory (Category) VALUES
('Novels'),     -- CategoryID: 75330001
('Fictions'),   -- CategoryID: 75330002
('Textbook');   -- CategoryID: 75330003




-- Creating Table 17 - BookAvailability
CREATE TABLE BookAvailability(
  AvailabilityID INT(8) AUTO_INCREMENT,
  Availability VARCHAR(15) NOT NULL,
  PRIMARY KEY (AvailabilityID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 17 - BookAvailability
ALTER TABLE BookAvailability AUTO_INCREMENT = 55240001;

-- Inserting records into Table 17 - BookAvailability
INSERT INTO BookAvailability(Availability) VALUES
('Available'),      -- AvailabilityID: 55240001
('Not Available'),  -- AvailabilityID: 55240002
('Pending'),        -- AvailabilityID: 55240003
('Reserved'),       -- AvailabilityID: 55240004
('Borrowed');       -- AvailabilityID: 55240005




-- Creating Table 18 - Book
CREATE TABLE Book(
  ISBN VARCHAR(17) NOT NULL,
  Name VARCHAR(200) NOT NULL,
  bcCategoryID INT(8) NOT NULL,
  baAvailabilityID INT(8) NOT NULL,
  ReserveDateTime DATETIME,
  uUserID_ReservedBy INT(8),
  RegisteredDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ISBN),
  FOREIGN KEY (bcCategoryID) REFERENCES BookCategory (CategoryID),
  FOREIGN KEY (baAvailabilityID) REFERENCES BookAvailability (AvailabilityID),
  FOREIGN KEY (uUserID_ReservedBy) REFERENCES User (UserID)
)ENGINE = INNODB;

-- Inserting records into Table 18 - Book
INSERT INTO Book (ISBN, Name, bcCategoryID, baAvailabilityID, RegisteredDateTime) VALUES
('978-1517671273', 'Elements of Programming Interviews in Java: The Insiders'' Guide 2nd Edition',
  75330003, 55240001, '2020-01-01 12:39:23.234'),
('978-0735219090', 'Where the Crawdads Sing', 75330001, 55240001, '2020-01-01 12:50:23.234'),
('978-0743247542', 'The Glass Castle: A Memoir', 75330001, 55240001, '2020-01-01 13:01:23.234'),
('978-0393356687', 'The Overstory: A Novel', 75330001, 55240003, '2020-01-01 13:15:23.234'),
('978-1250080400', 'Nightingale', 75330001, 55240005, '2020-01-01 13:20:23.234'),
('978-1501173219', 'All the Light We Cannot See: A Novel', 75330001, 55240001, '2020-01-01 13:25:23.234'),
('978-0735224315', 'Little Fires Everywhere: A Novel', 75330001, 55240002, '2020-01-01 13:29:29.234'),
('978-0525436140', 'There There', 75330001, 55240001, '2020-01-01 13:40:29.234'),
('978-0134093413', 'Campbell Biology (11th Edition)', 75330003, 55240001, '2020-01-01 13:44:29.234'),
('978-1118324578', 'Materials Science and Engineering: An Introduction 9th Edition', 75330003, 55240005, '2020-01-01 13:44:50.234'),
('978-0134414232', 'Chemistry: The Central Science (14th Edition) 14th Edition', 75330003, 55240002, '2020-01-01 13:56:29.234'),
('978-0323319744', 'Mosby''s Textbook for Nursing Assistants - Soft Cover Version 9th Edition', 75330003, 55240005, '2020-01-01 14:02:29.234'),
('978-1455770052', 'Guyton and Hall Textbook of Medical Physiology (Guyton Physiology) 13th Edition', 75330003, 55240001, '2020-01-01 14:20:29.234'),
('978-1796356304', 'The Fifth Science', 75330002, 55240005, '2020-01-02 09:09:29.234'),
('978-0718084226', 'The Hideaway', 75330002, 55240005, '2020-01-02 09:20:29.234');

-- Inserting records into Table 18 - Book
INSERT INTO Book VALUES
('978-0984782857', 'Cracking the Coding Interview: 189 Programming Questions and Solutions 6th Edition',
  75330003, 55240004, '2020-01-02 14:23:12.233', 45150002, '2020-01-01 12:34:06.693'),
('978-0323613170', 'Textbook of Diagnostic Microbiology 6th Edition',
  75330003, 55240004, '2020-01-03 10:20:12.233', 45150002, '2020-01-01 12:40:06.693'),
('978-1779501127', 'Watchmen (2019 Edition)',
  75330001, 55240004, '2020-01-04 09:30:12.233', 45150002, '2020-01-01 12:50:06.693'),
('978-1797738161', 'The Price of Time',
  75330002, 55240004, '2020-01-06 14:20:12.233', 45150002, '2020-01-01 13:15:06.693');



-- Creating Table 19 - BookAuthor
CREATE TABLE BookAuthor(
  bISBN VARCHAR(17) NOT NULL,
  Author VARCHAR(50) NOT NULL,
  PRIMARY KEY (bISBN, Author),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN)
)ENGINE = INNODB;

-- Inserting records into Table 19 - BookAuthor
INSERT INTO BookAuthor VALUES
('978-0984782857', 'Gayle Laakmann McDowell'),
('978-1517671273', 'Adnan Aziz'),
('978-1517671273', 'Tsung-Hsien Lee'),
('978-0735219090', 'Delia Owens'),
('978-0743247542', 'Jeannette Walls'),
('978-0393356687', 'Richard Powers'),
('978-1250080400', 'Kristin Hannah'),
('978-1501173219', 'Anthony Doerr'),
('978-0735224315', 'Celeste Ng'),
('978-0525436140', 'Tommy Orange'),
('978-0134093413', 'Lisa A. Urry'),
('978-0134093413', 'Michael L. Cain'),
('978-1118324578', 'William D. Callister Jr.'),
('978-1118324578', 'David G. Rethwisch'),
('978-0134414232', 'Theodore E. Brown'),
('978-0134414232', 'H. Eugene LeMay'),
('978-0323319744', 'Sheila A. Sorrentino PhD RN'),
('978-0323319744', 'Leighann Remmert MS RN'),
('978-1455770052', 'John E. Hall PhD'),
('978-0323613170', 'Connie R. Mahon MS MT(ASCP) CLS'),
('978-0323613170', 'Donald C. Lehman EdD MT(ASCP) SM(NRM)'),
('978-1779501127', 'Alan Moore'),
('978-1796356304', 'Exurb1a'),
('978-1797738161', 'Tim Tigner'),
('978-0718084226', 'Lauren K. Denton');




-- Creating Table 20 - BookBorrow
CREATE TABLE BookBorrow(
  BorrowID INT(8) AUTO_INCREMENT,
  BorrowDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  ReturnDateTime DATETIME NOT NULL,
  LateFine FLOAT,
  PRIMARY KEY (BorrowID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 20 - BookBorrow
ALTER TABLE BookBorrow AUTO_INCREMENT = 44250001;

-- Inserting records to Table 20 - BookBorrow
INSERT INTO BookBorrow (BorrowDateTime, ReturnDateTime) VALUES
('2020-01-03 09:12:43.233', '2020-01-05 12:52:02.233');  -- BDID: 44250001




-- Creating Table 21 - BookCatalog
CREATE TABLE BookCatalog(
  CatalogID INT(8) AUTO_INCREMENT,
  Name VARCHAR(40) NOT NULL,
  NoOfBooks INT DEFAULT '0',
  CreatedDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (CatalogID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 21 - BookCatalog
ALTER TABLE BookCatalog AUTO_INCREMENT = 22450001;

-- Inserting records to Table 21 - BookCatalog
INSERT INTO BookCatalog (Name, CreatedDateTime) VALUES
('Computing', '2020-01-02 10:25:34.131'); -- CatalogID: 22450001




-- Creating Table 22 - LoginUserType
CREATE TABLE LoginUserType(
  UserTypeID INT(8) AUTO_INCREMENT,
  UserType VARCHAR(9) NOT NULL,
  PRIMARY KEY (UserTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 22 - LoginUserType
ALTER TABLE LoginUserType AUTO_INCREMENT = 65350001;

-- Inserting records into Table 22 - LoginUserType
INSERT INTO LoginUserType (UserType) VALUES
('Student'),    -- UserTypeID: 65350001
('Professor'),  -- UserTypeID: 65350002
('Librarian');  -- UserTypeID: 65350003




-- Creating Table 23 - Login
CREATE TABLE Login(
  LoginID INT(8) AUTO_INCREMENT,
  Username VARCHAR(15) NOT NULL,
  Password VARCHAR(150) NOT NULL,
  lutUserTypeID INT(8) NOT NULL,
  CreationDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (LoginID),
  FOREIGN KEY (lutUserTypeID) REFERENCES LoginUserType (UserTypeID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 23 - Login
ALTER TABLE Login AUTO_INCREMENT = 11250001;

-- Inserting records to Table 23 - Login
-- Password encryption: password_hash (php function)
INSERT INTO Login(Username, Password, lutUserTypeID) VALUES
('NickieLangham22', '$2y$10$3gNWnpV5nw0LMrBsSAV/rev2YRwB8tYJkZwbLDfmmZHuJglmwIBy6', 65350003),
-- Password: WeLannick4_k33 | LoginID: 11250001 |  MemberType: Librarian
('jakeanderson52', '$2y$10$xb8OmUOyNtbCV.q99/p/j.xbeEs/pK0M1dSN2XZrQO7uPKmXReICm', 65350001),
-- Password: andRewsand_er2 | LoginID: 11250002 | MemberType: Student
('JacksonAndy32', '$2y$10$yEICTpS6D1u/wqV8/vsHie13oIwZQy6sObRXuTtdBo/1U2s.ikTPS', 65350002);
-- Password: jackpetera_pj33 | LoginID: 11250003 |  MemberType: Professor

-- Updating the lLoginID in Table 4 - User for these newly added records
UPDATE User SET lLoginID = 11250001 WHERE UserID = 45150001;
UPDATE User SET lLoginID = 11250002 WHERE UserID = 45150002;
UPDATE User SET lLoginID = 11250003 WHERE UserID = 45150003;

-- Updating lLoginID column in Table 4 - User as foreign key
ALTER TABLE User ADD FOREIGN KEY (lLoginID) REFERENCES Login (LoginID);




-- Creating Table 24 - LoginLogin
CREATE TABLE LoginLogin(
  lLoginID INT(8) NOT NULL,
  LoginDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLoginID, LoginDateTime)
)ENGINE = INNODB;

-- Inserting records into Table 24 - LoginLogin
INSERT INTO LoginLogin VALUES
(11250001, '2020-01-04 14:42:25.562');




-- Creating Table 25 - LoginLogout
CREATE TABLE LoginLogout(
  lLoginID INT(8) NOT NULL,
  LogoutDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lLoginID, LogoutDateTime)
)ENGINE = INNODB;

-- Inserting records into Table 25 - LoginLogout
INSERT INTO LoginLogout VALUES
(11250001, '2020-01-04 14:55:21.253');




-- Creating Table 26 - ManageModification
CREATE TABLE ManageModification(
  ModificationID INT(8) AUTO_INCREMENT,
  Modification VARCHAR(50) NOT NULL,
  PRIMARY KEY (ModificationID)
)ENGINE = INNODB;

-- Alterting table to change the starting point of the ID in Table 26 - ManageModification
ALTER TABLE ManageModification AUTO_INCREMENT = 65220001;

-- Inserting records to Table 26 - ManageModification
INSERT INTO ManageModification (Modification) VALUES
('Updated Password'); -- ModificationID: 65220001




-- Creating Table 27 - LibrarianManageBook
CREATE TABLE LibrarianManageBook(
  lUserID INT(8) NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  mmModificationID INT(8) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lUserID, bISBN, EditDateTime),
  FOREIGN KEY (lUserID) REFERENCES Librarian (uUserID),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN),
  FOREIGN KEY (mmModificationID) REFERENCES ManageModification (ModificationID)
)ENGINE = INNODB;

-- Inserting records to Table 27 - LibrarianManageBook





-- Creating Table 28 - LibrarianManageBookBorrow
CREATE TABLE LibrarianManageBookBorrow(
  lUserID INT(8) NOT NULL,
  bbBorrowID INT(8) NOT NULL,
  mmModificationID INT(8) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lUserID, bbBorrowID, EditDateTime),
  FOREIGN KEY (lUserID) REFERENCES Librarian (uUserID),
  FOREIGN KEY (bbBorrowID) REFERENCES BookBorrow (BorrowID),
  FOREIGN KEY (mmModificationID) REFERENCES ManageModification (ModificationID)
)ENGINE = INNODB;

-- Inserting records to Table 28 - LibrarianManageBookBorrow





-- Creating Table 29 - LibrarianManageBookCatalog
CREATE TABLE LibrarianManageBookCatalog(
  lUserID INT NOT NULL,
  bcCatalogID INT NOT NULL,
  mmModificationID INT(8) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lUserID, bcCatalogID, EditDateTime),
  FOREIGN KEY (lUserID) REFERENCES Librarian (uUserID),
  FOREIGN KEY (bcCatalogID) REFERENCES BookCatalog (CatalogID),
  FOREIGN KEY (mmModificationID) REFERENCES ManageModification (ModificationID)
)ENGINE = INNODB;

-- Inserting records to Table 29 - LibrarianManageBookCatalog





-- Creating Table 30 - UserManageLogin
CREATE TABLE UserManageLogin(
  uUserID INT NOT NULL,
  lLoginID INT NOT NULL,
  mmModificationID INT(8) NOT NULL,
  EditDateTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (uUserID, lLoginID, EditDateTime),
  FOREIGN KEY (uUserID) REFERENCES User (UserID),
  FOREIGN KEY (lLoginID) REFERENCES Login (LoginID),
  FOREIGN KEY (mmModificationID) REFERENCES ManageModification (ModificationID)
)ENGINE = INNODB;

-- Inserting records to Table 30 - UserManageLogin





-- Creating Table 31 - BookCatalogHasBook
CREATE TABLE BookCatalogHasBook(
  bcCatalogID INT NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  PRIMARY KEY (bcCatalogID, bISBN),
  FOREIGN KEY (bcCatalogID) REFERENCES BookCatalog (CatalogID),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN)
)ENGINE = INNODB;

-- Inserting records to Table 31 - BookCatalogHasBook
INSERT INTO BookCatalogHasBook VALUES
(22450001, '978-0984782857'),
(22450001, '978-1517671273');

-- Updating the NoOfBooks in Table 21: BookCatalog
UPDATE BookCatalog SET NoOfBooks = 2 WHERE CatalogID = 22450001;




-- Creating Table 32 - Borrow
CREATE TABLE Borrow(
  umUserID INT(8) NOT NULL,
  umUniversityNo INT(8) NOT NULL,
  bISBN VARCHAR(17) NOT NULL,
  bbBorrowID INT NOT NULL,
  PRIMARY KEY (umUserID, umUniversityNo, bISBN, bbBorrowID),
  FOREIGN KEY (umUserID, umUniversityNo) REFERENCES UniversityMember (uUserID, UniversityNo),
  FOREIGN KEY (bISBN) REFERENCES Book (ISBN),
  FOREIGN KEY (bbBorrowID) REFERENCES BookBorrow (BorrowID)
)ENGINE = INNODB;

-- Inserting records to Table 32 - Borrow
INSERT INTO Borrow VALUES
(45150002, 10004392, '978-0984782857', 44250001);
