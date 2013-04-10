CREATE TABLE Roll (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    UNIQUE idx_name (name)
);

INSERT INTO Roll (id, name) VALUES (1, 'admin');
INSERT INTO Roll (id, name) VALUES (2, 'normal');

CREATE TABLE User (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    pass VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    roll_id INTEGER NOT NULL,
    valid TINYINT(1) DEFAULT 0,
    UNIQUE idx_name (name),
    UNIQUE idx_email (email)
);

INSERT INTO User (name, pass, email, roll_id, valid) VALUES ('admin', 'admin', 'admin@example.com', 1, 1);
INSERT INTO User (name, pass, email, roll_id, valid) VALUES ('test', 'test', 'test@example.com', 2, 1);
