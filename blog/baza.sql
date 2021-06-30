Create table uzytkownicy (
	id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	login Varchar(255),
	haslo Varchar(255),
	email Varchar(255),
 Primary Key (id)) ENGINE = InnoDB;

 CREATE TABLE wpisy (
  id int(11) NOT NULL AUTO_INCREMENT,
  tytul varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  zawartosc text CHARACTER SET utf8 DEFAULT NULL,
  loginid int(11) DEFAULT NULL,
  PRIMARY KEY (id)
 ) ENGINE=InnoDB

 INSERT INTO `uzytkownicy`(`id`, `login`, `haslo`, `email`) VALUES ('1','admin','d033e22ae348aeb5660fc2140aec35850c4da997','admin')

 INSERT INTO `uzytkownicy`(`id`, `login`, `haslo`, `email`) VALUES ('2','Kamil','d78a8c513d0eb2427e7838036b9e6a2aca916e37','kam112@gmail.com')

 INSERT INTO `wpisy`(`id`, `tytul`, `zawartosc`, `loginid`) VALUES ('','Lorem','Lorem ipsum coś tam','1')

 INSERT INTO `wpisy`(`id`, `tytul`, `zawartosc`, `loginid`) VALUES ('','Myślę że kiedyś coś tu będzie','na przykład Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','2')
