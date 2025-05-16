<!-- application/views/router/index.php -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Router</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Router</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Router</h3>
                <div class="card-tools">
                    <a href="<?= site_url('router/add') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Router
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-router">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Router</th>
                                <th>IP Public</th>
                                <th>Username</th>
                                <th>Port</th>
                                <th>Status</th>
                                <th>Info</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($routers as $router): ?>
                            <?php 
                                // Cek koneksi untuk setiap router
                                $CI =& get_instance();
                                $CI->load->library('mikrotik');
                                $API = $CI->mikrotik;
                                $status = 'Down';
                                $cpu = '-';
                                $ram = '-';
                                
                                if ($API->connect($router->ip_public, $router->username, $router->password, $router->port)) {
                                    $status = 'Up';
                                    // Ambil resource info
                                    $resource = $API->comm('/system/resource/print');
                                    if (!empty($resource)) {
                                        $cpu = $resource[0]['cpu-load'] . '%';
                                        $free_memory = $resource[0]['free-memory'];
                                        $total_memory = $resource[0]['total-memory'];
                                        $ram = round((($total_memory - $free_memory) / $total_memory) * 100, 2) . '%';
                                    }
                                    $API->disconnect();
                                }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $router->nama_router ?></td>
                                <td><?= $router->ip_public ?></td>
                                <td><?= $router->username ?></td>
                                <td><?= $router->port ?></td>
                                <td>
                                    <?php if ($status == 'Up'): ?>
                                        <span class="badge badge-success">Online</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Offline</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($status == 'Up'): ?>
                                        <small>CPU: <?= $cpu ?> | RAM: <?= $ram ?></small>
                                    <?php else: ?>
                                        <small>-</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('router/detail/'.$router->id) ?>" class="btn btn-info btn-xs">
                                        <i class="fas fa-chart-line"></i> Monitor
                                    </a>
                                    <a href="<?= site_url('router/edit/'.$router->id) ?>" class="btn btn-warning btn-xs">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('#table-router').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 10,
        "language": {
            "search": "Cari:",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(disaring dari _MAX_ total data)"
        }
    });
    
    // Refresh halaman setiap 5 menit untuk update status
    setTimeout(function(){
        location.reload();
    }, 300000);
});
</script>