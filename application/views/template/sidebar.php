<div class="logo-element">
    KBMK
</div>
<?php if ($id_group == '1') { ?>
    <li class="active">
        <a href="<?= base_url('dashboard_pengurus'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_anggota'); ?>"><i class="fa fa-address-card"></i> <span class="nav-label">List Anggota</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_pengurus'); ?>"><i class="fa fa-users"></i> <span class="nav-label">List Pengurus</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_kegiatan'); ?>"><i class="fa fa-heartbeat"></i> <span class="nav-label">List Kegiatan</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_event'); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">List Event</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_pengumuman'); ?>"><i class="fa fa-bullhorn"></i> <span class="nav-label">List Pengumuman</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('pengurus/list_jadwal'); ?>"><i class="fa fa-calendar"></i> <span class="nav-label">List Jadwal</span> </a>
    </li>
    <!-- <li class="active">
        <a href="<?= base_url('pengurus/list_event'); ?>"><i class="fa fa-heartbeat"></i> <span class="nav-label">List Jadwal</span> </a>
    </li> -->
<?php } else { ?>
    <li class="active">
        <a href="<?= base_url('dashboard_anggota'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('anggota/profil_anggota'); ?>"><i class="fa fa-users"></i> <span class="nav-label">Profil Anggota</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('anggota/list_kegiatan'); ?>"><i class="fa fa-heartbeat"></i> <span class="nav-label">List Kegiatan</span> </a>
    </li>
    <li class="active">
        <a href="<?= base_url('anggota/pengajuan'); ?>"><i class="fa fa-wpforms"></i> <span class="nav-label">Form Pengajuan</span> </a>
    </li>
<?php } ?>

</div>
</nav>