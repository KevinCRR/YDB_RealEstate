DROP TABLE IF EXISTS securityQuestions;

CREATE TABLE securityQuestions (
    user_id varchar(20) PRIMARY KEY,
    security_question varchar(255),
	security_answer varchar(255),
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);

ALTER TABLE securityQuestions OWNER TO group12_admin;