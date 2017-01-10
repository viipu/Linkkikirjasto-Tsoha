-- Account-taulun testidata
INSERT INTO Account (email, password, accounttype) VALUES ('Ada@ada.fi', '123', 1); 
INSERT INTO Account (email, password, accounttype) VALUES ('Charles@ada.fi', '123', 2);
-- Item-taulun testidata
INSERT INTO Item (title, itemtype, added) VALUES ('Logicomix', 'kirja', NOW());
-- Loan-taulun testidata
INSERT INTO Loan (checkedout, account_id, item_id) VALUES (NOW(), 1, 1);
-- Author-taulun testidata
INSERT INTO Author (surname, othernames) VALUES ('Kirjailija', 'Kamu');
INSERT INTO Author (surname, othernames) VALUES ('Samsung', 'Industries');
-- ItemAuthor-taulun testidata
INSERT INTO ItemAuthor (item_id, author_id) VALUES (1, 1);

