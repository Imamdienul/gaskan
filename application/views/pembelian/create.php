<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>BUAT PENGAJUAN PEMBELIAN</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body">
                        <h5>DATA DOKUMEN</h5>
                        <hr>
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <input type="hidden" name="ftotal_item" id="ftotal_item" value="1" style="display: none">
                            <input type="hidden" name="fid_project" id="fid_project" style="display: none">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="ftgl_pengajuan">No. Pembelian</label>
                                        <input type="text" class="form-control" id="fno_pembelian" name="fno_pembelian" value="<?= strtoupper(sprintf("%04d", $no_urut) . '/PR/' . bulanRomawi(date('m')) . '/' . date('Y')) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="ftgl_pengajuan">Tanggal
                                            Pengajuan</label>
                                        <input type="text" class="form-control" id="ftgl_pengajuan" name="ftgl_pengajuan" value="<?= date('d-m-Y') ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fnik">NIK</label>
                                        <input type="text" class="form-control" id="fnik" name="fnik" value="<?= strtoupper($this->session->userdata('nik')) ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fname_user">Nama Lengkap</label>
                                        <input type="text" class="form-control <?= form_error('fname_user') ? 'is-invalid' : '' ?>" id="fname_user" name="fname_user" value="<?= strtoupper($this->session->userdata('nama_user')) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fdeadline_pembelian">Deadline
                                            Pembelian</label>
                                        <input type="date" class="form-control <?= form_error('fdeadline_pembelian') ? 'is-invalid' : '' ?>" id="fdeadline_pembelian" name="fdeadline_pembelian" placeholder="Tanggal join" value="<?= $this->input->post('fdeadline_pembelian'); ?>">
                                        <div class="invalid-feedback">
                                            <?= form_error('fdeadline_pembelian') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="fcatatan">Catatan</label>
                                        <textarea name="fcatatan" class="form-control <?= form_error('fcatatan') ? 'is-invalid' : '' ?> " id="fcatatan" placeholder="Catatan" height="1"><?= $this->input->post('fcatatan'); ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= form_error('fcatatan') ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <h5 class="mt-3">DATA PROJECT</h5>
                            <hr>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fproject">Nama Project</label>
                                        <div class="input-group ">
                                            <input type="text" class="text-uppercase form-control <?php echo form_error('fproject') ? 'is-invalid' : '' ?>" id="fproject" name="fproject" onfocus="onFocus()" placeholder="Pilih project">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-default " data-toggle="modal" data-target="#modal_project"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= form_error('fproject') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label " for="fdeadline">Deadline Project</label>
                                        <input type="text" class="form-control text-uppercase " id="fdeadline" name="fdeadline" value="-" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fowner">Project Owner</label>
                                        <input type="text" class="text-uppercase form-control <?= form_error('fowner') ? 'is-invalid' : '' ?>" id="fowner" name="fowner" value="-" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group required">
                                        <label class="control-label" for="fmanager">Project Manager</label>
                                        <input type="text" class="text-uppercase form-control <?= form_error('fmanager') ? 'is-invalid' : '' ?>" id="fmanager" name="fmanager" value="-" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row ">
                                <div class="col-md-6">
                                    <h5 class="mb-0">DATA BARANG</h5>
                                    <p class=" text-sm" id="count">Total Item : 1</p>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-default  float-right" id="addForm">TAMBAH
                                        ITEM</button>
                                </div>
                            </div>
                            <table class="table table-bordered" id='tblbarang'>
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Spesifikasi</th>
                                        <th scope="col">Note</th>
                                        <th scope="col">Act</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_item">

                                    <tr id="item_detail1">
                                        <td class="p-1">
                                            <input type="text" class="form-control <?= form_error('fnama_barang[]') ? 'is-invalid' : '' ?>" id="fnama_barang[]" name="fnama_barang[]" placeholder="Nama barang">
                                        </td>
                                        <td class="p-1">
                                            <input type="number" class="form-control <?= form_error('fharga_satuan[]') ? 'is-invalid' : '' ?> harga" id="fharga_satuan[]" name="fharga_satuan[]" placeholder="Harga satuan">
                                        </td>
                                        <td class="p-1" style="width:100px">
                                            <input type="number" class="form-control <?= form_error('fqty[]') ? 'is-invalid' : '' ?> qty" id="fqty1" name="fqty[]" placeholder="Qty" min="1">
                                        </td>
                                        <td class="p-1">
                                            <input type="text" class="form-control " id="fsatuan[]" name="fsatuan[]" placeholder="Satuan">
                                        </td>
                                        <td class="p-1">
                                            <input type="text" class="form-control <?= form_error('fspesifikasi[]') ? 'is-invalid' : '' ?>" id="fspesifikasi[]" name="fspesifikasi[]" placeholder="Spesifikasi">
                                        </td>
                                        <td class="p-1">
                                            <input type="text" class="form-control <?= form_error('fnote[]') ? 'is-invalid' : '' ?>" id="fnote[]" name="fnote[]" placeholder="Catatan">
                                        </td>
                                        <td class="p-1">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>

                            <button type="submit" class="btn btn-primary float-right mt-2">Buat
                                Pengajuan</button>
                            <a href="<?= base_url('pembelian') ?>" class="btn btn-secondary float-left mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="modal_project">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title text-bold">PILIH PROJECT</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body" id="bodymodal_modal_project">
                <div class="card-body table-responsive-sm">
                    <table id="tableOnModal" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>PILIH</th>
                                <th>PROJECT</th>
                                <th>OWNER</th>
                                <th>DEADLINE</th>
                                <th>PROJECT MANAGER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project as $key) : ?>
                                <tr class="text-uppercase">
                                    <td style="width: 10px;"><button class="btn btn-primary btn-sm" id="select" data-id="<?= $key->project_id ?>" data-project="<?= $key->nama_project ?>" data-owner="<?= $key->project_owner ?>" data-value="<?= rupiah($key->project_value) ?>" data-manager="<?= $key->nama_user ?>" data-deadline="<?= TanggalIndo($key->project_deadline) ?>">
                                            <i class="fa fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>
                                        <?= $key->nama_project ?>
                                    </td>
                                    <td>
                                        <?= $key->project_owner ?>
                                    </td>
                                    <td>
                                        <?= TanggalIndo($key->project_deadline) ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($key->nama_user) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function onFocus() {
        $('#modal_project').modal('show')
    }
    $(document).ready(function() {
        var i = 2;
        $("#addForm").on('click', function() {
            row = '<tr id="item_detail' + i + '">' +
                '<td class="p-1">' +
                '<input type="text" class="form-control" id="fnama_barang' + i + '" name="fnama_barang[]" placeholder="Nama barang">' +
                '</td>' +
                '<td class="p-1">' +
                '<input type="number" class="form-control harga" id="fharga_satuan[]" name="fharga_satuan[]" placeholder="Harga satuan">' +
                '</td>' +
                '<td class="p-1" style="width:100px">' +
                '<input type="number" class="form-control qty" id="fqty' + i + '" name="fqty[]" placeholder="Qty" min="1">' +
                '</td>' +
                '<td class="p-1">' +
                '<input type="text" class="form-control" id="fsatuan' + i + '" name="fsatuan[]" placeholder="Satuan">' +
                '</td>' +
                '<td class="p-1">' +
                '<input type="text" class="form-control" id="fspesifikasi' + i + '" name="fspesifikasi[]" placeholder="Spesifikasi">' +
                '</td>' +
                '<td class="p-1">' +
                '<input type="text" class="form-control" id="fnote' + i + '" name="fnote[]" placeholder="Catatan">' +
                '</td>' +
                '<td class="p-1">' +
                '<button class="btn btn-md btn-danger btn_remove" type="button" id="' + i + '" name="del"><i class="fa fa-trash"></i>' +
                '</button>' +
                '</td>' +
                '</tr>'
            var tanpa_rupiah = document.getElementById('fharga_satuan[]');
            tanpa_rupiah.addEventListener('keyup', function(e) {
                tanpa_rupiah.value = formatRupiah(this.value);
            });
            $(row).appendTo('#tbody_item');
            $('#ftotal_item').val(i);
            $('#count').html('Total Item : ' + i);
            i++;
        })

        $(document).on('click', '.btn_remove', function() {
            i--;
            var button_id = $(this).attr("id");
            $('#item_detail' + button_id + '').remove();
            $('#ftotal_item').val(i - 1);
            $('#count').html('Total Item : ' + (i - 1));
        });
        $(document).on('click', '#select', function() {
            var project_id = $(this).data('id');
            var project = $(this).data('project');
            var deadline = $(this).data('deadline');
            var manager = $(this).data('manager');
            var owner = $(this).data('owner');
            $('#fdeadline').val(deadline)
            $('#fid_project').val(project_id)
            $('#fowner').val(owner)
            $('#fmanager').val(manager)
            $('#fproject').val(project)
            $('#modal_project').modal('hide')
        })


    })
</script>