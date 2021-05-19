DROP TABLE IF EXISTS listings;

CREATE TABLE listings (
    listing_id int PRIMARY KEY, --number such as 123
    user_id varchar(20) NOT  NULL, -- user id where user = admint
    listing_status varchar(1) NOT  NULL, -- open, hidden, closed,sold
    price NUMERIC NOT  NULL, -- Price
    headline varchar(100) NOT  NULL, -- string
    description varchar(1000) NOT NULL, -- string
    postal_code char(7) NOT  NULL, --string does not include - in postal Code
    images INTEGER NOT NULL, --Changed to img number
    address varchar(50) NOT NULL,
    city INTEGER NOT  NULL, -- city: Pickering [0], Ajax [1], Whitby[2], Oshawa[3], Bowmanville[4], Clarignton[5] from west to east.
    property_options INTEGER NOT  NULL, -- as ints
    bedrooms int DEFAULT 0 NOT NULL,
    bathrooms int DEFAULT 0 NOT NULL,
    parking_space int DEFAULT 0 NOT NULL,
    stories int DEFAULT 0 NOT NULL,
    cooling int DEFAULT 0 NOT NULL, --cooling types Central air[0], room air[1], evaporated[2], ductless_mini_split[3], night_breeze[4], thermal_energy_storage[5], other[6]
    heating int DEFAULT 0 NOT NULL, --heating types Forced_Air[0], Boilers[1], Heat_pumps[2], furnace[3], gas fired[4], unvented[5], electric[6], Fire_Place[7], raadiant[8], Floor_heat[9], other[10]
    type_of_listing int DEFAULT 0 NOT NULL, -- house[0], condo[1], Commercial[2], Other[3]
    date_created DATE NOT NULL,
    last_update DATE NOT NULL,


    FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (listing_status) REFERENCES listing_status (value),
    FOREIGN KEY (city) REFERENCES city (value),
    FOREIGN KEY (property_options) REFERENCES property_options (value),
    FOREIGN KEY (bathrooms) REFERENCES bathrooms (value),
    FOREIGN KEY (bedrooms) REFERENCES bedrooms (value),
    FOREIGN KEY (parking_space) REFERENCES parking_space (value),
    FOREIGN KEY (stories) REFERENCES stories (value),
    FOREIGN KEY (cooling) REFERENCES cooling (value),
    FOREIGN KEY (heating) REFERENCES heating (value),
    FOREIGN KEY (type_of_listing) REFERENCES types_of_listing (value)
);


ALTER TABLE listings OWNER TO group12_admin;
