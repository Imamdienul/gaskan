<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Detail Router: <?= $router->nama_router ?></h3>
            <a href="<?= site_url('router') ?>" class="btn btn-default btn-sm pull-right">Kembali</a>
        </div>
        <div class="box-body">
            <p><strong>Status:</strong> <?= $status == 'Up' ? '<span class="label label-success">Online</span>' : '<span class="label label-danger">Offline</span>' ?></p>

            <?php if ($status == 'Up'): ?>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Hostname:</strong> <?= $monitor['identity'] ?></li>
                    <li class="list-group-item"><strong>Uptime:</strong> <?= $monitor['uptime'] ?></li>
                    <li class="list-group-item"><strong>CPU Usage:</strong> <?= $monitor['cpu_load'] ?>%</li>
                    <li class="list-group-item"><strong>RAM Usage:</strong> <?= $monitor['ram_usage'] ?>%</li>
                    <li class="list-group-item"><strong>Traffic RX:</strong> <?= $monitor['rx'] ?> KB/s</li>
                    <li class="list-group-item"><strong>Traffic TX:</strong> <?= $monitor['tx'] ?> KB/s</li>
                </ul>
            <?php else: ?>
                <div class="alert alert-danger">Tidak bisa terkoneksi ke router.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
