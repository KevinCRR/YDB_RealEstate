DROP TABLE IF EXISTS preferred_contact_method;

CREATE TABLE preferred_contact_method(
value VARCHAR(1) PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE preferred_contact_method OWNER TO group12_admin;

INSERT INTO preferred_contact_method (value, property) VALUES ('e', 'Email');

INSERT INTO preferred_contact_method (value, property) VALUES ('p', 'Phone Number');

INSERT INTO preferred_contact_method (value, property) VALUES ('l', 'Letter Post');