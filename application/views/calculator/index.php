<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Parameter Perhitungan</h3>
                </div>
                <form id="calculator-form" class="form-horizontal">
                    <div class="box-body">
                        <div class="callout callout-info">
                            <h4>Panduan Penggunaan:</h4>
                            <p>Isi semua parameter di bawah ini untuk menghitung redaman dan daya dalam jaringan fiber optik Anda.</p>
                            <p>Sistem akan menghitung redaman pada serat dan splitter, kemudian memberikan hasil daya keluaran dan margin daya.</p>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jarak Serat Optik (km)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="distance" min="0" step="0.01" required>
                                <span class="help-block">Masukkan jarak total serat optik dalam kilometer.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Daya Pancar / Tx Power (dBm)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="tx_power" step="0.01" required>
                                <span class="help-block">Masukkan daya pancar dari pemancar optik dalam dBm (positif atau negatif).</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sensitivitas Penerima / Rx Sensitivity (dBm)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="rx_sensitivity" step="0.01" required>
                                <span class="help-block">Masukkan sensitivitas penerima dalam dBm (biasanya nilai negatif).</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Splitter/Coupler</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="splitter_type[]" multiple="multiple" data-placeholder="Pilih jenis splitter/coupler" style="width: 100%;">
                                    <?php
                                    $splitter_types = $this->calculator_model->get_splitter_types();
                                    foreach ($splitter_types as $value => $label) {
                                        echo "<option value=\"$value\">$label</option>";
                                    }
                                    ?>
                                </select>
                                <span class="help-block">Pilih jenis splitter/coupler yang digunakan dalam jaringan. Bisa pilih lebih dari satu.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-calculator"></i> Hitung</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success" id="result-box" style="display: none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Hasil Perhitungan</h3>
                </div>
                <div class="box-body">
                    <div id="warnings-container"></div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-line-chart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Redaman Total</span>
                                    <span class="info-box-number" id="total-loss">0.00</span>
                                    <span class="info-box-description">dB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-signal"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Daya Keluaran</span>
                                    <span class="info-box-number" id="rx-power">0.00</span>
                                    <span class="info-box-description">dBm</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-life-ring"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Margin Daya</span>
                                    <span class="info-box-number" id="power-margin">0.00</span>
                                    <span class="info-box-description">dB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box" id="status-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number" id="link-status">Baik</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Komponen</th>
                                <th>Redaman (dB)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Redaman Serat Optik</td>
                                <td id="fiber-loss">0.00</td>
                            </tr>
                            <tr>
                                <td>Redaman Splitter</td>
                                <td id="splitter-loss">0.00</td>
                            </tr>
                            <tr class="info">
                                <th>Total Redaman</th>
                                <th id="total-loss-table">0.00</th>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Splitter Structure Visualization -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Struktur Splitter/Coupler</h3>
                        </div>
                        <div class="box-body">
                            <div id="splitter-structure">
                                <!-- Structure will be generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="info-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Informasi Kalkulator Fiber Optik</h4>
            </div>
            <div class="modal-body">
                <h4>Keterangan Parameter:</h4>
                <ul>
                    <li><strong>Redaman Serat Optik:</strong> 0.35 dB/km untuk kabel G.652.D</li>
                    <li><strong>Redaman Splitter:</strong> Tergantung pada jenis splitter yang dipilih</li>
                </ul>
                
                <h4>Panduan Interpretasi:</h4>
                <ul>
                    <li><strong>Margin Daya > 0 dB:</strong> Sistem dapat beroperasi</li>
                    <li><strong>Margin Daya < 0 dB:</strong> Sistem tidak dapat beroperasi</li>
                    <li><strong>Margin Daya > 3 dB:</strong> Direkomendasikan untuk operasi yang stabil</li>
                    <li><strong>Margin Daya > 6 dB:</strong> Sistem sangat baik</li>
                </ul>
                
                <h4>Peringatan:</h4>
                <ul>
                    <li>Perhitungan ini adalah estimasi dan dapat berbeda dengan kondisi aktual</li>
                    <li>Untuk jarak lebih dari 20km, pertimbangkan penggunaan penguat optik</li>
                    <li>Pastikan nilai sensitivitas penerima dimasukkan dengan benar (nilai negatif)</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('.select2').select2();
    
    // Tampilkan modal informasi
    var showInfoModal = function() {
        $('#info-modal').modal('show');
    };
    
    // Tambahkan tombol info di header
    $('.content-header').append(
        $('<button>', {
            class: 'btn btn-info btn-sm pull-right',
            html: '<i class="fa fa-info-circle"></i> Info',
            click: showInfoModal
        })
    );
    
    // Fungsi untuk menangani form submit
    $('#calculator-form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo site_url("calculator/calculate"); ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                // Tampilkan hasil
                $('#result-box').show();
                $('#fiber-loss').text(response.fiber_loss);
                $('#splitter-loss').text(response.splitter_loss);
                $('#total-loss').text(response.total_loss);
                $('#total-loss-table').text(response.total_loss);
                $('#rx-power').text(response.rx_power);
                $('#power-margin').text(response.power_margin);
                $('#link-status').text(response.status);
                
                // Ubah warna status box
                if (response.status === 'Baik') {
                    $('#status-box .info-box-icon').removeClass('bg-red').addClass('bg-green');
                    $('#status-box .info-box-icon i').removeClass('fa-times-circle').addClass('fa-check-circle');
                } else {
                    $('#status-box .info-box-icon').removeClass('bg-green').addClass('bg-red');
                    $('#status-box .info-box-icon i').removeClass('fa-check-circle').addClass('fa-times-circle');
                }
                
                // Tampilkan peringatan jika ada
                $('#warnings-container').empty();
                if (response.warnings.length > 0) {
                    var warningHtml = '<div class="callout callout-warning">';
                    warningHtml += '<h4><i class="fa fa-warning"></i> Peringatan!</h4>';
                    warningHtml += '<ul>';
                    
                    $.each(response.warnings, function(index, warning) {
                        warningHtml += '<li>' + warning + '</li>';
                    });
                    
                    warningHtml += '</ul></div>';
                    $('#warnings-container').html(warningHtml);
                }
                
                // Generate splitter structure visualization
                var structureHtml = '<div class="network-structure">';
                
                // Show initial power
                structureHtml += '<div class="text-center"><div class="well well-sm">';
                structureHtml += '<strong>Daya Awal:</strong> ' + response.tx_power + ' dBm';
                structureHtml += '</div></div>';
                
                // Show fiber loss
                structureHtml += '<div class="text-center"><i class="fa fa-long-arrow-down"></i></div>';
                structureHtml += '<div class="text-center"><div class="well well-sm">';
                structureHtml += '<strong>Setelah Redaman Serat (' + response.fiber_loss + ' dB):</strong> ' + response.power_after_fiber + ' dBm';
                structureHtml += '</div></div>';
                
                // Show each splitter
                $.each(response.splitter_details, function(index, splitter) {
                    structureHtml += '<div class="text-center"><i class="fa fa-long-arrow-down"></i></div>';
                    
                    structureHtml += '<div class="panel panel-default">';
                    structureHtml += '<div class="panel-heading"><strong>' + splitter.type + '</strong> (Loss: ' + splitter.loss + ')</div>';
                    structureHtml += '<div class="panel-body">';
                    structureHtml += '<div class="text-center"><small>Input: ' + splitter.input_power + '</small></div>';
                    
                    // Show outputs
                    structureHtml += '<div class="row" style="margin-top: 15px;">';
                    $.each(splitter.outputs, function(i, output) {
                        structureHtml += '<div class="col-xs-' + (12 / splitter.outputs.length) + '">';
                        structureHtml += '<div class="well well-sm">' + output + '</div>';
                        structureHtml += '</div>';
                    });
                    structureHtml += '</div>';
                    
                    structureHtml += '</div></div>';
                });
                
                structureHtml += '</div>';
                $('#splitter-structure').html(structureHtml);
                
                // Scroll ke hasil
                $('html, body').animate({
                    scrollTop: $('#result-box').offset().top
                }, 500);
            },
            error: function() {
                alert('Terjadi kesalahan saat menghitung. Silakan coba lagi.');
            }
        });
    });
});
</script>

<style>
.network-structure {
    margin: 20px 0;
}
.network-structure .well {
    margin-bottom: 5px;
    padding: 8px;
}
.network-structure .fa-long-arrow-down {
    margin: 10px 0;
    font-size: 20px;
    color: #666;
}
.network-structure .panel {
    margin-bottom: 20px;
}
</style>