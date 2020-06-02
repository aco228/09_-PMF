/* 
	Sajt prirodno-matematickog fakulteta
	11.4.14
 */

/*===============================================================================================*/
/* 												NALOG 											 */
DROP TABLE IF EXISTS nalog;
CREATE TABLE nalog(
	nid bigint unsigned auto_increment primary key,				/* ID naloga */
	ime varchar(50) default '',									/* Ime i prezime korisnika naloga */
	username varchar(50) default '',							/* username */
	sifra varchar(50) default '',								/* sifra */
	email varchar(70) default '', 								/* email */
	datum TIMESTAMP default CURRENT_TIMESTAMP,					/* Datum prijavljivanja */
	promjenaRukovodioca TIMESTAMP,								/*  */
	nalog_informacije text,										/* Informacije o nalogu koje ce se nalaziti na profil stranici naloga 
																   Informacije su formatirane na sledeci nacin
																   naslov_informacije#tekst_informacije|naslov_informacije#tekst_informacije|naslov_informacije#tekst_informacije|
																   gdje je '#' razmak izmedju naslova i teksta
																   a '|' predstavlja razmak izmedju dvije informacije
																*/
	jedinstvena_sifra varchar(30) default '',					/* jedinstvena sifra naloga */
	tip_prof varchar(1) default '-',							/* nalog je profesor ('+' || '-' ) */
	tip_admin varchar(1) default '-',							/* nalog je administrator ('+' || '-' ) */
	tip_ban varchar(1) default '-'								/* nalog je banovan ('+' || '-' ) */
)DEFAULT charset utf8;
INSERT INTO nalog(ime, username, sifra, email, jedinstvena_sifra, tip_prof, tip_admin) VALUES (
	'Administrator', /*ime*/
	'admin', /*username*/
	'system', /* sifra */
	'aco228', /*email*/
	'tutankamon', /* jedinstvena_sifra */
	'+', '+' /* tip_profesor i tip_administrator*/
);

/*===============================================================================================*/
/* 												DIALOG 											 */
/*							Veza izmedju dva naloga koja se dopisuju i poruka					 */
DROP TABLE IF EXISTS dialog;
CREATE TABLE dialog(
	did bigint unsigned auto_increment PRIMARY KEY,
	nid1 bigint default -1,
	nid1Neprocitane mediumint default 0,
	nid2 bigint default -1,
	nid2Neprocitane mediumint default 0,
	poslednja_promjena TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 										DIALOG_PORUKA 											 */
/*							Poruke koje razmjenjuju izmedju naloga u dialogu					 */
DROP TABLE IF EXISTS dialog_poruka;
CREATE TABLE dialog_poruka(
	dpid bigint unsigned auto_increment PRIMARY KEY,	/* ID poruke */
	did bigint default -1,								/* ID dialoga kojem pripada ova poruka */
	nidSalje bigint default -1,							/* Nalog koji salje poruku */
	nidPrima bigint default -1,							/* Nalog koji treba da primi ovu poruku */
	datum TIMESTAMP default CURRENT_TIMESTAMP,			/* Datum kada je poruka poslata */
	tekst text											/* Tekst poruke */
)DEFAULT charset utf8;

/*===============================================================================================*/
/*										 INDEKS_PORUKE 											 */
DROP TABLE IF EXISTS indeks_poruke;
CREATE TABLE indeks_poruke(
	ipid int auto_increment primary key,										/* id */
	autor int default -1,														/* Autor koji je poslednji promjenio poruku */
	poruka_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 							/* Datum mijenjanja poruke */
	poruka_srp varchar(700) default '',											/* poruke */
	poruka_eng varchar(700) default ''											/* poruke */
)DEFAULT charset utf8;
INSERT INTO indeks_poruke(poruka_srp, poruka_eng, autor) VALUES( 
	'"Prirodno-matematički fakultet Univerziteta Crne Gore otvoren je za mlade koji žele da dobiju obrazovanje koje će im omogućiti da se profesionalno posvete naučno-istraživačkom, stručnom i pedagoškom radu u oblasti matematike i računarskih nauka, fizike i biologije. Mladima koji upišu studije na Prirodno-matematičkom fakultetu obezbijedićemo dobre uslove za rad. Matematičari, fizičari i biolozi sa diplomom PMF-a lako nalaze posao u Crnoj Gori i van nje." 
	
<i>dekan Prirodno-matematičkog fakulteta</i> 
<i>prof. dr Žana Kovijanić Vukićević</i>', 
	'"Faculty of Science, University of Montenegro is open to young people who want to get an education that will enable them to professionally devoted to scientific research, professional and educational work in the field of mathematics and computer science, physics and biology. Youths who enroll in studies on natural Faculty of Science, we will provide good working conditions. Mathematicians, physicists and biologists with a degree in Science and easily find jobs in Montenegro and abroad. "

<i>Dean of the Faculty of Sciences</i> 
<i>prof. Dr. Jean Kovijanić Vukićević</i>', 
1 /*autor*/
);

/*===============================================================================================*/
/* 											SMJER 												*/
DROP TABLE IF EXISTS smjer;
CREATE TABLE smjer(
	sid int auto_increment primary key,		/* indetifikacija */
	ime_srp varchar(80) default '',			/* */
	ime_eng varchar(80) default '',			/* */
	namespace varchar(50) default '',		/* jedinstvena adresa za pristup (smjer/namespace) */
	broj_godina int default 0,				/* broj godina koliko traje smjer */
	pozicija int default 0,					/* pozicija u odnosu na ostale smjerove (odnosi se za administrator->predmeti) */
	opis_srp text,							/* */
	opis_eng text							/* */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 											PREDMET 											 */
DROP TABLE IF EXISTS predmet;
CREATE TABLE predmet(
	pid int auto_increment primary key,						/* ID predmeta */
	ime_srp varchar(80) default '',							/* ime */
	ime_eng varchar(80) default '',							/* ime na engleski */
	namespace varchar(50) default '',						/* adresa predmeta */
	poslednji_update TIMESTAMP default CURRENT_TIMESTAMP,	/* Posledni update, odnosi se na obavjestenja za predmete */
	termin text, 											/* termini kada se odrzavaju predavanja (opis formatiranja nadjite nedje u /p/ klasama */
	
	sid int default -1,										/* Smjer kojem semestar pripada */
	godina int default -1,									/* na kojoj se godini nalazi */
	semestar int default -1,								/* u kojem se semestru nalazi */
	estc int default -1										/* broj esct kredita */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 											RUKOVODIOCI 										 */
DROP TABLE IF EXISTS rukovodioci;
CREATE TABLE rukovodioci(
	rid int auto_increment primary key,		/* id */
	nid int default -1,						/* id rukovodeceg naloga */
	sid int default -1,						/* id smjera */
	pid int default -1,						/* id predmeta */
	rupre varchar(2) default 'da'			/* da li se rukovodi predmetom (ukoliko ne, onda se rukovodi smjerom) */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 												ARTIKLI 										 */
DROP TABLE IF EXISTS artikl;
CREATE TABLE artikl(
	aid int auto_increment primary key,			/* id */
	autor int default -1,						/* nid tj. id naloga koji je postavio vijest */
	datum TIMESTAMP default CURRENT_TIMESTAMP,	/* datum postavljanja */
	vijest varchar(2) default 'da',				/* da li se artikl koristi kao vijest ili ne */
	namespace varchar(50) default '', 			/* adresa vijesti */
	
	ime_srp varchar(80) default '',				/* tekst na srpskom */
	opis_srp varchar(150) default '',
	tekst_srp text,
	
	postoji_eng varchar(2) default 'ne',		/* da li postoji tekst na engleskom */
	ime_eng varchar(80) default '',				/* tekst na engleskom */
	opis_eng varchar(150) default '',			/* */
	download_orginal varchar(150) default '', 	/* orginalno ime download fajl a*/
	tekst_eng text								/* */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 												PRIJAVA 										 */
/*								   (veze izmedju studenata i predmeta)					     	 */
DROP TABLE IF EXISTS prijava;
CREATE TABLE prijava(
	prid int unsigned auto_increment PRIMARY KEY,	/* ID */
	nid int default -1,								/* Nalog studenta koji se prijavljuje na ispit */
	pid int default -1,								/* Predmet na koji se student prijavljuje */
	sid int default -1, 							/* Smjer na kojem se nalazi predmet */
	odjava varchar(2) default 'ne'					/* Da li se student odjavio */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 											OBAVJESTENJE 										 */
DROP TABLE IF EXISTS obavjestenje;
CREATE TABLE obavjestenje(
	oid bigint unsigned auto_increment PRIMARY KEY,	/* ID */
	tip varchar(3) default '',						/* tip obavjestenja 
														'oba' = obavjestenje
														'mat' = materijal
														'rez' = rezultat
														'kal' = novi unos u kalendar
													*/
	objavaPredmet varchar(2) default 'da',			/* Da li je objava za predmet ili ne */
	autor int default -1,							/* ID autora */
	pid int default -1,								/* predmet cije je obavjestenje */
	sid int default -1,								/* smjer iz kojeg je predmet cije je obavjestenje */
	datum TIMESTAMP default CURRENT_TIMESTAMP,		/* datum */
	naslov varchar(50) default '',					/* */
	tekst varchar(250) default '',					/* */
	/* DOWNLOAD FAJL */
	materijal_download varchar(100) default '',		/* fajl u slucaju da je materijal u pitanju */
	materijal_orginal varchar(100) default '',		/* orginalno ime materijala bez ikakvih dodataka */
	/* KALENDAR */
	kalid int default -1,							/* ID kalendara, ukoliko je u pitanju unos kalendara */
	kalMje tinyint default -1,						/* MJESEC odrzavanja kalendara*/
	kalGod mediumint default -1,					/* GODINA odrzavanja kalendara */
	kalDan tinyint default -1,						/* DAN odrzavanja kalendara */
	kalSat tinyint default -1,						/* SAT odrzavanja kalendara */
	kalMin tinyint default -1						/* MINUT odrzava kalendara */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 										TERMINI PREDMETA 										 */
DROP TABLE IF EXISTS termin;
CREATE TABLE termin(
	trid int unsigned auto_increment PRIMARY KEY,	/* ID */
	pid int default -1,								/* ID predmeta za koji se odnosi termin */
	sid int default -1,								/* ID smjera u kojem se nalazi predmet */
	opis_srp varchar(50) default '',				/* OPIS na srpskom */
	opis_eng varchar(50) default '',				/* OPIS na engleskom */
	predavac varchar(50) default '',				/* Profesor koji predaje u ovom terminu */
	kabinet varchar(20) default '',					/* kabinet */
	dan tinyint default -1,							/* dan odrzavanje termina */
	pocetakSat tinyint default -1,					/* pocetak SAT */
	pocetakMinut tinyint default -1,				/* pocetak MINUT */
	krajSat tinyint default -1,						/* kraj SAT */
	krajMinut tinyint default -1					/* kra MINUT */
)DEFAULT charset utf8;

/*===============================================================================================*/
/* 										KALENDAR PREDMETA 										 */
/* Podaci dodati u ovu tabelu ce takodje biti dodati i u tabelu (obavjestenja), sa tipom ('kal') */
/*																								 */
DROP TABLE IF EXISTS kalendar;
CREATE TABLE kalendar(
	kalid bigint UNSIGNED auto_increment PRIMARY KEY, /* ID kalendara */
	pid int default -1,								  /* ID predmeta */
	sid int default -1,								  /* ID smjera */
	ime varchar(50) default '',						  /* Naslov obavjestenja */
	opis varchar(250) default '',					  /* Opis obavjestenja */
	dan tinyint default -1,							  /* dan */
	mjesec tinyint default -1,						  /* mjesec */
	godina mediumint default -1,					  /* godina */
	sat tinyint default -1,							  /* Sat odrzavanja */
	minut tinyint default -1						  /* Minut odrzavanja */
)DEFAULT charset utf8;