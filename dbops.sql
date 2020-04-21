/*
SQLyog Community v11.51 (64 bit)
MySQL - 5.7.17-log : Database - authors
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `ConfusingTerm` (
  `termid` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(30) DEFAULT NULL,
  `sentence` varchar(500) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`termid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `confusingterm` */

insert  into `ConfusingTerm`(`termId`,`term`,`sentence`,`type`) values (1,'awnlike','(Carex tetrastachya)apex acuminate with subulate tip or awnlike, awn of at least proximate staminate scales and sometimes proximal pistillate scales 0.1–0.9 (–2.4) mm, scabrous.','category'),(2,'bristlelike','(Carex tetrastachya)proximal bracts bristlelike to 5 cm.','category'),(3,'scalelike','(Carex brevicaulis) proximal nonbasal bracts scalelike, usually equaling or shorter than inflorescences, rarely longer.','category'),(4,'leaflike','(Carex novae-angliea) proximal nonbasal bracts leaflike, equaling or shorter than inflorescences.','category'),(5,'cordlike','(Carex Parallela)Rhizomes ascending, cordlike, 0.5–1.4 mm in diam.','category'),(6,'threadlike','(Carex gynocrates)Rhizomes horizontal, threadlike, 0.3–0.8 mm in diam.','synonym');

/*Table structure for table `j_comfusingterm_option` */

CREATE TABLE `J_ConfusingTerm_Option_` (
  `termid` int(11) NOT NULL,
  `optionid` int(11) NOT NULL,
  PRIMARY KEY (`termid`,`optionid`),
  KEY `fk_optionid` (`optionid`),
  CONSTRAINT `j_comfusingterm_option_ibfk_1` FOREIGN KEY (`termid`) REFERENCES `confusingterm` (`termid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `j_comfusingterm_option_ibfk_2` FOREIGN KEY (`optionid`) REFERENCES `option_` (`optionid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `j_comfusingterm_option` */

insert  into `J_ConfusingTerm_Option`(`termId`,`optionId`) values (1,1),(2,1),(3,1),(4,1),(5,1),(1,2),(2,2),(3,2),(4,2),(5,2),(5,3),(6,4),(6,5);

/*Table structure for table `option_` */


CREATE TABLE `Option_` (
  `optionid` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(30) DEFAULT NULL,
  `definition` varchar(500) DEFAULT NULL,
  `picture` longblob,
  PRIMARY KEY (`optionid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `Option_` */

insert  into `Option_`(`optionId`,`term`,`definition`,`picture`) values (1,'shape','Overall two- or three – dimensional form or aspect thereof, e.g., rounded, spheroid, folded, folding, incurling.',NULL),(2,'architecture','The organization of parts that conform a complex structure and may dictate the form at a macro or micro-morphological level. Differentiate this category from Arrangement, Shape, and Structure. Architecture emphasizes the composition of an organ (have or have not a part) and the position of its components in it, e.g. antherless, bimucronate; Arrangement emphasizes the placement of similar organs in space, e.g. clustered, alternate; Shape is the appearance,e.g. rounded. ',NULL),(3,'texture','Substantial properties as perceived by visual and tactile senses, e.g. bony, fleshy, leathery, papery, cartilaginous. Differentate this category from Pubescence, Relief, and Coating.',NULL),(4,'linear','A shape quality inhering in a bearer by virtue of the bearer\'s being narrow, with the two opposite margins parallel. ',NULL),(5,'filamentous','bearing filaments',NULL);


insert  into `J_Conflict_ConfusingTerm`(`termId`,`termId`) values (1,1),(2,2),(3,3),(4,4);


