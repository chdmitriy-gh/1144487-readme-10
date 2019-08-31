CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE readme;

CREATE TABLE users (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creation_date DATETIME NOT NULL,
    email       VARCHAR(128) NOT NULL,
    username    VARCHAR(64) NOT NULL, 
    passw    	 VARCHAR(64) NOT NULL,
    avatar_path VARCHAR(255),
    contacts    VARCHAR(255)
);

CREATE TABLE types (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type_name   VARCHAR(64) NOT NULL,
    class_name  VARCHAR(64) NOT NULL
);

CREATE TABLE cards (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creation_date DATETIME NOT NULL,
    title       VARCHAR(255) NOT NULL,
    text_content TEXT,
    quote_auth  VARCHAR(255),
    photo_path  VARCHAR(255),
    video_path  VARCHAR(255),
    link_path   VARCHAR(255),
    show_count  INT UNSIGNED,
    user_id     INT UNSIGNED NOT NULL,
    type_id     INT UNSIGNED NOT NULL,
    CONSTRAINT FK_card_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT FK_card_type FOREIGN KEY (type_id) REFERENCES types(id)
);
CREATE INDEX show_count ON cards(show_count);
CREATE INDEX text_content ON cards(text_content(64));

CREATE TABLE comments (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creation_date DATETIME NOT NULL,
    content     TEXT NOT NULL,
    user_id     INT UNSIGNED NOT NULL,
    card_id     INT UNSIGNED NOT NULL,
    CONSTRAINT FK_comment_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT FK_comment_card FOREIGN KEY (card_id) REFERENCES cards(id)
);

CREATE TABLE cards_like (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    card_id     INT UNSIGNED NOT NULL,
    CONSTRAINT FK_like_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT FK_like_card FOREIGN KEY (card_id) REFERENCES cards(id)
);

CREATE TABLE subscribes (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    author_id   INT UNSIGNED NOT NULL,
    subscribed_id INT UNSIGNED NOT NULL,
    CONSTRAINT FK_subscr_author FOREIGN KEY (author_id) REFERENCES users(id),
    CONSTRAINT FK_subscr_subscribed FOREIGN KEY (subscribed_id) REFERENCES users(id)
);

CREATE TABLE messages (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    creation_date DATETIME NOT NULL,
    content     VARCHAR(255) NOT NULL,
    sender_id   INT UNSIGNED NOT NULL,
    recipient_id INT UNSIGNED NOT NULL,
    CONSTRAINT FK_mess_sender FOREIGN KEY (sender_id) REFERENCES users(id),
    CONSTRAINT FK_mess_recipient FOREIGN KEY (recipient_id) REFERENCES users(id)
);

CREATE TABLE hashtags (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tagname     VARCHAR(64) NOT NULL
);

CREATE TABLE cards_hashtags (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hashtag_id  INT UNSIGNED NOT NULL,
    card_id     INT UNSIGNED NOT NULL,
    CONSTRAINT FK_hashtag_card FOREIGN KEY (card_id) REFERENCES cards(id),
    CONSTRAINT FK_hashtag_hashtag FOREIGN KEY (hashtag_id) REFERENCES hashtags(id)
);