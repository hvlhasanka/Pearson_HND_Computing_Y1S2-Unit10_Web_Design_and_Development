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
  ZipPostalCode VARCHAR(5),
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
  ('Rosina', 'Jody', 'Prujean', 'jprujean0@columbia.edu', '1571 Clyde Gallagher Pass', 22120003, 23130004, 24140003, '0254659325','0458246951',
    '2020-01-01 12:50:13.342', NULL),  -- UserID: 45150004
  ('Jake', 'Andrews', 'Anderson', 'jakeanderson12@gmail.com', '818 School Park', 22120001, 23130001, 24140009, '0895874693','0341569634',
    '2020-01-01 10:32:12.132', NULL),  -- UserID: 45150002
  ('Peter', 'Andy', 'Jackson', 'JacksonAny42@gmail.com', 'A23 Palace Lane', 22120001, 23130001, 24140009, '0235316489','0425268313',
    '2020-01-01 11:23:13.342', NULL),  -- UserID: 45150003
  ('Jaime', 'Allina', 'Galiford', 'agalifordh@auda.org.au', '89 Pleasure Terrace', 22120004, 23130002, 24140007, '0258741259','0421589652',
    '2020-01-01 12:55:13.342', NULL),  -- UserID: 45150005
  ('Charles', 'Rikki', 'Linge', 'rlinge7@geocities.jp', '349 Anniversary Parkway', 22120005, 23130003, 24140004, '0147852635', '0415985424',
    '2020-01-02 10:25:34.131', NULL),  -- UserID: 45150006
  ('Gillian', 'Gerri', 'Bowsher', 'gbowsherk@va.gov', '4 Forest Lane', 22120002, 23130002, 24140009, '0248249658','0425163589',
    '2020-01-02 11:32:12.132', NULL),  -- UserID: 45150007
  ('Julee', 'Dacey', 'Adkins', 'dadkinsk@yolasite.com', '58 Monument Plaza',  22120001, 23130004, 24140009, '0247856354','0425874159',
    '2020-01-02 12:23:13.342', NULL),  -- UserID: 45150008
  ('Tamara', 'Wilhelm', 'Trayes', '	wtrayesc@topsy.com', '73690 Evergreen Center',  22120003, 23130005, 24140001, '0258745692','0415965475',
    '2020-01-02 13:40:13.342', NULL),  -- UserID: 45150009
  ('Gareth', 'Winfred', 'Rubes', 'wrubes5@t.co', '43952 Bartelt Place',  22120004, 23130003, 24140007, '0214569852','0412589635',
    '2020-01-02 13:55:13.342', NULL),  -- UserID: 45150010
  ('Bill', 'Dael', 'McKinless', 'dmckinlessh@forbes.com', '75 Riverside Road',  22120005, 23130001, 24140004, '0258746532','0412569874',
    '2020-01-02 14:28:13.342', NULL),  -- UserID: 45150011
  ('Toby', 'Lyndell', 'Dennant', 'ldennant7@xinhuanet.com', '1976 Rieder Drive',  22120002, 23130004, 24140009, '0284369574','0125478535',
    '2020-01-02 14:50:13.342', NULL);  -- UserID: 45150012




-- Creating Table 5 - Librarian
CREATE TABLE Librarian(
  uUserID INT(8) NOT NULL,
  PRIMARY KEY (uUserID),
  FOREIGN KEY (uUserID) REFERENCES User (UserID)
)ENGINE = INNODB;

-- Inserting records into Table 5 - Librarian
INSERT INTO Librarian VALUES
(45150001),
(45150002);




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
(45150003, 10004392, 44120001, 93140001, 91120001, 92130001),
(45150004, 10003242, 44120001, 93140001, 91120004, 92130002),
(45150005, 10002754, 44120001, 93140004, 91120003, 92130001),
(45150006, 10009647, 44120001, 93140001, 91120001, 92130003),
(45150007, 10003456, 44120001, 93140002, 91120002, 92130001),
(45150008, 10002458, 44120002, 93140001, 91120001, 92130004),
(45150009, 10008765, 44120002, 93140001, 91120003, 92130006),
(45150010, 10003458, 44120002, 93140003, 91120004, 92130005),
(45150011, 10002518, 44120002, 93140001, 91120002, 92130005),
(45150012, 10006492, 44120002, 93140001, 91120001, 92130004);




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
('Fall 2017'),     -- BatchID: 55760001
('Spring 2018'),   -- BatchID: 55760002
('Fall 2018'),     -- BatchID: 55760003
('Spring 2019');   -- BatchID: 55760004




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
('BSc(Hons) in Civil Engineering'),     -- DegreeProgramID: 56770002
('BSc(Hons) in Networking'),            -- DegreeProgramID: 56770003
('MSc(Hons) in Business Management');   -- DegreeProgramID: 56770004





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
(45150003, 10004392, 55760002, 56770001),
(45150004, 10003242, 55760003, 56770004),
(45150005, 10002754, 55760003, 56770002),
(45150006, 10009647, 55760001, 56770001),
(45150007, 10003456, 55760004, 56770003);




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
('Computing'),           -- SpecializationID: 33110001
('Business'),            -- SpecializationID: 33110002
('Civil Engineering');   -- SpecializationID: 33110003




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
(45150008, 10002458, 33110001),
(45150009, 10008765, 33110003),
(45150010, 10003458, 33110003),
(45150011, 10002518, 33110002),
(45150012, 10006492, 33110001);


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
('978-1796356304', 'The Fifth Science', 75330002, 55240001, '2020-01-02 09:09:29.234'),
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
('2020-01-03 09:12:43.233', '2020-01-10 12:52:02.233'),  -- BDID: 44250001
('2020-01-05 10:12:43.233', '2020-02-02 09:52:02.233'),  -- BDID: 44250002
('2020-01-07 14:12:43.233', '2020-01-15 14:52:02.233'),  -- BDID: 44250003
('2020-01-14 12:12:43.233', '2020-01-20 10:52:02.233');  -- BDID: 44250004




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
('Computing', '2020-01-02 10:25:34.131'), -- CatalogID: 22450001
('Science', '2020-01-04 11:25:34.131'); -- CatalogID: 22450002




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
('NickieLangham44', '$2y$10$sn7ORCBP3Raghs1axcIicO0k8BUTgjhY4f.iktx38quzql05Ci.kW', 65350003),
-- Password: NickieLangham$582 | LoginID: 11250001 |  MemberType: Librarian
('RosinaPrujean43', '$2y$10$1a./tjidJRM76zuLJ90ZxuDNCSyzJqYpqV6ntqV5uzvD4lE1cKnfe', 65350003),
-- Password: RosinaPrujean@481 | LoginID: 11250002 |  MemberType: Librarian
('JakeAnderson34', '$2y$10$EuhyLFkyaDdjeVkrMu7oGuUSrs9p13CwbzvgCpYBe5TpjsHlrSjqO', 65350001),
-- Password: JakeAnderson*146 | LoginID: 11250003 | MemberType: Student
('PeterJackson44', '$2y$10$xfJNcGd.E//iqweSQF9Zru.pQG.NYUx4aVKuTG/medwI21M/xf4CO', 65350001),
-- Password: PeterJackson%594 | LoginID: 11250004 |  MemberType: Student
('JaimeGaliford76', '$2y$10$aZH/CiiniZxC7PP0lVhKeuhVi87L7YgU/VltT4.E0yq5ZAZR1O70G', 65350001),
-- Password: JaimeGaliford$159 | LoginID: 11250005 |  MemberType: Student
('CharlesLinge63', '$2y$10$UAbWfIvFhSfza4HwJbyjjOLMws2JvUuFbKT/W9L61xlqPrxXOWGlW', 65350001),
-- Password: CharlesLinge*359 | LoginID: 11250006 | MemberType: Student
('GillianBowsher38', '$2y$10$YhotiHa7v9IDSjv73QrUqOquhS7Sk8CYRiqoxXTnT1jXn4ihnU9vi', 65350001),
-- Password: GillianBowsher!248 | LoginID: 11250007 |  MemberType: Student
('JuleeAdkins34', '$2y$10$CqdQAwPcRVd2GtsPU7V7XeVPF5vzYG7/WXZMQF9nM1swhJC8tcFW2', 65350002),
-- Password: JuleeAdkins$249 | LoginID: 11250008 |  MemberType: Professor
('TamaraTrayes77', '$2y$10$cZCUETGwEOK9OHLIUj77EebXeoa8LYsfA6ChP2aqtrdFa1ZopDcZS', 65350002),
-- Password: TamaraTrayes^154 | LoginID: 11250009 |  MemberType: Professor
('GarethRubes95', '$2y$10$32UAkUIz8tlMPaqqj.XJo.8.qPtHSy/ITkYjzn/O4v7.JuO53Fj3W', 65350002),
-- Password: GarethRubes#582 | LoginID: 11250010 | MemberType: Professor
('BillMckinless53', '$2y$10$4Zuvj42P6kk8PljQS5luj.s5rwcv30c80dydKINRTt6GT2y7OPYsy', 65350002),
-- Password: BillMckinless*335 | LoginID: 11250011 |  MemberType: Professor
('TobyDennant62', '$2y$10$BmbUwHo9bTFeJfmeodhMwe3mmDZBgMazRUOh/NYG860Xoly45uaYq', 65350002);
-- Password: TobyDennant$523 | LoginID: 11250012 |  MemberType: Professor

-- Updating the lLoginID in Table 4 - User for these newly added records
UPDATE User SET lLoginID = 11250001 WHERE UserID = 45150001;
UPDATE User SET lLoginID = 11250002 WHERE UserID = 45150002;
UPDATE User SET lLoginID = 11250003 WHERE UserID = 45150003;
UPDATE User SET lLoginID = 11250004 WHERE UserID = 45150004;
UPDATE User SET lLoginID = 11250005 WHERE UserID = 45150005;
UPDATE User SET lLoginID = 11250006 WHERE UserID = 45150006;
UPDATE User SET lLoginID = 11250007 WHERE UserID = 45150007;
UPDATE User SET lLoginID = 11250008 WHERE UserID = 45150008;
UPDATE User SET lLoginID = 11250009 WHERE UserID = 45150009;
UPDATE User SET lLoginID = 11250010 WHERE UserID = 45150010;
UPDATE User SET lLoginID = 11250011 WHERE UserID = 45150011;
UPDATE User SET lLoginID = 11250012 WHERE UserID = 45150012;

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
(22450001, '978-1517671273'),
(22450002, '978-0134093413'),
(22450002, '978-1118324578'),
(22450002, '978-0134414232'),
(22450002, '978-0323319744'),
(22450002, '978-1455770052'),
(22450002, '978-0323613170');

-- Updating the NoOfBooks in Table 21: BookCatalog
UPDATE BookCatalog SET NoOfBooks = 2 WHERE CatalogID = 22450001;
UPDATE BookCatalog SET NoOfBooks = 6 WHERE CatalogID = 22450002;




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
(45150003, 10004392, '978-1250080400', 44250001),
(45150006, 10009647, '978-1118324578', 44250002),
(45150008, 10002458, '978-0323319744', 44250003),
(45150012, 10006492, '978-0718084226', 44250004);
