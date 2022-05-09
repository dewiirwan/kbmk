<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url(); ?>assets/template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="<?= base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url(); ?>assets/template/css/style.css" rel="stylesheet">
</head>

<body id="page-top" class="landing-page no-skin-config">
    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a class="page-scroll" href="#page-top">Home</a></li>
                        <li><a class="page-scroll" href="#tentang">Tentang</a></li>
                        <li><a class="page-scroll" href="#pengumuman">Pengumuman</a></li>
                        <li><a class="page-scroll" href="#kontak">Kontak</a></li>
                    </ul>
                    <a class="navbar-brand navbar-right" href="<?= base_url(); ?>index.php/auth">LOGIN</a>
                </div>
            </div>
        </nav>
    </div>
    <div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#inSlider" data-slide-to="0" class="active"></li>
            <li data-target="#inSlider" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Welcome to<br />
                            SI KBMK Gunadarma</h1>
                        <p>Sistem Informasi <br />
                           Keluarga Besar Mahasiswa Khonghucu <br/>
                           Universitas Gunadarma.</p>
                    </div>
                </div>
                <!-- Set background for slide in css -->
                <div class="header-back one"></div>

            </div>
            <div class="item">
                <div class="container">
                    <div class="carousel-caption blank">
                    </div>
                </div>
                <!-- Set background for slide in css -->
                <div class="header-back two"></div>
            </div>
        </div>
        <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section id="tentang" class="container features">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Fasilitas<br /> <span class="navy"></span>KBMK GUNADARMA</h1>
                <p>Fasilitas yang ada pada Lithang SEGAR Cilodong. </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center wow fadeInLeft">
                <div>
                    <i class="fa fa-bell features-icon"></i>
                    <h2>Ruang Peribadahan </h2>
                    <p>Ruangan Peribahadan berada di Lantai 1 Lithang SEGAR yang terdapat Altar, mimbar, kursi untuk ibadah, meja persembahan Altar, dan alat-alat yang digunakan untuk sembahyang serta alat musik yang digunakan untuk mengiringi lagu pujian.</p>
                </div>
                <div class="m-t-lg">
                    <i class="fa fa-car features-icon"></i>
                    <i class="fa fa-motorcycle features-icon"></i>
                    <h2>Tempat Parkir</h2>
                    <p>Tempat Parkir di Lithang SEGAR bergabung dengan SMP Segar sehingga lumayan luas untuk umat membawa kendaraan pribadi.</p>
                </div>
            </div>
            <div class="col-md-6 text-center  wow zoomIn">
                <img src="<?= base_url(); ?>assets/template/img/landing/genta.png" alt="dashboard" class="img-responsive">
            </div>
            <div class="col-md-3 text-center wow fadeInRight">
                <div>
                    <i class="fa fa-book features-icon"></i>
                    <h2>Ruang Pendidikan</h2>
                    <p>Ruang Pendidikan berada di Lantai 2 Lithang SEGAR yang terdapat beberapa kursi dan meja untuk melaksanakan kegiatan pembelajaran.</p>
                </div>
                <div class="m-t-lg">
                    <i class="fa fa-bus features-icon"></i>
                    <h2>Mobil Elf</h2>
                    <p>Mobil Elf digunakan untuk mengantar-jemput kegiatan di luar Lithang dan pelayanan duka.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="gray-section team">
        <div class="container">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>Pengkhotbah Lithang SEGAR</h1>
                    <p>Pengkhotbah di Lithang Semangat Genta Rohani Cilodong</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 wow fadeInLeft">
                    <div class="team-member">
                        <img src="<?= base_url(); ?>assets/template/img/landing/Ws.Chandra.jpg" class="img-responsive img-circle img-small" alt="">
                        <h4><span class="navy">Ws. Chandra Kurniawan</span></h4>
                        <p>Ws. Chandra Kurniawan sebagai Dewan Penasihat Makin Semangat Genta Rohani Cilodong</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member wow zoomIn">
                        <img src="<?= base_url(); ?>assets/template/img/landing/Js.OkThian.jpg" class="img-responsive img-circle" alt="">
                        <h4><span class="navy">Js. Oey Ok Thian</span></h4>
                        <p>Js. Oey Ok Thian sebagai Ketua Makin Semangat Genta Rohani Cilodong.</p>
                    </div>
                </div>
                <div class="col-sm-4 wow fadeInRight">
                    <div class="team-member">
                        <img src="<?= base_url(); ?>assets/template/img/landing/Js.herry.jpg" class="img-responsive img-circle img-small" alt="">
                        <h4><span class="navy">Js. Heri Setiadi</span></h4>
                        <p>Js. Heri Setiadi sebagai Sie Kerohanian dan Pelayanan Makin Semangat Genta Rohani Cilodong.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>Pengurus Lithang SEGAR</h1>
                    <p>Pengurus di Lithang Semangat Genta Rohani Cilodong.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 wow fadeInLeft">
                    <div class="team-member">
                        <img src="<?= base_url(); ?>assets/template/img/landing/ko_talen.jpg" class="img-responsive img-circle img-small" alt="">
                        <h4><span class="navy">Junaedi</span></h4>
                        <p>Dq. Junaedi sebagai Sie Umum Makin Semangat Genta Rohani Cilodong.</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member wow zoomIn">
                        <img src="<?= base_url(); ?>assets/template/img/landing/citanty1.jpg" class="img-responsive img-circle" alt="">
                        <h4><span class="navy">Ritanty Kumala</span></h4>
                        <p>Dq. Ritanty Kumala sebagai Sie Kewanitaan dan Kepemudaan Makin Semangat Genta Rohani Cilodong. </p>
                    </div>
                </div>
                <div class="col-sm-4 wow fadeInRight">
                    <div class="team-member">
                        <img src="<?= base_url(); ?>assets/template/img/landing/ko surya.jpg" class="img-responsive img-circle img-small" alt="">
                        <h4><span class="navy">Surya Cintawarma</span></h4>
                        <p>Dq. Surya Cintawarman sebagai Sekretaris Makin Semangat Genta Rohani Cilodong.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pengumuman" class="features">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>INI BUAT PENGUMUMAN</h1>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. </p>
                </div>
            </div>

            <div class="gray-bg">
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-2">

                    </div>
                </div>

                <div class="wrapper wrapper-content  animated fadeInRight blog">
                    <div class="row">
                        <?php foreach ($pengumuman as $pngmmn) { ?>
                            <div class="col-lg-6">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <a class="btn-link">
                                            <h2>
                                                <?= $pngmmn->JUDUL ?>
                                            </h2>
                                        </a>

                                        <div class="small m-b-xs">
                                            <span class="text-muted"><i class="fa fa-clock-o"></i> <?= $pngmmn->TANGGAL_POSTING ?></span>
                                        </div>
                                        <h3><?= $pngmmn->HEADLINE_BERITA ?></h3>
                                        <p><?= $pngmmn->ISI_BERITA ?></p>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- <div class="row features-block">
    <?php foreach ($pengumuman as $pngmmn) : ?>
                <div class="col-lg-3 features-text wow fadeInLeft" >
                    <small>Publish : <?= $pngmmn->TANGGAL_POSTING ?></small>
                    <h2><?= $pngmmn->JUDUL ?></h2>
                    <p><?php
                        $pengum = $pngmmn->HEADLINE_BERITA;
                        $cut = substr($pengum, 0, 50,);
                        echo $cut;
                        echo " .....";

                        ?></p>
                    <a href="<?= base_url('Landing/readmore/' . $pngmmn->ID_PENGUMUMAN); ?>" class="btn btn-primary">Selengkapnya</a>
                </div>
                <?php endforeach; ?>
            </div> -->
    <section id="kontak" class="gray-section contact">
        <div class="container">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>Hubungi Kami</h1>
                    <p>Untuk saran dan kritik dapat menghubungi kami.</p>
                </div>
            </div>
            <div class="row m-b-lg">
                <div class="col-lg-3 col-lg-offset-3">
                    <address>
                        <strong><span class="navy">KBMK Universitas Gunadarma</span></strong><br />
                        Kampus D Universitas Gunadarma <br />
                        Jl. Margonda Raya 100. Pondok Cina, Kecamatan Beji, Kota Depok, Jawa Barat <br />        
                        <br>
                        Nomor yang dapat dihubungi: 0895345531188<br />
                    </address>
                </div>
                <div class="col-lg-4">
                    <p class="text-color" >
                        Keluarga Besar Mahasiswa Khonghucu Universitas Gunadarma (KBMK UG) merupakan Unit Kegiatan Mahasiswa (UKM) yang bergerak dalam bidang kerohanian agama Khonghucu dibawah naungan Universitas Gunadarma. KBMK Universitas Gunadarma telah berdiri sejak tahun 2016 dan berjalan hingga saat ini. KBMK Universitas Gunadarma juga merupakan media yang menjadi tempat bagi mahasiswa/mahasiswi beragama Khonghucu di Universitas Gunadarma.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="mailto:kbmkgunadarma@gmail.com" class="btn btn-primary">Send us mail</a>
                    <p class="m-t-sm">
                        Or follow us on social platform
                    </p>
                    <ul class="list-inline social-icon">
                        <li><a href="https://www.instagram.com/kbmk_gundar/"><i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                    <p><strong>&copy; Pengurus KBMK Gunadarma </strong><br />
                </div>
            </div>
        </div>
    </section>


    <!-- Mainly scripts -->
    <script src="<?= base_url(); ?>assets/template/js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?= base_url(); ?>assets/template/js/inspinia.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/plugins/pace/pace.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/plugins/wow/wow.min.js"></script>


    <script>
        $(document).ready(function() {

            $('body').scrollspy({
                target: '.navbar-fixed-top',
                offset: 80
            });

            // Page scrolling feature
            $('a.page-scroll').bind('click', function(event) {
                var link = $(this);
                $('html, body').stop().animate({
                    scrollTop: $(link.attr('href')).offset().top - 50
                }, 500);
                event.preventDefault();
                $("#navbar").collapse('hide');
            });
        });

        var cbpAnimatedHeader = (function() {
            var docElem = document.documentElement,
                header = document.querySelector('.navbar-default'),
                didScroll = false,
                changeHeaderOn = 200;

            function init() {
                window.addEventListener('scroll', function(event) {
                    if (!didScroll) {
                        didScroll = true;
                        setTimeout(scrollPage, 250);
                    }
                }, false);
            }

            function scrollPage() {
                var sy = scrollY();
                if (sy >= changeHeaderOn) {
                    $(header).addClass('navbar-scroll')
                } else {
                    $(header).removeClass('navbar-scroll')
                }
                didScroll = false;
            }

            function scrollY() {
                return window.pageYOffset || docElem.scrollTop;
            }
            init();

        })();

        // Activate WOW.js plugin for animation on scrol
        new WOW().init();
    </script>

</body>

</html>