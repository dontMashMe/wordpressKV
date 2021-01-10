<?php
/* 
Template Name: Profil
*/
get_header();

$user_info = vrati_user_info();
?>

<?php
if ($user_info != null) {
    $knjige_korisnika = vrati_knjige_korisnika();
    console_log($knjige_korisnika);
    $datum = formatiraj_datum($user_info->registered_date);
    $sva_djela = daj_knjige();
    shuffle($sva_djela);
    $prva_knjiga = $sva_djela[0];
    $druga_knjiga = $sva_djela[1];
    $treca_knjiga = $sva_djela[2];
?>
    <div class="container-fluid user-prof-main_div">
        <div class="row">
            <div class="col-lg-3 user-prof-left">
                <img src="<?php echo get_template_directory_uri() . '/images/user-reading.jpg' ?>" alt="" style='height: 50%; width: 50%; object-fit: contain'>
                <h6><i class="fas fa-signature user-prof-left-icons"></i><?php echo $user_info->user_name_surname ?></h6>
                <p><i class="fas fa-university user-prof-left-icons"></i><?php echo vrati_smjer_poId($user_info->smjer) ?></p>
                <p><i class="fas fa-envelope user-prof-left-icons"></i><?php echo $user_info->email ?></p>
                <p><i class="fas fa-calendar-week user-prof-left-icons"></i>Član od: <?php echo $datum ?>.</p>
            </div>
            <div class="col-lg-9">
                <h6>Tablica posuđenih knjiga</h6>
                <table class="table user-prof-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Naslov knjige</th>
                            <th>Autor</th>
                            <th>Kategorije</th>
                            <th>Posuđeno</th>
                            <th>Rok povrata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 0;
                        foreach ($knjige_korisnika as $a) {
                            $knjiga = vrati_knjigu_poId($a->book_id);
                            $autor_obj = vrati_autora(get_post_meta($a->book_id, 'autori_knjige', true));
                            $counter++;
                        ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $counter; ?>
                                </th>
                                <th scope="row">
                                    <?php echo $knjiga->ime_knjige ?>
                                </th>
                                <th scope="row">
                                    <a href="<?php echo $autor_obj->guid ?>"><?php echo $autor_obj->post_title ?></a>
                                </th>
                                <th scope="row">
                                    <?php
                                    $kates = "";
                                    foreach ($knjiga->kategorije as $b) {
                                        foreach ($b as $c) {
                                            $kates .= $c->kategorija_ime . ", ";
                                        }
                                    }
                                    echo rtrim($kates, ", ");
                                    ?>
                                </th>
                                <th scope="row" style="color:red;">
                                    <?php echo $a->date_rented ?>
                                </th>
                                <th scope="row" style="color:green;">
                                    <?php
                                    $date = new DateTime($a->date_rented);
                                    $date->add(new DateInterval('P14D'));
                                    echo $date->format('Y-m-d');
                                    ?>
                                </th>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
                <h6>Knjige koje bi vas možda mogle zanimati.</h6>
                <div class="container-fluid">
                    <div class="row" style="text-align: center;">
                        <div class="col-md-4 box">
                            <h6><?php echo $prva_knjiga->ime_knjige ?></h3>
                                <img class='archive-knjige' src="<?php echo $prva_knjiga->istaknuta_slika ?>" style="padding-bottom:15px;">
                                <a href="<?php echo $prva_knjiga->guid ?>" class="button">Pročitaj više!</a>
                        </div>
                        <div class="col-md-4 box">
                            <h6><?php echo $druga_knjiga->ime_knjige ?></h3>
                                <img class='archive-knjige' src="<?php echo $druga_knjiga->istaknuta_slika ?>" style="padding-bottom:15px;">
                                <a href="<?php echo $druga_knjiga->guid ?>" class="button">Pročitaj više!</a>
                        </div>
                        <div class="col-md-4 box">
                            <h6><?php echo $treca_knjiga->ime_knjige ?></h3>
                                <img class='archive-knjige' src="<?php echo $treca_knjiga->istaknuta_slika ?>" style="padding-bottom:15px;">
                                <a href="<?php echo $treca_knjiga->guid ?>" class="button">Pročitaj više!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
?>
    <div class="container" style="margin:auto; width:50%; text-align:center;">
        <h3>Sesija istekla!</h3>
        <img class="not-logged-user" src="<?php echo get_template_directory_uri() . '/images/sad.png' ?>" alt="">
        <a style="padding:3em; font-size:large" href="http://localhost/wordpress/prijava/"><i class="fas fa-sign-in-alt" style="padding-right:5px;"></i>Prijava</a>
    </div>
<?php
}
?>

<?php

get_footer();
?>