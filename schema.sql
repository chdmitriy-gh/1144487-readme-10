CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE readme;

CREATE TABLE users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP,
    email       CHAR(128),
    username    CHAR(64),
    passw    	 CHAR(64),
    avatar_path CHAR(255),
    contacts    CHAR(255)
);
CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX username ON users(username);

CREATE TABLE cards (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP,
    title       CHAR(255),
    text_cntnt  TEXT,
    quote_auth  CHAR(255),
    photo_path  CHAR(255),
    video_path  CHAR(255),
    link_path   CHAR(255),
    show_count  INT,
    user_id     INT,
    type_id     INT
);
CREATE INDEX dt_add ON cards(dt_add);
CREATE INDEX user_id ON cards (user_id);
CREATE INDEX type_id ON cards (type_id);

CREATE TABLE comments (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP,
    content     TEXT,
    user_id     INT,
    card_id     INT
);
CREATE INDEX dt_add ON comments(dt_add);
CREATE INDEX user_id ON comments(user_id);
CREATE INDEX card_id ON comments(card_id);

CREATE TABLE cards_like (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT,
    card_id     INT
);
CREATE INDEX user_id ON cards_like(user_id);
CREATE INDEX card_id ON cards_like(card_id);

CREATE TABLE subscribes (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    author_id   INT,
    subscr_id   INT
);
CREATE INDEX author_id ON subscribes(author_id);
CREATE INDEX subscr_id ON subscribes(subscr_id);

CREATE TABLE messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP,
    content     CHAR(255),
    sender_id   INT,
    recip_id    INT
);
CREATE INDEX sender_id ON messages(sender_id);
CREATE INDEX recip_id ON messages(recip_id);
CREATE INDEX dt_add ON messages(dt_add);

CREATE TABLE hashtags (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    tagname     CHAR(64)
);
CREATE UNIQUE INDEX tagname ON hashtags(tagname);

CREATE TABLE types (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        CHAR(64),
    class       CHAR(64)
);
CREATE UNIQUE INDEX name ON types(name);

CREATE TABLE cards_hashtags (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    hashtag_id  INT,
    card_id     INT
);
CREATE INDEX hashtag_id ON cards_hashtags(hashtag_id);
CREATE INDEX card_id ON cards_hashtags(card_id);
