<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
    }
    
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['languages'] = !empty($_COOKIE['languages_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['agreement'] = !empty($_COOKIE['agreement_error']);
    
    $messages = array();
    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        $messages['name'] = '<div class="error">Заполните имя. Допустимы только буквы и пробелы.</div>';
    }
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        $messages['phone'] = '<div class="error">Заполните телефон в формате +7/7/8 и 10 цифр.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages['email'] = '<div class="error">Заполните email в правильном формате.</div>';
    }
    if ($errors['birthdate']) {
        setcookie('birthdate_error', '', 100000);
        $messages['birthdate'] = '<div class="error">Заполните дату рождения.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages['gender'] = '<div class="error">Укажите пол.</div>';
    }
    if ($errors['languages']) {
        setcookie('languages_error', '', 100000);
        $messages['languages'] = '<div class="error">Выберите хотя бы один язык программирования.</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages['bio'] = '<div class="error">Заполните биографию. Допустимы буквы, цифры и знаки препинания.</div>';
    }
    if ($errors['agreement']) {
        setcookie('agreement_error', '', 100000);
        $messages['agreement'] = '<div class="error">Необходимо ваше согласие.</div>';
    }
    
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : $_COOKIE['birthdate_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['languages'] = empty($_COOKIE['languages_value']) ? array() : unserialize($_COOKIE['languages_value']);    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['agreement'] = empty($_COOKIE['agreement_value']) ? '' : $_COOKIE['agreement_value'];
    
    include('form.php');
    exit();
}
else {
    $errors = FALSE;
    
    if (empty($_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } elseif (!preg_match('/^[а-яёa-z\s-]+$/iu', $_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('name_value', $_POST['name'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } elseif (!preg_match('/^(\+7|7|8)\d{10}$/', $_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('phone_value', $_POST['phone'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['birthdate'])) {
        setcookie('birthdate_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('birthdate_value', $_POST['birthdate'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['languages'])) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('languages_value', serialize($_POST['languages']), time() + 365 * 24 * 60 * 60);}
    
    if (empty($_POST['bio'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } elseif (!preg_match('/^[а-яёa-z0-9\s.,!?-]+$/iu', $_POST['bio'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['bio'], time() + 365 * 24 * 60 * 60);
    }
    
    if (empty($_POST['agreement'])) {
        setcookie('agreement_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('agreement_value', $_POST['agreement'], time() + 365 * 24 * 60 * 60);
    }
    
    if ($errors) {
        header('Location: index.php');
        exit();
    }
    
    setcookie('name_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birthdate_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('agreement_error', '', 100000);
    
    $user = 'u68891'; 
    $pass = '3849293'; 
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=u68891', $user, $pass,
            [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
        $pdo->beginTransaction();
    
        $stmt = $pdo->prepare("INSERT INTO application (name, phone, email, birthdate, gender, bio) 
                  VALUES (:name, :phone, :email, :birthdate, :gender, :bio)");
        $stmt->execute([
            ':name' => $_POST['name'],
            ':phone' => $_POST['phone'],
            ':email' => $_POST['email'],
            ':birthdate' => $_POST['birthdate'],
            ':gender' => $_POST['gender'],
            ':bio' => $_POST['bio']
        ]);
        
        $applicationId = $pdo->lastInsertId();
    
        $langStmt = $pdo->prepare("
            INSERT INTO programming_language (name)
            VALUES (:name)
            ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)
        ");
        
        $appLangStmt = $pdo->prepare("
            INSERT INTO application_language (application_id, language_id)
            VALUES (:app_id, :lang_id)
        ");
        
        foreach ($_POST['languages'] as $langName) {
            $langStmt->execute([':name' => $langName]);
            $langId = $pdo->lastInsertId();
            $appLangStmt->execute([
                ':app_id' => $applicationId,
                ':lang_id' => $langId
            ]);
        }
        
        $pdo->commit();
        
        setcookie('save', '1');
        header('Location: index.php');
    } catch (PDOException $e) {
        $pdo->rollBack();
        print('Error: ' . $e->getMessage());
        exit();
    }
}
