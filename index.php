<?php
$page = "Accueil";
$racine_admin = "./site_admin/";
$racine = "./";
include("./includes/header.php");
$cnx = connex();
?>
<section class="header1 cid-s48MCQYojq mbr-fullscreen mbr-parallax-background" id="header1-f">
    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(255, 255, 255);"></div>

    <div class="align-center container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <h1 class="mbr-section-title mbr-fonts-style mb-3 display-2" ><strong><?php echo SITE_HOME_TITRE; ?></strong></h1>

                <p class="mbr-text mbr-fonts-style display-7" style="opacity: 0.8; background-color: rgb(255, 255, 255);">
                    <i class="fa fa-quote-left"></i>
                    <?php echo SITE_DESC; ?>
                </p>
                <div class="mbr-section-btn mt-3"><a class="btn btn-success display-4" href="<?php echo URL_SITE; ?>pages/about.php">Lire plus ...</a> </div>
            </div>
        </div>
    </div>
</section>

<section class="content2 cid-sFV9rV9v1E" id="content2-x">

    <div class="container">
        <div class="mbr-section-head">
            <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2"><strong>Notre Blog</strong></h4>
            <h5 class="mbr-section-subtitle mbr-fonts-style align-center mb-0 mt-2 display-5">Suivez des articles publiés dans le blog du CPS</h5>
        </div>
        <div class="row mt-4">

            <?php
            //filtre
            if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
                $valeur_requete = ' WHERE Fk_idcategorie=' . $_GET['categorie'];
            } else {
                //get post sans filtre
                $valeur_requete = " ";
            }

            //pagination
            $limit = 5;
            $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
            $paginationStart = ($page - 1) * $limit;

            $query = "SELECT * FROM `publication` $valeur_requete LIMIT $paginationStart, $limit";

            $queryCount = "SELECT COUNT(idpublication) AS nombre FROM `publication` $valeur_requete ";

            //echo $query;
            $publications = $cnx->query($query)->fetchAll();

            // Get total records
            $sql = $cnx->query($queryCount)->fetchAll();
            $allRecrods = $sql[0]['nombre'];

            // Calculate total pages
            $totoalPages = ceil($allRecrods / $limit);

            // Prev + Next
            $prev = $page - 1;
            $next = $page + 1;

            if ($allRecrods == 0) {
                echo"<div class=\"alert alert-danger  alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                                    <h4><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>
                                    <i class=\"fa fa-warning\"></i><strong>Attention : </strong><i> Aucune publication faite!</i></h4>
                                    </div>";
            }

            // echo 'Query : ' . $valeur_requete;

            $j = 1;
            ?>
            <?php foreach ($publications as $post): ?>
                <div class="item features-image сol-12 col-md-6 col-lg-4">
                    <div class="item-wrapper">
                        <div class="item-img">
                            <?php
                            // getting image
                            $postImg = "";
                            $medias = getMediasByCatId($post['idpublication'], "Fk_idpublication");
                            $iterationImg = 1;
                            foreach ($medias as $dataMedias) {
                                $typeFichier = $dataMedias['typeFichier'];
                                $extensionsImg = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
                                if (in_array($typeFichier, $extensionsImg) === true) {
                                    $postImg = $dataMedias['fichier'];
                                }
                                $iterationImg++;
                            }
                            ?>
                            <a href="post.php?post=<?php echo $post['idpublication']; ?>" class="text-primary">
                                <img src="<?php echo $racine_admin; ?>images/posts/<?php echo $postImg; ?>" alt="" title="<?php echo $post['titre']; ?>">
                            </a>
                        </div>
                        <div class="item-content">
                            <h5 class="item-title mbr-fonts-style display-5">
                                <a href="post.php?post=<?php echo $post['idpublication']; ?>" class="text-primary">
                                    <?php echo $post['titre']; ?>
                                </a>
                            </h5>
                            <h6 class="item-subtitle mbr-fonts-style mt-1 display-7">
                                <em> <?php echo afficheDate($post['datepublication']); ?></em></h6>
                            <p class="mbr-text mbr-fonts-style mt-3 display-7">
                                <?php echo limite_caractere($post['description'], 200); ?>[<a href="post.php?post=<?php echo $post['idpublication']; ?>" title="Lire plus">&hellip;</a>]
                            </p>
                        </div>
                        <div class="mbr-section-btn item-footer mt-2">
                            <a href="post.php?post=<?php echo $post['idpublication']; ?>" class="btn item-btn btn-primary display-7" >
                                Lire plus &gt;
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                $j++;
            endforeach;
            ?>
        </div>
    </div>
</section>

<section class="content2 cid-sFV9rV9v1E" id="content2-x">
    <div class="container">
            <?php if ($allRecrods > 0) { ?>
                <!-- Pagination -->
                <nav aria-label="Page navigation example mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php
                        if ($page <= 1) {
                            echo 'disabled';
                        }
                        ?>">
                            <a class="page-link"
                               href="<?php
                               if ($page <= 1) {
                                   echo '#';
                               } else {
                                   echo "?page=" . $prev;
                               }
                               ?>">Précédent</a>
                        </li>

                        <?php for ($i = 1; $i <= $totoalPages; $i++): ?>
                            <li class="page-item <?php
                            if ($page == $i) {
                                echo 'active';
                            }
                            ?>">
                                <a class="page-link" href="index.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php
                        if ($page >= $totoalPages) {
                            echo 'disabled';
                        }
                        ?>">
                            <a class="page-link"
                               href="<?php
                               if ($page >= $totoalPages) {
                                   echo '#';
                               } else {
                                   echo "?page=" . $next;
                               }
                               ?>">Suivant</a>
                        </li>
                    </ul>
                </nav>
            <?php } ?>
        </div>
    </div>
</section>
<!--<section class="features10 cid-sFV8TYxjeY" id="features11-q">
    
    <div class="container">
        <div class="title">
            <h3 class="mbr-section-title mbr-fonts-style mb-4 display-2">
                <strong>Les responsables</strong>
            </h3>

        </div>
        <div class="card">
            <div class="card-wrapper">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <div class="image-wrapper">
                            <img src="site_template/assets/images/membre.jpg" alt="Image" title="">
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-line">
                                        <h4 class="card-title mbr-fonts-style display-5"><strong>Nom responsable 1</strong></h4>
                                        <p class="cost mbr-fonts-style display-5">
                                            <a href="mailto:#" target="_blank" title="Contactez" class="btn btn-success"> 
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bottom-line">
                                        <p class="mbr-text mbr-fonts-style m-0 display-7">
                                            Themes in the Mobirise website builder offer multiple blocks: intros,
                                            sliders, galleries, forms, articles, and so on. Start a project and click on
                                            the red plus buttons to see the blocks available for your theme.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-wrapper">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <div class="image-wrapper">
                            <img src="site_template/assets/images/membre.jpg" alt="Image" title="">
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-line">
                                        <h4 class="card-title mbr-fonts-style display-5"><strong>Nom responsable 2</strong></h4>
                                        <p class="cost mbr-fonts-style display-5">
                                            <a href="mailto:#" target="_blank" title="Contactez" class="btn btn-success"> 
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bottom-line">
                                        <p class="mbr-text mbr-fonts-style m-0 display-7">
                                            Themes in the Mobirise website builder offer multiple blocks: intros,
                                            sliders, galleries, forms, articles, and so on. Start a project and click on
                                            the red plus buttons to see the blocks available for your theme.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-wrapper">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <div class="image-wrapper">
                            <img src="site_template/assets/images/membre.jpg" alt="Image" title="">
                        </div>
                    </div>
                    <div class="col-12 col-md">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="top-line">
                                        <h4 class="card-title mbr-fonts-style display-5"><strong>Nom responsable 3</strong></h4>
                                        <p class="cost mbr-fonts-style display-5">
                                            <a href="mailto:#" target="_blank" title="Contactez" class="btn btn-success"> 
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bottom-line">
                                        <p class="mbr-text mbr-fonts-style m-0 display-7">
                                            Themes in the Mobirise website builder offer multiple blocks: intros,
                                            sliders, galleries, forms, articles, and so on. Start a project and click on
                                            the red plus buttons to see the blocks available for your theme.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->


<section class="countdown4 cid-sFV92BR3wa mbr-fullscreen" id="countdown4-u">

    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(68, 121, 217);">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="mbr-section-title mb-5 align-center mbr-fonts-style display-2">
                    <strong>En chiffre !</strong>
                </h3>

                <div class="countdown-cont align-center mb-5">
                    <div class="daysCountdown col-xs-3 col-sm-3 col-md-3" title="Négociants"></div>
                    <div class="hoursCountdown col-xs-3 col-sm-3 col-md-3" title="Coopératives"></div>
                    <div class="minutesCountdown col-xs-3 col-sm-3 col-md-3" title="Sites"></div>
                    <div class="secondsCountdown col-xs-3 col-sm-3 col-md-3" title="Compotoirs"></div>
                    <div class="countdown" data-due-date="2021/01/01"></div>
                </div>
                <p class="mbr-text mb-5 align-center mbr-fonts-style display-7">
                    Trouvez nos statistiques en temps réel
                </p>
                <div class="icons-menu row justify-content-center display-7">

                    <div class="soc-item col-auto">
                        <a href="https://instagram.com/cpssk" target="_blank" class="social__link">
                            <span class="mbr-iconfont socicon-instagram socicon"></span>
                        </a>
                    </div>
                    <div class="soc-item col-auto">
                        <a href="https://twitter.com/cpssk" target="_blank" class="social__link">
                            <span class="mbr-iconfont socicon-twitter socicon"></span>
                        </a>
                    </div>
                    <div class="soc-item col-auto">
                        <a href="https://facebook.com/cpssk/" target="_blank" class="social__link">
                            <span class="mbr-iconfont socicon socicon-facebook"></span>
                        </a>
                    </div>
                    <div class="soc-item col-auto">
                        <a href="https://youtube.com/c/cpssk" target="_blank" class="social__link">
                            <span class="mbr-iconfont socicon socicon-youtube"></span>
                        </a>
                    </div></div>

            </div>
        </div>
    </div>
</section>

<?php
include("./includes/footer.php");
?>