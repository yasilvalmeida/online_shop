create table t_user(
    id tinyint not null auto_increment,
    username varchar(20) not null,
    password varchar(20) not null,
	access tinyint not null,
    primary key(id)
);

create table t_client(
    id int not null auto_increment,
    username varchar(20) not null,
    password varchar(20) not null,
    initial_balance float default 100,
    primary key(id)
);

create table t_shipping(
    id tinyint not null auto_increment,
    name varchar(20) not null,
	price float not null,
    primary key(id)
);

create table t_product(
    id int not null auto_increment,
    name varchar(20) not null,
    price float not null,
    quantity tinyint not null,
    unit varchar(5) not null,
    primary key(id)
);

create table t_order(
    id bigint not null auto_increment,
    date date not null,
    t_client_fk int not null,
    t_shipping_fk tinyint not null,
    primary key(id),
    foreign key(t_client_fk) references t_client(id),
    foreign key(t_shipping_fk) references t_shipping(id)
);

create table t_item(
    id bigint not null auto_increment,
    quantity tinyint not null,
    t_product_fk int not null,
    t_order_fk bigint not null,
    primary key(id),
    foreign key(t_product_fk) references t_product(id),
    foreign key(t_order_fk) references t_order(id)
);

create table t_rating(
    id bigint not null auto_increment,
    rate tinyint not null,
    username varchar(20) not null,
    date datetime not null,
    t_product_fk int not null,
    primary key(id),
    foreign key(t_product_fk) references t_product(id)
);