-- Скрипт создания БД

CREATE TABLE lab3_bd_messages (
    message_id serial PRIMARY KEY,
    user_name varchar(100) NOT NULL,
    user_email varchar(100) NOT NULL,
    user_phone varchar(100) NOT NULL,
    message_text text NOT NULL,
    send_time timestamp NOT NULL DEFAULT NOW()
);

-- Запросы для 1 пункта

CREATE TABLE transaction_records (
    trans_id SERIAL PRIMARY KEY,
    trans_type VARCHAR(50),
    trans_amount NUMERIC
);

INSERT INTO transaction_records (trans_type, trans_amount) VALUES
('Куплено программное обеспечение', 150.00),
('Возврат одежды', -75.00),
('Оплата подписки', 20.00),
('Куплено оборудование', 300.00),
('Возврат книги', -50.00),
('Оплата счета', 120.00),
('Куплены аксессуары', 90.00),
('Оплата услуг', 60.00);

SELECT ROW_NUMBER() OVER (ORDER BY trans_id) AS row_number, *
FROM transaction_records;

-- Запросы для 2 пункта

CREATE TABLE sports_athletes (
    athlete_id SERIAL PRIMARY KEY,
    athlete_fullname VARCHAR(100),
    sport_name VARCHAR(100)
);

INSERT INTO sports_athletes (athlete_fullname, sport_name) VALUES
('Алексей Иванов', 'гимнастика'),
('Елена Смирнова', 'гимнастика'),
('Максим Петров', 'гимнастика'),
('Анна Кузнецова', 'бокс'),
('Виктор Сидоров', 'бокс'),
('Мария Лебедева', 'бокс'),
('Денис Павлов', 'плавание'),
('Ольга Захарова', 'плавание'),
('Андрей Тихонов', 'плавание');

SELECT *,
       ROW_NUMBER() OVER (PARTITION BY sport_name ORDER BY athlete_id) AS row_number
FROM sports_athletes;

-- Запросы для 3 пункта

    CREATE TABLE financial_operations (
        operation_id SERIAL PRIMARY KEY,
        operation_description VARCHAR(100),
        operation_amount NUMERIC
    );

    INSERT INTO financial_operations (operation_description, operation_amount) VALUES
    ('Покупка автомобиля', 20000.00),
    ('Возврат телефона', -500.00),
    ('Оплата аренды', 800.00),
    ('Покупка мебели', 1500.00),
    ('Возврат обуви', -200.00),
    ('Оплата учебы', 5000.00),
    ('Куплены продукты', 100.00),
    ('Оплата коммунальных услуг', 250.00);

    UPDATE financial_operations
    SET operation_amount = 1800
    WHERE operation_id = 1;

    SELECT * FROM financial_operations;

    SELECT 
        operation_id,
        operation_description,
        operation_amount,
        SUM(operation_amount) OVER (ORDER BY operation_id) AS final_balance
    FROM financial_operations;

-- 4 пункт

ALTER TABLE financial_operations
ADD COLUMN percent_of_total NUMERIC;

UPDATE financial_operations
SET percent_of_total = (operation_amount / (SELECT SUM(operation_amount) FROM financial_operations)) * 100;

SELECT SUM(operation_amount) FROM financial_operations;

SELECT 
    operation_id,
    operation_description,
    operation_amount,
    percent_of_total,
    SUM(operation_amount) OVER (ORDER BY operation_id) AS final_balance
FROM financial_operations;

-- Пункт 5

SELECT 
    operation_id,
    operation_description,
    operation_amount,
    percent_of_total,
    SUM(operation_amount) OVER (ORDER BY operation_id) AS final_balance,
    (SELECT SUM(percent_of_total) FROM financial_operations) AS total_percent
FROM financial_operations;

-- Пункт 6

SELECT 
    operation_id,
    operation_description,
    operation_amount,
    percent_of_total,
    final_balance,
    total_percent
FROM (
    SELECT 
        operation_id,
        operation_description,
        operation_amount,
        percent_of_total,
        SUM(operation_amount) OVER (ORDER BY operation_id) AS final_balance,
        (SELECT SUM(percent_of_total) FROM financial_operations) AS total_percent
    FROM financial_operations
) AS subquery
WHERE final_balance < 0;

-- Задание 3.1 История изменения заказа

CREATE TABLE order_change_log (
    change_id SERIAL PRIMARY KEY,
    order_reference INT NOT NULL,
    change_timestamp TIMESTAMP NOT NULL,
    changed_field VARCHAR(50) NOT NULL,
    old_value VARCHAR(255),
    new_value VARCHAR(255)
);

INSERT INTO order_change_log (order_reference, change_timestamp, changed_field, old_value, new_value) VALUES
(1, '2024-01-01 10:00:00', 'order_status', NULL, 'создан'),
(1, '2024-01-02 12:00:00', 'order_status', 'создан', 'обработан'),
(1, '2024-01-03 14:00:00', 'order_status', 'обработан', 'отправлен'),
(2, '2024-01-01 11:00:00', 'order_status', NULL, 'создан'),
(2, '2024-01-02 13:00:00', 'order_status', 'создан', 'обработан'),
(3, '2024-01-01 12:00:00', 'order_status', NULL, 'создан'),
(3, '2024-01-03 15:00:00', 'order_status', 'создан', 'отправлен'),
(3, '2024-01-04 16:00:00', 'order_status', 'отправлен', 'доставлен');

WITH status_changes AS (
    SELECT 
        order_reference,
        change_timestamp,
        new_value AS status,
        LEAD(change_timestamp) OVER (PARTITION BY order_reference ORDER BY change_timestamp) AS next_change_timestamp
    FROM 
        order_change_log
    WHERE 
        changed_field = 'order_status'
),
status_durations AS (
    SELECT 
        status,
        EXTRACT(EPOCH FROM (COALESCE(next_change_timestamp, '2024-06-13 15:00:00') - change_timestamp)) / 60 AS duration -- Перевод в минуты
    FROM 
        status_changes
)
SELECT 
    status,
    AVG(GREATEST(duration, 0)) AS average_duration
FROM 
    status_durations
GROUP BY 
    status
ORDER BY 
    status;

SELECT * FROM order_change_log;

-- Задание 3.2 Визиты клиентов

CREATE TABLE site_visits (
    visit_id SERIAL PRIMARY KEY,
    client_id INTEGER,
    visit_time TIMESTAMP,
    duration_minutes INTEGER,
    entry_page VARCHAR(255),
    exit_page VARCHAR(255),
    source VARCHAR(255)
);

CREATE TABLE visit_pages (
    page_id SERIAL PRIMARY KEY,
    visit_ref INTEGER,
    page_url VARCHAR(255),
    time_spent_seconds INTEGER
);

ALTER TABLE visit_pages
ADD CONSTRAINT fk_site_visits
FOREIGN KEY (visit_ref) REFERENCES site_visits (visit_id);

INSERT INTO site_visits (client_id, visit_time, duration_minutes, entry_page, exit_page, source)
VALUES
    (1, '2024-03-01 08:00:00', 10, '/main', '/products', 'google_ads'),
    (1, '2024-03-02 09:00:00', 15, '/products', '/cart', 'facebook_ads'),
    (2, '2024-03-01 10:00:00', 5, '/main', '/about_us', 'instagram_ads'),
    (2, '2024-03-03 11:00:00', 12, '/products', '/checkout', 'direct');

INSERT INTO visit_pages (visit_ref, page_url, time_spent_seconds)
VALUES
    (1, '/main', 120),
    (1, '/products', 300),
    (1, '/cart', 180),
    (2, '/main', 60),
    (2, '/about_us', 240),
    (2, '/checkout', 180),
    (3, '/main', 100),
    (3, '/products', 150),
    (4, '/main', 90),
    (4, '/products', 200),
    (4, '/checkout', 60);

-- 1

-- здесь мы выводим даты последних визитов у двух пользователей

SELECT * FROM site_visits;
SELECT * FROM visit_pages;

SELECT 
    client_id AS "ID
    клиента",
    MAX(visit_time) AS "Дата последнего визита"
FROM 
    site_visits
GROUP BY 
    client_id;

-- 2 

SELECT 
    sv.client_id AS "ID клиента",
    AVG(vp.page_count) AS "Среднее количество просмотров страниц за визит"
FROM 
    (
        SELECT 
            visit_ref,
            COUNT(*) AS page_count
        FROM 
            visit_pages
        GROUP BY 
            visit_ref
    ) AS vp
JOIN 
    site_visits sv ON sv.visit_id = vp.visit_ref
GROUP BY 
    sv.client_id;

-- 3 

SELECT * FROM site_visits;
SELECT * FROM visit_pages;

SELECT client_id, entry_page, exit_page
FROM site_visits sv
WHERE duration_minutes > (
    SELECT ROUND(AVG(duration_minutes), 0)
    FROM site_visits
);

-- 3.3 Расчет конверсии

-- Создание таблицы с визитами
CREATE TABLE customer_visits (
    visit_id SERIAL PRIMARY KEY,
    client_id INTEGER,
    visit_datetime TIMESTAMP
);

-- Создание таблицы с информацией о клиентах
CREATE TABLE customer_info (
    client_id SERIAL PRIMARY KEY,
    signup_date TIMESTAMP,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone_number VARCHAR(20),
    email_address VARCHAR(100)
);

-- Создание таблицы с заказами
CREATE TABLE customer_orders (
    order_id SERIAL PRIMARY KEY,
    order_date TIMESTAMP,
    client_id INTEGER,
    handler_id INTEGER,
    status_id INTEGER,
    is_paid BOOLEAN,
    order_total DECIMAL(10, 2),
    traffic_source VARCHAR(100)
);

INSERT INTO customer_info (signup_date, first_name, last_name, phone_number, email_address) VALUES
    ('2024-01-01', 'John', 'Doe', '123456789', 'john.doe@example.com'),
    ('2024-02-01', 'Jane', 'Smith', '987654321', 'jane.smith@example.com');

INSERT INTO customer_orders (order_date, client_id, handler_id, status_id, is_paid, order_total, traffic_source) VALUES
    ('2024-01-05', 1, 1, 1, true, 100.00, 'Google'),  -- Менеджер 1
    ('2024-01-10', 1, 2, 3, false, 150.00, 'Facebook'),  -- Менеджер 2
    ('2024-02-05', 2, 1, 1, true, 200.00, 'Google'),  -- Менеджер 1
    ('2024-02-10', 2, 2, 1, true, 250.00, 'Facebook'),  -- Менеджер 2
    ('2024-02-12', 2, 3, 1, true, 300.00, 'Instagram'),  -- Менеджер 3
    ('2024-02-14', 2, 3, 3, false, 350.00, 'Instagram');  -- Менеджер 3

-- Предположим также, что у всех заказов есть по крайней мере один визит
INSERT INTO customer_visits (client_id, visit_datetime) VALUES
    (1, '2024-01-01 10:00:00'),
    (1, '2024-01-06 10:00:00'),
    (2, '2024-02-01 10:00:00'),
    (2, '2024-02-06 10:00:00');

-- Среднее время между заказами для каждого клиента

SELECT client_id, AVG(days_between_orders) AS avg_days_between_orders
FROM (
    SELECT client_id,
           EXTRACT(DAY FROM (LEAD(visit_datetime) OVER (PARTITION BY client_id ORDER BY visit_datetime) - visit_datetime)) AS days_between_orders
    FROM customer_visits
) AS subquery
WHERE days_between_orders IS NOT NULL
GROUP BY client_id;

-- Кол-во визитов и заказов для каждого клиента 

SELECT ci.client_id,
       COUNT(DISTINCT cv.visit_id) AS num_visits,
       COUNT(DISTINCT co.order_id) AS num_orders
FROM customer_info ci
LEFT JOIN customer_visits cv ON ci.client_id = cv.client_id
LEFT JOIN customer_orders co ON ci.client_id = co.client_id
GROUP BY ci.client_id;

-- Информация об источнике трафика

SELECT traffic_source,
       COUNT(DISTINCT cv.visit_id) AS num_visits,
       COUNT(DISTINCT co.order_id) AS num_orders_created,
       COUNT(DISTINCT CASE WHEN co.is_paid THEN co.order_id END) AS num_paid_orders,
       COUNT(DISTINCT CASE WHEN co.status_id = 1 THEN co.order_id END) AS num_completed_orders
FROM customer_orders co
LEFT JOIN customer_visits cv ON co.client_id = cv.client_id
GROUP BY traffic_source;

-- Среднее время выполнения заказов

SELECT 
    co.handler_id AS manager_id,
    AVG(EXTRACT(EPOCH FROM (co.order_date - cv.visit_datetime)) / 3600) AS avg_order_completion_time,
    SUM(CASE WHEN co.status_id = 3 THEN 1 ELSE 0 END)::FLOAT / COUNT(*) AS cancellation_rate,
    SUM(co.order_total) AS total_completed_orders,
    AVG(co.order_total) AS avg_order_cost
FROM 
    customer_orders co
JOIN 
    customer_visits cv ON co.client_id = cv.client_id
GROUP BY 
    co.handler_id;

-- последний отчет - рейтинги менеджеров
--если у менеджера все три показателя (доля завершенных заказов, среднее время выполнения и процент отмен) хуже,
--чем общие средние показатели, итоговый рейтинг будет отрицательным.

WITH manager_metrics AS (
    SELECT 
        co.handler_id,
        COUNT(*) AS total_orders,
        SUM(CASE WHEN co.status_id = 1 THEN 1 ELSE 0 END) AS completed_orders,
        AVG(EXTRACT(EPOCH FROM (co.order_date - cv.visit_datetime)) / 3600) AS avg_order_completion_time,
        SUM(CASE WHEN co.status_id = 3 THEN 1 ELSE 0 END)::FLOAT / COUNT(*) AS cancellation_rate
    FROM 
        customer_orders co
    JOIN 
        customer_visits cv ON co.client_id = cv.client_id
    GROUP BY 
        co.handler_id
),
overall_metrics AS (
    SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) AS completed_orders,
        AVG(EXTRACT(EPOCH FROM (co.order_date - cv.visit_datetime)) / 3600) AS avg_order_completion_time,
        SUM(CASE WHEN status_id = 3 THEN 1 ELSE 0 END)::FLOAT / COUNT(*) AS cancellation_rate
    FROM 
        customer_orders co
    JOIN 
        customer_visits cv ON co.client_id = cv.client_id
)
SELECT 
    mm.handler_id,
    (mm.completed_orders::FLOAT / mm.total_orders - om.completed_orders::FLOAT / om.total_orders) +
    (mm.avg_order_completion_time - om.avg_order_completion_time) -
    (mm.cancellation_rate - om.cancellation_rate) AS manager_rating
FROM 
    manager_metrics mm,
    overall_metrics om;
