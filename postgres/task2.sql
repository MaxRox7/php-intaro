-- Таблицы с различными типами данных
CREATE TABLE standard_data_types (
    numeric_column NUMERIC,
    character_column VARCHAR(50),
    boolean_column BOOLEAN,
    datetime_column TIMESTAMP
);

-- Перечисления
CREATE TYPE enum_type AS ENUM ('Option1', 'Option2', 'Option3');
CREATE TABLE enumerations (
    enum_column enum_type
);
/*==============================================================*/
/*==============================================================*/
--Массивы
CREATE TABLE arrays (
    integer_array_column INTEGER[]
);

--XML и JSON
CREATE TABLE xml_json (
    xml_column XML,
    json_column JSON
);

--Составные типы
CREATE type composite_types AS (
    amount integer,
    name character varying(100)
);

CREATE TABLE composite_table (

compose composite_types

);

--Прочие типы: денежный, двоичный, геометрический, битовые строки, UUID
CREATE TABLE other_types (
    money_column MONEY,
    binary_column BYTEA,
    geometric_column POINT,
    bitstring_column BIT VARYING(10),
    uuid_column UUID
);

-- INSERT запросы
INSERT INTO standard_data_types VALUES (10, 'Sample', TRUE, '2022-01-01 12:00:00');

INSERT INTO enumerations VALUES ('Option1');

INSERT INTO arrays VALUES ('{1, 2, 3}');

INSERT INTO xml_json VALUES ('<data>example</data>', '{"1": "BMW}');

INSERT INTO composite_table VALUES (ROW(200, 'Помидоры'));

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
INSERT INTO other_types VALUES (100.00, E'\\xDEADBEEF', POINT(1, 2), B'101010', uuid_generate_v4());

-- SELECT запросы
SELECT * FROM standard_data_types WHERE numeric_column = 10;

SELECT * FROM enumerations WHERE enum_column = 'Option1';

SELECT * FROM arrays WHERE integer_array_column @> ARRAY[2];

SELECT * FROM xml_json WHERE json_column->>'1' = 'BMW' ;


SELECT * FROM composite_table WHERE (compose).name = 'Помидоры'

SELECT * FROM other_types WHERE uuid_column = '550e8400-e29b-41d4-a716-446655440000';