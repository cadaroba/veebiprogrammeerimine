$weekDaysET = ["E", "T", "K", "N" ..];

$weekDayToday = date("N"); //esmaspäev = 1;

echo $weekDaysET[$weekDayToday -1];