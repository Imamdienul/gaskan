<div class="container-fluid px-4">
    <h1 class="mt-4">Rekap Kehadiran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Rekap Kehadiran</li>
    </ol>

    <!-- Keterangan Status -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i> Keterangan Status
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Masuk
                            <span class="badge bg-primary rounded-pill">Absen masuk tepat waktu</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Keluar
                            <span class="badge bg-danger rounded-pill">Hanya absen keluar</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Masuk-Keluar
                            <span class="badge bg-success rounded-pill">Absen masuk dan keluar tepat waktu</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Telat
                            <span class="badge bg-warning text-dark rounded-pill">Absen masuk terlambat</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Telat-Keluar
                            <span class="badge bg-warning text-dark rounded-pill">Absen masuk terlambat dan absen keluar</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Libur 
                            <span class="badge bg-info text-dark rounded-pill">Hari libur</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Data -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i> Filter Data
        </div>
        <div class="card-body">
            <?= form_open('attendance/recap', ['method' => 'get']); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i> Tampilkan
                            </button>
                            <a href="<?= base_url('attendance/export?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
    <!-- Add this section after the Filter Data card and before the Data Kehadiran card -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-trophy me-1"></i> Kejuaraan Kehadiran
        <span class="small ms-2">(<?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date)) ?>)</span>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Top 3 Champions -->
            <div class="col-md-8">
                <h5 class="card-title mb-4">Top 3 Karyawan Terbaik</h5>
                <div class="row">
                    <?php if (!empty($attendance_champions)): ?>
                        <?php foreach ($attendance_champions as $index => $champion): ?>
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <?php if($index === 0): // First place ?>
                                            <div class="display-1 mb-3 text-warning">
                                                <i class="fas fa-crown"></i>
                                            </div>
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon ribbon-top-right ribbon-gold">
                                                    <span>Juara 1</span>
                                                </div>
                                            </div>
                                        <?php elseif($index === 1): // Second place ?>
                                            <div class="display-1 mb-3 text-secondary">
                                                <i class="fas fa-medal"></i>
                                            </div>
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon ribbon-top-right ribbon-silver">
                                                    <span>Juara 2</span>
                                                </div>
                                            </div>
                                        <?php else: // Third place ?>
                                            <div class="display-1 mb-3 text-dark-orange">
                                                <i class="fas fa-award"></i>
                                            </div>
                                            <div class="ribbon-wrapper">
                                                <div class="ribbon ribbon-top-right ribbon-bronze">
                                                    <span>Juara 3</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <h5 class="card-title"><?= strtoupper($champion['nama_user']) ?></h5>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $champion['percentage'] ?>%"
                                                aria-valuenow="<?= $champion['percentage'] ?>" aria-valuemin="0" aria-valuemax="100">
                                                <?= $champion['percentage'] ?>%
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            <span class="text-success fw-bold"><?= $champion['perfect_days'] ?></span> dari 
                                            <span class="fw-bold"><?= $champion['working_days'] ?></span> hari kerja
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                Belum ada data kehadiran yang cukup untuk menentukan juara.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Frequently Late Employee -->
            <div class="col-md-4">
                <h5 class="card-title mb-4">Karyawan Sering Terlambat</h5>
                <?php if (!empty($frequently_late)): ?>
                    <div class="card h-100 border-0 shadow-sm bg-light">
                        <div class="card-body text-center">
                            <div class="display-1 mb-3 text-danger">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <h5 class="card-title"><?= strtoupper($frequently_late['nama_user']) ?></h5>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-danger" role="progressbar" 
                                    style="width: <?= $frequently_late['late_percentage'] ?>%"
                                    aria-valuenow="<?= $frequently_late['late_percentage'] ?>" 
                                    aria-valuemin="0" aria-valuemax="100">
                                    <?= $frequently_late['late_percentage'] ?>%
                                </div>
                            </div>
                            <p class="card-text">
                                Terlambat <span class="text-danger fw-bold"><?= $frequently_late['late_days'] ?></span> dari 
                                <span class="fw-bold"><?= $frequently_late['working_days'] ?></span> hari kerja
                            </p>
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Mohon tingkatkan kedisiplinan waktu
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-1"></i>
                        Tidak ada karyawan yang sering terlambat. Selamat!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

    <!-- Data Kehadiran -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Data Kehadiran
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display nowrap" id="attendance-table">
                    <thead class="table-light">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">No</th>
                            <th rowspan="2" class="align-middle text-center">Nama</th>
                            <?php foreach ($dates as $date): ?>
                                <th class="text-center"><?= $date->format('Y-m-d') ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= strtoupper($user['nama_user']) ?></td>
                                <?php foreach ($dates as $date): ?>
                                    <?php 
                                        $formatted_date = $date->format('Y-m-d'); 
                                        $attendance_data = $attendance_matrix[$user['id_user']][$formatted_date];
                                        $status = is_array($attendance_data) ? $attendance_data['status'] : $attendance_data;
                                        $times = is_array($attendance_data) ? ($attendance_data['times'] ?? []) : [];
                                    ?>
                                    <td class="text-center">
                                        <?php if ($status == 'masuk'): ?>
                                            <span class="badge bg-primary">masuk</span>
                                            <?php if (!empty($times['masuk'])): ?>
                                                <div class="small mt-1"><?= $times['masuk'] ?></div>
                                            <?php endif; ?>
                                        <?php elseif ($status == 'keluar'): ?>
                                            <span class="badge bg-danger">keluar</span>
                                            <?php if (!empty($times['keluar'])): ?>
                                                <div class="small mt-1"><?= $times['keluar'] ?></div>
                                            <?php endif; ?>
                                        <?php elseif ($status == 'masuk-keluar'): ?>
                                            <span class="badge bg-success">masuk-keluar</span>
                                            <?php if (!empty($times['masuk']) || !empty($times['keluar'])): ?>
                                                <div class="small mt-1">
                                                    <?= !empty($times['masuk']) ? $times['masuk'] : '' ?>
                                                    <?= (!empty($times['masuk']) && !empty($times['keluar'])) ? ' - ' : '' ?>
                                                    <?= !empty($times['keluar']) ? $times['keluar'] : '' ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($status == 'telat'): ?>
                                            <span class="badge bg-warning text-dark">telat</span>
                                            <?php if (!empty($times['telat'])): ?>
                                                <div class="small mt-1"><?= $times['telat'] ?></div>
                                            <?php endif; ?>
                                        <?php elseif ($status == 'telat-keluar'): ?>
                                            <span class="badge bg-warning text-dark">telat-keluar</span>
                                            <?php if (!empty($times['telat']) || !empty($times['keluar'])): ?>
                                                <div class="small mt-1">
                                                    <?= !empty($times['telat']) ? $times['telat'] : '' ?>
                                                    <?= (!empty($times['telat']) && !empty($times['keluar'])) ? ' - ' : '' ?>
                                                    <?= !empty($times['keluar']) ? $times['keluar'] : '' ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($status == 'Libur'): ?>
                                            <span class="badge bg-info text-dark">Libur</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    $(document).ready(function() {
        $('#start_date, #end_date').change(function() {
            if ($('#start_date').val() && $('#end_date').val()) {
                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());

                if (startDate > endDate) {
                    alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
                    $('#end_date').val($('#start_date').val());
                }
            }
        });

        if ($.fn.DataTable) {
            $('#attendance-table').DataTable({
                responsive: true,
                scrollX: true,
                paging: true,
                ordering: true,
                searching: true,
                info: true,
                lengthChange: true,
                autoWidth: false
            });
        }
    });
</script>
<style>
/* Ribbon styles */
.ribbon-wrapper {
    width: 85px;
    height: 88px;
    overflow: hidden;
    position: absolute;
    top: -3px;
    right: -3px;
}

.ribbon {
    font: bold 15px sans-serif;
    color: #fff;
    text-align: center;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    position: relative;
    padding: 7px 0;
    left: -5px;
    top: 15px;
    width: 120px;
    -webkit-box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.3);
}

.ribbon:before, .ribbon:after {
    content: "";
    border-top: 3px solid transparent;
    border-left: 3px solid transparent;
    border-right: 3px solid transparent;
    position: absolute;
    bottom: -3px;
}

.ribbon:before {
    left: 0;
}

.ribbon:after {
    right: 0;
}

.ribbon-top-right {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
    left: -21px;
    top: 18px;
}

.ribbon-gold {
    background-color: #FFD700;
    background-image: -webkit-linear-gradient(top, #FFD700, #FFA500);
    background-image: -moz-linear-gradient(top, #FFD700, #FFA500);
    background-image: -ms-linear-gradient(top, #FFD700, #FFA500);
    background-image: -o-linear-gradient(top, #FFD700, #FFA500);
}

.ribbon-silver {
    background-color: #C0C0C0;
    background-image: -webkit-linear-gradient(top, #C0C0C0, #A9A9A9);
    background-image: -moz-linear-gradient(top, #C0C0C0, #A9A9A9);
    background-image: -ms-linear-gradient(top, #C0C0C0, #A9A9A9);
    background-image: -o-linear-gradient(top, #C0C0C0, #A9A9A9);
}

.ribbon-bronze {
    background-color: #CD7F32;
    background-image: -webkit-linear-gradient(top, #CD7F32, #8B4513);
    background-image: -moz-linear-gradient(top, #CD7F32, #8B4513);
    background-image: -ms-linear-gradient(top, #CD7F32, #8B4513);
    background-image: -o-linear-gradient(top, #CD7F32, #8B4513);
}

.text-dark-orange {
    color: #CD7F32 !important;
}

/* Card hover effects */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
