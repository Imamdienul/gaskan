<section class="content-header align-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mt-2">SLIP GAJI</h1>
            </div>
            <div class="col-sm-6">
                <div class=" float-sm-right justify-content-center">
                    <a class="btn btn-md btn-default mt-2" href="<?= base_url('payroll') ?>">KEMBALI</a>
                </div>
            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <form role="form" method="POST" action="" autocomplete="off">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <div class="form-group required">
                                <label class="control-label" for="fkaryawan">Karyawan</label>
                                <select class="text-uppercase form-control <?php echo form_error('fkaryawan') ? 'is-invalid' : '' ?>" id="fkaryawan" name="fkaryawan">
                                    <option hidden value="" selected>Pilih Karyawan </option>
                                    <?php foreach ($user as $key) : ?>
                                        <option value="<?= encrypt_url($key->id_user)  ?>"><?= $key->nik ?> - <?= $key->nama_user ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fkaryawan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="fbulan">Periode Bulan</label>
                                <select class="form-control <?php echo form_error('fbulan') ? 'is-invalid' : '' ?>" id="fbulan" name="fbulan">
                                    <?php $month = date('m'); ?>
                                    <option hidden value="" selected>Pilih Bulan </option>
                                    <option value="01" <?= $month == '01' ? 'selected' : '' ?>>JANUARI</option>
                                    <option value="02" <?= $month == '02' ? 'selected' : '' ?>>FEBRUARI</option>
                                    <option value="03" <?= $month == '03' ? 'selected' : '' ?>>MARET</option>
                                    <option value="04" <?= $month == '04' ? 'selected' : '' ?>>APRIL</option>
                                    <option value="05" <?= $month == '05' ? 'selected' : '' ?>>MEI</option>
                                    <option value="06" <?= $month == '06' ? 'selected' : '' ?>>JUNI</option>
                                    <option value="07" <?= $month == '07' ? 'selected' : '' ?>>JULI</option>
                                    <option value="08" <?= $month == '08' ? 'selected' : '' ?>>AGUSTUS</option>
                                    <option value="09" <?= $month == '09' ? 'selected' : '' ?>>SEPTEMBER</option>
                                    <option value="10" <?= $month == '10' ? 'selected' : '' ?>>OKTOBER</option>
                                    <option value="11" <?= $month == '11' ? 'selected' : '' ?>>NOVEMBER</option>
                                    <option value="12" <?= $month == '12' ? 'selected' : '' ?>>DESEMBER</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('fbulan') ?>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="control-label" for="ftahun">Periode Tahun</label>
                                <select class="form-control <?php echo form_error('ftahun') ? 'is-invalid' : '' ?>" id="ftahun" name="ftahun">
                                    <option hidden value="" selected>Pilih Tahun </option>
                                    <?php
                                    $tahun = date('Y');
                                    $now = date('Y') - 3;
                                    $range = date('Y') + 10;
                                    for ($i = $now; $i < $range; $i++) { ?>
                                        <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php  } ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('ftahun') ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">GENERATE</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <?php if ($selectedUser == null) {
                            echo 'Tidak ada data..';
                        } else { ?>
                            <div class="row mb-5">
                                <div class="col-md-8 text-uppercase">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="<?= base_url('/assets/images/logogisaka.png') ?>" alt="logo gisaka" class="mb-2" height="50px">
                                        </div>
                                        <div class="col-md-7 ml-md-n3">
                                            <p class="mb-0 text-bold">SLIP GAJI</p>
                                            <p class="mt-n2 mb-0 text-bold">PT. GIANDRA SAKA MEDIA</p>
                                            <p class="mt-n2"><b>GISAKA MEDIA |</b> <i class="text-lowercase">Connecting</i> <i>NICE</i> <i class="text-lowercase">Peoples!</i></p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <b>NIK : </b> <?= $selectedUser->nik ?><br>
                                        <b>NAMA : </b> <?= $selectedUser->nama_user ?><br>
                                        <b>EMAIL : </b> <?= $selectedUser->email_user ?><br>
                                        <b>GROUP : </b> <?= $selectedUser->group_user ?><br>
                                    </div>

                                </div>
                                <div class="col-md-4 text-uppercase text-md-right">
                                    <b>NO. </b> <?= $post['fbulan'] . $post['ftahun'] . $selectedUser->nik ?><br>
                                    <b>BULAN : </b> <?= bulanindo($post['fbulan']) ?> <?= $post['ftahun'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-bold text-center ">INCOME / PENDAPATAN</p>
                                    <div class="table-responsive text-uppercase">
                                        <table class="table table-sm">
                                            <tbody>
                                                <?php foreach ($benefit as $key) : ?>
                                                    <tr>
                                                        <td width="250px"><?= $key->nama_benefit ?></td>
                                                        <td><?= rupiah($key->nominal_benefit) ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-bold text-center">DEDUCTION / POTONGAN</p>
                                    <div class="table-responsive text-uppercase">
                                        <table class="table table-sm">
                                            <tbody>
                                                <?php foreach ($kasbon as $key) : ?>
                                                    <tr>
                                                        <td width="250px"><?= $key->kategori_keuangan . " " . TanggalIndo($key->created_date)  ?></td>
                                                        <td><?= rupiah($key->nominal) ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive text-uppercase">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th width="250px">TOTAL PENDAPATAN</th>
                                                    <td><?= rupiah($total_benefit) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th width="250px">TOTAL POTONGAN</th>
                                                    <td><?= rupiah($total_kasbon) ?></td>
                                                </tr>
                                                <tr>
                                                    <th width="250px">PENDAPATAN BERSIH</th>
                                                    <td><?= rupiah($total_benefit - $total_kasbon) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <a class="btn btn-success btn-md float-right" href="<?= base_url('pdf/payslip_pdf/') . $post['fkaryawan'] . '/' . $post['fbulan'] . '/' . $post['ftahun'] ?>" target="_blank">DOWNLOAD PDF</a>
                                </div>
                            </div>
                        <?php    } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>