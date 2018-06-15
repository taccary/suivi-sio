 <?php  include_once 'exit.php'; ?>
<?php
  // 2016-09-03 Modification nom de fichier contenant le nom de l'étudiant + utilisation dc() pour libellés
  // 2016-09-07 !!! passage en tout UTF-8 trop compliqué. Nécessite tfpdf (http://www.fpdf.org/fr/script/script92.php)
  // 2016-09-08 Mise en forme pour optimiser le nombre de situations sur une page + ajout pages détails
  // 2017-01-30 Bascule en tout UTF-8 : fichier PHP enregistré en UTF8-BOM (Notepad++), Police Roboto unicode, tfPDF plutôt que FPDF

  function dtihm($d){
    return substr($d,8,2)."/".substr($d,5,2)."/".substr($d,0,4);
  }
  function dtint($d){
    return mkTime(0,0,0,substr($d,5,2),substr($d,8,2),substr($d,0,4));
  }
  function getRadio($nb,$val){
    $a=array();
    for ($i=0;$i<$nb;$i++)
      if ($i==$val) $a[]='O'; else $a[]='N';
    return $a;
  }
  function dc($c){  // la base et les pages HTML sont en UTF-8... ici ce n'est pas possible avec fpdf
    return utf8_decode(stripslashes($c));
	return $c;
  }


include("passfpdf.php");

header('Content-type: application/pdf');

//récup des données
$tableau  =$data["tableau"];
$ident    =$tableau["ident"];
$typologie=$tableau["typologie"];
$lescorps =$tableau["sit"];
$leslibs  =$tableau["libsit"];
$entete   =$tableau["et"];
$nbp      =$entete["nbp"];
$nba      =$entete["nba"];


//en mm :
$margeg=10; 		//marge gauche
$hvt=13; 			//hauteur texte (originale : 15)
$hvp=8; 			//hauteur ligne processus (origine:15)
$hv=67;				//hauteur cadre texte vertical (typologie A.1.x...) (origine 60);
$hvs=10;			//hauteur pour une situ, fixe puisque seul libcourt<=64car (origine:15, modifié:10)
$htxt=3; 			//initialement 5, passé à 3 pour gagner en nombre de situation sur une seule feuille
$margeinterne=4;	//marge entre 4 col. oblig et les 57 autres ( 1 <= $margeinterne <= 6) origine 4
if ($nbp==5){		//pour 57 activités, parcours indifférencié (1er semestre)
	$lg=6; 			// prevoir 6 mm par colonne
	$lgoblig=6;		//largeur colonnes pour themes obligatoires (tjs 4)
	$offset=7;
	$mgs=35;		//largeur colonne de gauche pour situs (libcourt) origine:32
} else { 			//SISR / SLAM
	$lg=8; 			//origine:7
	$lgoblig=7;
	$offset=6.5;
	$mgs=55;		//largeur colonne de gauche pour situs (libcourt) origine:32
}

//en points :
$potitre=14;
$potexte=12;
$pocroix=10;
$posousigne=10;		// taille pour "soussigné"
$polibelle=6;		// taille police typologie (A.1.x xxxxxx...)
$poprocessus=7;		// taille police libellés étudiants (découverte snmp, création VLAN...)
//niveau de gris
$CheckFond=55; 		// pseudo noir pour les cellules validées (situations)
$UncheckFond=255;
$grisclairfond=200;	//gris clair pour fond cellules E6
$grisclairtrait=200;
$BlancTrait=255;
$police="Roboto";
//$police="Arial";



$pdf = new PassFPDF('L','mm','A3');//L/P : paysage/portrait
// 2017-01-30 Ajout d'une police unicode et compatibilité UTF-8
$pdf->AddFont($police,'','Roboto-Condensed.ttf',true);
$pdf->AddFont($police,'B','Roboto-BoldCondensed.ttf',true);
$pdf->AddFont($police,'I','Roboto-CondensedItalic.ttf',true);
$pdf->AddFont($police,'BI','Roboto-BoldCondensedItalic.ttf',true);

$pdf->SetTitle("Tableau de synthèse");
$pdf->SetAuthor('BTS SIO');


$pdf->AddPage();
$pdf->SetAutoPageBreak(true,50);
$pdf->SetFont($police,'B',$potitre);
$txt="BTS SERVICES INFORMATIQUES AUX ORGANISATIONS - TABLEAU DE SYNTHÈSE";

$pdf->Cell(0,$hvt,$txt,0,1,"C");
$pdf->SetFont($police,'B',$potexte);
$txt="Nom et prénom du candidat : ".$ident[0]["nom"]." ".$ident[0]["prenom"];
$pdf->Cell(60, $hvt,"",0,0);
$pdf->Cell(160,$hvt,$txt,0,0);
$txt="Parcours : ".$ident[0]["nomenclature"];
$pdf->Cell(60,$hvt,$txt,0,0);
$txt="Numéro du candidat : ".$ident[0]["numexam"];
$pdf->Cell(0,$hvt,$txt,0,1);

$pdf->SetFont($police,'B',$polibelle);
$pdf->Ln(2);
//situ oblig
$pdf->Cell(4*$lgoblig,$hvp,"Situation obligatoire",1,0,"C");

$pdf->Cell($mgs+$margeinterne,$hvp,"",0,0);
//processus (P1, P2, P3, P4, P5)
$pdf->SetFontSize($poprocessus);  // On grossit légèrement la taille de police des libellés P1 à P5
for ($i=0;$i<$nbp;$i++){
  $unproc=$entete[$i];
  $largeur=$lg*count($unproc["act"]);
  $pdf->Cell($largeur,$hvp,$unproc["nomenclature"]." ".dc($unproc["libelle"]),1,0,"C");
}
$pdf->SetFontSize($polibelle);

//ecriture verticale pour activites
$pdf->Ln($hvp);

$x0=$offset;
$x=$x0+$lgoblig/2;
$y0=$pdf->getY();
$y1=$y0+$hv;//hauteur texte à 90°
$pdf->SetFillColor($grisclairfond);
// $pdf->SetFont($police,'',14);

for ($i=0;$i<4;$i++){ //4 sûr, sinon on est mal
	$pdf->TourneTexte(90,$x+$lg/2,$y1,"  ".dc($typologie[$i]["libelle"]));
    $pdf->SetXY($x,$y0);
  	$pdf->Cell($lg,$hv,"",1,0);//hauteur case verticale
    $x+=$lg;
}
//<>ajouté
$y0=$pdf->getY();
$x0=$pdf->getX();
$pdf->MultiCell($mgs+$margeinterne,$hvp/2,"Situation professionnelle",0,"C");
$pdf->SetXY($x0,$y0);
//</ajouté>
$x0=$mgs+4*$lgoblig+$margeinterne+$offset;
$x=$x0+$lg/2;;
$y0=$pdf->getY();
$y1=$y0+$hv;

$eprE6=array();//récupere à la volée le type d'epreuve pour les autres lignes
for ($i=0;$i<$nbp;$i++){
  $lesact=$entete[$i]["act"];
  for ($j=0;$j<count($lesact);$j++){
    $pdf->SetXY($x,$y0);
    if ($lesact[$j]["idEpreuve"]==3) { //epreuve E6=3 (E4=1 ; E5=2)
    	$pdf->Cell($lg,$hv,"",1,0,"C",true);
    	$eprE6[]=true;
    } else {
    	$pdf->Cell($lg,$hv,"",1,0,"C",false);
    	$eprE6[]=false;
    }
  	$pdf->SetXY($x,$y0);
  	$pdf->TourneTexte(90,$x+$lg/2,$y1,"  ".$lesact[$j]["nomenclature"]."   ".dc($lesact[$j]["libelle"]));
  	$pdf->Cell($lg,$hv,"",1,0);//hauteur case verticale
    $x+=$lg;
  }
}

$pdf->Ln($hv);


//itération sur les trois sortes de situations
for ($src=0 ; $src<3 ; $src++){//0=formation / 1=stage1 / 2=stage2
	$corps=$lescorps[$src];

	//affichage celules en filigranne
	//$pdf->SetDrawColor($grisclairtrait);
	$pdf->SetDrawColor($BlancTrait);
	for ($i=0; $i<4;$i++) $pdf->Cell($lgoblig,$hvs,"","LR",0); //4 cellules claires à gauche
	$pdf->Cell($mgs+$margeinterne,$hvs,"",0,0);
	$ysrc=$pdf->getY();
	$xsrc=$pdf->getX();

	for ($i=0;$i<$nba ; $i++) $pdf->Cell($lg,$hvs,"","LR",0);//que gauche et droite en clair
	$pdf->SetXY($xsrc,$ysrc);
	$pdf->SetFont($police,'B',$potexte);
	$pdf->Cell(0,$hvs,dc($leslibs[$src]),0,1,"C"); //Titre SITUATION VÉCUES...

	$pdf->SetDrawColor(0); //noir
	foreach($corps as $situ){
	  $typo=$situ["typo"];
	  $pdf->SetFont($police,'B',$pocroix);
	  for ($i=0; $i<count($typologie);$i++)  //X ou pas dans Situation obligatoire
	    $pdf->Cell($lgoblig,$hvs,$typo[$i],1,0);
	  $pdf->Cell($margeinterne,$hvs,"",0,0);
	  $pdf->SetFont($police,'B',$polibelle);
	  $x0=$pdf->getX();
	  $y0=$pdf->getY();
	  $dts=dtihm($situ["datedebut"]).' - '.dtihm($situ["datefin"]);
	  // décodage UTF-8 vers ISO-5581-1
	  $pdf->MultiCell($mgs,$htxt,dc($situ["libcourt"])."\n".$dts,0);
	  $pdf->setXY($x0,$y0);
	  $pdf->Cell($mgs,$hvs,"",1,0);

	  $act=$situ["act"];

	  //affichage des X pour les activites citées
	  $pdf->SetFont($police,'B',$pocroix);
	  for ($i=0;$i<$nba ; $i++) {
		  $pdf->Cell($lg,$hvs," ".$act[$i],1,0,"C",$eprE6[$i]); // X ou pas X : là est la question
	  }
	  $pdf->Ln($hvs);
	}
}
//gestion bas de page : soussigné... version plusieurs signataires
/* $pdf->Ln(6);
$y0=$pdf->getY();
$pdf->SetFont($police,'B',$posousigne);
$hsigne=6;
$txtj="Je soussigné-e\n";
$txt=$txtj."formateur(-trice) au centre de formation, certifie que l'étudiant-e a bien effectué \nles activités et missions présentées dans ce tableau, en formation.";
$pdf->MultiCell(140,$hsigne,$txt,"B","L",0);

$x0=$pdf->getX();
$pdf->setXY(153,$y0);
$txt=$txtj."représentant(-e) de l'organisation, certifie que l'étudiant-e a bien effectué \nles activités et missions présentées ce tableau, en stage 1.";
$pdf->MultiCell(130,$hsigne,$txt,"B","L",0);

$pdf->setXY(287,$y0);
$txt=$txtj."représentant(-e) de l'organisation, certifie que l'étudiant-e a bien effectué \nles activités et missions présentées dans ce tableau, en stage 2.";
$pdf->MultiCell(130,$hsigne,$txt,"B","L",0); */

//gestion bas de page : soussigné...
$pdf->Ln(6);
$y0=$pdf->getY();
$pdf->SetFont($police,'B',$posousigne);
$txtj="Je soussigné-e";
$pdf->Cell(80,$hvt,$txtj,0,0);
$txt="formatrice (formateur) au centre de formation";
$pdf->Cell(120,$hvt,$txt,0,0);
$txt="certifie que le candidat (la candidate) a bien effectué en formation les activités et missions présentées dans ce tableau";
$pdf->Cell(0,$hvt,$txt,0,1,"R");

//**********************************************
//pages perso supplementaires
$synthese=$data["synth"];
$pdf->AddPage();

$po2=9;
$ht =8;
$hcl=5;
$pdf->SetFont($police,'B',$potitre);
$txt="BTS SERVICES INFORMATIQUES AUX ORGANISATIONS - DÉTAILS DES ACTIVITÉS";
$pdf->Cell(0,$hvt,$txt,0,1,"C");
$goDroite=0;
$goNext=1;
$goBottom=2;

if (count($synthese)>0){
  foreach ($synthese as $synt){
    //situation
    //ref, libcourt as libcs, descriptif as descs, datedebut, datefin
    $pdf->SetFont($police,'B',$po2+1);
	$pdf->SetDrawColor(0);
    $pdf->SetFillColor($grisclairfond);
    $txt=dtihm($synt["datedebut"]).' - '.dtihm($synt["datefin"]);
    $pdf->Cell(60, $ht, $txt, "LTRB", $goDroite, "L", 1);					// date
	//$x0=$pdf->getX();
	//$y0=$pdf->getY();

	$pdf->SetFont($police,'B',$po2);
    $txt="Situation : ".$synt["libcs"];
	//$y0=$pdf->getY();
	//$pdf->setXY(0,$y0);
    $pdf->Cell(200, $ht, dc($txt), "LTRB", 1, "C", 0);						// titre activité
    $pdf->SetFont($police,'',$po2);
	$pdf->SetFontSize($po2);
    $txt=$synt["descs"];
	//$y0=$pdf->getY();
	//$pdf->setXY(60,$y0+$ht);
    $pdf->MultiCell(260, $hcl, dc($txt), "LTBR", "LT", 0);					// détail activité
	//$pdf->getXY($x0,$y0);
	$x0=$pdf->getX();
	$y0=$pdf->getY();
	$pdf->setXY($x0,$y0+2);
	//$pdf->cell(0);
  }
}

$pdf->Output("Synthese_".$ident[0]["nom"]."_".$ident[0]["prenom"]."_(".$ident[0]["numexam"].").pdf", "I");



?>
