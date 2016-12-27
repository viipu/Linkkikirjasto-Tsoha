CREATE TABLE Account(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  firstname varchar(50) NOT NULL, 
  surname varchar(50), 
  password varchar(50) NOT NULL,
  created DATE,
  accounttype varchar(50)
);

CREATE TABLE Item(
  id SERIAL PRIMARY KEY,
  title varchar(50),
  itemtype varchar(50),
  added DATE
);

CREATE TABLE Loan(
  id SERIAL PRIMARY KEY,
  checkedout DATE,
  checkedin DATE,
  account_id INTEGER REFERENCES Account(id), -- Viiteavain Account-tauluun
  item_id INTEGER REFERENCES Item(id) -- Viiteavain Item-tauluun
);
