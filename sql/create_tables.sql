CREATE TABLE Account(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  surname varchar(50), 
  othernames varchar(50),
  email varchar(50) NOT NULL, 
  password varchar(50) NOT NULL,
  created DATE,
  accounttype INTEGER
);

CREATE TABLE Item(
  id SERIAL PRIMARY KEY,
  title varchar(50),
  itemtype varchar(50),
  added DATE,
  otherdetails varchar(100)
);

CREATE TABLE Loan(
  id SERIAL PRIMARY KEY,
  checkedout DATE,
  checkedin DATE,
  account_id INTEGER REFERENCES Account(id), -- Viiteavain Account-tauluun
  item_id INTEGER REFERENCES Item(id) -- Viiteavain Item-tauluun
);

CREATE TABLE Author(
  id SERIAL PRIMARY KEY,
  surname varchar(50),
  othernames varchar(50)
);

CREATE TABLE ItemAuthor(
  id SERIAL PRIMARY KEY,
  item_id INTEGER REFERENCES Item(id), -- Viiteavain Item-tauluun
  author_id INTEGER REFERENCES Author(id) -- Viiteavain Author-tauluun
);