<form id="validasi" action="<?= $form_action; ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control input-sm required" id="judul" name="judul" value="<?= $main->judul; ?>" placeholder="Judul"  <?= jecho($main->kirim, true, 'disabled')?>/>
        </div>

        <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="text" class="form-control input-sm required" id="tahun" name="tahun" value="<?= $main->tahun; ?>" placeholder="Tahun"  <?= jecho($main->kirim, true, 'disabled')?>/>
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>
            <select class="form-control input-sm select2 required" id="semester" name="semester" <?= jecho($main->kirim, true, 'disabled')?>>
                <option value="1" <?= selected(1, $main->semester); ?>>1</option>
                <option value="2" <?= selected(2, $main->semester); ?>>2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="file" >File : <code>(.pdf)</code></label>
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="file_path" name="satuan">
                <input type="file" class="hidden <?= jecho($main, false, 'required'); ?>" id="file" name="nama_file" accept=".pdf" />
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-search"></i> Browse</button>
                </span>
            </div>
            <span class="help-block"><code>Kosongkan jika tidak ingin mengubah dokumen. Ukuran maksimal <strong><?= max_upload() ?> MB</strong>.</code></span>
        </div>
    </div>

    <div class="modal-footer">
        <button type="reset" class="btn btn-social btn-flat btn-danger btn-sm pull-left"><i class="fa fa-times"></i> Batal</button>
        <button type="submit" class="btn btn-social btn-flat btn-info btn-sm" id="aksi"><i class="fa fa-check"></i> Simpan</button>
    </div>
</form>
<?php $this->load->view('global/validasi_form'); ?>
