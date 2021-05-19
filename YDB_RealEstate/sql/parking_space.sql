-- File: parking_space.sql
-- Author: Group 12
-- Date: 10/28/2019
-- Description: SQL file to create parking_space property/value table

DROP TABLE IF EXISTS parking_space;

CREATE TABLE parking_space(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE parking_space OWNER TO group12_admin;

INSERT INTO parking_space (value, property) VALUES (1, 'One Space');

INSERT INTO parking_space (value, property) VALUES (2, 'Two Spaces');

INSERT INTO parking_space (value, property) VALUES (4, 'Three Spaces');

INSERT INTO parking_space (value, property) VALUES (8, 'Four Spaces');

INSERT INTO parking_space (value, property) VALUES (16, 'Five Spaces');

INSERT INTO parking_space (value, property) VALUES (32, 'Six Spaces');

INSERT INTO parking_space (value, property) VALUES (64, 'Seven Spaces');
