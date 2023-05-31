<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Verificar credenciales de usuario
    if ($username == 'muymucho' && $password == 'muymucho') {
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
    } else {
            $_SESSION['loggedin'] = false;
            $error = "Usuario o contraseña incorrectos";
            header("Location: login.php?error=".$error);
        }
    } else {
        // Mostrar formulario de inicio de sesión
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
        }
        include 'login_form.php';
    }
?>
