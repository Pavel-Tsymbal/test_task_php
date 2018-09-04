<?php
//Имеется база со следующими таблицами:
//Напишите запрос, возвращающий имя и число указанных телефонных номеров девушек в возрасте от 18 до 22 лет.
//Оптимизируйте таблицы и запрос при необходимости.

$sql = "SELECT name,COUNT(phone) as phones_count FROM 
phone_numbers INNER JOIN users ON users.id=phone_numbers.user_id 
WHERE YEAR(NOW()) - YEAR(birth_date) >= 18 AND YEAR(NOW()) - YEAR(birth_date) <= 22 AND gender=2 
GROUP BY users.id";

//Опитимизировать можно добавив индекс на birth_date,gender.
// После добавления индекса на birth_date сразу виден результат, даже на маленьком кол-ве записей, а вот создав индекс на gender, мы увидим результат только на большом кол-ве данных.