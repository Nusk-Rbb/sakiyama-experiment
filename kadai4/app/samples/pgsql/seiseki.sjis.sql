-- �����̃e�[�u�����폜
DROP TABLE seiseki_tbl;

-- �e�[�u����V�K�쐬
CREATE TABLE seiseki_tbl (
	uid   INT  PRIMARY KEY,
	name  TEXT,
	score INT
);

-- �����f�[�^�̓o�^
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '100', '��', '90' );
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '110', '�r�c', '85' );
INSERT INTO seiseki_tbl (uid, name, score) VALUES ( '120', '��c', '90' );

-- �A�N�Z�X�����̐ݒ�
GRANT ALL ON seiseki_tbl TO apache;
