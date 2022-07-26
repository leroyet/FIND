<?php

 include("fonctions/connexionbdd.php");

?>

<?php $id = /*(int)*/ $_GET['id']; ?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIND</title>
    <link rel="shortcut icon" href="../Logos/Logo128.png">
    <link rel="stylesheet" media="screen" href="../style.css">
    <link rel="stylesheet" media="screen" href="../style.css">
    <!-- PWA -->
    <link rel="manifest" href="../manifest.json">
    <link rel="apple-touch-icon" href="../Logos/Logo96.png">
    <link rel="apple-touch-startup-image" href="../Logos/Logo96.png">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="black">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width, user-scalable=no">
</head>
<body>

<header>
<section id="headerBase">
        <img src="../boutons/menu-lateral.png" class="openbtn" onclick="openNav()" alt="menu" id="menu">
        <img src="../Logos/Logo512.png" alt="logo512" id="logo" onclick="self.location.href='../index.php'">
        <img src="../boutons/recherche.png" alt="recherche" id="recherche" class="openbtn" onclick="myFunction(), closeNav()">
      </section>


      <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type='text/javascript' src='https://code.jquery.com/jquery-1.12.4.js'></script>  
      <!-- RECHERCHE -->
      <form id="searchForm" class="searchForm" method="GET">
        <div class="container-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <div class="searchInput"><input type="text" name="s" placeholder="Chercher folklore" id="searchInput" autocomplete="off"></div>
        </div>
        <div class="closebtnSearchForm"><img onclick="myFunction(), closeNav()" name="closebtnSearchForm" id="closebtnSearchForm" class="closebtnImg" src="../Logos/closeBtnSearchForm.png"></div>
    </form>

    </header>
    
    <main>
      <!-- RECHERCHE RESULTATS -->
    <div id="result-search-global"></div>



    <script>
  $(document).ready(function(){
    $('#searchInput').keyup(function(){
      $('#result-search-global').html('');

      var utilisateur = $(this).val();

          $.ajax({
              type: 'GET',
              url: '../localisation_folklore/fonctions/recherche_globale.php',
              data: 'user=' + encodeURIComponent(utilisateur),
              success: function(data){
                if(data != ""){
                    $('#result-search-global').append(data);
                    console.log(utilisateur)
              }
              else{
                    document.getElementById('result-search-global').innerHTML = "<div>Aucun résultat</div>"
              }
              }

          })
    });
  });
  </script>

<script>
  $(document).ready(function(){
    $('#closebtnSearchForm').click(function(){
      $('#result-search-global').html('');
    });
  });
  </script>

    </header>
    
    <main>


    <?php
      include("sidebar2.php");
    ?>
    
    <!-- RETOUR -->
    <a href="javascript:void(0)" onclick="history.go(-1)"><img class="retourbtn" src="../boutons/retour.png"></a>

    <!-- MAIN -->

    <!-- NOM CORPO -->
    <?php   
      $pc = $pdo->query('SELECT nom, photo_profil_corpo FROM corporations WHERE nom="'.$id.'"');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo ' <div class="head"><h1 class="titreCorporation">'.$prenom['nom'].'</h1>';
        echo '<img src="../Photos/posts_images_profil/' . ($prenom['photo_profil_corpo']) . '"></div>';
    }    ?>

    <!-- RESUME -->
        <p class="resumeCorporation"><h2>Résumé</h2>
        <?php   
      $pc = $pdo->query('SELECT resume_corporation FROM corporations WHERE nom="'.$id.'"');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="resume">'.$prenom['resume_corporation'].'</div></p>';
    }    ?>

    <!-- TABLE -->
        <div class="premierTableau"><table class="tableCorporation">
          <tr>
            <td class="tableauGauche">Dénomination</td>
            <td>
            <?php   
      $pc = $pdo->query('SELECT nom, abreviation FROM corporations WHERE nom="'.$id.'"');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo $prenom['nom'].' ('.$prenom['abreviation'].')';
    }    ?>
            </td>
          </tr>
          <tr>
            <td>Fondation</td>
            <td>
            <?php   
      $pc = $pdo->query('SELECT date_creation FROM corporations WHERE nom="'.$id.'"');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo $prenom['date_creation'];
    }    ?>
            </td>
          </tr>
          <tr>
            <td>Particularités</td>
            <th><ul>
            <?php   
      $pc = $pdo->query('SELECT titre_information, text_info FROM infos_corporations WHERE type_info="particularite" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>'.$prenom['titre_information'].'- '.$prenom['text_info'].'</li>';
    }    ?>
            </ul></th>
          </tr>
        </table></div>


       <!-- DECORUM -->
        <div class="decorumCorporation">
          <h2>Décorum</h2>
            <table>
              <tr>
                            <?php   
                    $pc = $pdo->query('SELECT chemin_fichier FROM photos_corporations WHERE type_photo="decorum" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
                    while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
                      echo '<td><img class="photoDecorum" src="../Photos/posts_images/' . ($prenom['chemin_fichier']) . '"></td>';
                  }   ?>
              </tr>
              <tr>
              <?php   
                    $pc = $pdo->query('SELECT nom_photo, date_photo FROM photos_corporations WHERE type_photo="decorum" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
                    while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
                      echo '<td class="infoDecorum">'.$prenom['nom_photo'] .' '. $prenom['date_photo'].'</td>';
                  }   ?>
              </tr>
            </table>
        </div>


        <!-- ANECDOTE -->
        <div class="anecdotesCorporation">
          <h2>Anecdotes</h2>

          <?php   
      $pc = $pdo->query('SELECT titre_information, text_info FROM infos_corporations WHERE type_info="anecdote" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo '<a class="titreAnecdote">'.$prenom['titre_information'].'</a><br><a>'.$prenom['text_info'].'</a>';
    }    ?>

        </div>

        <div  class="chantCorporation">
          <h2>Chant</h2>

    <!-- CHANT CORPO -->
    <?php   
      $pc = $pdo->query('SELECT texte_chant FROM chants_corporations WHERE id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        echo $prenom['texte_chant'];
    }    ?>

        </div>


    <!-- HISTORIQUE CROIX -->
        <div class="historiqueCroixCorporation">
          <h2>Historique croix</h2>
          <table>
            
            <?php  

      $pc = $pdo->query('SELECT date_debut, date_fin, surnom FROM historique_comite WHERE id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'") AND fonction="GM" ORDER BY date_debut');
      
      while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
        $date_debut = $prenom['date_debut'];
        $GM = $prenom['surnom'];
        echo '<tr><td>'.$date_debut.'</td>';
        echo '<td>GM : '.$GM.'</td>';

        $pcd = $pdo->query('SELECT date_debut, date_fin, surnom FROM historique_comite WHERE date_debut='.$date_debut.' AND fonction="GC" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
        while($surnom = $pcd->fetch(PDO::FETCH_ASSOC)) {
          $GC = $surnom['surnom'];
        echo '<td>GC : '.$GC.'</td>';
      }
      }
        ?>
          </table>
        </div>



        <!-- PINS -->
        <div class="pinsCorporation">
          <h2>Pin's</h2>
            <table>
              <tr>
                            <?php   
                    $pc = $pdo->query('SELECT chemin_fichier FROM photos_corporations WHERE type_photo="pins" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
                    while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
                      echo '<td><img src="../Photos/posts_images/' . ($prenom['chemin_fichier']) . '"></td>';
                  }   ?>
              </tr>
              <tr>
              <?php   
                    $pc = $pdo->query('SELECT nom_photo, date_photo FROM photos_corporations WHERE type_photo="pins" AND id_corporation = (SELECT id_corporation FROM corporations WHERE nom="'.$id.'")');
                    while($prenom = $pc->fetch(PDO::FETCH_ASSOC)) {
                      echo '<td>'.$prenom['nom_photo'] .' '. $prenom['date_photo'].'</td>';
                  }   ?>
              </tr>
            </table>

        </div>



    </main>


</body>
</html>