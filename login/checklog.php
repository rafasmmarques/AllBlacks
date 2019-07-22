<?php

if(session_id()=="")
{
    session_start();
}

    if(!(array_key_exists('usuario',$_SESSION)))
    {
        echo "<script language='javascript' type='text/javascript'>alert('Acesso não permitido. Realize o login.');window.location.href='../views/login.php';</script>";
    }
