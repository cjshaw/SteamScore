DROP DATABASE IF EXISTS steam_score;

CREATE DATABASE steam_score;

USE steam_score;

CREATE TABLE steam_score.users
(
  user_id     CHAR(17) PRIMARY KEY NOT NULL,
  username    VARCHAR(50)          NOT NULL,
  steam_score INT DEFAULT 0
);

CREATE TABLE steam_score.games
(
  app_id    VARCHAR(20) PRIMARY KEY NOT NULL,
  app_title VARCHAR(50),
  logo      VARCHAR(50)
);

CREATE TABLE steam_score.achievement
(
  achievement_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  apiname        VARCHAR(50) UNIQUE
);


CREATE TABLE steam_score.game_achievement
(
  app_id         VARCHAR(20) NOT NULL,
  achievement_id INT         NOT NULL,
  CONSTRAINT PRIMARY KEY (app_id, achievement_id),
  CONSTRAINT game_achievement_app_id_fk
  FOREIGN KEY (app_id) REFERENCES games (app_id),
  CONSTRAINT game_achievement_achievement_id_fk
  FOREIGN KEY (achievement_id) REFERENCES achievement (achievement_id)
);

CREATE TABLE steam_score.user_achievement
(
  user_id        CHAR(17) NOT NULL,
  achievement_id INT      NOT NULL,
  achieved       BOOLEAN  NOT NULL DEFAULT FALSE,
  CONSTRAINT PRIMARY KEY (user_id, achievement_id),
  CONSTRAINT user_achievement_user_id_fk
  FOREIGN KEY (user_id) REFERENCES users (user_id),
  CONSTRAINT user_achievement_achievement_id_fk
  FOREIGN KEY (achievement_id) REFERENCES achievement (achievement_id)
);

CREATE TABLE steam_score.user_game
(
  user_id    CHAR(17)    NOT NULL,
  app_id     VARCHAR(20) NOT NULL,
  game_score INT DEFAULT 0,
  CONSTRAINT PRIMARY KEY (user_id, app_id),
  CONSTRAINT user_game_user_id_fk
  FOREIGN KEY (user_id) REFERENCES users (user_id),
  CONSTRAINT user_game_app_id_fk
  FOREIGN KEY (app_id) REFERENCES games (app_id)
);


INSERT INTO games (app_id, app_title, logo)
VALUES ('6969', 'fake_game', 'no_logo');

INSERT INTO user_game(user_id, app_id)
VALUES ('xxxxxxxxxxxxxxxxx','6969');

INSERT INTO users(user_id, username)
VALUES('xxxxxxxxxxxxxxxxx','Clint_Shaw');

INSERT INTO achievement(apiname)
VALUES ('lost_achievement');

INSERT INTO game_achievement(app_id, achievement_id)
VALUES ('6969','999999999');

INSERT INTO user_achievement(user_id, achievement_id, achieved)
VALUES ('xxxxxxxxxxxxxxxxx','999999999','1');



INSERT INTO games (app_id, app_title, logo)
VALUES ('0000', 'fake_game2', 'no_logo2');

INSERT INTO user_game(user_id, app_id)
VALUES ('zzzzzzzzzzzzzzzzz','0000');

INSERT INTO users(user_id, username)
VALUES('zzzzzzzzzzzzzzzzz','Clint_Shaw2');

INSERT INTO achievement(apiname)
VALUES ('lost_achievement2');

INSERT INTO game_achievement(app_id, achievement_id)
VALUES ('0000','1111111111');

INSERT INTO user_achievement(user_id, achievement_id, achieved)
VALUES ('zzzzzzzzzzzzzzzzz','1111111111','0');
