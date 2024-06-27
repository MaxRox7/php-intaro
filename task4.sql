--Создаем таблицу
CREATE TABLE products (
 	id INTEGER PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
	price INTEGER NOT NULL,
	description VARCHAR(30),
	created_at DATE NOT NULL
    active boolean NOT NULL

);

--Загрузим 10000 случайных значений

INSERT INTO products (id, name, price, description, created_at, active)
SELECT tmp.id, 'Название' || tmp.id, (random() * 100 + 10000)::integer, 'Описание' || tmp.id, timestamp '2024-01-01 20:00:00' + random() * (timestamp '2024-01-01 ' - timestamp '2024-06-27 '),
CASE WHEN random() < 0.5 THEN TRUE ELSE FALSE END
FROM (SELECT generate_series(1, 10000) as id) as tmp
LEFT JOIN products ON products.id = tmp.id
WHERE products.id IS NULL;


--Напишем запросы

-- Запрос для активных товаров
EXPLAIN ANALYZE
SELECT *
FROM products
WHERE active = true
ORDER BY price desc

-- Запрос по цене
EXPLAIN ANALYZE
SELECT *
FROM products
ORDER BY price desc

-- Запрос для даты
EXPLAIN ANALYZE
SELECT * FROM products
WHERE created_at < '2023-10-11'
ORDER BY created_at desc

-- Запрос для имени
EXPLAIN ANALYZE
SELECT * FROM products
WHERE name = 'Название7487'
ORDER BY created_at desc



-- Запрос для описания
EXPLAIN ANALYZE
SELECT *
FROM products
WHERE description like 'Описание9%'
ORDER BY description asc


-- Запрос для товаров по цене в промежутке
EXPLAIN ANALYZE
SELECT * FROM products
WHERE price BETWEEN 30000 AND 45000
ORDER BY price ASC


-- Теперь создадим индексы
--brin
CREATE INDEX brin_created_index ON products USING brin (created_at);

--btree
CREATE INDEX btree_price_index ON products USING btree (price);

--gim
CREATE EXTENSION pg_trgm;
CREATE EXTENSION btree_gin;
CREATE INDEX gin_name_index ON products USING gin (name);

--hash
CREATE INDEX hash_active_index ON products USING hash(active);

--Частичный индекс
CREATE INDEX part_price_index ON products (price) WHERE price < 40000;


-- Перейдем к json
--Создадим таблицу
CREATE TABLE table_json (
    id SERIAL PRIMARY KEY,
    json JSONB NOT NULL
);


--Создадим индекс

CREATE EXTENSION IF NOT EXISTS btree_gist;
CREATE INDEX gist_json_index ON table_json USING gin (json);

--Введем данные

INSERT INTO table_json (json)
SELECT 
    ('{"name":"Имя' || tmp.id || '","Фамилия":"Фамилия' || tmp.id || 
    CASE 
        WHEN random() < 0.5 THEN '","error":"Error"' 
        ELSE '"' 
    END || '}')::jsonb
FROM (SELECT generate_series(1, 10000) as id) as tmp;



--Видим, что gist испольуется
EXPLAIN ANALYZE
SELECT json FROM table_json
WHERE json @> '{"name": "Имя1000"}';


--Ищем, где 'error'
SELECT id, json 
FROM table_json
WHERE json ->> 'error' IS NOT NULL;