<section class="content">
    <form method="post" action="<?= site_url('router/add') ?>">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Tambah Router</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Nama Router</label>
                    <input type="text" name="nama_router" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>IP Publik</label>
                    <input type="text" name="ip_public" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Port</label>
                    <input type="number" name="port" class="form-control" value="8728">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('router') ?>" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </form>
</section>
