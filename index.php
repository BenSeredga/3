<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include('form.php');
  if (!empty($_GET['save'])) {
    print('результаты сохранены');
  }
  exit();
}

// Проверяем ошибки.
$errors = FALSE;

if (empty($_POST['name'])) {
  print('Укажите имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Укажите год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Укажите email.<br/>');
  $errors = TRUE;
}

if($_POST['gender'] !== 'male' && $_POST['gender'] !== 'female'){
  print('Неверный пол<br/>');
  $errors = TRUE;
}

if($_POST['limbs'] !== '1' && $_POST['limbs'] !== '2' && $_POST['limbs'] !== '3' && $_POST['limbs'] !== '4'){  
  print('Укажите количество конечностей<br/>');
  $errors = TRUE;
}

if (empty($_POST['abilities'])) {  
    print('Укажите способности<br/>');
    $errors = TRUE;
}

if (empty($_POST['checkbox']) || !($_POST['checkbox'] == 'on' || !$_POST['checkbox'] == 1)) {
    print('Чекбокс<br/>');
    $errors = TRUE;
}

if ($errors) {exit();}

// Сохранение в базу данных.

$user = 'u52807';
$pass = '8865176';
$db = new PDO('mysql:host=localhost;dbname=u52807', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.
try {
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

header('Location: ?save=1');
?>



