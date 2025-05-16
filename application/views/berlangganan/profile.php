<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Profile Berlangganan</h4>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" id="btnAdd">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="profileTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Profile</th>
                                <th>Group Rate</th>
                                <th>Limit/Shared</th>
                                <th>Aktif</th>
                                <th>HPP</th>
                                <th>Komisi</th>
                                <th>Harga</th>
                                <th>User</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($profiles as $profile) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $profile->nama ?></td>
                                <td><?= $profile->profile ?></td>
                                <td><?= $profile->group_rate ?></td>
                                <td><?= $profile->limit_shared ?></td>
                                <td><?= $profile->aktif ?></td>
                                <td>Rp <?= number_format($profile->hpp, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($profile->komisi, 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($profile->harga, 0, ',', '.') ?></td>
                                <td><?= $profile->user ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btnEdit" data-id="<?= $profile->id ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm btnDelete" data-id="<?= $profile->id ?>" data-nama="<?= $profile->nama ?>">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
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

<!-- Modal Form -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Form Profile Berlangganan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProfile">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <input type="text" class="form-control" id="profile" name="profile" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="group_rate">Group Rate</label>
                        <input type="text" class="form-control" id="group_rate" name="group_rate" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="limit_shared">Limit/Shared</label>
                        <input type="text" class="form-control" id="limit_shared" name="limit_shared" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="aktif">Aktif</label>
                        <input type="text" class="form-control" id="aktif" name="aktif" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hpp">HPP</label>
                        <input type="number" class="form-control" id="hpp" name="hpp" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="komisi">Komisi</label>
                        <input type="number" class="form-control" id="komisi" name="komisi" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="number" class="form-control" id="user" name="user" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus profile <span id="deleteName"></span>?</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // Initialize DataTable
    $('#profileTable').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
    });

    // Add New Profile
    $('#btnAdd').click(function() {
        $('#formProfile')[0].reset();
        $('#id').val('');
        $('#profileModalLabel').text('Tambah Profile Berlangganan');
        $('#profileModal').modal('show');
    });

    // Edit Profile - dengan event delegation
    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id');
        $('#profileModalLabel').text('Edit Profile Berlangganan');
        
        $.ajax({
            url: '<?= site_url('profile/get_profile_by_id') ?>',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                $('#id').val(response.id);
                $('#nama').val(response.nama);
                $('#profile').val(response.profile);
                $('#group_rate').val(response.group_rate);
                $('#limit_shared').val(response.limit_shared);
                $('#aktif').val(response.aktif);
                $('#hpp').val(response.hpp);
                $('#komisi').val(response.komisi);
                $('#harga').val(response.harga);
                $('#user').val(response.user);
                $('#profileModal').modal('show');
            }
        });
    });

    // Save Profile
    $('#formProfile').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= site_url('profile/save') ?>',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            }
        });
    });

    // Show Delete Confirmation - dengan event delegation
    $(document).on('click', '.btnDelete', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        
        $('#deleteId').val(id);
        $('#deleteName').text(nama);
        $('#deleteModal').modal('show');
    });

    // Confirm Delete
    $('#confirmDelete').click(function() {
        const id = $('#deleteId').val();
        
        $.ajax({
            url: '<?= site_url('profile/delete') ?>',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            }
        });
    });
});
</script>