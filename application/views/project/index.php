<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">LIST PROJECT</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-primary mt-2" href="<?= base_url('project/create') ?>">BUAT PROJECT</a>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="tableUSer" class="display nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 15px">NO</th>
                                    <th>NO SPK/PO</th>
                                    <th>PROJECT</th>
                                    <th>OWNER</th>
                                    <th>DEADLINE</th>
                                    <th>VALUE</th>
                                    <th>PROJECT MANAGER</th>
                                    <th>OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($project as $key): ?>
                                    <tr class="text-uppercase">
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>

                                            <?= $key->nomor_spk ?>

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
                                            <?= rupiah($key->project_value) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->nama_user) ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('project/update/') . encrypt_url($key->project_id) ?>"
                                                class="btn btn-xs btn-primary">EDIT</a>
                                            <a href="#" class="btn btn-xs btn-danger"
                                                onclick="deleteConfirm('<?= base_url() . 'project/delete/' . encrypt_url($key->project_id) ?>')">DELETE</a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
</section>

<!--Delete Confirmation-->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 d-flex justify-content-center">
                        <i class="fa  fa-exclamation-triangle" style="font-size: 70px; color:red;"></i>
                    </div>
                    <div class="col-9 pt-2">
                        <h5>Apakah anda yakin?</h5>
                        <span>Data yang dihapus tidak akan bisa dikembalikan.</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"> Batal</button>
                <a id="btn-delete" class="btn btn-danger" href="#"> Hapus</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_Detail">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_Detail">
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_status">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" id="bodymodal_status">
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirm -->
<script type="text/javascript">
    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }

    function getDetail(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url('kasbon/detail/'); ?>" + id,
            // data: "id=" + id,
            dataType: "html",
            success: function (response) {
                $('#bodymodal_Detail').empty();
                $('#bodymodal_Detail').append(response);
            }
        });
    }




</script>