create database clean_eats
create table clean_eats.restaurant_health_rating (
    pk_restaurant_health_rating_id int not null auto_increment, --could create a bigint if production environment and more rows were to be inserted
    camis int,
    dba varchar(500),
    boro varchar(50),
    building varchar(500), --building could contain dash
    street varchar(1000),
    zipcode varchar(50), --zipcode could contain dash
    phone varchar(50), --phone could contain parentheses or dash
    cuisine_description varchar(1000),
    inspection_date date,
    action varchar(1000),
    violation_code varchar(100),
    violation_description varchar(2000),
    critical_flag varchar(1000), --could change this to boolean for better performance
    score int(11),
    grade varchar(100),
    grade_date date,
    record_date date,
    inspection_type varchar(500),
    datetime_created timestamp default current_timestamp, --convenient for checking last time data was inserted
    primary key(pk_restaurant_health_rating_id)

)
