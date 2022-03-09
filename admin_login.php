<?php 
    require_once('database.php');

    // Get the login form data
    $loginError = filter_input(INPUT_POST, 'login_error');
    $form_user = filter_input(INPUT_POST, 'admin_id');
    $form_pass = filter_input(INPUT_POST, 'admin_password');

    // Check if username exists and if so, checking if it has the correct corresponding password 
    $getUsernameQuery = 'SELECT * FROM admins WHERE adminID = :form_user';
    $getUsernameStatement = $db->prepare($getUsernameQuery);
    $getUsernameStatement->bindValue(':form_user', $form_user);
    $getUsernameStatement->execute();
    $username = $getUsernameStatement->fetchAll(PDO::FETCH_ASSOC);
    $getUsernameStatement->closeCursor();

    if (count($username) == 0) {
        $loginError = true;
        include('admin_login_form.php');
    } else {
        if ($username[0]['adminPass'] == $form_pass) {
            header("Location: admin_home.php", true, 301);
            exit();
        } else {
            $loginSuccess = false;
        include('admin_login_form.php');
        }
    }
?>