TRUNCATE TABLE users, scores RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE scores (
    user_id INT REFERENCES users(user_id),
    score INT NOT NULL DEFAULT 0
);

GRANT ALL ON users TO apache;
GRANT ALL ON scores TO apache;

INSERT INTO users (username, password) VALUES ('admin', '$2y$10$lYYHSZc5lFTBuG2J3wOhFeN0FmcKf7q5syZvHnU9mw1f6GARwAjKa');
INSERT INTO scores (user_id, score) VALUES (1, 9900);

SELECT * FROM users;
SELECT * FROM scores;