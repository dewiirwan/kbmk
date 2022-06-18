<!-- Modal -->
<div class="modal inmodal fade" id="m_tambah" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Jadwal di KBMK Gunadarma</h4>
            </div>
            <div class="form-horizontal">
                <form class="form-horizontal" action="#" id="form_tambah" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kegiatan" class="col-sm-3 control-label">Nama Kegiatan<span class="text-danger">*</span> :</label>
                            <div class="col-sm-9">
                                <select name="nama_kegiatan" class="form-control" id="nama_kegiatan">
                                    <option value=''>- Pilih Kegiatan -</option>
                                    <?php foreach ($Kegiatan_list_jadwal as $kegiatan_list) {
                                        echo '<option value="' . $kegiatan_list->id_kegiatan . '">' . $kegiatan_list->nama_kegiatan . ' - ' . $kegiatan_list->tgl_kegiatan . ' - Jumlah Slot: ' . $kegiatan_list->jml_slot . '</option>';
                                    } ?>
                                </select>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kapasitas Kegiatan</label>
                            <div class="col-lg-9">
                                <input type="number" min="1" class="form-control qty" name="kapasitas_kegiatan" id="kapasitas_kegiatan" disabled />
                            </div>
                        </div>
                    </div>

                    <div id="alert-msg"></div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button>
                    <button type="submit" id="btn_simpan" class="btn btn-primary" onclick="confirm_save()"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>