<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detil Pengumuman</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('pengurus/list_pengumuman/') ?>">Pengumuman</a>
            </li>
            <li class="active">
                <strong>
                    <a>Detil Pengumuman</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">

            <!-- BAGIAN PROFIL -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="wrapper wrapper-content  animated fadeInRight blog">
                        <div class="row">
                            <?php foreach ($query_detil_pengumuman_result as $pngmmn) { ?>
                                <div class="col-lg-6 col-lg-offset-3">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            <a class="btn-link">
                                                <h2>
                                                    <?php echo $pngmmn->judul ?>
                                                </h2>
                                            </a>

                                            <div class="small m-b-xs">
                                                <span class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $pngmmn->tgl_posting ?></span>
                                            </div>
                                            <h3><?= $pngmmn->headline_berita ?></h3>
                                            <p style="font-size:18px;"><?php echo $pngmmn->isi_berita ?></p>
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
            <!-- BAGIAN PROFIL -->

        </div>
    </div>
</div>