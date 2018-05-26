<?php $this->load->view('layouts/base_start') ?>

<div class="container">
  <legend>Data Kamera</legend>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <table class="table table-striped">
      <thead>
        <th>No</th>
        <th>Nama</th>
        <th>
          <a class="btn btn-primary" href="<?php echo site_url('kamera/create') ?>">
            Tambah
          </a>
        </th>
      </thead>
      <tbody>
        <?php $number = 1; foreach($kamera as $row) { ?>
        <tr>
          <td>
            <a href="<?php echo site_url('kamera/show/'.$row->id) ?>">
              <?php echo $number++ ?>
            </a>
          </td>
          <td>
            <a href="<?php echo site_url('kamera/show/'.$row->id) ?>">
              <?php echo $row->nama ?>
            </a>
          </td>
          <td>
            <?php echo form_open('kamera/destroy/'.$row->id)  ?>
            <a class="btn btn-info" href="<?php echo site_url('kamera/edit/'.$row->id) ?>">
              Ubah
            </a>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
            <?php echo form_close() ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php $this->load->view('layouts/base_end') ?>