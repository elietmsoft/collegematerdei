<?php
include("connexion.php");
if($_SESSION)
{

$Branches=$bd->prepare("SELECT distinct intitule bI FROM t_branche WHERE branche_id=?");
$Branches->execute(array($_SESSION['branche_id']));
$lstB1=$Branches->fetch();
//$nbreCours=$cours->rowcount();
$eleve_db=$bd->prepare("SELECT * FROM t_eleve e WHERE e.classe_id=?");
$eleve_db->execute(array($_SESSION['classe_id']));
//-----------------------------------------------------------------------
$Classes=$bd->prepare("SELECT distinct c.intitule cI,o.intitule oI,s.intitule sI 
                     FROM t_classe c,t_option o,t_section s 
                     WHERE c.classe_id=? and c.option_id=o.option_id and o.section_id=s.section_id");
$Classes->execute(array($_SESSION['classe_id']));
$lstC1=$Classes->fetch();
//-------------------------------------------------------------------------
$Periodes=$bd->prepare("SELECT intitule pI FROM t_periode_total where Sigle<>'Tot1' and Sigle<>'Tot2' and Sigle<>'T.G' and periode_id=?");
$Periodes->execute(array($_SESSION['periode_id']));
$lstP=$Periodes->fetch();
//---------------------------------------------------------------------------------------------------------------------------
//requete pour le maxima du cours selectionné ainsi que la période
$Maximas=$bd->prepare("SELECT m.intitule mI FROM t_maxima m,t_concerner c 
	                   where m.maxima_id=c.maxima_id and c.periode_id=? and c.branche_id=?");
$Maximas->execute(array($_SESSION['periode_id'],$_SESSION['branche_id']));
$lstM=$Maximas->fetch();

//----------------------------------------------------------------------------------------------------------------------------
//button envoi
if(isset($_POST['btnEnvoi'])){
	//debut while
	while($eleve=$eleve_db->fetch()){
	if(isset($_POST['point_'.$eleve['eleve_id'].'']) && !empty($_POST['point_'.$eleve['eleve_id'].''])){
		if(((int)$_POST['point_'.$eleve['eleve_id'].''] < (int)$lstM['mI']) || ((int)$_POST['point_'.$eleve['eleve_id'].'']>0)){
            if(isset($_POST['eleve'.$eleve['eleve_id'].'']) && !empty($_POST['eleve'.$eleve['eleve_id'].''])){
                $point=htmlspecialchars($_POST['point_'.$eleve['eleve_id'].'']);
                $eleve_id=htmlspecialchars($_POST['eleve'.$eleve['eleve_id'].'']);
                //----------------------------------------------------------------------------------------------------------------
                $ExistPupils=$bd->prepare("SELECT * FROM t_note 
	                                       where branche_id=? and periode_id=? and eleve_id=?");
                $ExistPupils->execute(array($_SESSION['branche_id'],$_SESSION['periode_id'],$eleve_id));
                $nbre=$ExistPupils->rowcount();
                //----------------------------------------------------------------------------------------------------------------
                if($nbre===0){

                   $Notes=$bd->prepare("INSERT INTO t_note(pointObtenu,branche_id,periode_id,eleve_id) VALUES(?,?,?,?)");
                   $Notes->execute(array($point,$_SESSION['branche_id'],$_SESSION['periode_id'],$eleve_id));
                   $succes="envoi effectué avec succès !";
                   header('Location:views.php');
                }
                //................................................................................................................
                else{

                   $Notes=$bd->prepare("UPDATE t_note SET pointObtenu=? WHERE branche_id=? and periode_id=? and eleve_id=?");
                   $Notes->execute(array($point,$_SESSION['branche_id'],$_SESSION['periode_id'],$eleve_id));
                   $succes="envoi effectué avec succès !";
                   header('Location:/COLLEGEMATERDEI/teatcherdetail.php');
                }
                //................................................................................................................

            }else{
            	$errorP="verifier l'existence de l'élève";
            }
		}
		else{
			$errorP="le point ne peut pas être > ".$lstM['mI']. " ni < 0";
		}
	}
	else{
    	$errorP="cette case ne doit pas etre vide  ";
    }
}//fin while
    
}
//----------------------------------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html class="no-js oldie ie8" lang="fr">
<html class="no-js oldie ie9" lang="fr">
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="fr"> <!--<![endif]-->
<head>

   <!--- basic page needs
   ================================================== -->
   <meta charset="UTF-8">
	<title>Mater Dei</title>
	<meta name="description" content="">  
	<meta name="author" content="Elie-TMS">

   <!-- mobile specific metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

 	<!-- CSS
   ================================================== -->
   <link rel="stylesheet" href="css/base.css"> 
   <link rel="stylesheet" href="css/vendor.css"> 
   <link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" type="text/css" href="css-ctrl/ctrl.css"> 

   <!-- script
   ================================================== -->
	<script src="js/modernizr.js"></script>
	<script src="js/pace.min.js"></script>

   <!-- favicons
	================================================== -->
	<link rel="icon" type="image/png" href="favicon.png">

</head>

<body id="top">
<meta charset="UTF-8">	
	<!-- header 
   ================================================== -->
   <header class="main-header">
   	
   	<div class="logo">
	      <a href="">Mater Dei</a>
	   </div> 
	   <a class="menu-toggle" href="#"><span>Menu</span></a>   	
   </header>

   <!-- main navigation 
   ================================================== -->
   <nav id="menu-nav-wrap">
	  <div class="action">
		 <a class="button" href="/COLLEGEMATERDEI/teatcherdetail.php">RETOUR</a>
	  </div>
	</nav> <!-- /menu-nav-wrap -->

	<!-- main content wrap
   ================================================== -->
   <div id="main-content-wrap">


		<!-- main content wrap
   	================================================== -->
   	<section id="intro" style="background-color:#449ad5;height:150px;">
      <!-- <div class="shadow-overlay"></div> -->
	    <div class="row intro-content">
		  <div class="col-twelve">
		   	<h1 class="animate-intro" style="color:#cecece;margin-top:-60px;">FICHE DE COTATION.</h1>
			   <h3 class="animate-intro"></h3>	
		  </div>
		   <!-- /twelve --> 		   			
		</div> <!-- /row -->   
	</section> <!-- /intro -->
		<!-- features
   	================================================== -->
		<section id="features">
			<div class="row section-intro group animate-this">	
	   		<div class="col-twelve with-bottom-line" id="contenu">
	   			<h2 style="margin-top:-110px;"><?php echo $lstC1['cI']. "è  ".$lstC1['oI']."  /  ".$lstP['pI']; ?></h2>
				   <h3><?php echo $lstB1['bI']; ?></h3>
	   		</div> 		
	   	</div>
			
		</section> <!-- /features -->

   	<section id="stats" class="count-up" style="margin-top:-100px;">

			<div class="row">
				<div class="col-twelve">
				<?php if(isset($errorP)){echo '<div style="color:red;">'.$errorP.'</div>';} ?>
				<form class="customform" method="POST" action="">
				    <table class="table table-bordered table-striped table-condensed">
				  		<thead style="color: blue;">
				  			<tr>
				  				<th style="color:#449ad5">NOMS</th>
				  				<th style="color:#f9da4f">POINT/<?php echo $lstM['mI']; ?></th>
				  			</tr>
				  		</thead>
				  		<tbody>
						  <?php while($eleve=$eleve_db->fetch()){?>
		                    <tr>
			                    <td style="color:#fff;"><?php echo $eleve['nom'].' '.$eleve['postnom'].' '.$eleve['prenom'];?></td>
								<td style="height:20px">
									<input type="text" value="" name="point_<?php echo $eleve['eleve_id'];?>" style="height:15px;width:80px;color:#449ad5;border:solid 1px #449ad5;"/>
									<input type="hidden" value="<?php echo $eleve['eleve_id'];?>" name="eleve<?php echo $eleve['eleve_id'];?>"/>
							    </td>
		                    </tr>
					     <?php }?>	
				  		</tbody>
				  	  </table>
				  	  <button type="submit" name="btnEnvoi" id="envoi">Envoyer</button>
                </form>
				</div> <!-- /twelve -->
			</div> <!-- /row -->

			<div class="row">
				<div class="col-twelve">

				</div> <!-- /twelve -->
			</div> <!-- /row -->
	</section> <!-- /stats -->

   </div> <!-- /main-content-wrap -->


   <!-- footer
	================================================== -->
	<footer id="main-footer" style="background-color:#449ad5">

	   	<div class="copyright" style="color:#fff">
		     	<span>© Copyright 2019, LearnPro Dev.</span> 
		     	<span>Design and Coding by Elie-TM'S<a href=""></a></span>    	
		</div> 
	   	
   </footer> 
   <div id="go-top">
		<a class="smoothscroll" title="Back to Top" href="#top"><i class="fa fa-long-arrow-up"></i></a>
	</div>

   <!-- preloader
   ================================================== -->
   <div id="preloader"> 
    	<div id="loader"></div>
   </div> 

   <!-- Java Script
   ================================================== --> 
   <script src="js/jquery-2.1.3.min.js"></script>
   <script src="js/plugins.js"></script>
   <script src="js/main.js"></script>

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
	  </script>
	  <script type="text/javascript">
	  function voir(){
	  for(i=0;document.f1.cours.length;i++){
		  if(document.f1.cours.options[i].selected==true){
			  //let para = document.createElement('p');
			  let para=document.querySelector('#branche');
			  para.textContent="Cours :"+document.f1.cours.options[i].value;
			  document.querySelector("#brancheId").value=i+1;
		  }
	  }
	}
	     /*var button=document.querySelector('#lstcours');
          button.addEventListener('click',(event)=>{
          const nom = prompt('Donner votre nom');

    //let para = document.createElement('p');
    //para.style.color = 'blue';
    //para.textContent = `votre nom est ${nom}`;
    //document.querySelector('div').appendChild(para);
       });*/
	  </script>
      <script>
      function ChangeCours()
       {
         var paragraphe = document.getElementById("lstcours");
         //var txt=paragraphe.innerHTML=document.getElementById("probleme").value +"<br/>";
		 //document.getElementById("txt1").value=paragraphe.innerHTML=document.getElementById("probleme").value;
		 document.getElementById("branche").value=paragraphe.value;

        }
     </script>

</body>
</html>
<?php }else{
	header('Location:Projet.php');
}
?>