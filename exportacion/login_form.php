<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Descarga usuarios</h1>
    <form method="post" action="login.php">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" autocomplete="off" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" autocomplete="off" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <?php if (isset($error)): ?>
    <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <script>
    window.onload = function() {
        document.getElementById("username").value = "";
        document.getElementById("password").value = "";
    };
    </script>
</body>
</html>
