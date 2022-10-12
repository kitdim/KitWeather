<?php

$ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDER'] . '?lang=eng');// TODO отдельный файл Search_Ip
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// TODO отдельный файл Search_Ip
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// TODO отдельный файл Search_Ip
curl_setopt($ch, CURLOPT_HEADER, false);// TODO отдельный файл Search_Ip
$res = curl_exec($ch); // TODO отдельный файл Search_Ip
curl_close($ch); // TODO отдельный файл Search_Ip

$res = json_decode($res, true); // TODO отдельный файл Search_Ip

// API ключ

$jsonKey = json_decode('setting.json');
$apiKey = $jsonKey['key']; // TODO отдельный файл settings
// Город погода которого нужна
$city = $res['city']; // TODO отдельный файл settings, и добавить фукнцию определения города по ip
// Ссылка для отправки
$url = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&lang=ru&units=metric&appid=" . $apiKey; // TODO отдельный файл settings

// Создаём запрос
$ch = curl_init(); // TODO отдельный файл

// Настройка запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // TODO отдельный файл
curl_setopt($ch, CURLOPT_URL, $url); // TODO отдельный файл

// Отправляем запрос и получаем ответ
$data = json_decode(curl_exec($ch)); // TODO отдельный файл

// Закрываем запрос
curl_close($ch); // TODO отдельный файл

echo "В городе " . $data->name."<br>"; // TODO отдельный файл form.html
echo "Погода " . $data->main->temp_min. "°C"."<br>"; // TODO отдельный файл form.html
echo "Влажность " .$data->main->humidity. "%"."<br>"; // TODO отдельный файл form.html
echo "Скорость ветра " .$data->wind->speed."км/ч"."<br>"; // TODO отдельный файл form.html

class Weather
{
    const WEATHER_IP_KEY = ''; // добавить подключения ключа погоды
    private $IpCity; // сделать отдельный класс определения города
    private $ViewInfoWeather; // сделать класс или файл вывода погоды

}




