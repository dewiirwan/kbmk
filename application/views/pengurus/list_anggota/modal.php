<!-- Modal -->
<div class="modal inmodal fade" id="m_tambah" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Kegiatan di KBMK Gunadarma</h4>
            </div>
            <div class="form-horizontal">
                <form class="form-horizontal" action="#" id="form_tambah" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_lengkap" class="col-sm-3 control-label">Nama Lengkap<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="npm" class="col-sm-3 control-label">NPM<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="npm" class="form-control" id="npm" placeholder="NPM">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tempat Tanggal lahir<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="ttl" class="form-control" id="ttl" placeholder="Contoh: Bogor, 16 Mei 1996">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor Handphone<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Contoh: 08123456789">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Alamat<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat" name="alamat" value="" placeholder="Masukkan Alamat Lengkap" required>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Contoh: google@gmail.com" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="confirm_save()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="m_konsultasi" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Form Verifikasi Konsultasi</h4>
            </div>
            <div class="form-horizontal">
                <form class="form-horizontal" action="#" id="form_konsultasi" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id_mhss" id="id_mhss">
                            <label class="col-sm-3 control-label">Tanggal Konsultasi<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="datetime-local" name="tgl_konsultasi" class="form-control" id="tgl_konsultasi" placeholder="Contoh: mm/dd/yyyy">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan Zoom<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <textarea type="text" name="keterangan" class="form-control" id="keterangan" placeholder=""></textarea>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="verif_konsultasi()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="m_edit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Pengurus di KBMK Gunadarma</h4>
            </div>
            <div class="form-horizontal">
                <form class="form-horizontal" action="#" id="form_edit" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_mhs" id="id_mhs">
                        <div class="form-group">
                            <label for="nama_lengkap" class="col-sm-3 control-label">Nama Lengkap<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_lengkap_" class="form-control" id="nama_lengkap_" placeholder="Nama Lengkap">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="npm" class="col-sm-3 control-label">NPM<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="npm_" class="form-control" id="npm_" placeholder="NPM">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tempat Tanggal lahir<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="ttl_" class="form-control" id="ttl_" placeholder="Contoh: Bogor, 16 Mei 1996">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor Handphone<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_hp_" class="form-control" id="no_hp_" placeholder="Contoh: 08123456789">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Alamat<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat_" name="alamat_" value="" placeholder="Masukkan Alamat Lengkap" required>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="email" name="email_" class="form-control" id="email_" placeholder="Contoh: google@gmail.com" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="confirm_update()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>