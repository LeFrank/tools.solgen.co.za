create table notes_tags(
    id Int NOT NULL AUTO_INCREMENT,
    note_id int not null,
    user_id int null,
    `name` varchar(250) null,
    create_date timestamp null,
    update_date timestamp null
PRIMARY KEY (`id`));

