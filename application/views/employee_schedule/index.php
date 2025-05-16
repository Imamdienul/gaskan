<div class="container-fluid px-4">
    <h1 class="mt-4">Pengaturan Jadwal Karyawan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Jadwal Karyawan</li>
    </ol>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-calendar me-1"></i>
            Atur Jadwal Karyawan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <?php foreach ($days as $day): ?>
                                <th class="text-center"><?= $day ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= strtoupper($user['nama_user'] )?></td>
                                <?php foreach ($days as $day): ?>
                                    <td class="text-center">
                                        <?php 
                                        $schedule = isset($schedules[$user['id_user']][$day]) 
                                            ? $schedules[$user['id_user']][$day] 
                                            : null; 
                                        ?>
                                        <button type="button" class="btn btn-sm 
                                            <?= $schedule && $schedule['is_working_day'] == 0 
                                                ? 'btn-danger' : 'btn-success' ?>" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#scheduleModal"
                                            data-user-id="<?= $user['id_user'] ?>"
                                            data-day="<?= $day ?>"
                                            data-is-working="<?= $schedule ? $schedule['is_working_day'] : 1 ?>"
                                            data-holiday-reason="<?= $schedule ? $schedule['custom_holiday_reason'] : '' ?>"
                                        >
                                            <?= $schedule && $schedule['is_working_day'] == 0 
                                                ? 'Libur' : 'Kerja' ?>
                                        </button>
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

<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atur Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('employee_schedule/update_schedule') ?>
            <div class="modal-body">
                <input type="hidden" name="user_id" id="modal-user-id">
                <input type="hidden" name="day_of_week" id="modal-day">
                
                <div class="mb-3">
                    <label class="form-label">Status Hari</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_working_day" 
                               id="working-day" value="1">
                        <label class="form-check-label" for="working-day">
                            Hari Kerja
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_working_day" 
                               id="holiday" value="0">
                        <label class="form-check-label" for="holiday">
                            Libur
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="custom-holiday-reason" class="form-label">Alasan Libur (Opsional)</label>
                    <input type="text" class="form-control" id="custom-holiday-reason" 
                           name="custom_holiday_reason" placeholder="Contoh: Cuti, Sakit, dll">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Modal population
    $('#scheduleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');
        var day = button.data('day');
        var isWorking = button.data('is-working');
        var holidayReason = button.data('holiday-reason');

        var modal = $(this);
        modal.find('#modal-user-id').val(userId);
        modal.find('#modal-day').val(day);
        
        // Set radio button
        if (isWorking == 1) {
            modal.find('#working-day').prop('checked', true);
        } else {
            modal.find('#holiday').prop('checked', true);
        }

        // Set holiday reason
        modal.find('#custom-holiday-reason').val(holidayReason);
    });
});
</script>