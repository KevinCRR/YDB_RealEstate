/*
SQL file for constructing and inserting data to the database
Deliverable 1
*/
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users(
	user_id VARCHAR(50) PRIMARY KEY,
	password VARCHAR(32) NOT NULL,
	email_address VARCHAR(256) NOT NULL,
	user_type VARCHAR(2) NOT NULL,
	enrol_date DATE NOT NULL,
	last_access DATE NOT NULL
);

ALTER TABLE users OWNER TO group12_admin;
/* Passwords are 
adminpass
clientpass
agentpass
clientpass2
*/

INSERT INTO users VALUES(
	'jdoe',
	md5('password'),
	'jdoe@dcmail.ca',
	'c',
	'2018-1-1',
	'2019-2-2');
	
INSERT INTO users VALUES(
	'the_admin',
	md5('adminpass'),
	'jdoe@durhamcollege.ca',
	's',
	'2019-1-1',
	'2019-2-1');

INSERT INTO users VALUES(
	'the_client',
	md5('clientpass'),
	'rplant@durhamcollege.ca',
	'c',
	'2018-1-1',
	'2017-2-1');

INSERT INTO users VALUES(
	'the_agent',
	md5('agentpass'),
	'mcross@durhamcollege.ca',
	'a',
	'1999-1-1',
	'1982-2-1');
	
INSERT INTO users VALUES(
	'another_client',
	md5('clientpass2'),
	'client@durhamcollege.ca',
	'c',
	'1999-1-1',
	'2000-1-1');