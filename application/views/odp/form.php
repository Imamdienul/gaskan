
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= isset($odp) ? 'Edit Data ODP' : 'Tambah ODP Baru' ?></h3>
                        </div>
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible m-3">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                <?= validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= isset($odp) ? base_url('odp/edit/'.$odp->id_odp) : base_url('odp/add') ?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_odp">Nama ODP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_odp" name="nama_odp" placeholder="Masukkan nama ODP" value="<?= isset($odp) ? $odp->nama_odp : set_value('nama_odp') ?>" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kapasitas">Kapasitas <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="kapasitas" name="kapasitas" placeholder="Masukkan kapasitas ODP" value="<?= isset($odp) ? $odp->kapasitas : set_value('kapasitas') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="terpakai">Terpakai <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="terpakai" name="terpakai" placeholder="Masukkan jumlah terpakai" value="<?= isset($odp) ? $odp->terpakai : set_value('terpakai', 0) ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_wilayah">Wilayah <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="id_wilayah" name="id_wilayah" required>
                                        <option value="">Pilih Wilayah</option>
                                        <?php foreach ($wilayah as $w): ?>
                                            <option value="<?= $w->id_wilayah ?>" <?= (isset($odp) && $odp->id_wilayah == $w->id_wilayah) ? 'selected' : (set_value('id_wilayah') == $w->id_wilayah ? 'selected' : '') ?>>
                                                <?= $w->nama_wilayah ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"><?= isset($odp) ? $odp->alamat : set_value('alamat') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Masukkan latitude" value="<?= isset($odp) ? $odp->latitude : set_value('latitude') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Masukkan longitude" value="<?= isset($odp) ? $odp->longitude : set_value('longitude') ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div id="map" style="height: 400px;"></div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                <a href="<?= base_url('odp') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Leaflet map implementation
    var map = L.map('map').setView([-6.2088, 106.8456], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    var marker;
    
    <?php if (isset($odp) && $odp->latitude && $odp->longitude): ?>
        var lat = <?= $odp->latitude ?>;
        var lng = <?= $odp->longitude ?>;
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 15);
    <?php endif; ?>
    
    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        
        marker = L.marker(e.latlng).addTo(map);
        
        $('#latitude').val(e.latlng.lat);
        $('#longitude').val(e.latlng.lng);
    });
});
</script>