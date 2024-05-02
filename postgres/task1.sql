-- task 1
-- 3
INSERT INTO client(full_name_client, phone_client, id_user) values ('Болдырев Максим Романович', '9802695322', 4),
('Кретов Игорь Олегович', '9323255651', 13), ('Толстунов Владимир Дмитриевич', '9563735678', 14), 
('Данченко Александр Сергеевич', '9563796457', 15), ('Горшков Александр Эдуардович', '9345678673', 17)

-- 4 
SELECT * FROM client

-- 5 
--Запрос получение информации об оборудовании конкретного клиента::


SELECT ce.name_equip, ce.serial_number_equip, ce.desc_equip, c.full_name_client
FROM client_equipment ce
JOIN client c ON ce.id_client = c.id_client;
ORDER BY ce.id_client


--6
--Запрос на модификацию заказа со статусом “В процессе” с отсутствующей датой на “Закончен” с датой окончания

UPDATE booking 
SET status_booking = 'Закончен', booking_close_date = '22.12.2023' 
WHERE id_booking = 3


--7
--Запрос на удаление сотрудника из базы по имени

DELETE FROM worker WHERE fn_worker = 'Сидоров Сидор Сидорович'
