
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Router Mikrotik</h3>
                        </div>
                        <form action="<?= base_url('router/add') ?>" method="post">
                            <div class="card-body">
                                <?php if (validation_errors()) : ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        <?= validation_errors() ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="form-group">
                                    <label for="nama">Nama Router</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama router" value="<?= set_value('nama') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Masukkan IP Address" value="<?= set_value('ip_address') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= set_value('username') ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                </div>
                                
                                <div class="form-group">
                                    <label for="port">Port</label>
                                    <input type="number" class="form-control" id="port" name="port" placeholder="Masukkan port (default: 3799)" value="<?= set_value('port', '3799') ?>">
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="<?= base_url('router') ?>" class="btn btn-default">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>