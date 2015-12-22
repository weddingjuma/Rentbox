-- Lisää INSERT INTO lauseet tähän tiedostoon

INSERT INTO System_user (first_name, last_name, email, password) 
VALUES ('Jussi', 'Viinikka', 'jussi.viinikka@gmail.com', 'salasana');

INSERT INTO Rental_unit (description_title, description, address, advertised_rent, landlord) 
VALUES ('Big room', 'Upea ja mahtava myös fantastinen', 'Osoitekatu 32, 00100, Helsinki', '500', '1');

INSERT INTO Rental_unit (description_title, description, address, advertised_rent, landlord) 
VALUES ('Small room', 'Aika surkea tönö', 'Katutie 8, 00101, Helsinki', '400', '1');

INSERT INTO Amenity (name, description) 
VALUES ('Electricity', 'Electricity with usual consumption');

INSERT INTO Amenity (name, description) 
VALUES ('Water', 'Water with usual consumption');

INSERT INTO Amenity (name, description) 
VALUES ('Internet', '10Mbps connection');

INSERT INTO Amenity_rental_unit (rental_unit, amenity) 
VALUES ('1', '1');

INSERT INTO Amenity_rental_unit (rental_unit, amenity) 
VALUES ('1', '2');

INSERT INTO Lease (tenant, tenant_email, rent, start_date, end_date, rental_unit)
VALUES ('Oliver Nääs','naas@hotmail.ee','450','2015-12-20','2016-12-31','1');

INSERT INTO Amenity_lease (lease, amenity) 
VALUES ('1', '1');

INSERT INTO Photo (url, description, rental_unit) 
VALUES ('http://s11.postimg.org/u3lect7vn/isohuone2.jpg', 'Lots of space', '1');

