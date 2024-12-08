DROP TABLE user_tbl;

CREATE TABLE user_tbl (
	id	INT PRIMARY KEY,
	name	TEXT,
	birth	INT
);

INSERT INTO user_tbl (id, name, birth) VALUES ('1', 'あんどう', '19801111');
INSERT INTO user_tbl (id, name, birth) VALUES ('2', 'いまい', '20000123');
INSERT INTO user_tbl (id, name, birth) VALUES ('3', 'うの', '19950518');

GRANT ALL ON user_tbl TO apache;
