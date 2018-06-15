<?php
function __autoload($class_name) {
    require_once './ctrl/'.$class_name.'.class.php';
}

if (@opendir('dirrw/init/')) {
  $URL = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  echo '<HTML><HEAD>';
  echo '  <meta charset="UTF-8" />';
  echo '</HEAD><BODY><HR />';
  echo "SuiviSIO :<HR />";
  echo 'Voulez-vous <b>réinitialiser</b> l\'application <b>et</b> la base de données ? <br />';

  echo "- OUI, alors cliquez sur le lien <a href=http://".$URL."dirrw/init/instal.php>Ré-installation</a><br />";
  echo '- NON, alors renommez le sous-dossier "init" dans le répertoire "dirrw" (solution recommandée) ou supprimez-le (conservez-en une copie ailleurs) <br />';
  echo '</br>';
  echo "Pour une mise à jour de la base de données (après copie des fichiers PHP)";
  echo "cliquez sur le lien <a href=http://".$URL."dirrw/init/maj.php>Mise à jour</a><br />";
  echo '</BODY></HTML>';
  

} else {
  include_once './ctrl/util.class.php';
  session_start();

  if (!isset($_SESSION['ctrl'])){
    $util = Utilisateur::getInstance();
    include './dirrw/param/param.ini.php';
  } else {
    $util = $_SESSION['ctrl'];
  }

  include_once './dirrw/param/classes.class.php';
  if (!isset($_REQUEST["action"])){
    $ctrl= new Accueil($util,$_REQUEST);
  } else {
    $act=$_REQUEST["action"];
    if (in_array($act,$cl,TRUE) && ($util->estAuthent() || $act="authent")){
      if ($act=="chpromo"){
      	$util->changeGroupe($_REQUEST["legroupe"]);
      	$ctrl= new Eaccueil($util,"p");
      }	else {
      	$actm=ucfirst($act);
      	$ctrl = new $actm($util,$_REQUEST);
      }
    } else {
      //if ($util->estAuthent()) if ($util->estProf()) {
      //  @unlink('./dirrw/csv/'.substr('0000'.$util->getId(),-4,4).".csv");
      //}
      $util->init(0,null,null,-1,null);
      session_destroy();
      $ctrl= new Accueil($util,$_REQUEST);
    }
  }

  echo $ctrl->getView()->getPage();
}
?>
