<div class="mdl-layout__drawer">
    <header>darkboard</header>
    <div class="scroll__wrapper" id="scroll__wrapper">
        <div class="scroller" id="scroller">
            <div class="scroll__container" id="scroll__container">
                <nav class="mdl-navigation">
                    <?php if ($id_group == '1') { ?>
                        <a class="mdl-navigation__link" href="index.html">
                            <i class="material-icons" role="presentation">dashboard</i>
                            Dashboard
                        </a>
                        <a class="mdl-navigation__link" href="<?= base_url('pengurus/list_pengurus') ?>">
                            <i class="material-icons">person</i>
                            List Pengurus
                        </a>
                        <a class="mdl-navigation__link" href="<?= base_url('pengurus/list_kegiatan') ?>">
                            <i class="material-icons" role="presentation">schedule</i>
                            List Kegiatan
                        </a>
                    <?php } else { ?>
                        <a class="mdl-navigation__link" href="index.html">
                            <i class="material-icons" role="presentation">dashboard</i>
                            Dashboard
                        </a>
                        <a class="mdl-navigation__link" href="<?= base_url('anggota/profil_anggota') ?>">
                            <i class="material-icons">person</i>
                            Profil Anggota
                        </a>
                        <a class="mdl-navigation__link" href="<?= base_url('anggota/list_kegiatan') ?>">
                            <i class="material-icons" role="presentation">schedule</i>
                            List Kegiatan
                        </a>
                        <a class="mdl-navigation__link" href="<?= base_url('anggota/pengajuan') ?>">
                            <i class="material-icons" role="presentation">schedule</i>
                            Form Pengajuan
                        </a>
                    <?php } ?>
                    <div class="mdl-layout-spacer"></div>
                    <hr>
                    <a class="mdl-navigation__link" href="<?= base_url('auth/logout') ?>">
                        <i class="material-icons" role="presentation">exit_to_app</i>
                        Logout
                    </a>
                </nav>
            </div>
        </div>
        <div class='scroller__bar' id="scroller__bar"></div>
    </div>
</div>