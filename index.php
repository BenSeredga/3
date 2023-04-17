<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();

  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);


  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }

  if ($errors['year']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('year_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">укажите год.</div>';
  }

  if ($errors['email']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните email конкретно.</div>';
  }

  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните пол.</div>';
  }

  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">укажите конечности.</div>';
  }

  if ($errors['abilities']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('abilities_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните сверхспособности.</div>';
  }

  if ($errors['checkbox']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('checkbox_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Check the box.</div>';
  }

  if ($errors['biography']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('biography_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Биография пустая/слишком длинная.</div>';
  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];


  include('form.php');
  exit();
}


// Проверяем ошибки.
$errors = FALSE;

if (empty($_POST['name'])){ //|| !preg_match('/^([a-zA-Z\'\-]+\s*|[а-яА-ЯёЁ\'\-]+\s*)$/u', $_POST['name'])){

//!preg_match('/^[A-zА-я- ]{2,}( [A-zА-я]{2,})*$/', $_POST['name'])) {
  //print('Укажите имя.<br/>');

  $errors = TRUE;
  // Удаляем куку, указывая время устаревания в прошлом.
  setcookie('name_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || (int)$_POST['year']<=1923 || (int)$_POST['year']>=2024) {
  //print('Укажите год.<br/>');
  $errors = TRUE;
  setcookie('year_error', '1', time() + 24 * 60 * 60);
  
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['email']) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email'])){

//!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $_POST['email'])) {
  //print('Укажите email correct.<br/>');

  $errors = TRUE;
  setcookie('email_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
}

if($_POST['gender'] !== 'male' && $_POST['gender'] !== 'female'){
  //print('Неверный пол<br/>');
  $errors = TRUE;
  setcookie('gender_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
}

if($_POST['limbs'] !== '1' && $_POST['limbs'] !== '2' && $_POST['limbs'] !== '3' && $_POST['limbs'] !== '4'){  
  //print('Укажите количество конечностей<br/>');
  $errors = TRUE;
  setcookie('limbs_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['abilities']) || !is_array($_POST['abilities'])) {  
    //print('Укажите способности<br/>');
    $errors = TRUE;
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('abilities_value', $_POST['abilities'], time() + 30 * 24 * 60 * 60);
}

if (empty($_POST['biography']) || strlen($_POST['biography']) >128){
  $errors = TRUE;
  setcookie('biography_error', '1', time() + 24 * 60 * 60);
}
else{
  setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
}


//if (empty($_POST['checkbox'])){ //|| !($_POST['checkbox'] == 'on' || !$_POST['checkbox'] == 1 || )) {
if($_POST['checkbox']==''){
    //print('Чекбокс<br/>');
    $errors = TRUE;
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
}
else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
}

if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
}
else {
    // Удаляем Cookies с признаками ошибок.
  setcookie('name_error', '', 100000);
  setcookie('year_error', '', 100000);
  setcookie('email_error', '', 100000);
  setcookie('gender_error', '', 100000);
  setcookie('limbs_error', '', 100000);
  setcookie('abilities_error', '', 100000);
  setcookie('checkbox_error', '', 100000);
    
}




//if ($errors) {exit();}

// Сохранение в базу данных.

$user = 'u52807';
$pass = '8865176';
$db = new PDO('mysql:host=localhost;dbname=u52807', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.
try {
  //var_dump($_POST['abilities']);
  $stmt = $db->prepare("INSERT INTO application SET name = ?, year = ?, email = ?,  gender = ?, checkbox = ?, biography = ?, limbs = ?");
  $stmt->execute([$_POST['name'], $_POST['year'], $_POST['email'], $_POST['gender'], 1, $_POST['biography'], $_POST['limbs']]);
  if(!$stmt){print('Error: ' . $stmt->errorInfo());}
} 
catch (PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

$person_id = $db->lastInsertId();

foreach ($_POST['abilities'] as $sup_id) {
  try {
    $stmt = $db->prepare("INSERT INTO connects SET person_id = ?, sup_id = ?");
    $stmt->execute([$person_id, $sup_id]);
    if (!$stmt) {print('Error : ' . $stmt->errorInfo());}
  } 
  catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
  }
}
setcookie('save', '1');
header('Location: index.php');
?>



