<?php
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

    $firstDayOfWeek = date('w', $timestamp);
    foreach (range(1, $firstDayOfWeek) as $value) {
        
    }

    return '<table class="table table-bordered">
            <tr>
                <td>Monday</td>
                <td>Tuesday</td>
                <td>Wednesday</td>
                <td>Thursday</td>
                <td>Friday</td>
                <td>Saturday</td>
                <td>Sunday</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
            </tr>
            <tr>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
            </tr>
            <tr>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
                <td>19</td>
                <td>20</td>
                <td>21</td>
            </tr>
            <tr>
                <td>22</td>
                <td>23</td>
                <td>24</td>
                <td>25</td>
                <td>26</td>
                <td>27</td>
                <td>28</td>
            </tr>
            <tr>
                <td>29</td>
                <td>30</td>
                <td>31</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr></tr></table>';
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
                