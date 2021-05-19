DROP TABLE IF EXISTS persons;

CREATE TABLE persons (
    user_id varchar(20) PRIMARY KEY,
    salutation varchar(10) NOT  NULL,
    first_name varchar(128) NOT  NULL,
    last_name varchar(128) NOT  NULL,
    street_address1 varchar(128) NOT  NULL,
    street_address2 varchar(128),
    city varchar(64) NOT  NULL,
    province char(2) NOT  NULL,
    postal_code char(10) NOT  NULL,
    primary_phone_number varchar(15) NOT  NULL,
    secondary_phone_number varchar(15),
    fax_number varchar(15),
    preferred_contact_method char(1) NOT  NULL,
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);

ALTER TABLE persons OWNER TO group12_admin;