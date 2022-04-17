<!-- Modal -->
<div class="modal fade" data-backdrop="false" id="m_tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_tambah" action="#" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah </h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama_kegiatan" class="col-sm-2 control-label">Nama Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="tgl_kegiatan" class="col-sm-2 control-label">Tanggal Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="tgl_kegiatan" class="form-control" id="tgl_kegiatan" placeholder="Tanggal Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Pengkhotbah<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" name="pengkhotbah" class="form-control" id="pengkhotbah" placeholder="Contoh: Js. We Ok Tian">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label class="col-sm-2 control-label">Durasi Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" name="durasi" class="form-control" id="durasi" placeholder="Contoh: 2 Jam 30 Menit">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ketua Pelaksana<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="ketuplak" name="ketuplak" value="" placeholder="Contoh: Dewi" required>
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="kapasitas" class="col-sm-2 control-label">Kapasitas Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="number" name="kapasitas" class="form-control" id="kapasitas" placeholder="Contoh: 20" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bukti SWAB<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="bukti_swab" id="bukti_swab">
                                    <option value="YA">YA</option>
                                    <option value="OPTIONAL">OPTIONAL</option>
                                </select>
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="deskripsi" class="col-sm-2 control-label">Deskripsi<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Contoh: Kegiatan ini..." required="required"></textarea>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="confirm_save()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="false" id="m_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" action="#" id="form_edit" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" name="id_kegiatan" id="id_kegiatan">
                        <div class="form-group">
                            <label for="nama_kegiatan_" class="col-sm-2 control-label">Nama Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="nama_kegiatan_" class="form-control" id="nama_kegiatan_" placeholder="Nama Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="tgl_kegiatan_" class="col-sm-2 control-label">Tanggal Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="tgl_kegiatan_" class="form-control" id="tgl_kegiatan_" placeholder="Tanggal Kegiatan">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Pengkhotbah<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" name="pengkhotbah_" class="form-control" id="pengkhotbah_" placeholder="Contoh: Js. We Ok Tian">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label class="col-sm-2 control-label">Durasi Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" name="durasi_" class="form-control" id="durasi_" placeholder="Contoh: 2 Jam 30 Menit">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ketua Pelaksana<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="ketuplak_" name="ketuplak_" value="" placeholder="Contoh: Dewi" required>
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="kapasitas_" class="col-sm-2 control-label">Kapasitas Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="number" name="kapasitas_" class="form-control" id="kapasitas_" placeholder="Contoh: 20" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bukti SWAB<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="bukti_swab_" id="bukti_swab_">
                                    <option value="YA">YA</option>
                                    <option value="OPTIONAL">OPTIONAL</option>
                                </select>
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="deskripsi_" class="col-sm-2 control-label">Deskripsi<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <textarea name="deskripsi_" class="form-control" id="deskripsi_" placeholder="Contoh: Kegiatan ini..." required="required"></textarea>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="confirm_update()">Simpan</button>
            </div>
        </div>
    </div>
</div>