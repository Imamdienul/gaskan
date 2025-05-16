<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">ARSIP SLIP GAJI</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-default mt-2" href="<?= base_url('payroll') ?>">KEMBALI</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card ">
                    <!-- card-body -->
                    <div class="card-body table-responsive-sm">
                        <table id="tableUSer" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No</th>
                                    <th>FILE NAME</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($arsip as $key) : ?>
                                    <tr class="text-uppercase">
                                        <td>
                                            <?= $no++ ?>
                                        </td>
                                        <td>
                                            <a href="#" onclick="viewPDF('<?= $key ?>')"><?= $key ?></a>

                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8" id="frame">


            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    function viewPDF(file) {
        $('#frame').empty();
        $('#frame').append(`<embed type="application/pdf" src="<?= base_url("uploads/payslip/") ?>${file}" width="100%" height="700"></embed>`);
    }
</script>