<?php

/**
 * Обновляет текущую страницу
 *
 * @return void
 */
function reload()
{
    header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"]);
}

/**
 * Определяет: авторизован пользователь или нет.
 *
 * @return boolean true - авторизован, false - нет.
 */
function isAuthorized()
{
    return isset($_SESSION['username']);
}

/**
 * Выдает сообщение о неправильно введенных данных при авторизации.
 *
 * @return string HTML-код блока с ошибкой.
 */
function getAuthErrorHtml()
{
    return '<div class="alert alert-warning" role="alert">
                Ошибка авторизации: проверьте введенные данные.
            </div>';
}

/**
 * Записывает новое сообщение в файл GUESTBOOK_FILE_NAME
 *
 * @param string $__text     Текст сообщения.
 * @param string $__username Имя пользователя.
 * @param string $__ip       IP-адрес клиента.
 * 
 * @return void
 */
function sendMessage(string $__text, string $__username, string $__ip)
{

    # Получаем массив сообщений
    $messagesArr = getMessagesArr();

    #Записываем новое сообщение
    $messageArr = array(
        'username'     => $__username,
        'datetime'     => date('j.m.Y H:i:s'),
        'message_text' => trim($__text),
        'user_ip'      => $__ip,
    );
    array_unshift($messagesArr, $messageArr);

    #Запись в файл
    putContentInFile(GUESTBOOK_FILE_NAME, serialize($messagesArr));
}

/**
 * Редактирует сообщение гостевой книги
 *
 * @param integer $__messageId   ID сообщения.
 * @param string  $__messageText Текст сообщения.
 * @param string  $__username    Имя пользователя.
 * 
 * @return void
 */
function editMessage(int $__messageId, string $__messageText, string $__username)
{

    #Получаем массив сообщений
    $messagesArr = getMessagesArr();

    #Изменяем поле с текстом сообщения
    $messagesArr[$__messageId]['message_text'] = trim($__messageText);

    #Добавляем два новых поля: дата изменения, username изменявшего
    $messagesArr[$__messageId]['edited_datetime'] = date('j.m.Y H:i:s');
    $messagesArr[$__messageId]['edited_username'] = $__username;

    #Запись в файл
    putContentInFile(GUESTBOOK_FILE_NAME, serialize($messagesArr));
}

/**
 * Удаляет сообщение.
 *
 * @param integer $__messageId ID сообщения.
 * 
 * @return void
 */
function deleteMessage(int $__messageId)
{

    #Получаем массив сообщений
    $messagesArr = getMessagesArr();

    #Удаляем заданное сообщение
    unset($messagesArr[$__messageId]);

    #Переиндексируем массив и записываем в файл
    $messagesArr = array_values($messagesArr);
    putContentInFile(GUESTBOOK_FILE_NAME, serialize($messagesArr));
}

/**
 * Возвращает массив номеров страниц пагинации для текущей страницы
 *
 * @param integer $__numberOfPages Общее количество страниц.
 * @param integer $__currentPage   Текущая страница.
 * 
 * @return array Массив номеров страниц пагинации для текущей страницы.
 */
function paginationListRender(int $__numberOfPages, int $__currentPage)
{

    # Массив номеров страниц
    $pagesArr = array();

    # Добавление в массив страниц которые находятся на расстоянии PAGES_AROUND от текущей
    for ($pageNumber = 1; $pageNumber <= $__numberOfPages; $pageNumber++) {
        if (abs($__currentPage - $pageNumber) <= PAGES_AROUND) {
            $pagesArr[] = $pageNumber;
        }
    }

    # Первый и последний элементы массива
    $first = $pagesArr[0];
    $last  = $pagesArr[count($pagesArr) - 1];

    # Если первый элемент массива - показываем 1 страницу без троеточия
    if ($first == 2) {
        array_unshift($pagesArr, 1);
    }
    
    # Если первый элемент массива это 3 или больше - показываем 1 страницу и разделяем троеточием
    elseif ($first >= 3) {
        array_unshift($pagesArr, 1, '...');
    }

    # Если последний элемент массива соседний с последней страницей - показываем последнюю страницу без троеточия
    if ($last == $__numberOfPages - 1) {
        array_push($pagesArr, $__numberOfPages);
    }
    
    # Если последний элемент на расстоянии больше 2 от последней страницы - показываем последнюю страницу, разделяя троеточием
    elseif ($last <= $__numberOfPages - 2) {
        array_push($pagesArr, '...', $__numberOfPages);
    }

    # Возвращаем массив пагинации
    return $pagesArr;
}

/**
 * Возвращает HTML-код кнопок навигации между страницами.
 *
 * @param integer $__currentPage   Текущая,выбранная страница.
 * @param integer $__numberOfPages Общее количество страниц.
 * 
 * @return string HTML-код кнопок навгации.
 */
function getPagination(int $__currentPage, int $__numberOfPages)
{
    # Получаем массив кнопок, которые надо вывести на экран
    $pagesArr = paginationListRender($__numberOfPages, $__currentPage);

    # Начало блока навигации
    $html = '<nav style="margin-top: 10px;">
                <form method="post">
                    <ul class="pagination justify-content-center">';

    # Вывод кнопок пагинации, кнопку с текущей страницей - выделяем цветом,
    # Кнопку с троеточием - делаем disabled
    foreach ($pagesArr as $pageNumber) {
        $html .= '<li class="page-item" style="margin-right: 5px;">
         <button class="btn btn-'.($pageNumber != $__currentPage ? 'outline-' : '').'primary btn-sm"
         type="submit" name="page" value="'.$pageNumber.'"'
        .($pageNumber === '...' ? ' disabled="disabled" ' : ' ').'>'.$pageNumber.'</button></li>';
    }

    #Конец блока навигации
    $html .= '</ul></form></nav>';

    #Возвращаем HTML код
    return $html;
}

/**
 * Возвращает массив сообщений.
 *
 * @return array Массив сообщений.
 */
function getMessagesArr()
{

    #Чтение файла и его ансериалицация в массив
    $data        = getFileContent(GUESTBOOK_FILE_NAME);
    $messagesArr = $data ? unserialize($data) : array();

    //
    return $messagesArr;
}

/**
 * Возвращает количество всех сообщений, хранящихся в книге
 * 
 * @return int Количество сообщений.
 */
function getMessagesCount()
{
    $messagesArr = getMessagesArr();
    return $messagesArr ? count($messagesArr) : 1;
}

/**
 * Возвращает HTML-код блоков с сообщениями на заданной странице
 *
 * @param integer $__currentPage   Номер страницы.
 * @param integer $__numberOfPages Количество страниц.
 * 
 * @return string HTML-код всех сообщений на странице.
 */
function getMessages(int $__currentPage, int $__numberOfPages)
{

    #Получение и реверс массива(согласно ТЗ)
    $html        = '';
    $messagesArr = getMessagesArr();

    #Вычисление id сообщений, которые выводятся на текущей странице
    $messagesIds = getMessagesIdsOnPage($__currentPage, $__numberOfPages);

    #Поочередный вывод сообщений
    foreach ($messagesIds as $messageId) {

        #Обработка случая, когда на странице недостаточно сообщений
        if (!isset($messagesArr[$messageId])) {
            continue;
        }

        #Информацию о текущем сообщение помещаем в массив
        $messageArr = $messagesArr[$messageId];

        #И заносим в HTML
        $html .= '<div class="card" style="margin-bottom: 15px;">
                    <div class="card-body" style="position: relative;">
                        <h6 class="card-title"><b>'.$messageArr['username']."</b> ".getIp($messageArr['user_ip']).
        ' | '.$messageArr['datetime'].'</h6>
         <p class="card-text" style="margin-bottom:5px; font-size: 18px;">'.$messageArr['message_text'].'</p>'
        .getEditLabel($messageId).' 
         '.getEditAndCloseButtonsHtml($messageArr['username'], $messageId).'</div></div>';
    }

    #Возвращаем HTML-код сообщений на странице
    return $html;
}

/**
 * Возвращает IP-адресс, если сессия админа(access_level = 1), в противном случае - пустую строку
 *
 * @param string $__ip IP-адресс клиента при отправке сообщения.
 * 
 * @return string IP-адресс или пустая строка.
 */
function getIp(string $__ip)
{
    # Вывожу имя польователя, ip и дату через '| '
    # Посмотрите на самой странице, так визуально понятнее разделяются блоки информации
    return $_SESSION['access_level'] !== 1 ? '' : '| '.$__ip;
}

/**
 * Возвращает HTML-код кнопки удаления, если это сообщение пользователя, который его отправил
 * Или, если это сессия админа. В противном случае - пустая строка.
 *
 * @param string  $__username Имя пользователя.
 * @param integer $__id       ID сообщения.
 * 
 * @return string HTML-код или пустая строка.
 */
function getEditAndCloseButtonsHtml(string $__username, int $__id)
{

    #Определяем уровень доступа
    $accessLevel = $_SESSION['access_level'];

    #Проверяем: может ли этот пользователь удалить это сообщание
    if ($accessLevel === 1 || $accessLevel === 2 && $__username == $_SESSION['username']) {

        #Если да, то возвращаем кнопку удаления
        return '<form method="post" style="position: absolute; top: 5px; right: 25px;">
                    <button type="button" style="border:none; background:none;" 
                    data-bs-toggle="modal" data-bs-target="#modal'.$__id.'">
                        <img src="img/edit.png" style="width:15px;">
                    </button>
                </form>
                <form method="post" style="position: absolute; top: 5px; right: 5px;">
                    <button name="deleteMessageId" value='.$__id.' type="submit" style="border:none; background:none;">
                        <img src="img/close.png" style="width:15px;">
                    </button>
                </form>';
    }

    #В противном случае - пустая строка
    else {
        return '';
    }
}

/**
 * Возвращает HTML-код текста об изменении сообщения
 *
 * @param integer $__messageId IВ сообщения.
 * 
 * @return string HTML-код или пустая строка.
 */
function getEditLabel(int $__messageId)
{

    #Получаем массив сообщений
    $messagesArr = getMessagesArr();

    #Если оно было изменено, то выводим доп информаицю об изменении в отдельный абзац
    if (isset($messagesArr[$__messageId]['edited_username'])) {
        return '<p class="card-subtitle text-muted">Edited by '
        .$messagesArr[$__messageId]['edited_username'].' at '
        .$messagesArr[$__messageId]['edited_datetime'].'</p>';
    }

    #Если сообщение не изменялось - пустая строка
    return '';
}

/**
 * Выводит форму авторизации и сообщение об ошибке если установлен флаг.
 *
 * @param boolean $__errorFlag Флаг ошибки авторизации.
 * 
 * @return void
 */
function printSignInForm(bool $__errorFlag)
{

    #Вывод HTML-кода, если установлен флаг, то под формой выводим ошибку
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="text-center">
        <div>
            <form class="form-signin" method="post">
                <img class="mb-4" src="img/ibooks.png" alt="guestbook" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                <input name="username" type="text" class="form-control" placeholder="Username" autofocus="">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <button name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="SignIn">Sign in</button>
                <button name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="SignInAsGuest">Sign in as guest</button>
            </form>
            '.($__errorFlag ? getAuthErrorHtml() : '').'
        </div></body></html>';
}

/**
 * Выводит гостевую книгу на экран, если user - гость, то допольнительно поле для ввода имени
 *
 * @param integer $__numberOfPages Количество страниц.
 * @param integer $__currentPage   Текущая страница с сообщениями.
 * 
 * @return void
 */
function printGuestBook(int $__numberOfPages, int $__currentPage)
{

    #Вывод HTML-кода гостевой книги
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/book.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
    
        <nav class="navbar navbar-light" style="background-color: #ffd89e;">
            <a class="navbar-brand" href="#" style="margin-left: 20px;">
                <img src="img/ibooks.png" width="30" height="30" class="d-inline-block align-top" alt="">
                GuestBook
            </a>
            <form method="post" class="form-inline my-2 my-lg-0" style="margin-right: 15px;">
                <span class="navbar-text badge badge-success" style="margin-right: 10px; font-size: 14px;">
                Hi, '.$_SESSION['username'].'<img src="img/hand.png" width="20">  
                </span>
                <button name="action" class="btn btn-outline-danger" type="submit" value="LogOut">Log out</button>
            </form>
        </nav>
    
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-9">

                '.getPagination($__currentPage, $__numberOfPages).'                    
    
                <div class="container">
    
                    '.getMessages($__currentPage, $__numberOfPages).'
    
                </div>
    
            </div>
    
            <div class="col-md-3 text-center" style="padding: 60px 15px;">
                <form method="post">
                    '.($_SESSION["access_level"] == 3
        ? '<input name="guestname" type="text" class="form-control" placeholder="Username" required="" autofocus="" style="margin-bottom: 15px;">'
        : '').'
                    <textarea name="message" class="form-control" placeholder="Message" rows="3" required="" style="margin-bottom: 15px;"></textarea>
                    <button name="action" class="btn btn-outline-success btn-block" type="submit" value="SendMessage">Send Message</button>
                </form>
            </div>
            </div>
        </div>'
    .getModalForms($__currentPage, $__numberOfPages).'
    </body>
    </html>';
}

/**
 * Возвращает HTML-код модальных форм для изменения сообщений
 *
 * @param integer $__currentPage   Номер страницы.
 * @param integer $__numberOfPages Количество страниц.
 * 
 * @return string HTML-код.
 */
function getModalForms(int $__currentPage, int $__numberOfPages)
{

    # Вытаскиваем массив сообщений на текущей странице
    $idsArr = getMessagesIdsOnPage($__currentPage, $__numberOfPages);
    $html = '';

    # Генерируем HTML-код формы изменения для каждого сообщения
    foreach ($idsArr as $id) {
        $html .= '<div class="modal fade" id="modal'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit message</h5>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" name="message" value="'.getMessageTextById($id).'" 
                                class="form-control" placeholder="Message text">
                            </div>
                            <div class="col-3">
                                <button type="submit" name="editMessageId" value="' . $id . '" class="btn btn-success">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>';
    }

    //
    return $html;
}

/**
 * Получает данные из файла, используя разделяемую блокировку
 *
 * @param string $__fileName Имя входного файла.
 * 
 * @return string|boolean Данные в файле, false - в случае неудачного открытия
 */
function getFileContent(string $__fileName)
{

    # "Трогаем" файл и открываем для чтения
    touch($__fileName);
    $fp = fopen($__fileName, "r");

    # Ставим разделяемую блокировку
    if (flock($fp, LOCK_SH)) {

        #Забираем данные из файла
        $data = fgets($fp);

        #Закрываем поток и снимаем блокировку
        flock($fp, LOCK_UN);
        return $data;
    }

    #В случае неудачи - false
    return false;
}

/**
 * Записывает данные в файл, используя исключительную блокировку
 *
 * @param string $__fileName Имя файла для записи.
 * @param string $__data     Данные для записи в файл.
 * 
 * @return boolean true - успешно, иначе - false.
 */
function putContentInFile(string $__fileName, string $__data)
{

    # "Трогаем" файл и открываем для записи
    touch($__fileName);
    $fp = fopen($__fileName, "w+");

    # Ставим исключительную блокировку
    if (flock($fp, LOCK_EX)) {

        #Записываем данные в файл,закрываем поток и снимаем блокировку
        fputs($fp, $__data);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    }

    #В случае неудачи - false
    return false;
}

/**
 * Возвращает массив ID сообщений, которые находятся на странице $__page
 *
 * @param integer $__page          Номер страницы.
 * @param integer $__numberOfPages Количество страниц.
 * 
 * @return array Массив из ID сообщений.
 */
function getMessagesIdsOnPage(int $__page, int $__numberOfPages)
{
    
    # Вычисляем ID первого сообщения
    $start = ($__page - 1) * MESSAGES_ON_PAGE;

    # Если страница последняя - возвращаем до крайнего сообщения
    if ($__page == $__numberOfPages) {
        return range($start, getMessagesCount() - 1);
    }

    # Иначе возвращаем MESSAGE_ON_PAGE - 1 последующих сообщений
    return range($start, $start + MESSAGES_ON_PAGE - 1);
}

/**
 * Возвращает текст сообщения номером $__id
 *
 * @param integer $__id ID сообщения.
 * 
 * @return string Текст сообщения.
 */
function getMessageTextById(int $__id)
{

    # Забираем массив сообщений и возвращаем текст нужного
    $messagesArr = getMessagesArr();
    return $messagesArr[$__id]['message_text'];
}
