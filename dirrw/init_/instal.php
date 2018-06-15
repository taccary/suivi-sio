<html>
<head>
<title>Installation suiviSIO</title>
	<link rel="stylesheet" type="text/css" href="init.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<h1 align="center">Installation et paramétrage de l'application "Suivi des
 compétences SIO"</h2>

<form method="post" action="enregparam.php">
  <h2>Paramètres du serveur</h2>
  <table width="100%" border="0" cellspacing="0">
    <tr>
      <td width="55%">
        <div align="right">Nom du serveur de base de donn&eacute;es : </div>
      </td>
      <td width="45%">
        <input type="text" name="nomserveur" maxlength="40" size="50" value="localhost">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Login du compte d'administration de ce serveur : </div>
      </td>
      <td width="45%">
        <input type="text" name="login" maxlength="24" size="30" value="root">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Mot de passe du compte d'administration de ce serveur
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="mdp" maxlength="32" size="40">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Nom de la base de donn&eacute;es : </div>
      </td>
      <td width="45%">
        <input type="text" name="nombd" maxlength="40" size="50" value="suiviSIO">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Faut-il cr&eacute;er la base de donn&eacute;es (si
          elle n'existe pas encore) ?</div>
      </td>
      <td width="45%">
        <input type="checkbox" name="creation" value="checkbox" checked>
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Pr&eacute;fixe des tables (<i>underscore</i> sera ajout&é
          en fin de pr&eacute;fixe): </div>
      </td>
      <td width="45%">
        <input type="text" name="prefixe" maxlength="6" size="10" value="sio">
      </td>
    </tr>
	</table>
	<h2>Paramètres de sécurité</h2>
	<table width="100%" border="0" cellspacing="0">
	
    <tr>
      <td width="55%">
        <div align="right">Longueur des mots de passe (12 caract&egrave;res maximum)
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="lngmdp" maxlength="2" size="5" value="6">
      </td>
    </tr>
	    <tr>
      <td width="55%">
        <div align="right">Cryptage des mots de passe dans la base ? </div>
      </td>
      <td width="45%">
        <input type="checkbox" name="crypte" value="checkbox">
      </td>
    </tr>
	</table>
	<h2>Paramètres de messagerie</h2>
	<table width="100%" border="0" cellspacing="0">
    <tr>
      <td width="55%">
        <div align="right">Un serveur SMTP est-il disponible ?</div>
      </td>
      <td width="45%">
        <input type="checkbox" name="smtp" value="checkbox">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Adresse messagerie du contact pour les étudiants
          : </div>
      </td>
      <td width="45%">
        <input type="text" name="contact" maxlength="64" size="40" value="-votre mel-">
      </td>
    </tr>
	</table>
	<h2>Administrateur de l'application</h2>
	<table width="100%" border="0" cellspacing="0">
    <tr> 
      <td width="55%"> 
        <div align="right">Adresse messagerie (&quot;identifiant&quot;) de l'administrateur:
          pour gérer "SuiviSIO" : </div>
      </td>
      <td width="45%"> 
        <input type="text" name="loginadmin" maxlength="64" size="40" value="admin@local.fr">
      </td>
    </tr>

    <tr>
      <td width="55%">
        <div align="right">Mot de passe (&quot;code&quot;) del'administrateur
          (&quot;admin&quot;) de l'application : </div>
      </td>
      <td width="45%">
        <input type="text" name="mdpadmin" maxlength="12" size="20" value="123456">
      </td>
    </tr>
    <tr>
      <td width="55%">
        <div align="right">Enregistrement des donn&eacute;es et cr&eacute;ation
          des tables </div>
      </td>
      <td width="45%">
        <input type="submit" name="Submit" class="button" value="Envoyer">
      </td>
    </tr>
  </table>
</form>

</body>
</html>
