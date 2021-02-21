<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TODO LIST</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ad775fe11f.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                    if (!isset($_SESSION)) session_start();
                    if (isset($_SESSION['auth'])) {
                        $link = "/list/index";
                    } else {
                        $link = "";
                    }
                ?>
                <a class="navbar-brand" href=<?=$link?>>TODO LIST</a>
                <?php
                    if (isset($_SESSION['auth'])) { 
                ?>
                    <ul class="navbar-nav mr-auto text-right"></ul>
                    <a href="/user/logOut" id="logOut"> Log Out </a>
                <?php
                }
                ?>
            </div>
        </nav>
    <?php
        if (isset($_SESSION['error'])){
    ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <p></p>
            <?=$_SESSION['error']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])){
    ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?=$_SESSION['success']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
            unset($_SESSION['success']);
        }
    ?>