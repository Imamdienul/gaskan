
    
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar PPPoE User</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                                    <i class="fas fa-plus"></i> Tambah PPPoE User
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="berlangganan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>IP Address</th>
                                        <th>Layanan</th>
                                        <th>Bandwidth</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($berlangganan as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= !empty($row->fullname) ? $row->fullname : (isset($row->nama_lengkap) ? $row->nama_lengkap : 'N/A'); ?></td>
                                        <td><?= $row->username; ?></td>
                                        <td><?= $row->password; ?></td>
                                        <td><?= $row->ip_address; ?></td>
                                        <td><?= $row->jenis_layanan; ?></td>
                                        <td><?= $row->bandwidth; ?></td>
<td>
    <span id="pppoe-status-<?= $row->id_berlangganan; ?>" class="badge badge-secondary">
        Checking...
    </span>
</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info btn-edit" data-id="<?= $row->id_berlangganan; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= site_url('berlangganan/delete/'.$row->id_berlangganan); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus PPPoE user ini?')">
                                                <i class="fas fa-trash"></i>
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
        </div>
    </section>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah PPPoE User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('berlangganan/add'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Sumber Data <span class="text-danger">*</span></label>
                        <select class="form-control" id="source-type" name="source_type" required>
                            <option value="">-- Pilih Sumber Data --</option>
                            
                            <option value="registration">Registrasi</option>
                        </select>
                    </div>

                    <div class="form-group source-customer" style="display: none;">
                        <label>Customer <span class="text-danger">*</span></label>
                        <select class="form-control" id="customer-id" name="source_id">
                            <option value="">-- Pilih Customer --</option>
                            <?php foreach($customers as $customer): ?>
                            <option value="<?= $customer->uid_customer; ?>"><?= $customer->id_customer . ' - ' . $customer->fullname; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="customer-id-error">
                            Silakan pilih customer terlebih dahulu
                        </div>
                    </div>

                    <div class="form-group source-registration" style="display: none;">
                        <label>Registrasi <span class="text-danger">*</span></label>
                        <select class="form-control" id="registration-id" name="source_id">
                            <option value="">-- Pilih Registrasi --</option>
                            <?php foreach($registrations as $registration): ?>
                            <option value="<?= $registration->id_registrasi_customer; ?>"><?= $registration->nomor_registrasi . ' - ' . $registration->nama_lengkap; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" id="registration-id-error">
                            Silakan pilih registrasi terlebih dahulu
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>IP Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ip-address" name="ip_address" placeholder="192.168.90.x" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit PPPoE User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="edit-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" id="edit-password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>IP Address</label>
                        <input type="text" class="form-control" id="edit-ip-address" name="ip_address" placeholder="192.168.90.x" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="edit-status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#berlangganan-table').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
    
    // Form validation
    $('#modal-add form').submit(function(e) {
        var sourceType = $('#source-type').val();
        var sourceId = '';
        var isValid = true;
        
        if (sourceType == 'customer') {
            sourceId = $('#customer-id').val();
            if (!sourceId) {
                $('#customer-id').addClass('is-invalid');
                $('#customer-id-error').show();
                isValid = false;
            } else {
                $('#customer-id').removeClass('is-invalid');
                $('#customer-id-error').hide();
            }
        } else if (sourceType == 'registration') {
            sourceId = $('#registration-id').val();
            if (!sourceId) {
                $('#registration-id').addClass('is-invalid');
                $('#registration-id-error').show();
                isValid = false;
            } else {
                $('#registration-id').removeClass('is-invalid');
                $('#registration-id-error').hide();
            }
        } else {
            // No source type selected
            $('#source-type').addClass('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
    });
    
    // Source Type Change Event
    $('#source-type').change(function() {
        var sourceType = $(this).val();
        $('#source-type').removeClass('is-invalid');
        
        if (sourceType == 'customer') {
            $('.source-customer').show();
            $('.source-registration').hide();
            $('#registration-id').val('');
        } else if (sourceType == 'registration') {
            $('.source-registration').show();
            $('.source-customer').hide();
            $('#customer-id').val('');
        } else {
            $('.source-customer').hide();
            $('.source-registration').hide();
        }
    });
    
    // Customer ID Change Event
    $('#customer-id').change(function() {
        var customerId = $(this).val();
        $('#customer-id').removeClass('is-invalid');
        $('#customer-id-error').hide();
        
        if (customerId) {
            $.ajax({
                url: '<?= site_url('berlangganan/get_customer_data'); ?>',
                type: 'POST',
                data: { id: customerId },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#username').val(data.username);
                        $('#password').val(data.password);
                        $('#ip-address').val(data.ip_address);
                    }
                },
                error: function() {
                    alert('Error fetching customer data');
                }
            });
        }
    });
    
    // Registration ID Change Event
    $('#registration-id').change(function() {
        var registrationId = $(this).val();
        $('#registration-id').removeClass('is-invalid');
        $('#registration-id-error').hide();
        
        if (registrationId) {
            $.ajax({
                url: '<?= site_url('berlangganan/get_registration_data'); ?>',
                type: 'POST',
                data: { id: registrationId },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#username').val(data.username);
                        $('#password').val(data.password);
                        $('#ip-address').val(data.ip_address);
                    }
                },
                error: function() {
                    alert('Error fetching registration data');
                }
            });
        }
    });
    
    // Edit Button Click Event
    $('.btn-edit').click(function() {
        var id = $(this).data('id');
        
        // Reset form
        $('#edit-form')[0].reset();
        
        // Set form action
        $('#edit-form').attr('action', '<?= site_url('berlangganan/edit/'); ?>' + id);
        
        // Get data
        $.ajax({
            url: '<?= site_url('berlangganan/get_berlangganan_data'); ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#edit-username').val(data.username);
                    $('#edit-password').val(data.password);
                    $('#edit-ip-address').val(data.ip_address);
                    $('#edit-status').val(data.status);
                    
                    // Show modal
                    $('#modal-edit').modal('show');
                }
            },
            error: function() {
                alert('Error fetching subscription data');
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    // Fungsi untuk memperbarui status PPPoE
    function updatePPPoEStatus() {
        $.ajax({
            url: '<?= site_url('berlangganan/get_status'); ?>',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                // Update status untuk setiap user
                $.each(data, function(id, userData) {
                    let statusBadge = $('#pppoe-status-' + id);
                    
                    // Hapus semua class badge
                    statusBadge.removeClass('badge-secondary badge-success badge-danger badge-warning');
                    
                    // Set status dan class badge sesuai status
                    if (userData.status === 'online') {
                        statusBadge.text('Online');
                        statusBadge.addClass('badge-success');
                    } else if (userData.status === 'offline') {
                        statusBadge.text('Offline');
                        statusBadge.addClass('badge-danger');
                    } else {
                        statusBadge.text('Never Connected');
                        statusBadge.addClass('badge-warning');
                    }
                });
            },
            error: function() {
                console.error('Error fetching PPPoE status');
            },
            complete: function() {
                // Perbarui status setiap 10 detik
                setTimeout(updatePPPoEStatus, 10000);
            }
        });
    }
    
    // Mulai pembaruan status
    updatePPPoEStatus();
});</script>