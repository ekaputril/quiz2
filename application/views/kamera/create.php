<?php $this->load->view('layout/base_start') ?>

<div class="container">
  <legend>Tambah Data Kamera</legend>
  <div class="col-xs-12 col-sm-12 col-md-12">
  <?php echo form_open_multipart('kamera/store'); ?>

    <div class="form-group">
      <label for="Nama">Nama Kamera</label>
      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Kamera"
    value="<?php echo set_value('nama'); ?>">  
    </div>
  <div class="form-group">
    <label for="Foto">Foto</label>
    <input type="file" name="foto" size="20" value="<?php echo set_value('foto'); ?>">
  </div>
  <div class="form-group">
    <label for="Jenis">Jenis Kamera</label>
    <select class="form-control" id="jenis" name="jenis">
    
    <?php foreach($data as $row) { ?>
      <option value="<?php echo $row->id_jenis ?>"><?php echo $row->jenis ?></option>
    <?php } ?>
    
    </select>
  </div>

  <?php echo $error; ?>    

  <a class="btn btn-info" href="<?php echo site_url('kamera/') ?>">Kembali</a>
    <button type="submit" class="btn btn-primary">OK</button>
  <?php echo form_close() ?>
  </div>
</div>

<?php $this->load->view('layout/base_end') ?>