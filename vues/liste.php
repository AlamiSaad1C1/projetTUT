<?php
include('config/head.php');
?>
<div class="swiper-slide" id="slideListe">

            <section id="MaListe">
            <!-- Début de la liste -->
            
            <?php

            // débuggage
            // echo "<pre> SESSION actuelle : ";
            // print_r($_SESSION['ing_checked']);
            // echo "</pre>";

        // on vérifie que la session existe
        if(isset($_SESSION['ing_checked'])) {
            //message si liste vide
            $nbrCoches=COUNT($_SESSION['ing_checked']);
            $nbrManquant=4-$nbrCoches;
            if($nbrCoches==0) {
                 echo "<p class=pas-ing__comp>Votre liste est vide</p>";
            }
            if($nbrManquant==1) { //gestion du pluriel
                echo "<p class=pas-ing__coch>Merci de cocher au moins ".$nbrManquant." ingrédient supplémentaire pour voir une recette</p>";
            }
            else if($nbrManquant>0) {
                    echo "<p class=pas-ing__coch>Merci de cocher au moins ".$nbrManquant." ingrédients supplémentaires pour voir une recette</p>";
            }

            // 1. on remplit un tab ViandesPoissonsBDD à partir des viandes et poissons de la BDD
            $ViandesPoissonsBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='Viandes & poissons'";          
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($ViandesPoissonsBDD,$line['id']);
            }

            // on fait de meme pour les autres types d'ing de la BDD
            // légumes
            $LegumesBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='legume'";          
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($LegumesBDD,$line['id']);
            }

            //féculents
            $FeculentBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='feculent'";          
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($FeculentBDD,$line['id']);
            }

            //laitage
            $LaitierBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='laitier'";          
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($LaitierBDD,$line['id']);
            }

            //divers
            $DiversBDD=array();
            $sql="SELECT * FROM ingredient WHERE type='divers'";          
            $q=$pdo->prepare($sql);
            $q->execute();
            while($line=$q->fetch()) {
                array_push($DiversBDD,$line['id']);
            }

            // 2. on compare le type d'aliment aux ing checked
            // viandes à afficher
            $viandespoissonsAffiches=array_intersect($ViandesPoissonsBDD,$_SESSION['ing_checked']);
            
            //légumes à afficher
            $legumesAffiches=array_intersect($LegumesBDD,$_SESSION['ing_checked']);

            //féculents à afficher
            $feculentAffiches=array_intersect($FeculentBDD,$_SESSION['ing_checked']);

            //laitiers à afficher
            $laitierAffiches=array_intersect($LaitierBDD,$_SESSION['ing_checked']);

            //divers à afficher
            $diversAffiches=array_intersect($DiversBDD,$_SESSION['ing_checked']);

            // débuggage
            // echo "<pre> BDD : ";
            // print_r($ViandesPoissonsBDD);
            // echo "</pre>";

            // echo "<pre>";
            // print_r($viandespoissonsAffiches);
            // echo "</pre>";
            
            // s'il y a des viandes poissons parmi les checked, on affiche image et bouton - pour chaque
            if(COUNT($viandespoissonsAffiches)>0) {
            
                echo "<h3>Mes viandes et poissons</h3>";
                
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($viandespoissonsAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div>";
                        echo "<img src=img/viandes/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer>-</a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach              
            }
            // fin du if COUNT Viandes & Poissons

            if(COUNT($legumesAffiches)>0) {
            
                echo "<h3>Mes légumes</h3>";
                
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($legumesAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div>";
                        echo "<img src=img/legumes/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer>-</a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach              
            }
            // fin du if COUNT Légumes

            if(COUNT($feculentAffiches)>0) {
            
                echo "<h3>Mes féculents</h3>";
                
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($feculentAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div>";
                        echo "<img src=img/feculents/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer>-</a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach              
            }
            // fin du if COUNT Féculents

            if(COUNT($laitierAffiches)>0) {
            
                echo "<h3>Mes produits laitiers</h3>";
                
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($laitierAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div>";
                        echo "<img src=img/laitiers/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer>-</a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach              
            }
            // fin du if COUNT Laitiers

             if(COUNT($diversAffiches)>0) {
            
                echo "<h3>Mes autres produits</h3>";
                
                // on passe en revue tous les ingredients checked du type viande/poisson
                foreach ($diversAffiches as $key => $id) {
                    // pour chaque, on va chercher l'image et l'id (pour le supprimer si voulu)
                    $sql="SELECT * FROM ingredient WHERE id = ?";          
                    $q=$pdo->prepare($sql);
                    $q->execute(array($id));
                    while($line=$q->fetch()) {
                        echo "<div>";
                        echo "<img src=img/divers/".$line['imgListe']." class=post-it alt=".$line['imgListe'].">";
                        echo "<a href=index.php?id=".$line['id']."&action=supprimer>-</a>";
                        echo "</div>";
                    }
                    // fin du while
                }
                // fin du foreach              
            }
            // fin du if COUNT Divers
    }
    // fin du if isset SESSION
        
            
?>
            <!-- Fin Affichage divers sélectionnés -->
            </section>
</div>
        <!-- Fin Slide liste -->


    <!-- Swiper JS -->
    <script src="dist/js/swiper.min.js"></script>
