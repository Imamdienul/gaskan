<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mt-2">LOG GAS ACTIVITY</h1>
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
                        <table  class=" table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>OS</th>
                                    <th>USERNAME</th>
                                    <th>ACTIVITY</th>
                                    <th>LOG TIME</th>
                                    <th>ADDRESS</th>
                                    <th>BROWSER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($log as $key) : ?>
                                    <tr>
                                        <td>
                                            <?= strtoupper($key->os) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->username) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->deskripsi) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->log_time) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->address) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($key->browser) . ' v' . $key->browser_version ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
</section>