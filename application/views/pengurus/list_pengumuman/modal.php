<!-- Modal -->
<div class="modal inmodal fade" id="m_tambah" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Pengumuman di KBMK Gunadarma</h4>
            </div>
            <div class="form-horizontal">
                <form class="form-horizontal" action="#" id="form_tambah" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="judul" class="col-sm-3 control-label">Judul<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="headline_berita" class="col-sm-3 control-label">Headline Berita<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <textarea name="headline_berita" class="form-control" id="headline_berita" placeholder="Contoh: Daftarkan diri anda, simak dialognya, dan dapatkan kesempatan menangkan hadiah angpao hingga ratusan ribu rupiah* (s&k berlaku)"></textarea>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Isi berita<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="isi_berita" class="form-control" id="isi_berita" placeholder="Contoh: Dalam rangka memperingati HUT ke-98 Majelis Tinggi Agama Khonghucu Indonesia (MATAKIN), kami mengundang Anda untuk bergabung dalam “Dialog Islam-Khonghucu” dengan tema “Tuhan dan Ketuhanan dalam Perspektif Islam dan Khonghucu">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Posting<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="tgl_posting" class="form-control" id="tgl_posting" placeholder="Contoh: mm/dd/yyyy">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="col-sm-3 control-label">Keterangan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Contoh: Harap menaati Protokol Kesehatan" required="required">
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
                        <input type="hidden" name="id_pengumuman" id="id_pengumuman">
                        <div class="form-group">
                            <label for="judul_" class="col-sm-3 control-label">Judul<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="judul_" class="form-control" id="judul_" placeholder="Judul">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="headline_berita_" class="col-sm-3 control-label">Headline Berita<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <textarea name="headline_berita_" class="form-control" id="headline_berita_" placeholder="Contoh: Daftarkan diri anda, simak dialognya, dan dapatkan kesempatan menangkan hadiah angpao hingga ratusan ribu rupiah* (s&k berlaku)"></textarea>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Isi berita<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="isi_berita_" class="form-control" id="isi_berita_" placeholder="Contoh: Dalam rangka memperingati HUT ke-98 Majelis Tinggi Agama Khonghucu Indonesia (MATAKIN), kami mengundang Anda untuk bergabung dalam “Dialog Islam-Khonghucu” dengan tema “Tuhan dan Ketuhanan dalam Perspektif Islam dan Khonghucu">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Posting<span class="text-danger">*</span> :</label>
                            <div class="col-lg-9">
                                <input type="text" name="tgl_posting_" class="form-control" id="tgl_posting_" placeholder="Contoh: mm/dd/yyyy">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan_" class="col-sm-3 control-label">Keterangan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <input type="text" name="keterangan_" class="form-control" id="keterangan_" placeholder="Contoh: Harap menaati Protokol Kesehatan" required="required">
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