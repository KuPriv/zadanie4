<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['r1'] = !empty($_COOKIE['r1_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['r2'] = !empty($_COOKIE['r2_error']);
  $errors['cb'] = !empty($_COOKIE['cb_error']);
  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  if ($errors['fio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('fio_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }

  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните почту.</div>';
  }

  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите год рождения.</div>';
  }
  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  if ($errors['r1']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('r1_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['abilities']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('abilities_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите сверхспособности.</div>';
  }
  if ($errors['r2']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('r2_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Выберите количество конечностей.</div>';
  }
  if ($errors['cb']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('cb_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Ознакомьтесь с контрактом.</div>';
  }
  // TODO: тут выдать сообщения об ошибках в других полях.

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['r1'] = empty($_COOKIE['r1_value']) ? '' : $_COOKIE['r1_value'];
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $values['r2'] = empty($_COOKIE['r2_value']) ? '' : $_COOKIE['r2_value'];
  $values['cb'] = empty($_COOKIE['cb_value']) ? '' : $_COOKIE['cb_value'];
  // TODO: аналогично все поля.

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;


  if (empty($_POST['fio'])) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }


  if (empty($_POST['email'])) {
    setcookie('email_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  

  if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '3', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }
  

  if(empty($_POST['biography'])) {
    setcookie('biography_error', '4', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }

  
  if(!isset($_POST['r1'])){
    setcookie('r1_error', '4', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('r1_value', $_POST['r1'][0], time() + 30 * 24 * 60 * 60);
  }

  if(!isset($_POST['abilities'])){
    setcookie('abilities_error', '5', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('abilities_value', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
  }
  
  if(!isset($_POST['r2'])){
    setcookie('r2_error', '6', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('r2_value', $_POST['r2'], time() + 30 * 24 * 60 * 60);
  }

  if(!isset($_POST['cb'])){
    setcookie('cb_error', '7', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('cb_value', $_POST['cb'], time() + 30 * 24 * 60 * 60);
  }

// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('r1_error', '', 100000);
    setcookie('abilities_error', '', 100000);
    setcookie('r2_error', '', 100000);
    setcookie('cb_error', '', 100000);
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Сохранение в БД.
    $user = 'u45960'; // Заменить на ваш логин uXXXXX
    $pass = '445623'; // Заменить на пароль, такой же, как от SSH
    $db = new PDO('mysql:host=localhost;dbname=u45960', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

    // Подготовленный запрос. Не именованные метки.

    try {
    $stmt = $db->prepare("INSERT INTO application (name, email, year, gender, limbs, biography) VALUES (:name, :email, :year, :gender, :limbs, :biography)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':limbs', $limbs);
    $stmt->bindParam(':biography', $biography);

    $name = $_POST['fio'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $gender = $_POST['r1'][0];
    $limbs = $_POST['r2'][0];
    $biography = $_POST['biography'];

    $stmt->execute();
    $dbh = new PDO('mysql:host=localhost;dbname=u45960', $user, $pass);
    $last_id = $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO abilities (id, ability) VALUES (:id, :ability)");
    
    foreach($_POST['abilities'] as $abil) {
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ability', $ability);
        $id = $last_id;
        $ability = $abil;
        
        $stmt->execute();
    }

    }
    catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
    }
  // ...

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}
