<?php
$page = "404";
$racine_admin = "./site_admin/";
$racine = "./";
include("./includes/header.php"); 
?>
<section class="content1 cid-s48udlf8KU" id="content1-8">

    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-md-9">
                <h3 class="mbr-section-title mbr-fonts-style align-center mb-4 display-2"><strong>Erreur 404</strong></h3>


                <div  class="alert alert-danger col-12">
                    <h4 class="mbr-section-subtitle align-center mbr-fonts-style mb-4 display-7">La ressource démandée n'est pas disponible.</h4>
                </div>
                <div  class="alert alert-warning col-12">
                    <i class="fa fa-warning"></i>
                    <h4 class="mbr-section-subtitle align-center mbr-fonts-style mb-4 display-7">Le site est encours de conception !</h4>
                </div>
                <h4 class="mbr-section-subtitle align-center mbr-fonts-style mb-4 display-7">Effectuez une recherche.</h4>

                <?php
                include("./includes/search_form.php");
                ?>
            </div>
        </div>
    </div>
</section>

<?php
include("./includes/footer.php");
?>
