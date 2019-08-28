-- Заполнение таблицы типов контента
INSERT INTO types (type_name, class) VALUES 
	('Текст', 'text'), 
	('Цитата', 'quote'), 
	('Картинка', 'photo'), 
	('Видео', 'video'), 
	('Ссылка', 'link');
-- Заполнение таблицы пользователей
INSERT INTO users (creation_date, email, username, passw) VALUES 
	(NOW(), 'larisa@yandex.ru', 'Лариса', 'passwlarisa'),
	(NOW(), 'victor@gmail.com', 'Виктор', 'passwvictor'),
	(NOW(), 'vladik@mail.ru', 'Владик', 'passwvladik');
-- Заполнение таблицы постов
SET @user1_id = (SELECT id FROM users WHERE email = 'larisa@yandex.ru');
SET @user2_id = (SELECT id FROM users WHERE email = 'victor@gmail.com');
SET @user3_id = (SELECT id FROM users WHERE email = 'vladik@mail.ru');
SET @type1 = (SELECT id FROM types WHERE class = 'text');
SET @type2 = (SELECT id FROM types WHERE class = 'quote');
INSERT INTO cards (id, creation_date, title, text_content, quote_auth, show_count, user_id, type_id) VALUES
   (1, NOW(), 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный автор', 10, @user1_id, @type2),
   (2, NOW(), 'Игра престолов', 'Не могу дождаться начала финального сезона!', NULL, 5, @user2_id, @type1),
   (3, NOW(), 'Байкал', 'Озеро Байкал – огромное древнее озеро в горах Сибири.', NULL, 3, @user1_id, @type1);
-- Заполнение таблицы комментариев
INSERT INTO comments (creation_date, content, user_id, card_id) VALUES
	(NOW(), 'Это якобы Есенин.', @user2_id, 1),
	(NOW(), 'На самом деле, нет.', @user1_id, 1),
	(NOW(), 'Тоже очень жду.', @user1_id, 2),
	(NOW(), 'Не жду ничего хорошего.', @user3_id, 2);

-- Выводит все посты с указанием имени автора и типа поста, сортировка по количеству просмотров 
SELECT text_content, username, type_name FROM cards 
JOIN users ON cards.user_id = users.id
JOIN types ON cards.type_id = types.id 
ORDER BY show_count DESC;

-- Выводит все посты определенного автора
SET @user_id = (SELECT id FROM users WHERE email = 'larisa@yandex.ru');
SELECT text_content FROM cards WHERE user_id = @user_id;

-- Выводит для определенного поста все комментарии с именем комментатора
SELECT content, username FROM cards
JOIN comments ON comments.card_id = cards.id
JOIN users ON users.id = comments.user_id
WHERE cards.id = 2;

-- Добавляет 5 лайков от разных пользователей разным постам
INSERT INTO cards_like (user_id, card_id) VALUES 
	(@user1_id, 2), (@user2_id, 1), (@user2_id, 3), (@user3_id, 1), (@user3_id, 3);

-- Добавляет 5 подписок пользователей друг на друга
INSERT INTO subscribes (author_id, subscribed_id) 
	VALUES (@user1_id, @user2_id), (@user1_id, @user3_id), (@user2_id, @user1_id), (@user3_id, @user1_id), (@user3_id, @user2_id);

	
