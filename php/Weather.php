<?php
class Weather
{
    private $data;
    private $ch;
    private $url;
    private $res;
    private $jsonKey;
    private $apiKey;
    private $city;

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
        try {
            $this->jsonKey = json_decode('setting.json');
        }
        catch (Exception){
            echo "Не удалось получить ipiKey";
        }
        $this->apiKey = $this->jsonKey['key'];
        $this->city = $this->res['city'];
        // Ссылка для отправки
        $this->url = "http://api.openweathermap.org/data/2.5/weather?q=" . $this->city . "&lang=ru&units=metric&appid=" . $this->apiKey;

        return $this->url;
    }

    /// Создание города по Ip
    private function CreateIpCity(){
        try {
            error_reporting(E_ERROR);
            $this->ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDER'] . '?lang=eng');
        }
        catch (Exception){
            echo "Не удалось обратиться к сервису для получения ip города";
        }

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        $this->res = curl_exec($this->ch);
        curl_close($this->ch);

        $this->res = json_decode($this->res, true);

        return $this->res;
    }
}