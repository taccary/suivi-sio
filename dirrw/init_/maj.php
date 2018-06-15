<?php
/*
  David ROUMANET - 01/02/2017
  Cette fonctionne diffère par la relecture des paramètres saisies et la possibilité de
  les modifier.
*/
$fic=fopen("../param/param.ini.php", "r");
$nomServeur="";
$loginAdminServeur="";
$motPasseAdminServeur="";
$nomBaseDonnee="";
$prefixeTable="";
$crypte="false";
$smtp="false";
$melContact="";
$lngmdp="6";

while(!feof($fic))
{
	$ligne= fgets($fic,1024);
	if (strpos($ligne, '=')>0) {
		$table = explode('=',$ligne);
		$part = str_replace('"', "", $table[1]);
		$part = str_replace(';', "", $part);
		switch($table[0]) {
			case '$nomServeur':
				$nomServeur = $part;
			case '$loginAdminServeur':
				$loginAdminServeur = $part;
			case '$motPasseAdminServeur':
				$motPasseAdminServeur = $part;
			case '$nomBaseDonnee':
				$nomBaseDonnee = $part;
			case '$prefixeTable':
				$prefixeTable = str_replace('_', "", $part);
			case '$crypte':
				$crypte = $part;
			case '$smtp':
				$smtp = $part;
			case '$melContact':
				$melContact = $part;
			case '$lngmdp':
				$lngmdp = $part;
		}
	}
}
fclose($fic) ;


echo '<html>';
echo '<head>';
echo '<title>Mise à jour suiviSIO</title>';
echo '	<link rel="stylesheet" type="text/css" href="init.css">';
echo '	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '	<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '</head>';
echo '';
echo '<body>';
echo '<h1 align="center">Mise à jour de l\'application "Suivi des compétences SIO"</h2>';
echo '';
echo '<form method="post" action="majparam.php">';
echo '  <h2>Paramètres du serveur</h2>';
echo '  <table width="100%" border="0" cellspacing="0">';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Nom du serveur de base de donn&eacute;es : </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="text" name="nomserveur" maxlength="40" size="50" value='.$nomServeur.'>';
echo '      </td>';
echo '    </tr>';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Login du compte d\'administration de ce serveur : </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="text" name="login" maxlength="24" size="30" value='.$loginAdminServeur.'>';
echo '      </td>';
echo '    </tr>';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Mot de passe du compte d\'administration de ce serveur';
echo '          : </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="text" name="mdp" maxlength="30" size="30" value='.$motPasseAdminServeur.'>';
echo '      </td>';
echo '    </tr>';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Nom de la base de donn&eacute;es : </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="text" name="nombd" maxlength="40" size="30" value='.$nomBaseDonnee.'>';
echo '      </td>';
echo '    </tr>';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Pr&eacute;fixe des tables (<i>underscore</i> sera ajout&é';
echo '          en fin de pr&eacute;fixe): </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="text" name="prefixe" maxlength="6" size="10" value='.$prefixeTable.'>';
echo '      </td>';
echo '    </tr>';
echo '	</table>';
echo '	<h2>Paramètres de sécurité</h2>';
echo '	<table width="100%" border="0" cellspacing="0">';
echo '';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right">Longueur des mots de passe (12 caract&egrave;res maximum)';
echo '          : </div>';
      echo '</td>';
echo '      <td width="45%">';
echo '        <input type="text" name="lngmdp" maxlength="2" size="5" value='.$lngmdp.'>';
      echo '</td>';
echo '    </tr>';
echo '	    <tr>';
      echo '<td width="55%">';
echo '        <div align="right">Cryptage des mots de passe dans la base ? </div>';
      echo '</td>';
echo '      <td width="45%">';
echo '        <input type="checkbox" name="crypte" value="checkbox">';
      echo '</td>';
echo '    </tr>';
echo '	</table>';
echo '	<h2>Paramètres de messagerie</h2>';
echo '	<table width="100%" border="0" cellspacing="0">';
echo '    <tr>';
      echo '<td width="55%">';
echo '        <div align="right">Un serveur SMTP est-il disponible ?</div>';
echo '      </td>';
echo '      <td width="45%">';
echo '        <input type="checkbox" name="smtp" value="checkbox">';
echo '      </td>';
echo '    </tr>';
echo '    <tr>';
      echo '<td width="55%">';
echo '        <div align="right">Adresse messagerie du contact pour les étudiants';
echo '          : </div>';
      echo '</td>';
echo '      <td width="45%">';
echo '        <input type="text" name="contact" maxlength="64" size="40" value='.$melContact.'>';
      echo '</td>';
echo '    </tr>';
echo '	</table>';
echo '  <table width="100%" border="0" cellspacing="0">';
echo '    <tr>';
echo '      <td width="55%">';
echo '        <div align="right"><b>Lancer la mise à jour</b> </div>';
echo '      </td>';
echo '      <td width="45%">';
echo '		<input type="submit" name="Actualiser" class="button" value="Actualiser">';
echo '      </td>';
echo '    </tr>';
echo '  </table>';
echo '</form>';
echo '';
echo '</body>';
echo '</html>';
?>