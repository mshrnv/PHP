<?php

date_default_timezone_set('Europe/Moscow');
define('HOLIDAYS_ARR', array('01.01', '23.02', '08.03', '01.05', '09.05', '01.09', '20.12'));

// Обработка GET
if (isset($_GET['year']) && isset($_GET['month'])) {
    print getCalendar($_GET['month'], $_GET['year']);
}
else {
    $html  = getHeader();
    $html .= getCalendar(date('n'), date('Y'));
    $html .= getFooter();
    print $html;
}

function getCalendar($__month, $__year)
{
    $timestamp = mktime(0, 0, 0, $__month, 1, $__year);
    $daysCount = date('t', $timestamp);
    $dates = range(1, $daysCount);

    $html = '<table class="table table-bordered">
            <tr>
                <td>Monday</td>
                <td>Tuesday</td>
                <td>Wednesday</td>
                <td>Thursday</td>
                <td>Friday</td>
                <td>Saturday</td>
                <td>Sunday</td>
            </tr>';

    $beginEmptyDaysCount = date('N', $timestamp) - 1;
    for($day = 0; $day < $beginEmptyDaysCount; $day++) {
        array_unshift($dates, '');
    }

    $endEmptyDaysCount = 7 - (count($dates) % 7);
    if ($endEmptyDaysCount == 7) {
        $endEmptyDaysCount = 0;
    }

    for ($day = 0; $day < $endEmptyDaysCount; $day++) {
        array_push($dates, '');
    }

    # Выделение текущей даты
    if ($__month == date('m', strtotime('now'))) {
        $currentDate = date('d', strtotime('now'));
        $currentDateIndex = array_search($currentDate, $dates);
        $dates[$currentDateIndex] = "<div class='now'>{$dates[$currentDateIndex]}</div>";
    }

    $holidaysInMonth = array();
    foreach (HOLIDAYS_ARR as $index => $date) {
        if (preg_match('/(\d{2})\.'.$__month.'/ui', $date, $matches)) {
            $index = array_search($matches[1], $dates);
            $dates[$index] = "<div class='holiday'>{$dates[$index]}</div>";
        }
    }
    
    foreach(range(1, count($dates) / 7) as $week) {
        $html .= '<tr>';
        foreach (range(1,7) as $day) {
            $html .= '<td>'.array_shift($dates).'</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;
}

function getHeader()
{
    return '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Calendar</title>
                <link rel="stylesheet" href="css/bootstrap.css">
                <link rel="stylesheet" href="css/style.css">
                <script src="js/jquery-3.6.0.min.js"></script>
                <script src="js/script.js"></script>
            </head>
            <body>
                <div class="container-fluid">
                    <div class="row">
                        <nav class="navbar navbar-light bg-light">
                            <div class="container-fluid">
                                <a class="navbar-brand" href="#">
                                    <img src="img/calendar.png" alt="Icon" width="30" height="30" class="d-inline-block align-text-top">
                                    Calendar
                                </a>
                            </div>
                        </nav>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <select class="form-select" id="year" onchange="update()">
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021" selected>2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="month" onchange="update();">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">Jule</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">Octomber</option>
                                <option value="11">November</option>
                                <option value="12" selected>December</option>
                            </select>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-8" id="calendar">';
}

function getFooter()
{
    return '</div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>
</html>';
}
                