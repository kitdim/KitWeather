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
    private $data;
    private $ch;
    private $url;
    private $res;

    public function __construct()
    {
        $this->res = $this->CreateIpCity();
        $this->url = $this->GetIpCity();
        $this->data = $this->CreateWeather();
    }

    /// Отобразить информацию о погоде
    public function ViewWeather()
    {
        echo "В городе " .$this->data->name."<br>";
        echo "Погода " .$this->data->main->temp_min. "°C"."<br>";
        echo "Влажность " .$this->data->main->humidity. "%"."<br>";
        echo "Скорость ветра " .$this->data->wind->speed."км/ч"."<br>";
    }

    /// Создание погоды по API
    private function CreateWeather(){
        // Создаём запрос
        $this->ch = curl_init();
        // Настройка запроса
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_URL, $this->url);

        // Отправляем запрос и получаем ответ
        $this->data = json_decode(curl_exec($this->ch));

        // Закрываем запрос
        curl_close($this->ch);

        return $this->data;
    }

    /// Получить ip города
    private function GetIpCity(){
        $this->jsonKey = json_decode('setting.json');
        $this->apiKey = $this->jsonKey['key'];
        $this->city = $this->res['city'];
        // Ссылка для отправки
        $this->url = "http://api.openweathermap.org/data/2.5/weather?q=" . $this->city . "&lang=ru&units=metric&appid=" . $this->apiKey;

        return $this->url;
    }

    /// Создание города по Ip
    private function CreateIpCity(){
        $this->ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDER'] . '?lang=eng');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        $this->res = curl_exec($this->ch);
        curl_close($this->ch);

        $this->res = json_decode($this->res, true);

        return $this->res;
    }
}




