<?php 

foreach ($customers as &$customer) {
    $customer->assignment = $this->Survey_m->get_survey_assignment($customer->id_registrasi_customer);
}


$total = count($customers);
$belum = 0;
$proses = 0;
$selesai = 0;

foreach ($customers as $c) {
    if ($c->status_survey == 'belum') $belum++;
    else if ($c->status_survey == 'proses') $proses++;
    else if ($c->status_survey == 'selesai') $selesai++;
}
?>

<section class="content">

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $total ?></h3>
                    <p>Total Pelanggan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer" id="filter-all">Tampilkan Semua <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3><?= $belum ?></h3>
                    <p>Belum Ditugaskan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <a href="#" class="small-box-footer" id="filter-belum">Tampilkan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $proses ?></h3>
                    <p>Dalam Proses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <a href="#" class="small-box-footer" id="filter-proses">Tampilkan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $selesai ?></h3>
                    <p>Selesai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer" id="filter-selesai">Tampilkan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
 
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-filter"></i> Filter dan Pencarian</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status Survey:</label>
                        <select class="form-control" id="status-filter">
                            <option value="">Semua Status</option>
                            <option value="belum">Belum Ditugaskan</option>
                            <option value="proses">Sedang Diproses</option>
                            <option value="selesai">Selesai Survey</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Layanan:</label>
                        <select class="form-control" id="layanan-filter">
                            <option value="">Semua Layanan</option>
                            <?php 
                            $layanan_list = [];
                            foreach ($customers as $c) {
                                if (!in_array($c->jenis_layanan, $layanan_list) && !empty($c->jenis_layanan)) {
                                    $layanan_list[] = $c->jenis_layanan;
                                    echo '<option value="' . htmlspecialchars($c->jenis_layanan) . '">' . htmlspecialchars($c->jenis_layanan) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kecamatan:</label>
                        <select class="form-control" id="kecamatan-filter">
                            <option value="">Semua Kecamatan</option>
                            <?php 
                            $kecamatan_list = [];
                            foreach ($customers as $c) {
                                if (!in_array($c->kecamatan, $kecamatan_list) && !empty($c->kecamatan)) {
                                    $kecamatan_list[] = $c->kecamatan;
                                    echo '<option value="' . htmlspecialchars($c->kecamatan) . '">' . htmlspecialchars($c->kecamatan) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bandwidth:</label>
                        <select class="form-control" id="bandwidth-filter">
                            <option value="">Semua Bandwidth</option>
                            <?php 
                            $bandwidth_list = [];
                            foreach ($customers as $c) {
                                if (!in_array($c->bandwidth, $bandwidth_list) && !empty($c->bandwidth)) {
                                    $bandwidth_list[] = $c->bandwidth;
                                    echo '<option value="' . htmlspecialchars($c->bandwidth) . '">' . htmlspecialchars($c->bandwidth) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teknisi:</label>
                        <select class="form-control" id="teknisi-filter">
                            <option value="">Semua Teknisi</option>
                            <?php foreach ($teknisi as $t) : ?>
                                <option value="<?= $t->id_user ?>"><?= htmlspecialchars($t->nama_user) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cari:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-input" placeholder="Cari nama, nomor registrasi, atau alamat...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="search-btn"><i class="fas fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mt-2">
                    <button class="btn btn-danger" id="reset-filter"><i class="fas fa-sync"></i> Reset Filter</button>
                    <button class="btn btn-success" id="bulk-assign" data-toggle="modal" data-target="#bulkAssignModal"><i class="fas fa-users-cog"></i> Assign Massal</button>
                    <button class="btn btn-info" id="export-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pelanggan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr class="bg-primary">
                        <th width="3%"><input type="checkbox" id="select-all"></th>
                        <th width="3%">#</th>
                        <th>Nomor Registrasi</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Layanan</th>
                        <th>Bandwidth</th>
                        <th>Alamat Pemasangan</th>
                        <th width="12%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($customers as $customer) : 
                        $assignment = $customer->assignment;
                        $status_badge = '';
                        $row_class = '';
                        
                        if ($customer->status_survey == 'belum') {
                            $status_badge = '<span class="badge badge-secondary">Belum Ditugaskan</span>';
                            $row_class = 'table-secondary';
                        } else if ($customer->status_survey == 'proses') {
                            $status_badge = '<span class="badge badge-warning">Sedang Diproses</span>';
                            $row_class = 'table-warning';
                        } else if ($customer->status_survey == 'selesai') {
                            $status_badge = '<span class="badge badge-success">Selesai Survey</span>';
                            $row_class = 'table-success';
                        }
                    ?>
                    <tr class="<?= $row_class ?>" data-status="<?= $customer->status_survey ?>" 
                        data-layanan="<?= htmlspecialchars($customer->jenis_layanan) ?>"
                        data-kecamatan="<?= htmlspecialchars($customer->kecamatan) ?>"
                        data-bandwidth="<?= htmlspecialchars($customer->bandwidth) ?>"
                        data-teknisi="<?= !empty($assignment) ? $assignment->id_teknisi : '' ?>">
                        <td>
                            <?php if ($customer->status_survey == 'belum') : ?>
                            <input type="checkbox" class="customer-checkbox" value="<?= $customer->id_registrasi_customer ?>">
                            <?php endif; ?>
                        </td>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($customer->nomor_registrasi) ?></td>
                        <td><?= htmlspecialchars($customer->nama_lengkap) ?></td>
                        <td><?= htmlspecialchars($customer->jenis_layanan) ?></td>
                        <td><?= htmlspecialchars($customer->bandwidth) ?></td>
                        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                            <?= htmlspecialchars($customer->alamat_pemasangan) ?>, <?= htmlspecialchars($customer->desa) ?>, <?= htmlspecialchars($customer->kecamatan) ?>
                        </td>
                        <td class="text-center"><?= $status_badge ?></td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#statusModal<?= $customer->id_registrasi_customer ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <?php if ($customer->status_survey != 'selesai') : ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignModal<?= $customer->id_registrasi_customer ?>">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                                <?php else : ?>
                                <a href="<?= site_url('survey/detail_survey/' . encrypt_url($customer->id_registrasi_customer)); ?>" class="btn btn-success">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($customer->whatsapp)) : ?>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#waModal<?= $customer->id_registrasi_customer ?>">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="summary">
                        Menampilkan <span id="showing-entries">0</span> dari <span id="total-entries"><?= $total ?></span> pelanggan
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div id="selected-info" class="text-bold text-primary" style="display:none">
                        <i class="fas fa-info-circle"></i> <span id="selected-count">0</span> pelanggan dipilih
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="bulkAssignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('survey/bulk_assign_survey') ?>" method="post" id="bulk-assign-form">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-users-cog"></i> Assign Tugas Survey Massal</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Anda akan menugaskan survey untuk <span id="bulk-assign-count">0</span> pelanggan sekaligus.
                    </div>
                    <div id="selected-customers-container">
                      
                    </div>
                    <div class="form-group">
                        <label>Pilih Teknisi <span class="text-danger">*</span></label>
                        <select name="id_teknisi" class="form-control select2" required>
                            <option value="">- Pilih Teknisi -</option>
                            <?php foreach ($teknisi as $t) : ?>
                            <option value="<?= $t->id_user ?>">
                                <?= htmlspecialchars($t->nama_user) ?> (<?= htmlspecialchars($t->phone_user) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan untuk Teknisi</label>
                        <textarea name="catatan" class="form-control"></textarea>
                    </div>
                  
                    <input type="hidden" name="customer_ids" id="customer-ids-input">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Assign Teknisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php foreach ($customers as $customer) : 
    if (!empty($customer->whatsapp)) : ?>
<div class="modal fade" id="waModal<?= $customer->id_registrasi_customer ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fab fa-whatsapp"></i> Kirim Pesan WhatsApp</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pelanggan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer->nama_lengkap) ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nomor WhatsApp</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($customer->whatsapp) ?>" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Template Pesan:</label>
                    <select class="form-control wa-template-selector" data-target="waMessage<?= $customer->id_registrasi_customer ?>">
                        <option value="default">Informasi Survey</option>
                        <option value="selesai">Survey Selesai</option>
                        <option value="jadwal">Jadwal Kunjungan</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pesan:</label>
                    <textarea id="waMessage<?= $customer->id_registrasi_customer ?>" class="form-control" rows="5"><?= 
                        "Selamat " . (date('H') < 12 ? 'pagi' : (date('H') < 15 ? 'siang' : (date('H') < 18 ? 'sore' : 'malam'))) . " Bapak/Ibu " . 
                        htmlspecialchars($customer->nama_lengkap) . ",\n\nPerkenalkan, kami dari PT. Giandra Saka Media (Gisaka). Kami ingin menginformasikan bahwa status survey pemasangan layanan internet untuk lokasi Anda telah kami proses. Untuk informasi lebih lanjut, bisa menghubungi kami di nomor ini.\n\nTerima kasih atas kepercayaan Anda memilih layanan internet dari Gisaka.\n\nSalam,\nTim Layanan Pelanggan Gisaka" ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" onclick="sendWhatsAppMessage('<?= preg_replace('/^0/', '62', $customer->whatsapp) ?>', 'waMessage<?= $customer->id_registrasi_customer ?>')" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Kirim Pesan
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; endforeach; ?>


<?php foreach ($customers as $customer) : 
    $assignment = $customer->assignment;
    $status_badge = ($customer->status_survey == 'belum') ? '<span class="badge badge-secondary">Belum Ditugaskan</span>' :
                    (($customer->status_survey == 'proses') ? '<span class="badge badge-warning">Sedang Diproses</span>' :
                    '<span class="badge badge-success">Selesai Survey</span>');
?>
<div class="modal fade" id="statusModal<?= $customer->id_registrasi_customer ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle"></i> Status Survey Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th width="30%">Pelanggan</th><td><?= htmlspecialchars($customer->nama_lengkap) ?></td></tr>
                    <tr><th>Status Survey</th><td><?= $status_badge ?></td></tr>
                    <?php if (!empty($assignment)) : ?>
                    <tr><th>Yang Menugaskan</th><td><strong><?= htmlspecialchars($assignment->nama_penugas) ?></strong> </td></tr>
                    <tr><th>Ditugaskan Kepada</th><td><strong><?= htmlspecialchars($assignment->nama_teknisi) ?></strong> (<?= htmlspecialchars($assignment->phone_user) ?>)</td></tr>
                    <tr><th>Tanggal Penugasan</th><td><?= date('d M Y H:i', strtotime($assignment->created_date)) ?></td></tr>
                    <tr>
                        <th>Progress</th>
                        <td>
                            <?php if ($assignment->survey_completed > 0) : ?>
                                <div class="progress progress-xs"><div class="progress-bar bg-success" style="width: 100%"></div></div>
                                <span class="badge badge-success">Selesai</span>
                            <?php else : ?>
                                <div class="progress progress-xs"><div class="progress-bar bg-warning" style="width: 50%"></div></div>
                                <span class="badge badge-warning">Sedang Dikerjakan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php else : ?>
                    <tr><td colspan="2" class="text-center text-muted"><i class="fas fa-info-circle"></i> Belum ada teknisi yang ditugaskan</td></tr>
                    <?php endif; ?>
                </table>
                <div class="form-group mt-3">
                    <label for="customWaMessage<?= $customer->id_registrasi_customer ?>">
                        <i class="fab fa-whatsapp text-success"></i> Pesan WhatsApp :
                    </label>
                    <textarea id="customWaMessage<?= $customer->id_registrasi_customer ?>" data-wa="<?= !empty($customer->whatsapp) ? preg_replace('/^0/', '62', $customer->whatsapp) : '' ?>" class="form-control" rows="3"><?= 
                        "Selamat " . (date('H') < 12 ? 'pagi' : (date('H') < 15 ? 'siang' : (date('H') < 18 ? 'sore' : 'malam'))) . " Bapak/Ibu " . 
                        htmlspecialchars($customer->nama_lengkap) . ",\n\nPerkenalkan, kami dari PT. Giandra Saka Media (Gisaka). Kami ingin menginformasikan bahwa status survey pemasangan layanan internet untuk lokasi Anda telah kami proses. Untuk informasi lebih lanjut, bisa menghubungi kami di nomor ini.\n\nTerima kasih atas kepercayaan Anda memilih layanan internet dari Gisaka.\n\nSalam,\nTim Layanan Pelanggan Gisaka" ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <?php if (!empty($customer->whatsapp)) : ?>
                <button type="button" onclick="sendWhatsAppMessage('<?= preg_replace('/^0/', '62', $customer->whatsapp) ?>', 'customWaMessage<?= $customer->id_registrasi_customer ?>')" class="btn btn-success btn-sm">
                    <i class="fab fa-whatsapp"></i> Kirim
                </button>
                <?php else : ?>
                <span class="text-muted"><i class="fas fa-ban"></i> Tidak ada WA</span>
                <?php endif; ?>

                <?php if ($customer->status_survey == 'selesai') : ?>
                <a href="<?= site_url('survey/detail_survey/' . encrypt_url($customer->id_registrasi_customer)); ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-file-alt"></i> Detail
                </a>
                <a href="<?= base_url() . 'customer/detail_registrasi/' . encrypt_url($customer->id_registrasi_customer) ?>" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Export
                </a>
                <a href="<?= base_url() . 'registrasi/edit/' . encrypt_url($customer->id_registrasi_customer) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <?php endif; ?>

                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="assignModal<?= $customer->id_registrasi_customer ?>" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url('survey/assign_survey') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> <?= empty($assignment) ? 'Assign Teknisi untuk Survey' : 'Edit Penugasan Teknisi Survey' ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_registrasi_customer" value="<?= $customer->id_registrasi_customer ?>">
                    <?php if (!empty($assignment)) : ?>
                    <input type="hidden" name="id_survey_teknisi" value="<?= $assignment->id_survey_teknisi ?>">
                    <input type="hidden" name="is_update" value="1">
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Pelanggan</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($customer->nama_lengkap) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" readonly><?= htmlspecialchars($customer->alamat_pemasangan) ?>, <?= htmlspecialchars($customer->desa) ?>, <?= htmlspecialchars($customer->kecamatan) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?= empty($assignment) ? 'Pilih Teknisi' : 'Ganti Teknisi' ?> <span class="text-danger">*</span></label>
                        <select name="id_teknisi" class="form-control select2" required>
                            <option value="">- Pilih Teknisi -</option>
                            <?php foreach ($teknisi as $t) : ?>
                            <option value="<?= $t->id_user ?>" <?= (!empty($assignment) && $assignment->id_teknisi == $t->id_user) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t->nama_user) ?> (<?= htmlspecialchars($t->phone_user) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan untuk Teknisi</label>
                        <textarea name="catatan" class="form-control"><?= !empty($assignment) ? htmlspecialchars($assignment->catatan) : '' ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= empty($assignment) ? 'save' : 'sync-alt' ?>"></i> 
                        <?= empty($assignment) ? 'Assign Teknisi' : 'Update Penugasan' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
function sendWhatsAppMessage(phoneNumber, messageId) {
    const textarea = document.getElementById(messageId);
    const message = textarea.value;
    
    if (!phoneNumber || !message.trim()) {
        alert("Nomor WhatsApp tidak tersedia atau pesan kosong.");
        return;
    }
    
    const encodedMessage = encodeURIComponent(message);
    const waURL = 'https://wa.me/' + phoneNumber + '?text=' + encodedMessage;
    window.open(waURL, '_blank');
}

$(document).ready(function() {
    // Initialize DataTable with better configuration
    var table = $('#table1').DataTable({
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [0, 6, 7, 8] }
        ],
        order: [[0, 'asc']],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
            infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
            paginate: {
                first: "Pertama",
                previous: "Sebelumnya",
                next: "Selanjutnya",
                last: "Terakhir"
            }
        },
        initComplete: function () {
            updateShowingEntries(this.api());
        },
        drawCallback: function () {
            updateShowingEntries(this.api());
        }
    });

    // Update showing entries info
    function updateShowingEntries(tableInstance) {
        if (!tableInstance || typeof tableInstance.page !== 'function') return;

        var pageInfo = tableInstance.page.info();
        $('#showing-entries').text(`Menampilkan ${pageInfo.start + 1}–${pageInfo.end} dari ${pageInfo.recordsTotal} entri`);
        $('#total-entries').text(pageInfo.recordsTotal);
    }

    // Filter buttons
    $('#filter-all').click(function(e) {
        e.preventDefault();
        $('#status-filter').val('').trigger('change');
    });

    $('#filter-belum').click(function(e) {
        e.preventDefault();
        $('#status-filter').val('belum').trigger('change');
    });

    $('#filter-proses').click(function(e) {
        e.preventDefault();
        $('#status-filter').val('proses').trigger('change');
    });

    $('#filter-selesai').click(function(e) {
        e.preventDefault();
        $('#status-filter').val('selesai').trigger('change');
    });

    // Custom filter function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var row = table.row(dataIndex).node();
        
        // Get filter values
        var status = $('#status-filter').val();
        var layanan = $('#layanan-filter').val();
        var kecamatan = $('#kecamatan-filter').val();
        var bandwidth = $('#bandwidth-filter').val();
        var teknisi = $('#teknisi-filter').val();
        var search = $('#search-input').val().toLowerCase();

        // Get row data attributes
        var rowStatus = $(row).data('status');
        var rowLayanan = $(row).data('layanan');
        var rowKecamatan = $(row).data('kecamatan');
        var rowBandwidth = $(row).data('bandwidth');
        var rowTeknisi = $(row).data('teknisi');

        // Apply filters
        if (status && rowStatus !== status) return false;
        if (layanan && rowLayanan !== layanan) return false;
        if (kecamatan && rowKecamatan !== kecamatan) return false;
        if (bandwidth && rowBandwidth !== bandwidth) return false;
        if (teknisi && rowTeknisi !== teknisi) return false;

        // Apply search
        if (search) {
            var rowData = data[2] + ' ' + data[3] + ' ' + data[6]; 
            if (rowData.toLowerCase().indexOf(search) === -1) return false;
        }
        
        return true;
    });

    // Filter change events
    $('#status-filter, #layanan-filter, #kecamatan-filter, #bandwidth-filter, #teknisi-filter').change(function() {
        table.draw();
    });

    // Search functionality
    $('#search-btn').click(function() {
        table.draw();
    });

    $('#search-input').keypress(function(e) {
        if (e.which === 13) {
            table.draw();
        }
    });

    // Reset all filters
    $('#reset-filter').click(function() {
        $('#status-filter, #layanan-filter, #kecamatan-filter, #bandwidth-filter, #teknisi-filter').val('');
        $('#search-input').val('');
        table.draw();
    });

    // Select all functionality
    $('#select-all').click(function() {
        $('.customer-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    // Individual checkbox handling
    $(document).on('change', '.customer-checkbox', function() {
        updateSelectedCount();
        
        $('#select-all').prop('checked', 
            $('.customer-checkbox:checked').length === $('.customer-checkbox').length);
    });

    // Update selected count display
    function updateSelectedCount() {
        var count = $('.customer-checkbox:checked').length;
        $('#selected-count').text(count);
        $('#bulk-assign-count').text(count);
        
        $('#selected-info').toggle(count > 0);
    }

    // Bulk assign modal preparation
    $('#bulk-assign').click(function() {
        var selectedIds = [];
        var selectedNames = [];
        
        $('.customer-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
            var customerName = $(this).closest('tr').find('td:eq(3)').text().trim();
            selectedNames.push(customerName);
        });
        
        if (selectedIds.length === 0) {
            alert('Pilih pelanggan terlebih dahulu!');
            return false;
        }
        
        $('#customer-ids-input').val(selectedIds.join(','));
        
        var customerList = '<div class="alert alert-light">';
        customerList += '<p class="mb-1"><strong>Pelanggan yang akan ditugaskan:</strong></p>';
        customerList += '<ol>';
        
        for (var i = 0; i < selectedNames.length; i++) {
            customerList += '<li>' + selectedNames[i] + '</li>';
            if (i >= 4 && selectedNames.length > 6) {
                customerList += '<li>Dan ' + (selectedNames.length - 5) + ' pelanggan lainnya</li>';
                break;
            }
        }
        
        customerList += '</ol></div>';
        $('#selected-customers-container').html(customerList);
    });

    // WhatsApp template selector
    $('.wa-template-selector').change(function() {
        var targetId = $(this).data('target');
        var customerId = targetId.replace('waMessage', '');
        var customerName = $('#waModal' + customerId + ' .form-control').first().val();
        var selected = $(this).val();
        var message = '';
        
        var hours = new Date().getHours();
        var greeting = "Selamat " + 
            (hours < 12 ? 'pagi' : 
            (hours < 15 ? 'siang' : 
            (hours < 18 ? 'sore' : 'malam')));
        
        switch(selected) {
            case 'default':
                message = greeting + " Bapak/Ibu " + customerName + ",\n\n" +
                    "Perkenalkan, kami dari PT. Giandra Saka Media (Gisaka). " +
                    "Kami ingin menginformasikan bahwa status survey pemasangan layanan internet " +
                    "untuk lokasi Anda telah kami proses. Untuk informasi lebih lanjut, " +
                    "bisa menghubungi kami di nomor ini.\n\n" +
                    "Terima kasih atas kepercayaan Anda memilih layanan internet dari Gisaka.\n\n" +
                    "Salam,\nTim Layanan Pelanggan Gisaka";
                break;
                
            case 'selesai':
                message = greeting + " Bapak/Ibu " + customerName + ",\n\n" +
                    "Kami dari PT. Giandra Saka Media (Gisaka) ingin menginformasikan bahwa " +
                    "survey untuk pemasangan layanan internet di lokasi Anda telah selesai dilakukan. " +
                    "Selanjutnya kami akan memproses instalasi perangkat.\n\n" +
                    "Untuk informasi lebih lanjut, silakan hubungi kami di nomor ini.\n\n" +
                    "Terima kasih,\nTim Layanan Pelanggan Gisaka";
                break;
                
            case 'jadwal':
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                var date = tomorrow.getDate() + '/' + (tomorrow.getMonth() + 1) + '/' + tomorrow.getFullYear();
                
                message = greeting + " Bapak/Ibu " + customerName + ",\n\n" +
                    "Kami dari PT. Giandra Saka Media (Gisaka) ingin menginformasikan bahwa " +
                    "teknisi kami akan melakukan survey ke lokasi Anda pada tanggal " + date + ". " +
                    "Mohon ketersediaannya di lokasi pemasangan.\n\n" +
                    "Untuk konfirmasi atau informasi lebih lanjut, silakan hubungi kami di nomor ini.\n\n" +
                    "Terima kasih,\nTim Layanan Pelanggan Gisaka";
                break;
                
            case 'custom':
                message = "";
                break;
        }
        
        $('#' + targetId).val(message);
    });

    // Export Excel with current filters
    $('#export-excel').click(function() {
        var status = $('#status-filter').val() || '';
        var layanan = $('#layanan-filter').val() || '';
        var kecamatan = $('#kecamatan-filter').val() || '';
        var bandwidth = $('#bandwidth-filter').val() || '';
        var teknisi = $('#teknisi-filter').val() || '';
        var search = $('#search-input').val() || '';
        
        var baseUrl = '<?= site_url("survey/export_excel") ?>';
        var url = baseUrl + 
            '?status=' + encodeURIComponent(status) +
            '&layanan=' + encodeURIComponent(layanan) +
            '&kecamatan=' + encodeURIComponent(kecamatan) +
            '&bandwidth=' + encodeURIComponent(bandwidth) +
            '&teknisi=' + encodeURIComponent(teknisi) +
            '&search=' + encodeURIComponent(search);
        
        window.location.href = url;
    });
});
</script>
