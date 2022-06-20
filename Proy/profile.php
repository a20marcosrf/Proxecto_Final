<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="view/css/profile_register.css">
</head>
<body>
    <?php

        require_once("controller/usuario_controller.php");
        //echo password_hash(1, PASSWORD_DEFAULT);

    ?>
</body>
<script>
   document.getElementById("sesion").innerHTML+=" "+sessionStorage.getItem('key');
</script>
</html>