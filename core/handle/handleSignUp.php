<?php
include '../core/init.php';
require_once '../core/classes/validation/Validator.php';
use validation\Validator;

if (isset($_POST['signup'])) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    if(!empty($email) || !empty($password) || !empty($name) || !empty($username))   {
    $email = User::checkInput($email);
    $password = User::checkInput($password);
    $name = User::checkInput($name);
    $username = User::checkInput($username);


   }



    $v = new Validator;
    $v->rules('name' , $name , ['required' , 'string' , 'max:20']);
    $v->rules('username' , $username , ['required' , 'string' , 'max:20']);
    $v->rules('email' , $email , ['required' , 'email']);
    $v->rules('password' , $password , ['required' , 'string' , 'min:5']);
    $errors = $v->errors;

    if ($errors == []){
        $username = str_replace(' ', '', $username);

        if(User::checkEmail($email) === true) {
            $_SESSION['errors_signup'] = ['Cet e-mail est déjà utilisé'];
            header('location: ../index.php')  ;
        } else if (User::checkUserName($username) === true) {
            $_SESSION['errors_signup'] = ["Ce nom d'utilisateur est déjà utilisé"];
            header('location: ../index.php')  ;
        } else if (!preg_match("/^[a-zA-Z0-9_]*$/" , $username)) {
            $_SESSION['errors_signup'] = ["Seuls les caractères et les chiffres sont autorisés dans le nom d'utilisateur"];
            header('location: ../index.php')  ;
        } else {
                User::register($email , $password ,$name , $username);

        }
    } else {

        $_SESSION['errors_signup'] = $errors;
    header('location: ../index.php'); }

} else header('location: ../index.php')  ;








?>
