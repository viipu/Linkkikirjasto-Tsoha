-- Account-taulun testidata
INSERT INTO Account (firstname, password) VALUES ('Ada', '123'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Account (firstname, password) VALUES ('Charles', '123');
-- Item-taulun testidata
INSERT INTO Item (title, itemtype, added) VALUES ('Logicomix', 'kirja', NOW());
-- Loan-taulun testidata
INSERT INTO Loan (checkedout, account_id, item_id) VALUES (NOW(), 1, 1);