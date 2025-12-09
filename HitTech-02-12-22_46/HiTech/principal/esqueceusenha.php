<?php
 include("config.php");
 if (isset($_POST[ok])){
    
    $email = $mysqli->escape_string($_POST['email']);

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erro[] = "E-mail invalido";

    }

    $novasenha = substr(md5(time()), 0, 6);
    $nscriptografada = md5(md5($novasenha));

    if(mail($email, "Sua nova senha", "Sua nova senha: ".$novasenha));{

        $sql_code = "UPDATE usuarios SET senha = '$nscriptografada'
        WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die ($mysqli->error);
    }
 
 }

?>



<form action="">
     <input placeholder="e-mail" name="email" type="text">
     <input placeholder="ok" value="ok" type="tesubmit">
</form>
