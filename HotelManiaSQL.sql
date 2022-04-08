SET NAMES latin1;
SET FOREIGN_KEY_CHECKS=0;

BEGIN;
DROP DATABASE IF EXISTS `DBHotelMania`;
CREATE DATABASE `DBHotelMania`;
COMMIT;

USE `DBHotelMania`;

-- ----------------------------------------------------
-- Sezione adibita alla creazione di tabelle	     --
-- ----------------------------------------------------

-- TABELLA HOTEL --

CREATE TABLE IF NOT EXISTS `Hotel`(
	`IDHotel` INT UNSIGNED AUTO_INCREMENT NOT NULL,
	`Nome` VARCHAR(50) NOT NULL,
	`Citta` CHAR(30) NOT NULL,
	`Prezzo` INT UNSIGNED NOT NULL,
	`Valutazione` FLOAT UNSIGNED,
	`Descrizione` VARCHAR(300),
	PRIMARY KEY(`IDHotel`)
);

-- TABELLA UTENTE --

CREATE TABLE IF NOT EXISTS `Utente`(
	`IDUtente` INT UNSIGNED AUTO_INCREMENT,
	`Nome` CHAR(30) NOT NULL,
	`Cognome` CHAR(30) NOT NULL,
	`CodiceFiscale` VARCHAR(16) NOT NULL,
	`CartaDiCredito` VARCHAR(16) NOT NULL,
	`Indirizzo` VARCHAR(40) NOT NULL,
	`Citta` VARCHAR(30) NOT NULL,
	`Email` VARCHAR(50) NOT NULL,
	`Password` VARCHAR(40) NOT NULL,
	`_Admin` BOOLEAN NOT NULL,
	PRIMARY KEY(`IDUtente`),
	UNIQUE(`CodiceFiscale`,`CartaDiCredito`,`Email`)
);

-- TABELLA RECENSIONE --
CREATE TABLE IF NOT EXISTS `Recensione`(
	`Cliente` INT UNSIGNED NOT NULL,
	`Location` INT UNSIGNED NOT NULL,
	`Timestamp` TIMESTAMP NOT NULL,
	`Descrizione` VARCHAR(2048) NOT NULL,
	`Votazione` TINYINT UNSIGNED NOT NULL,
	PRIMARY KEY(`Cliente`,`Location`),
	CONSTRAINT
		FOREIGN KEY(`Cliente`)
		REFERENCES `Utente`(`IDUtente`)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
	CONSTRAINT
		FOREIGN KEY(`Location`)
		REFERENCES `Hotel`(`IDHotel`)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION

);

-- TABELLA PRENOTAZIONI --
CREATE TABLE IF NOT EXISTS `Prenotazione`(
	`IDPrenotazione` INT UNSIGNED AUTO_INCREMENT NOT NULL,
	`Cliente` INT UNSIGNED NOT NULL,
	`Location` INT UNSIGNED NOT NULL,
	`DataInizio` DATE NOT NULL,
	`DataFine` DATE NOT NULL,
  `N_Persone` INT UNSIGNED NOT NULL,
	`DataPrenotazione` TIMESTAMP NOT NULL,
	`Prezzo` FLOAT,
	PRIMARY KEY(`IDPrenotazione`),
	CONSTRAINT
		FOREIGN KEY(`Cliente`)
		REFERENCES `Utente`(`IDUtente`)
		ON UPDATE NO ACTION
		ON DELETE CASCADE,
	CONSTRAINT
		FOREIGN KEY(`Location`)
		REFERENCES `Hotel`(`IDHotel`)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION
);

-- ----------------------------------------------------
-- Sezione adibita al popolamento del DB       	     --
-- ----------------------------------------------------

-- Inserimento Utente --
INSERT INTO Utente VALUES
(null,"Admin","","adminadminadmin1","0000000000000000","","","admin@hotelmania.it","admin",true),
(null,"Federico","Montini","MNTFRC98D43DE64G","157342658790984","San Romano","Via Tosco-Romagnola","fedemontini@email.it","fede",false),
(null,"Matteo","Giorgini","MNTMTT03D850SJ4G","1048362395847362","Montopoli","Via Lavialla","matteo@email.it","matteo",false),
(null,"Elisa","Banti","BNTELS04D05JC96L","3029403823569850","Santa Croce","Via del corso","elisa@email.it","elisa",false),
(null,"Aurora","Rufini","RFNARR98FLE964KC","2941053069472459","San Miniato","Via Dalmazia","aurora@email.it","aurora",false),
(null,"Carol","Canini","CNNCRL20FLRO506N","3059482740694827","Empoli","Piazza Vittoria","carol@email.it","carol",false)
;

-- Inserimento Hotel --
INSERT INTO Hotel VALUES
(1,"PisaCentro","Pisa",25,3,"Il miglior hotel di Pisa!"),
(2,"FirenzeCentro","Firenze",30,4,"Vieni a trovarci e non rimarrai deluso!"),
(3,"PratoCentro","Prato",20,2.5,"L'hotel più comodo per visitare Firenze senza dover pensare al traffico!"),
(4,"citizenM Paris Gare de Lyon","Parigi",94.76,4,"Situato nel 12° arrondissement di Parigi, vicino alla stazione ferroviaria Gare de Lyon, il citizenM Paris Gare de Lyon vanta una vista sulla Senna."),
(5,"Hotel Daniel Vienna","Vienna",65.5,4,"Personalizzato nel design, l'Hotel Daniel Vienna sorge proprio accanto al Castello del Belvedere e alla Stazione Ferroviaria principale. Dotata di garage e di WiFi gratuito, la struttura ospita il ristorante The Bakery che coltiva erbe, verdura e frutta nel proprio giardino."),
(6,"Hotel Park 45","Zagabria",42,3.5,"Situato a Zagabria, a soli 800 m dalla piazza principale, l'Hotel Park 45 offre camere con bagno privato e un'area salotto in comune. "),
(7,"NH Collection Berlin Mitte Friedrichstrasse","Berlino",50,4.5,"Insignito di 4 stelle superior, l’NH Collection Berlin Mitte Friedrichstrasse sorge in una posizione privilegiata lungo la famosa Friedrichstrasse nel centro di Berlino."),
(8,"Lempuyang Boutique Hotel","Bali",31,3,"Situato a Karangasem, a 1,1 km dalla spiaggia di Ujung, il Lempuyang Boutique Hotel offre un ristorante, un parcheggio privato gratuito, una piscina all'aperto e un bar."),
(9,"Il Sole","Roma",28,2,"Il Sole vi attende a Roma, nelle vicinanze di una caffetteria dove potrete consumare una colazione tradizionale con croissant e bevande calde, e pranzi e cene a tariffe scontate."),
(10,"Scandic Simonkenttä","Helsinki",46,5,"Situato a 200 metri dalla stazione centrale di Helsinki e a 400 metri dal quartiere dello shopping Esplanaden, lo Scandic Simonkenttä offre la connessione WiFi senza costi aggiuntivi e l'accesso gratuito alla sauna e alla palestra."),
(11,"Wyndham Dubai Deira","Dubai",150,5,"Situato a Dubai, a 1,5 km dalla Grande Moschea, il Wyndham Dubai Deira offre un ristorante, un parcheggio privato gratuito, una piscina all'aperto e un centro fitness."),
(12,"B&B Hotels Rio Copacabana Posto 5","Rio De Janeiro",130,4.5,"Caratterizzato dalla combinazione tra comfort moderni e arredi classici, il Copacabana Rio Hotel offre una vista panoramica sul monte Pan di Zucchero e la connessione WiFi gratuita."),
(13,"Oak Manor","Città del Capo",40,1.5,"Situato a Città del Capo, a 11 km dal CTICC e a 12 km dal traghetto per Robben Island, l'Oak Manor offre un giardino, la connessione WiFi gratuita in tutte le aree e un parcheggio privato senza costi aggiuntivi. La struttura vanta camere familiari e una terrazza. La struttura vanta una piscina coperta e un servizio concierge."),
(14,"Novapark","Santiago",97,1.5,"Situato nel centro storico di Santiago del Cile, vicino a negozi e ristoranti, il Novapark offre il WiFi gratuito e un parcheggio privato gratuito."),
(15,"relexa hotel München","Monaco",53,3,"Situato a soli 600 metri dal Theresienwiese, sede del famoso Oktoberfest, il moderno relexa hotel München sorge in una posizione centrale a Monaco di Baviera e offre la connessione WiFi gratuita."),
(16,"Art Deco Nevsky","San Pietroburgo",67,4,"Situato nel quartiere Tsentralny di San Pietroburgo, il Nevsky Capsule Hotel dista 800 m dal Museo di Stato Russo, 1,1 km dalla Piazza del Palazzo e 1,2 km dalla Chiesa del Salvatore sul Sangue"),
(17,"Sheraton Atlanta","Atlanta",65,1,"Dotata di un giardino con cortile e piscina coperta da un soffitto retrattile in vetro, la struttura metterà a vostra disposizione sedie a sdraio e l’accesso illimitato al centro fitness aperto 24 ore su 24, dove troverete tapis roulant e stepper."),
(18,"Novotel Ottawa Hotel","Ottawa",46,3.5,"Il Novotel Ottawa si trova nel centro di Ottawa, a soli 5 minuti a piedi dall'elegante quartiere Byward Market, e offre una piscina coperta e la connessione WiFi gratuita."),
(19,"Hotel Aurora","Nuuk",27,1,"L'Hotel Aurora offre sistemazioni a Nuuk. L'hotel dispone di camere familiari. Tutte le camere sono dotate di scrivania. Il bagno privato è completo di doccia."),
(20,"Hestia Hotel Europa","Tallinn",85,4.5,"Ubicato a soli 150 metri dal porto di Tallinn, l'albergo a 4 stelle Hestia Hotel Europa offre interni di classe, 2 saloni di bellezza ed eleganti camere con connessione internet WiFi gratuita e TV a schermo piatto.")
;

-- Inserimento Prenotazioni --
INSERT INTO Prenotazione VALUES
(null,2,20,"2021-06-02","2021-06-06",2,CURRENT_TIMESTAMP(),150),
(null,2,11,"2021-07-12","2021-07-16",3,CURRENT_TIMESTAMP(),350),
(null,3,6,"2021-03-20","2021-04-16",1,CURRENT_TIMESTAMP(),60),
(null,3,18,"2021-08-20","2021-09-01",4,CURRENT_TIMESTAMP(),20),
(null,3,14,"2021-09-02","2021-09-06",4,CURRENT_TIMESTAMP(),80),
(null,3,4,"2021-10-03","2021-10-06",2,CURRENT_TIMESTAMP(),90),
(null,3,2,"2021-11-22","2021-11-24",5,CURRENT_TIMESTAMP(),100),
(null,3,8,"2021-01-01","2021-01-10",3,CURRENT_TIMESTAMP(),120),
(null,4,9,"2021-02-10","2021-02-16",4,CURRENT_TIMESTAMP(),300),
(null,4,10,"2021-12-29","2022-01-03",1,CURRENT_TIMESTAMP(),240),
(null,4,16,"2021-09-12","2021-09-16",1,CURRENT_TIMESTAMP(),150),
(null,4,11,"2021-10-02","2021-10-06",4,CURRENT_TIMESTAMP(),350),
(null,5,12,"2021-08-13","2021-08-16",6,CURRENT_TIMESTAMP(),260),
(null,6,13,"2021-06-04","2021-06-15",5,CURRENT_TIMESTAMP(),190)
;

-- Inserimento Recensioni --
INSERT INTO Recensione VALUES
(5,2,CURRENT_TIMESTAMP(),"Esperienza Fantastica!",5),
(5,3,CURRENT_TIMESTAMP(),"Ottimo Hotel, peccato il personale sia poco cordiale",4),
(5,7,CURRENT_TIMESTAMP(),"Bella posizione e camere pulite, bagno un po piccolo",4),
(5,12,CURRENT_TIMESTAMP(),"Ottima location la consiglio a tutti!",5),
(2,19,CURRENT_TIMESTAMP(),"Grandioso, un vero paradiso",5),
(2,14,CURRENT_TIMESTAMP(),"Pessima esperienza! sconsigliato",1),
(2,8,CURRENT_TIMESTAMP(),"Sembrava fantastico, peccato la camera fosse un po sporca",2),
(2,3,CURRENT_TIMESTAMP(),"Un esperienza mediocre, c'è di meglio",3),
(3,1,CURRENT_TIMESTAMP(),"Ottima location in pieno centro",4),
(3,11,CURRENT_TIMESTAMP(),"Bellissimo! Consigliato",5),
(3,10,CURRENT_TIMESTAMP(),"Meh... mi hanno trattato male",2),
(3,16,CURRENT_TIMESTAMP(),"NON CI ANDATE! Foto poco veritiere",1),
(4,15,CURRENT_TIMESTAMP(),"Hotel in buona posizione ma tenuto male",2),
(4,4,CURRENT_TIMESTAMP(),"Tutto bene ma... non c'è il Bidet!",3),
(4,13,CURRENT_TIMESTAMP(),"Non ci tornerò mai",2),
(4,19,CURRENT_TIMESTAMP(),"Bel posto, c'è di meglio",3)
;

-- --------------------------------------------------------
-- 						TRIGGERS	
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 1;
SET GLOBAL AUTOCOMMIT = 1;
SET GLOBAL EVENT_SCHEDULER = 1;
DELIMITER $$

DROP TRIGGER IF EXISTS AggiornaValutazione$$
CREATE TRIGGER AggiornaValutazione
AFTER INSERT ON Recensione
FOR EACH ROW
BEGIN
    DECLARE NewMedia FLOAT UNSIGNED;
    
    SELECT SUM(Votazione)/COUNT(*) INTO NewMedia
    FROM Recensione
	  WHERE Location = new.Location;

    UPDATE Hotel SET Valutazione=NewMedia WHERE IDHotel=new.Location;
    
END$$