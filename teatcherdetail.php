<?php
include("./Util/connexion.php");
if ($_SESSION)
{
//-------------Infos de la table user(ici on utilise les sessions) et compte--------------------------------------!
$Classes = $bd->prepare("SELECT distinct c.classe_id id,c.intitule cI,o.intitule oI,s.intitule sI
                     FROM t_classe c,t_option o,t_section s,t_branche b 
                     WHERE b.enseignant_id=? and  
                      c.classe_id=b.classe_id and 
                      c.option_id=o.option_id and 
                      o.section_id=s.section_id");
$Periodes = $bd->query("SELECT periode_id id,intitule pI FROM t_periode_total where Sigle<>'Tot1' and Sigle<>'Tot2'");
//------------------------------------------------------------------
$Classes->execute(array($_SESSION['enseignant_id']));
//code pour lancer la list de cours correspondant à une classe choisie
//------------------------------------------------------------------------
if (isset($_POST['lienOK'])) {
    if (isset($_POST['lstClasse']) && !empty($_POST['lstClasse'])) {
        $item = htmlspecialchars($_POST['lstClasse']);

        $Branches = $bd->prepare("SELECT branche_id id,intitule bI
                     FROM t_branche 
                     WHERE enseignant_id=? and classe_id=?");
        $Branches->execute(array($_SESSION['enseignant_id'], $item));
    }
} else {
    $error = "veuillez selectionner une classe et appuyer sur le bouton OK";
}
// code pour le bouton valider
//--------------------------------------------------------------------------
if (isset($_POST['btnNote'])) {
    if (isset($_POST['lstBranches']) && !empty($_POST['lstBranches'])) {
        $itemC = htmlspecialchars($_POST['lstBranches']);
        if (isset($_POST['lstPeriodes']) && !empty($_POST['lstPeriodes'])) {
            $itemP = htmlspecialchars($_POST['lstPeriodes']);
            if (isset($_POST['lstClasse']) && !empty($_POST['lstClasse'])) {
                //sauvegarde dans les sessions
                $item = htmlspecialchars($_POST['lstClasse']);
                $_SESSION['classe_id'] = $item;
                $_SESSION['branche_id'] = $itemC;
                $_SESSION['periode_id'] = $itemP;
                header('Location:./www.college.mater.dei.com/oldprojet.php');
            } else {
                $error = "veuillez selectionner une classe et appuyer sur le bouton OK";
            }
        } else {
            $error = "veuillez choisir une période";
        }
    } else {
        $error = "veuillez choisir un cours";
    }
}
//--------------------------------------------------------------------------------------------
/*if (isset($_POST['btnVoir'])) {
    if (isset($_POST['lstBranches']) && !empty($_POST['lstBranches'])) {
        $itemC = htmlspecialchars($_POST['lstBranches']);
        if (isset($_POST['lstPeriodes']) && !empty($_POST['lstPeriodes'])) {
            $itemP = htmlspecialchars($_POST['lstPeriodes']);
            if (isset($_POST['lstClasse']) && !empty($_POST['lstClasse'])) {
                //sauvegarde dans les sessions
                $item = htmlspecialchars($_POST['lstClasse']);
                $_SESSION['classe_id'] = $item;
                $_SESSION['branche_id'] = $itemC;
                $_SESSION['periode_id'] = $itemP;
                header('Location:views.php');
            } else {
                $error = "veuillez selectionner une classe et appuyer sur le bouton OK";
            }
        } else {
            $error = "veuillez choisir une période";
        }
    } else {
        $error = "veuillez choisir un cours";
    }
}*/
//-------------------------------------------------------------------------------------------------


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
                <a href="teatcher.php" id="branding">
                    <img src="images/mater_dei_logo.png" alt="College Mater Dei">
                    <!--<h1 class="site-title">College Mater Dei</h1>-->
                </a> <!-- #branding -->

                <div class="main-navigation">
                    <button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
                    <ul class="menu">
                        <li class="menu-item" ><a href="#">Envoi</a></li>
                        <li class="menu-item"><a href="/COLLEGEMATERDEI/www.college.mater.dei.com/views.php">Message</a></li>
                        <li class="menu-item current-menu-item"><a href="teatcher.php">Retour</a></li>
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
                    <h3 class="widget-title" id="authentification">Remplir les infos</h3>
                    <form class="customForm" method="POST" action="" name="f1" id="f1" class="subscribe" >
                        <div class="col-s-12 m-6 l-3 margin-bottom">
                            <span>Classes</span>
                                <select class="" name="lstClasse" id="<?php if(isset($error)){echo 'c1';} ?>" title="<?php if(isset($error)){echo $error;} ?>" onclick="voir()">
                                    <?php while ($lstC=$Classes->fetch()) {?>
                                        <option value="<?php echo $lstC['id']; ?>">
                                            <?php echo $lstC['cI']. "è  ".$lstC['oI']."  /  ".$lstC['sI']; ?>
                                        </option>
                                    <?php  }  ?>
                                </select>
                            <span><input type="submit" name="lienOK" id="lienOK" value="OK" /></span>
                        </div>
                        <div class="col-s-12 m-6 l-3 margin-bottom">
                            <span>Branches</span>
                                <select class="combox" name="lstBranches">
                                    <?php if(isset($_POST['lienOK'])){?>
                                        <?php while ($lstB=$Branches->fetch()) {?>
                                            <option value="<?php echo $lstB['id']; ?>">
                                                <?php echo $lstB['bI']; ?>
                                            </option>
                                        <?php  }  ?><?php } ?>
                                </select>
                        </div>
                        <div class="s-12 m-6 l-3 margin-bottom">
                            <span>Période</span>
                            <select class="combox" name="lstPeriodes">
                                <?php while ($lstP=$Periodes->fetch()) {?>
                                    <option value="<?php echo $lstP['id']; ?>">
                                        <?php echo $lstP['pI']; ?>
                                    </option>
                                <?php  }  ?>
                            </select>
                        </div>
                        <div class="s-12 m-6 l-2 margin-bottom">
                            <input type="submit" name="btnNote" id="id" class="light" value="Valider"/>
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

<script type="text/javascript" src="jQuery/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="jQuery/jquery-3.1.1.js"></script>
<script type="text/javascript" src="js/responsee.js"></script>
<script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var owl = $('#news-carousel');
        owl.owlCarousel({
            nav: true,
            dots: false,
            items: 1,
            loop: true,
            navText: ["&#xf007","&#xf006"],
            autoplay: true,
            autoplayTimeout: 4000
        });
    });
    var owl = $('#news-carousel');
    owl.owlCarousel({
        nav: true,
        dots: false,
        items: 1,
        loop: true,
        navText: ["&#xf007","&#xf006"],
        autoplay: true,
        autoplayTimeout: 4000
    });
    });
</script>
<script type="text/javascript">

    let voire=function voir(){
        for(i=0;document.f1.lstClasse.length;i++){
            if(document.f1.lstClasse.options[i].selected==true){
                //let lien=document.querySelector('#lien');
                //lien.href=lien.baseURI;
            }
        }
    }

    let combo=document.querySelector('#lienOK');
    combo.addEventListener('click',voire);
    //let comboLien=document.querySelector('#lien');
    //comboLien.addEventListener('click',voire);

</script>

</body>
</html>
<?php }else{
    header('Location:teatcherdetail.php');
}

