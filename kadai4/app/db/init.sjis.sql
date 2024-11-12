truncate table city_table, school_table;
drop table if exists school_table, city_table;

create table city_table (
    cid int primary key,
    city text
);

create table school_table (
    sid int primary key,
    school text,
    cid int references city_table(cid)
);

insert into city_table values (10, 'V‹•ls'); 
insert into city_table values (11, 'l‘’†‰›s'); 
insert into city_table values (12, '¼ğs'); 
insert into city_table values (13, '¡¡s'); 

insert into school_table values (1, 'V‹•l¼‚“™ŠwZ', 10); 
insert into school_table values (2, 'V‹•l“ì‚“™ŠwZ', 10); 
insert into school_table values (3, '¼ğ–k‚“™ŠwZ', 12); 

select school_table.sid, school_table.school, city_table.city from school_table inner join city_table on school_table.cid = city_table.cid;