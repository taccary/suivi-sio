<?php
  // 2016-09-04 Compatibilité avec SQLI_ (SQL_ déprécié)
  // 2017-01-31 Format UTF-8 (BOM) du fichier
  
  $c="init"; //répertoire à renommer

  $nomserveur=$_POST["nomserveur"];
  $login=$_POST["login"];
  $mdp=$_POST["mdp"];
  $nombd=$_POST["nombd"];
  $prefixe=$_POST["prefixe"].'_';

  $lngmdp=$_POST["lngmdp"];
  $mdpadmin=substr($_POST["mdpadmin"],0,$lngmdp);

  try {
    if (!$param=@fopen("../param/param.ini.php","w"))
      throw new Exception('Création param.ini.php impossible (droit écriture ?)');
    fputs($param,"<?php\r\n");

    $lg='$nomServeur="'.$nomserveur.'";'."\r\n";
    fputs($param,$lg);
    $lg='$loginAdminServeur="'.$login.'";'."\r\n";
    fputs($param,$lg);
    $lg='$motPasseAdminServeur="'.$mdp.'";'."\r\n";
    fputs($param,$lg);
    $lg='$nomBaseDonnee="'.$nombd.'";'."\r\n";
    fputs($param,$lg);
    $lg='$prefixeTable="'.$prefixe.'";'."\r\n";
    fputs($param,$lg);

    if (isset($_POST["crypte"])){
    	$lg='$crypte=true;'."\r\n";
    	$mdpadminCr = md5($mdpadmin);
    }
    else {
    	$lg='$crypte=false;'."\r\n";
    	$mdpadminCr = $mdpadmin;
    }
    fputs($param,$lg);

    if (isset($_POST["smtp"]))
    	$lg='$smtp=true;'."\r\n";
    else
    	$lg='$smtp=false;'."\r\n";
    fputs($param,$lg);

    $lg='$melContact="'.$_POST["contact"].'";'."\r\n";
    fputs($param,$lg);

    $lg='$lngmdp='.$lngmdp.';'."\r\n";
    fputs($param,$lg);


    fputs($param,'?'.'>');
    fclose($param);



	  if (!$cn=@mysqli_connect($nomserveur,$login,$mdp)) throw new Exception('Connexion impossible : '.mysqli_connect_error());
      echo 'Connexion base de données : OK <br />';
	  if (isset($_POST["creation"])){ //création bd
	    $req='drop database if exists '.$nombd;
	    mysqli_query($cn,$req);
	    $req='create database '.$nombd;
	    if (!mysqli_query($cn,$req)) throw new Exception('Création base impossible');
	  }
	  if (!mysqli_select_db($cn,$nombd)) throw new Exception('Base non trouvée : '.$nombd.' '.mysqli_error($nomdb));
      echo 'Création des informations dans '.$nombd.' en cours : patientez... <br />';
	  include 'tb.php';
	  foreach($requete as $cle => $valeur)
	    if (!mysqli_query($cn,$debut.$prefixe.$cle.'('.$valeur.$fin)) throw new Exception('Erreur création table '.$cle);

	  include 'cle.php';
	  foreach($cle as $reqcle)
	    if (!mysqli_query($cn,$reqcle)) throw new Exception('Erreur sur FK / index '.$reqcle);

	  include 'data.php';
	  // tentative de création des valeurs au format UTF8 dans la table
	  foreach($requete as $cle=>$valeur)
	    foreach($valeur as $ligne)
		/* A priori le fichier data.php est au format UTF-8 et la base aussi... pas de conversion. (2017-01-31)
	      if (!mysqli_query($cn,'insert into '.$prefixe.$cle.' values('.utf8_encode($ligne).');'))
	      	throw new Exception('Erreur écriture table '.$cle);
		*/
	      if (!mysqli_query($cn,'insert into '.$prefixe.$cle.' values('.$ligne.');'))
	      	throw new Exception('Erreur écriture table '.$cle);
	  $req='update '.$prefixe.'professeur set mel="'.$_POST["loginadmin"].'", mdp="'.$mdpadminCr.'" where num=1';
	  mysqli_query($cn,$req);

	  mysqli_close($cn);
	  echo 'Fin de l\'installation<br />';
	  echo 'Notez bien les identifiants de connexion de l\'administrateur :';
	  echo '<ul><li>Login = '.$_POST["loginadmin"].'</li>';
	  echo '<li>Code = '.$mdpadmin.'</li>';
	  echo '<li>Groupe = admins-00</li></ul>';
	  srand((float) microtime()*1000000);
	  $corigine=$c;
	  for($i=1;$i<=8;$i++)
	    $c.=chr(rand(0,25)+97);
	  if (rename("../".$corigine,"../".$c))
	    echo 'Le répertoire "'.$corigine.'" a été; renommé; pour sécuriser l\'application';
	  else
	    throw new Exception('Manque (peut-être) droit d\'écriture sur le répertoire "dirrw"');

  } catch (Exception $e) {
    echo 'Erreur interceptée : ',  $e->getMessage(), "\n";
  }
?>
