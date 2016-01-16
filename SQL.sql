
--Creacion de las tablas, procedimientos almacenados y funciones--

--Configurar Base de Datos--

create database cms;

create user cmsuser@localhost identified by 'pass';

grant all on cms.* to cmsuser@localhost;

----------------------------

--Tablas--

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
create table account
(
	id int primary key auto_increment,
	user varchar(20) not null,
	pass varchar(120) not null,
	addr varchar(40) not null,
	name varchar(20),
	lname varchar(20)
) auto_increment=2;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
create table post
(
	id int primary key auto_increment,
	title varchar(60) not null,
	body varchar(2048) not null,
	post_date varchar(8) not null,
	category varchar(150) not null,
	id_acc int not null,
	foreign key(id_acc) references account(id)
);
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
create table comment
(
	id int primary key auto_increment,
	body varchar(200) not null,
	name varchar(20) not null,
	addr varchar(40) not null,
	comm_date varchar(8) not null,
	id_post int not null,
	id_acc int,
	foreign key(id_post) references post(id),
	foreign key(id_acc) references account(id)
);
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
create table info
(
	id int primary key,
	descr varchar(230) default 'Blog de noticias',
	post_cont int default 0,
	comm_cont int default 0,
	act_rec1 int,
	act_rec2 int,
	comm_rec1 int,
	comm_rec2 int,
	id_acc int not null,
	foreign key(act_rec1) references post(id),
	foreign key(act_rec2) references post(id),
	foreign key(comm_rec1) references comment(id),
	foreign key(comm_rec2) references comment(id),
	foreign key(id_acc) references account(id)
);
--*/

----------

--Procedimientos almacenados--

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create procedure Autenticate(us varchar(20), pas varchar(30))
begin
if exists(select 1 from account as t1 where user=us and pass=md5(pas)) then
select (select id from account where user = us);
else
select -1;
end if;
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create procedure CreateUser(us varchar(20), pas varchar(30), adr varchar(40))
begin
if exists(select 1 from account where user=us)
then
select 0;
else
insert into account values(default,us,md5(pas),adr,null,null);
select 1;
end if;
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create procedure DelPost(_id int)
begin
delete from comment where id_post=_id;
delete from post where id=_id;
end;
&&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create procedure Search(val varchar(60), filter varchar(20))
begin
if filter = 'publicacion'
then
select * from post where title like '%val%';
elseif filter = 'editor'
then
select * from post as t1 inner join account as t2 on t1.id=t2.id_acc where t2.id_acc=val;
elseif filter = 'categoria'
then
select * from post where categoria like cat('%', val, '%');
elseif filter = 'fecha'
then
select * from post where post_date=val;
else
select 'ERROR';
end if;
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create procedure FetchPost(_id int)
begin
declare id1 int;
declare id2 int;
set id1 = (select comm_rec1 from info where id_acc = _id);
set id2 = (select comm_rec2 from info where id_acc = _id);
set id1 = (select id_post from comment where id = id1);
set id2 = (select id_post from comment where id = id2);
select * from post where id = id1 or id = id2;
/*select comm_rec1,comm_rec2 into id1,id2 from info where id_acc = _id;
select id_post into id1 from comment where id = id1;
select id_post into id2 from comment where id = id2;
select * from post where id = id1 or id = id2;*/
end &&
delimiter ;
--*/

------------------------------


--Funciones--

-- * YA NO SON NECESARIAS DEBIDO A LOS TRIGGERS * --

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*
delimiter &&
create function CountPost(id int)
returns int
begin
return (select count(*) from post where id_acc=id);
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*
delimiter &&
create function CountComm(id int)
returns int
begin
return (select count(*) from comment as t1 inner join post as t2 on t1.id_post = t2.id
where t2.id=id);
end &&
delimiter ;
--*/

-------------

--Triggers--

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create trigger InsertInfo after insert on account for each row
begin
insert into info(id_acc) values(new.id);
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create trigger UpdateInfo_post after insert on post for each row
begin
if (select act_rec1 from info where id_acc = new.id) is null then
update info set post_cont = post_cont + 1, act_rec1 = new.id
	where id_acc = new.id_acc;
else
update info set post_cont = post_cont + 1, act_rec2 = act_rec1, act_rec1 = new.id
	where id_acc = new.id_acc;
end if;
end &&
delimiter ;
--*/

/*Borra el ultimo slash de esta linea para comentar este bloque de codigo*/
delimiter &&
create trigger UpdateInfo_comm after insert on comment for each row
begin
if new.id_acc is not null then
if (select comm_rec1 from info where id_acc = new.id_acc) is null then
update info set comm_cont = comm_cont + 1, comm_rec1 = new.id
	where id_acc = new.id_acc;
else
update info set comm_cont = comm_cont + 1, comm_rec2 = comm_rec1, comm_rec1 = new.id
	where id_acc = new.id_acc;
end if;
end if;
end &&
delimiter ;
--*/

------------