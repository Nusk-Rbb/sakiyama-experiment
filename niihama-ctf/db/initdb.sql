TRUNCATE TABLE scores, users, flags, user_ch1, user_ch2, solves RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS solves;
DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS flags;
DROP TABLE IF EXISTS user_ch1;
DROP TABLE IF EXISTS user_ch2;

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE scores (
    user_id INT REFERENCES users(user_id),
    score INT NOT NULL DEFAULT 0
);

CREATE TABLE flags (
    flag_id SERIAL PRIMARY KEY,
    flag VARCHAR(255)
);

CREATE TABLE user_ch1 (
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE user_ch2 (
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE solves (
    user_id INT REFERENCES users(user_id),
    flag_id INT REFERENCES flags(flag_id),
    solved BOOLEAN
);

GRANT ALL ON users TO apache;
GRANT ALL ON scores TO apache;
GRANT ALL ON flags TO apache;
GRANT ALL ON user_ch1 TO apache;
GRANT ALL ON user_ch2 TO apache;
GRANT ALL ON solves TO apache;

-- Insert user score Trigger
CREATE OR REPLACE FUNCTION insert_user_score()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO scores (user_id, score)
    VALUES (NEW.user_id, 0);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW
EXECUTE PROCEDURE insert_user_score();

-- Insert user solve Trigger
CREATE OR REPLACE FUNCTION insert_user_solves()
RETURNS TRIGGER AS $$
DECLARE
    flag_id_rec RECORD;
BEGIN
    FOR flag_id_rec IN SELECT flag_id FROM flags LOOP
        INSERT INTO solves (user_id, flag_id, solved)
        VALUES (NEW.user_id, flag_id_rec.flag_id, FALSE);
    END LOOP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_score_insert
AFTER INSERT ON users
FOR EACH ROW
EXECUTE PROCEDURE insert_user_solves();

-- Update flag solve Trigger
CREATE OR REPLACE FUNCTION insert_flags_solves()
RETURNS TRIGGER AS $$
DECLARE
    user_id_rec RECORD;
BEGIN
    FOR user_id_rec IN SELECT user_id FROM users LOOP
        INSERT INTO solves (user_id, flag_id, solved)
        VALUES (user_id_rec.user_id, NEW.flag_id, FALSE);
    END LOOP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_flag_insert
AFTER INSERT ON flags
FOR EACH ROW
EXECUTE PROCEDURE insert_flags_solves();

INSERT INTO user_ch1 (username, password) VALUES ('admin1', 'password1');
INSERT INTO user_ch1 (username, password) VALUES ('test1', 'test1');
INSERT INTO user_ch1 (username, password) VALUES ('user1', 'pass1');
INSERT INTO user_ch2 (username, password) VALUES ('admin2', 'password2');
INSERT INTO user_ch2 (username, password) VALUES ('test2', 'test2');
INSERT INTO user_ch2 (username, password) VALUES ('user2', 'pass2');

INSERT INTO flags (flag) VALUES ('niihama{PHP_has_SQL_Injection_r43fai3}');
INSERT INTO flags (flag) VALUES ('niihama{OS_command_Injection_71dajq84}');
INSERT INTO flags (flag) VALUES ('niihama{Reverse_Shell_3d4f4f3f}');

INSERT INTO users (username, password) VALUES ('admin', '$2y$10$lYYHSZc5lFTBuG2J3wOhFeN0FmcKf7q5syZvHnU9mw1f6GARwAjKa');

UPDATE scores SET score = 9900 WHERE user_id = 1;
UPDATE solves SET solved = TRUE WHERE user_id = 1 AND flag_id = 1;
UPDATE solves SET solved = TRUE WHERE user_id = 1 AND flag_id = 2;
UPDATE solves SET solved = TRUE WHERE user_id = 1 AND flag_id = 3;

SELECT * FROM users;
SELECT * FROM scores;
SELECT * FROM flags;
SELECT * FROM user_ch1;
SELECT * FROM user_ch2;
SELECT * FROM solves;