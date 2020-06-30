<?php
include("connexion.php");
if($_SESSION)
{

$Branches=$bd->prepare("SELECT distinct intitule bI FROM t_branche WHERE branche_id=?");
$Branches->execute(array($_SESSION['branche_id']));
$lstB1=$Branches->fetch();
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
$Notes=$bd->prepare("SELECT n.pointObtenu nPO,e.nom eN,e.postnom ePo,e.prenom ePr FROM t_note n,t_eleve e
	                   where n.periode_id=? and n.branche_id=? and e.eleve_id=n.eleve_id and e.classe_id=?");
$Notes->execute(array($_SESSION['periode_id'],$_SESSION['branche_id'],$_SESSION['classe_id']));
//----------------------------------------------------------------------------------------------------------------------------
$Messages=$bd->prepare("SELECT message mE,date_envoi dE,expediteur exE FROM t_envoyer
	                   where periode_id=? and branche_id=? and classe_id=? and enseignant_id=?");
$Messages->execute(array($_SESSION['periode_id'],$_SESSION['branche_id'],$_SESSION['classe_id'],$_SESSION['enseignant_id']));
//----------------------------------------------------------------------------------------------------------------------------
//button envoi
if(isset($_POST['envoi'])){
	if(isset($_POST['message']) && !empty($_POST['message'])){

       $message=htmlspecialchars($_POST['message']);
       $exp="vous";
       $dest="direction";
       $Envois=$bd->prepare("INSERT INTO t_envoyer(message,date_envoi,expediteur,destinateur,enseignant_id,periode_id,classe_id,branche_id) VALUES(?,?,?,?,?,?,?,?)");
       $Envois->execute(array($message,date('d-m-Y  H:i:s'),$exp,$dest,$_SESSION['enseignant_id'],$_SESSION['periode_id'],$_SESSION['classe_id'],$_SESSION['branche_id']));
       header('Location:views.php');
	}
	else{
		$errorP="veuillez saisir un message !";
	}
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
   	<section id="intro" style="background-color:#449ad5;height:50px;">
      <!-- <div class="shadow-overlay"></div> -->
	    <div class="row intro-content">
		  <div class="col-twelve">
		   	<h1 class="animate-intro" style="color:#cecece;margin-top:-90px;">INFORMATIONS.</h1>
			   <h3 class="animate-intro"></h3>	
		  </div>
		   <!-- /twelve --> 		   			
		</div> <!-- /row -->   
	</section> <!-- /intro -->
		<!-- features
   	================================================== -->
		<section id="features" style="height: 50px">
			<div class="row section-intro group animate-this">	
	   		<div class="col-twelve with-bottom-line" id="contenu">
	   			<h2 style="margin-top:-110px;"><?php echo $lstC1['cI']. "è  ".$lstC1['oI']."  /  ".$lstP['pI']; ?></h2>
				   <h3><?php echo $lstB1['bI']; ?></h3>
	   		</div> 		
	   	</div>
			
		</section> <!-- /features -->

   	<section id="stats" class="count-up" style="margin-top:-100px;">
			<div class="row">
				<div class="col-six">
		        	<?php if(isset($errorP)){echo '<div style="color:red;">'.$errorP.'</div>';} ?>
					<form class="customform" method="POST" action="">
						<textarea type="text" name="message" placeholder="envoyer un message à la direction !"></textarea>
						<button type="submit" name="envoi"  id="envoi">envoyer !</button>
					</form>
				    <table>
				  		<thead style="color: blue;">
				  			<tr>
				  				<th style="color:#449ad5"></th>
				  				<th style="color:#f9da4f">Messages</th>
				  				<th style="color:#f9da4f">Dates</th>
				  			</tr>
				  		</thead>
				  		<tbody>
				  			<?php while ($msg=$Messages->fetch()) {?>
		                    <tr style="color:<?php if($msg['exE']==="direction"){echo "#8631c7;";}else{echo "#fff;";} ?>">
			                    <td><?php echo $msg['exE']; ?></td>
								<td style="height:20px"><?php echo $msg['mE']; ?></td>
								<td style="height:20px"><?php echo $msg['dE'];  ?></td>
		                    </tr>
		                   <?php } ?>
				  		</tbody>
				  	  </table>
				</div> <!-- /six -->


				<div class="col-six">
				    <table class="table table-bordered table-striped table-condensed">
				  		<thead style="color: blue;">
				  			<tr>
				  				<th style="color:#449ad5">NOMS</th>
				  				<th style="color:#f9da4f">POINT/<?php echo $lstM['mI']; ?></th>
				  			</tr>
				  		</thead>
				  		<tbody>
						  <?php while($eleve=$Notes->fetch()){?>
		                    <tr>
			                    <td style="color:#fff;"><?php echo $eleve['eN'].' '.$eleve['ePo'].' '.$eleve['ePr'];?></td>
								<td style="height:20px;width: 15px;color: <?php if($eleve['nPO']<($lstM['mI']/2)){ echo "red;";}else{echo "#f9da4f;";} ?>"> <?php echo $eleve['nPO']; ?></td>
		                    </tr>
					     <?php }?>	
				  		</tbody>
				  	  </table>
				</div> <!-- /six -->
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
			  
			  let para=document.querySelector('#branche');
			  para.textContent="Cours :"+document.f1.cours.options[i].value;
			  document.querySelector("#brancheId").value=i+1;
		  }
	  }
	}
	  </script>
      <script>
      function ChangeCours()
       {
         var paragraphe = document.getElementById("lstcours");
		 document.getElementById("branche").value=paragraphe.value;

        }
     </script>

</body>
</html>
<?php }else{
	header('Location:/COLLEGEMATERDEI/teatcherdetail.com.php');
}
?>