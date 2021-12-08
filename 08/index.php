<?php

# Устанавливаем временную зону
date_default_timezone_set('Europe/Moscow');

# Определение констант
define('HOLIDAYS_ARR', array('01.01', '23.02', '08.03', '01.05', '09.05', '01.09', '20.12'));
define('MIN_YEAR', 2015);
define('MAX_YEAR', 2025);
define('DAYS_IN_WEEK', 7);

# Обработка параметров GET запроса
$month = isset($_GET['month']) ? htmlspecialchars($_GET['month']) : date('n');
$year  = isset($_GET['year']) ? htmlspecialchars($_GET['year']) : date('Y');

# Если month и year пришли в GET запросе - возвращаем только таблицу календаря
if (isset($_GET['month']) && isset($_GET['year'])) {
    print getCalendar($month, $year);
}

# Если их нет в GET запросе - выводим всю страницу
else {
    $html  = getHeader();
    $html .= getCalendar($month, $year);
    $html .= getFooter();
    print $html;
}

/**
 * Возвращает HTML код таблицы календаря
 *
 * @param string  $__month Месяц календаря.
 * @param integer $__year  Год календаря.
 * 
 * @return string HTML код календаря.
 */
function getCalendar(string $__month, int $__year)
{

    # Определяем выбранный для показа месяц в формате UNIX time
    $timestamp = mktime(0, 0, 0, $__month, 1, $__year);

    # Определяем количество дней в месяце и заполняем массив дней
    $daysCount = date('t', $timestamp);
    $dates     = range(1, $daysCount);

    # Начало таблицы
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

    # Добавляем в начало массива (Номер_дня_недели_первого_числа - 1) пустых элементов
    $beginEmptyDaysCount = date('N', $timestamp) - 1;
    for ($day = 0; $day < $beginEmptyDaysCount; $day++) {
        array_unshift($dates, '');
    }

    # Определяем количество пустых элементов, чтобы последняя строка была длины DAYS_IN_WEEK
    $endEmptyDaysCount = DAYS_IN_WEEK - (count($dates) % DAYS_IN_WEEK);
    if ($endEmptyDaysCount == 7) {
        $endEmptyDaysCount = 0;
    }

    # Добавляем в конец массива пустые элементы
    for ($day = 0; $day < $endEmptyDaysCount; $day++) {
        array_push($dates, '');
    }

    # Выделение текущей даты (Оборачиваем в div с классом now)
    if ($__month == date('m', strtotime('now'))) {
        $currentDate              = date('d', strtotime('now'));
        $currentDateIndex         = array_search($currentDate, $dates);
        $dates[$currentDateIndex] = "<div class='now'>{$dates[$currentDateIndex]}</div>";
    }

    # Выделение праздников в месяце (Оборачиваем в div с классом holiday)
    foreach (HOLIDAYS_ARR as $index => $date) {
        if (preg_match('/(\d{2})\.' . $__month . '/ui', $date, $matches)) {
            $index         = $matches[1] + $beginEmptyDaysCount - 1;
            $dates[$index] = "<div class='holiday'>{$dates[$index]}</div>";
        }
    }

    # Пробегаем по неделям, каждая неделя - строка таблицы
    foreach (range(1, count($dates) / DAYS_IN_WEEK) as $week) {
        $html .= '<tr>';

        # Пробегаем по дням недели, каждый день недели - это столбец строки
        foreach (range(1, DAYS_IN_WEEK) as $day) {
            $html .= '<td>' . array_shift($dates) . '</td>';
        }

        //
        $html .= '</tr>';
    }

    # Закрываем таблицу
    $html .= '</table>';

    # Возвращаем HTML код
    return $html;
}

/**
 * Возвращает шапку HTML страницы
 *
 * @return string HTML код шапки страницы.
 */
function getHeader()
{
    $html = '<!DOCTYPE html>
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
                            <select class="form-select" id="year" onchange="update()">';

    # Отображение option`ов внутри select 
    foreach (range(MIN_YEAR, MAX_YEAR) as $year) {
        $html .= "<option value='{$year}'>$year</option>";
    }

    //
    $html .= '</select>
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

    //
    return $html;
}

/**
 * Возвращает подвал HTML страницы
 *
 * @return string HTML код подвала страницы.
 */
function getFooter()
{
    return '</div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <script>$("option[value=\'2021\']").attr("selected", true)</script>
</body>
</html>';
}
