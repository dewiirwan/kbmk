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
                            <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="kelas" class="col-sm-2 control-label">Kelas<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="kelas" class="form-control" id="kelas" placeholder="Kelas">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">NPM<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="number" name="npm" class="form-control" id="npm" placeholder="Contoh: 5341421">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label class="col-sm-2 control-label">No. Telp (WA)<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="number" name="no_telp" class="form-control" id="no_telp" placeholder="Contoh: 08164862346">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fakultas<span class="text-danger">*</span> :</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="fakultas" name="fakultas" value="" placeholder="Contoh: Teknologi Industri" required>
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="jurusan" class="col-sm-2 control-label">Jurusan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="text" name="jurusan" class="form-control" id="jurusan" placeholder="Contoh: Teknik Informatika" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="semester" class="col-sm-2 control-label">Semester<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="number" name="semester" class="form-control" id="semester" placeholder="Contoh: 8" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                            <label for="tahun_angkatan" class="col-sm-2 control-label">Tahun Angkatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input type="number" name="tahun_angkatan" class="form-control" id="tahun_angkatan" placeholder="Contoh: 2018" required="required">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="region" class="col-sm-2 control-label">Region Kampus<span class="text-danger">*</span> :</label>
                            <div class="col-sm-10">
                                <select name="region" class="form-control" id="region">
                                    <option value="">Pilih Region</option>
                                    <option value="Depok">Depok</option>
                                    <option value="Cengkareng">Cengkareng</option>
                                    <option value="Bekasi">Bekasi</option>
                                    <option value="Karawaci">Karawaci</option>
                                    <option value="Salemba">Salemba</option>
                                </select>
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