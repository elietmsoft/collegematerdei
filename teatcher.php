<?php
include("./Util/connexion.php");
if(isset($_POST['connecter'])){
    if(isset($_POST['login']) && !empty($_POST['login'])){
        $login=htmlspecialchars($_POST['login']);
        if(isset($_POST['password']) && !empty($_POST['password'])){
            $password=htmlspecialchars($_POST['password']);
            $verifier=$bd->prepare("SELECT * FROM t_enseignant WHERE login=?");
            $verifier->execute(array($login));
            if($verifier->rowcount()==!0){
                $infos=$verifier->fetch();
                $password=$infos['pwd'];
                $login=$infos['login'];
                if($password===$_POST['password'] && $login===$_POST['login']){
                    $_SESSION['enseignant_id']=$infos['enseignant_id'];
                    $_SESSION['nom']=$infos['nom'];
                    $_SESSION['postnom']=$infos['postnom'];
                    $_SESSION['prenom']=$infos['prenom'];
                    $_SESSION['login']=$infos['login'];
                    $_SESSION['pwd']=$infos['pwd'];
                    header("Location:teatcherdetail.php");
                }
                else
                {
                    $error="Votre password n'est pas correct !";
                    $col_PassWord="border-color : red;";
                }
            }
            else
            {
                $error="Votre login est incorrect!";
                $col_login="border-color : red;";
            }
        }
        else
        {
            $error="Veuillez saisir votre password !";
            $col_PassWord="border-color : red;";
        }
    }
    else{
        $error="Veuillez saisir votre login !";
        $col_login="border-color : red;";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">

    <title>Collège Mater Dei</title>
    <!-- Loading third party fonts -->
    <link href="http://fonts.googleapis.com/css?family=Arvo:400,700|" rel="stylesheet" type="text/css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--style pour les inputs et form -->
    <link href="special.css" rel="stylesheet">

    <!-- Loading main css file -->
    <link rel="stylesheet" href="style.css">

    <!--[if lt IE 9]>
    <script src="js/ie-support/html5.js"></script>
    <script src="js/ie-support/respond.js"></script>
    <![endif]-->

</head>


<body>

<div id="site-content">
    <header class="site-header">
        <div class="primary-header">
            <div class="container">
                <a href="index.php" id="branding">
                    <img src="images/mater_dei_logo.png" alt="College Mater Dei">
                    <!--<h1 class="site-title">College Mater Dei</h1>-->
                </a> <!-- #branding -->

                <div class="main-navigation">
                    <button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
                    <ul class="menu">
                        <li class="menu-item" ><a href="index.php">Accueil</a></li>
                        <li class="menu-item"><a href="qui_sommes_nous.php">Qui sommes-nous</a></li>
                        <li class="menu-item"><a href="formations.php">Adminssion</a></li>
                        <li class="menu-item"><a href="contact.php">Contact</a></li>
                        <li class="menu-item current-menu-item"><a href="teatcher.php">Professeur</a></li>
                    </ul> <!-- .menu -->
                </div> <!-- .main-navigation -->

                <div class="mobile-navigation"></div>
            </div> <!-- .container -->
        </div> <!-- .primary-header -->
    </header>
    <main class="main-content">

        <div class="home-slider">
            <div class="container">
                <div class="slider col-md-12">

                </div> <!-- .slider -->
            </div> <!-- .container -->
        </div> <!-- .home-slider -->
        <div class="container">
            <div class="entry-content">
                <div class="col-md-3 thumbnail">

                </div>
                <div class="col-md-6 thumbnail">
                    <h3 class="widget-title" id="authentification">Professeur/Authentification</h3>
                    <!--Pour gerer l'affichage de l'erreur en rouge au dessus du formulaire -->
                    <?php if(isset($error)){echo '<div style="color:red;">'.$error.'</div>';} ?>

                    <form action="teatcher.php" method="post" class="subscribe">
                        <input type="text" id="login" name="login" placeholder="Votre login..." value="" style="<?php if(isset($col_login)){echo $col_login;}else{echo "border-color:#eaeaeaea;";} ?>" title="<?php if(isset($error)){echo $error;}else{echo 'saisir ton login';}?>">
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe..." value="" style="<?php if(isset($col_PassWord)){echo $col_PassWord;}else{echo "border-color:#eaeaeaea;";} ?>" title="<?php if(isset($error)){echo $error;}else{echo 'saisir ton password';}?>">
                        <div class="control">
                            <input type="submit" id="connecter" name="connecter" class="light" value="Se Connecter">
                        </div>
                    </form>
                </div>
                <div class="col-md-3 thumbnail">

                </div>

                <div class="col-md-3 thumbnail">

                </div>

                <div class="col-md-3 thumbnail">

                </div>

                <div class="col-md-3 thumbnail">

                </div>

                <div class="col-md-3 thumbnail">

                </div>
            </div>
        </div>

    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="widget">
                        <h3 class="widget-title">Contacter nous</h3>
                        <address>College Mater Dei <br>Chepa mai c sur la route de matadi<br>Kinshasa,Mt Ngafula</address>

                        <a href="mailto:cmd@gmail.com">cmd@gmail.com</a> <br>
                        <a href="t">+24388747646</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <h3 class="widget-title">Reseaux Sociaux</h3>
                        <p>Rejoignez le College Mater Dei</p>
                        <div class="social-links circle">
                            <a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="widget"><!--field for subscribing-->
                        <h3 class="widget-title">Reservez Votre Inscription</h3>
                        <p>Pour ne pas créer du désordre,vous pouvez reserver votre place en ligne.</p>
                        <form action="#" class="subscribe">
                            <input type="text" placeholder="Votre nom...">
                            <input type="email" placeholder="Address Email...">
                            <div class="control">
                                <input type="submit" class="light" value="Reservez">
                            </div>
                        </form>
                    </div>

                </div>

            </div>

            <div class="copy">Copyright 2017 College Mater Dei</div>
        </div>

    </footer>
    </div>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/app.js"></script>

</body>

</html>
