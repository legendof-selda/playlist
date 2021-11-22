CREATE DATABASE playlistDB;
USE playlistDB;
CREATE TABLE users (uid int primary key auto_increment, username varchar(20) unique, password varchar(20) ,fullname varchar(50), emailID varchar(50), artistName varchar(20), dob date, you varchar(200));
CREATE TABLE `genre`(
	`gid` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `genreName` varchar(30) NOT NULL,
    `Description` varchar(100)
);
CREATE TABLE `albums`(
	`aid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uid` INT NOT NULL,
    `albumName` varchar(30),
    `CreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `Description` varchar(100),
    FOREIGN KEY (`uid`) REFERENCES users(uid)
);
CREATE TABLE `songs` (
  `sid` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `songName` varchar(255) NOT NULL,
  `aid` int,
  `gid` int,
  `TrackNo` int NOT NULL DEFAULT 1,
  `DiscNo` int NOT NULL DEFAULT 1,
  `CreatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Duration` int,
  `privacy` ENUM('private', 'public', 'friends') DEFAULT 'private' NOT NULL,
  `RecentlyPlayed` datetime DEFAULT NULL,
  `ext` char(4) NOT NULL,
  PRIMARY KEY (`sid`),
  FOREIGN KEY (`uid`) REFERENCES users(uid),
  FOREIGN KEY (`gid`) REFERENCES genre(gid),
  FOREIGN KEY (`aid`) REFERENCES albums(aid)
);
CREATE VIEW `userMusic` AS SELECT songs.*, coalesce(albums.albumName, 'Unknown Album') AS `albumName`, coalesce(genre.genreName, 'Unknown Genre') AS `genreName`, users.artistName FROM songs INNER JOIN users ON(songs.uid=users.uid)  LEFT JOIN albums ON (coalesce(albums.aid, -1)=coalesce(songs.aid, -1)) LEFT JOIN genre ON (coalesce(genre.gid, -1)=coalesce(songs.gid, -1));
CREATE TABLE `friends`(
	`frnd1` int NOT NULL,
    `frnd2` int NOT NULL,
    `requestedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `acceptedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`frnd1`) REFERENCES users(uid),
    FOREIGN KEY (`frnd2`) REFERENCES users(uid),
    PRIMARY KEY(a,b)
);

INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Alternative Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Blues');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Classical Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Country Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Dance Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Easy Listening');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Electronic Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('European Music (Folk / Pop)');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Hip Hop / Rap');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Indie Pop');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Inspirational (incl. Gospel)');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Asian Pop (J-Pop, K-pop)');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Jazz');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Latin Music');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('New Age');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Opera');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Pop (Popular music)');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('R&B / Soul');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Reggae');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Rock');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Singer/Songwriter');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('World Music/Beats');
INSERT INTO `playlistdb`.`GENRE` (`Name`) VALUES ('Folk');

