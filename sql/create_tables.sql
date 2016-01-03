-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE System_user
(
	id SERIAL PRIMARY KEY,
	first_name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	email varchar(255) UNIQUE NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE Rental_unit
(
	id SERIAL PRIMARY KEY,
	address varchar(255) NOT NULL,
        area numeric(15,6) NOT NULL,
	description_title varchar(255),
	description varchar(255),
	advertised_rent numeric(15,6),
	landlord int REFERENCES System_user(id)
);

CREATE TABLE Amenity
(
	id SERIAL PRIMARY KEY,
	name varchar(255) NOT NULL,
	description varchar(255)
);

CREATE TABLE Amenity_rental_unit
(
	rental_unit int REFERENCES Rental_unit(id),
	amenity int REFERENCES Amenity(id)
);

CREATE TABLE Lease
(
	id SERIAL PRIMARY KEY,
        tenant varchar(255) NOT NULL,
        tenant_email varchar(255) NOT NULL,
	rent numeric(15,6) NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	rental_unit int REFERENCES Rental_unit(id) ON DELETE CASCADE
);

CREATE TABLE Amenity_lease
(
	lease int REFERENCES Lease(id),
	amenity int REFERENCES Amenity(id)
);

CREATE TABLE Photo
(
	id SERIAL PRIMARY KEY,
	url varchar(255) NOT NULL,
	description varchar(255),
	rental_unit int REFERENCES Rental_unit(id)
);