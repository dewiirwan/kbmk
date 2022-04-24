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
                            <label for="nama_kegiatan" class="col-sm-3 control-label">Nama Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_kegiatan" class="col-sm-3 control-label">Tanggal Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan" placeholder="Tanggal Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Pengkhotbah<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="pengkhotbah" class="form-control" id="pengkhotbah" placeholder="Contoh: Js. We Ok Tian">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Durasi Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="durasi" class="form-control" id="durasi" placeholder="Contoh: 3 Jam 30 Menit">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ketua Pelaksana<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="ketuplak" name="ketuplak" value="" placeholder="Contoh: Dewi" required>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas" class="col-sm-3 control-label">Kapasitas Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="kapasitas" class="form-control" id="kapasitas" placeholder="Contoh: 20" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="col-sm-3 control-label">Deskripsi<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Contoh: Kegiatan ini..." required="required"></textarea>
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
                        <input type="hidden" name="id_kegiatan" id="id_kegiatan">
                        <div class="form-group">
                            <label for="nama_kegiatan_" class="col-sm-3 control-label">Nama Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_kegiatan_" class="form-control" id="nama_kegiatan_" placeholder="Nama Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_kegiatan_" class="col-sm-3 control-label">Tanggal Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="tgl_kegiatan_" class="form-control" id="tgl_kegiatan_" placeholder="Tanggal Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Pengkhotbah<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="pengkhotbah_" class="form-control" id="pengkhotbah_" placeholder="Contoh: Js. We Ok Tian">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Durasi Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="durasi_" class="form-control" id="durasi_" placeholder="Contoh: 2 Jam 30 Menit">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ketua Pelaksana<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="ketuplak_" name="ketuplak_" value="" placeholder="Contoh: Dewi" required>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas_" class="col-sm-3 control-label">Kapasitas Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="number" name="kapasitas_" class="form-control" id="kapasitas_" placeholder="Contoh: 20" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_" class="col-sm-3 control-label">Deskripsi<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <textarea name="deskripsi_" class="form-control" id="deskripsi_" placeholder="Contoh: Kegiatan ini..." required="required"></textarea>
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