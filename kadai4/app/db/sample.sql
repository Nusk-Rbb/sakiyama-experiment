DROP TABLE IF EXISTS sample_tbl;

CREATE TABLE sample_tbl (
    id   INT  PRIMARY KEY,
    name  TEXT,
    score INT
)

INSERT INTO sample_tbl (id, name, score) VALUES ( '100', '青木', '90' );
INSERT INTO sample_tbl (id, name, score) VALUES ( '110', '池田', '85' );
INSERT INTO sample_tbl (id, name, score) VALUES ( '120', '上田', '90' );
INSERT INTO sample_tbl (id, name, score) VALUES ( '130', '佐藤', '95' );
INSERT INTO sample_tbl (id, name, score) VALUES ( '140', '田中', '80' );

GRANT ALL ON sample_tbl TO apache;