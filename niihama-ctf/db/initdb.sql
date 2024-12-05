TRUNCATE TABLE scores, users, flags RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS flags;

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

GRANT ALL ON users TO apache;
GRANT ALL ON scores TO apache;
GRANT ALL ON flags TO apache;

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

INSERT INTO users (username, password) VALUES ('admin', '$2y$10$lYYHSZc5lFTBuG2J3wOhFeN0FmcKf7q5syZvHnU9mw1f6GARwAjKa');

SELECT * FROM users;
SELECT * FROM scores;
SELECT * FROM flags;