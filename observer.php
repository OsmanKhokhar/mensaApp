<?php 

interface Observer{
    public function update(float $temperature);
}

interface Subject{
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

class WeatherStation implements Subject {

    private array $observers = [];
    private float $temperature;

    public function attach(Observer $observer){
        $this->observers[]= $observer;
    }
    public function detach(Observer $observer){
        foreach($this->observers as $key=>$obs){
            if($obs === $observer){
                unset($this->observers[$key]);

            }

        }
    }
    public function setTemperature(float $temp){
        echo "\n>>> Wetterstation: Temperature gesetz auf $temp °C\n";
        $this->temperature = $temp;
        $this->notify($temp);
    }

    public function notify(){
        foreach($this->observers as $observer){
            $observer->update($this->temperature);
        }
    }
}

class CurrentConditionDisplay implements Observer{
    public function update(float $temperature){
        echo "Aktulle Temperatue: $temperature °C\n";
    }
}

class StatsDisplay implements Observer{
private array $temperatureHistory = [];

    public function update(float $temperature){
        $this->temperatureHistory[] = $temperature;
        $avg = array_sum($this->temperatureHistory) / count($this->temperatureHistory);

        echo "Stats: Avg Temp is =". round($avg, 2). "°C\n";
    }
}

$station = new WeatherStation();

$display1 = new CurrentConditionDisplay();
$display2 = new StatsDisplay();

$station->attach($display1);
$station->attach($display2);


$station->setTemperature(20.5);
$station->setTemperature(22.0);
$station->setTemperature(23.7);



?>