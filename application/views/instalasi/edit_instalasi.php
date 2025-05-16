<!-- application/views/survey/edit_survey.php -->
<!-- application/views/instalasi/edit_instalasi.php -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data instalasi</h3>
                <div class="card-tools">
                    <a href="<?= site_url('instalasi/detail_instalasi')?> class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>

                <form action="<?= site_url('instalasi/update_instalasi') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_instalasi" value="<?= $Instalasi->id_instalasi ?>">
                    <input type="hidden" name="id_teknisi" value="<?= $Instalasi->id_teknisi ?>">

                    <div class="form-group">
                        <label for="tanggal_pemasangan">Tanggal Pemasangan <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" id="ftgl_pmsngn" name="ftgl_pmsngn" value="<?= date('Y-m-d', strtotime($Instalasi->tgl_pasang)) ?>" required>
                            <input type="time" class="form-control" id="fjam_pmsngn" name="fjam_pmsngn" value="<?= date('H:i', strtotime($Instalasi->waktu_pasang)) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_area">Area <span class="text-danger">*</span></label>
                        <select name="id_area" id="id_area" class="form-control select2" required>
                            <option value="">- Pilih Area -</option>
                            <?php foreach ($area as $ar) : ?>
                                <option value="<?= $ar->id_wilayah ?>" <?= $Instalasi->id_area == $ar->id_wilayah ? 'selected' : '' ?>><?= $ar->nama_wilayah ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-control select2" required>
                            <option value="">- Pilih Pelanggan -</option>
                            <?php foreach ($customer as $rc) : ?>
                                <option value="<?= $rc->id_registrasi_customer ?>" <?= $rc->id_registrasi_customer == $Instalasi->id_registrasi_customer ? 'selected' : '' ?>><?= $rc->nama_lengkap ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat_pelanggan">Alamat Pasang</label>
                        <input type="text" class="form-control" id="alamat_pelanggan" value="" readonly>
                    </div>
                
                    <div class="form-group">
                        <label for="no_hp_pelanggan">No Hp Pelanggan</label>
                        <input type="text" class="form-control" id="no_hp_pelanggan" value="" readonly>
                    </div>

                    <div class="form-group">
                        <label for="id_paket">Paket <span class="text-danger">*</span></label>
                        <select name="id_paket" id="id_paket" class="form-control select2" required>
                            <option value="">- Pilih Paket -</option>
                            <?php foreach ($paket as $pk) : ?>
                                <option value="<?= $pk->id_paket ?>" <?= $Instalasi->id_paket == $pk->id_paket ? 'selected' : '' ?>><?= $pk->nama_paket ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="odp">ODP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="odp" name="odp" value="<?= $Instalasi->id_odp ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="port_odp">Port ODP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="port_odp" name="port_odp" value="<?= $Instalasi->port_odp ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pjg_kabel">Panjang Kabel (m) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="pjg_kabel" name="pjg_kabel" value="<?= $Instalasi->panjang_kabel ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_roll_kabel">Nomor Roll Kabel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_roll_kabel" name="no_roll_kabel" value="<?= $Instalasi->nomor_roll_kabel ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="merk_modem">Merk Modem/Router/ONT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="merk_modem" name="merk_modem" value="<?= $Instalasi->merk_modem ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipe_modem">Tipe Modem/Router/ONT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tipe_modem" name="tipe_modem" value="<?= $Instalasi->tipe_modem ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sn_modem">SN Modem/Router/ONT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sn_modem" name="sn_modem" value="<?= $Instalasi->sn_modem ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="mac_modem">MAC Addres Modem/Router/ONT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mac_modem" name="mac_modem" value="<?= $Instalasi->mac_address ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="redaman_plnggn">Redaman Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="redaman_plnggn" name="redaman_plnggn" value="<?= $Instalasi->redaman_pelanggan ?>" required>
                    </div>

                    <!-- Foto-foto instalasi -->
                    <div class="card mt-4">
                        <div class="card-header bg-success">
                            <h3 class="card-title">Foto-foto instalasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Foto Koneksi ODP -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_koneksi">Foto Koneksi ODP</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_koneksi_odp" name="foto_koneksi_odp" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_koneksi_odp">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info camera-btn" onclick="activateCamera('foto_koneksi_odp')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($Instalasi->foto_koneksi_odp)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_koneksi_odp) ?>" alt="Foto Koneksi ODP" class="img-thumbnail preview-img" id="preview_foto_koneksi_odp" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_koneksi" value="<?= $Instalasi->foto_koneksi_odp ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_koneksi_odp" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_koneksi">Deskripsi</label>
                                        <textarea name="deskripsi_foto_koneksi" id="deskripsi_foto_koneksi" class="form-control" rows="2"><?= $Instalasi->deskripsi_foto_koneksi_odp ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Foto Redaman -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_redaman_pelanggan">Foto Redaman Pelanggan</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_redaman_pelanggan" name="foto_redaman_pelanggan" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_redaman_pelanggan">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info camera-btn" onclick="activateCamera('foto_redaman_pelanggan')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($Instalasi->foto_redaman_pelanggan)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_redaman_pelanggan) ?>" alt="Foto Redaman Pelanggan" class="img-thumbnail preview-img" id="preview_foto_redaman_pelanggan" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_redaman" value="<?= $Instalasi->foto_redaman_pelanggan ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_redaman_pelanggan" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_redaman">Deskripsi</label>
                                        <textarea name="deskripsi_foto_redaman" id="deskripsi_foto_redaman" class="form-control" rows="2"><?= $Instalasi->deskripsi_foto_redaman_pelanggan ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Foto Instalasi -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_instalasi">Foto Instalasi</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_instalasi" name="foto_instalasi" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_instalasi">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info camera-btn" onclick="activateCamera('foto_instalasi')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($Instalasi->foto_instalasi)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_instalasi) ?>" alt="Foto Instalasi" class="img-thumbnail preview-img" id="preview_foto_instalasi" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_instalasi" value="<?= $Instalasi->foto_instalasi ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_instalasi" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_instalasi">Deskripsi</label>
                                        <textarea name="deskripsi_foto_instalasi" id="deskripsi_foto_instalasi" class="form-control" rows="2"><?= $Instalasi->deskripsi_foto_instalasi ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Foto Rumah -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_rumah">Foto Rumah</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_rumah" name="foto_rumah" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_rumah">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info camera-btn" onclick="activateCamera('foto_rumah')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($Instalasi->foto_rumah)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/instalasi/' . $Instalasi->foto_rumah) ?>" alt="Foto Rumah" class="img-thumbnail preview-img" id="preview_foto_rumah" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_rumah" value="<?= $Instalasi->foto_rumah ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_rumah" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_rumah">Deskripsi</label>
                                        <textarea name="deskripsi_foto_rumah" id="deskripsi_foto_rumah" class="form-control" rows="2"><?= $Instalasi->deskripsi_foto_rumah ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="note">Catatan instalasi</label>
                        <textarea name="note" id="note" rows="4" class="form-control"><?= $Instalasi->catatan ?></textarea>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#id_pelanggan').select2({
            placeholder: "Cari Pelanggan...",
            allowClear: true
        });

        $('#id_area').select2({
            placeholder: "Cari Area...",
            allowClear: true
        });

        $('#id_paket').select2({
            placeholder: "Cari Paket...",
            allowClear: true
        });

        $('#id_pelanggan').on('change', function() {
            // Get selected value
            var selectedValue = $(this).val();

            $.ajax({
                url: '<?= base_url('instalasi/get_data_pelanggan') ?>',
                method: 'POST',
                data: {
                    id_pelanggan: selectedValue,
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, item) {
                        // Insert selected value into the input field
                        $('#alamat_pelanggan').val(item.alamat_pemasangan);
                        $('#no_hp_pelanggan').val(item.whatsapp);
                    });
                }
            });
        });
    });
</script>

<script>
    // Updated camera activation function for edit_survey.php
function activateCamera(inputId) {
    const input = document.getElementById(inputId);
    
    // Check if the browser supports the MediaDevices API
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Create a temporary video element
        const videoElement = document.createElement('video');
        videoElement.style.position = 'fixed';
        videoElement.style.top = '0';
        videoElement.style.left = '0';
        videoElement.style.width = '100%';
        videoElement.style.height = '100%';
        videoElement.style.zIndex = '9999';
        videoElement.style.backgroundColor = '#000';
        videoElement.autoplay = true;
        
        // Create a canvas element for capturing the photo
        const canvasElement = document.createElement('canvas');
        canvasElement.style.display = 'none';
        
        // Create a capture button
        const captureButton = document.createElement('button');
        captureButton.textContent = 'Ambil Foto';
        captureButton.style.position = 'fixed';
        captureButton.style.bottom = '20px';
        captureButton.style.left = '50%';
        captureButton.style.transform = 'translateX(-50%)';
        captureButton.style.zIndex = '10000';
        captureButton.style.padding = '10px 20px';
        captureButton.style.backgroundColor = '#007bff';
        captureButton.style.color = '#fff';
        captureButton.style.border = 'none';
        captureButton.style.borderRadius = '5px';
        
        // Create a cancel button
        const cancelButton = document.createElement('button');
        cancelButton.textContent = 'Batal';
        cancelButton.style.position = 'fixed';
        cancelButton.style.top = '20px';
        cancelButton.style.right = '20px';
        cancelButton.style.zIndex = '10000';
        cancelButton.style.padding = '10px 20px';
        cancelButton.style.backgroundColor = '#dc3545';
        cancelButton.style.color = '#fff';
        cancelButton.style.border = 'none';
        cancelButton.style.borderRadius = '5px';
        
        // Add elements to the document
        document.body.appendChild(videoElement);
        document.body.appendChild(canvasElement);
        document.body.appendChild(captureButton);
        document.body.appendChild(cancelButton);
        
        // Status text for geolocation
        const statusText = document.createElement('div');
        statusText.style.position = 'fixed';
        statusText.style.bottom = '80px';
        statusText.style.left = '50%';
        statusText.style.transform = 'translateX(-50%)';
        statusText.style.zIndex = '10000';
        statusText.style.color = '#fff';
        statusText.style.backgroundColor = 'rgba(0,0,0,0.7)';
        statusText.style.padding = '5px 10px';
        statusText.style.borderRadius = '5px';
        statusText.textContent = 'Mendapatkan lokasi...';
        document.body.appendChild(statusText);
        
        // Get geolocation
        let latitude = null;
        let longitude = null;
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    statusText.textContent = `Lokasi: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                },
                (error) => {
                    console.error('Error getting location:', error);
                    statusText.textContent = 'Tidak dapat mendapatkan lokasi';
                }
            );
        } else {
            statusText.textContent = 'Geolocation tidak didukung oleh browser ini';
        }
        
        // Function to load an image
        function loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        }
        
        // Enhanced watermark function
        function addWatermark(ctx, width, height, lat, long) {
            // Save the current context state
            ctx.save();
            
            // Set font properties for the watermark
            ctx.font = `${Math.floor(height / 40)}px Arial`;
            ctx.fillStyle = 'white';
            ctx.strokeStyle = 'black';
            ctx.lineWidth = 1;
            
            // Add semi-transparent background for the watermark
            ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
            ctx.fillRect(0, height - (height/10), width, height/10);
            
            // Add watermark text
            ctx.fillStyle = 'white';
            
            // Add current date and time
            const now = new Date();
            const dateTimeString = now.toLocaleString('id-ID', { 
                year: 'numeric', 
                month: '2-digit', 
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            
            ctx.textAlign = 'left';
            ctx.fillText(`Tanggal: ${dateTimeString}`, 10, height - (height/10) + 20);
            
            // Add coordinates if available
            if (lat && long) {
                ctx.fillText(`Lokasi: ${lat.toFixed(6)}, ${long.toFixed(6)}`, 10, height - (height/10) + 40);
            } else {
                ctx.fillText("Lokasi: Tidak tersedia", 10, height - (height/10) + 40);
            }
            
            // Add technician name if available
            const technicianName = document.getElementById('technician_name')?.value || 
                         "<?= $this->session->userdata('nama_user') ?>";
            if (technicianName) {
                ctx.fillText(`Teknisi: ${technicianName}`, 10, height - (height/10) + 60);
            }
            
            // Add logo (Gisaka Media)
            ctx.textAlign = 'right';
            ctx.font = `bold ${Math.floor(height / 30)}px Arial`;
            ctx.fillText("GISAKA MEDIA", width - 10, height - (height/10) + 30);
            
            // Restore the context state
            ctx.restore();
        }
        
        // Get user media with correct constraints
        navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: { ideal: 'environment' },
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }, 
            audio: false 
        })
        .then(stream => {
            videoElement.srcObject = stream;
            
            // Capture photo when button is clicked
            captureButton.addEventListener('click', () => {
                // Set canvas dimensions to match video
                canvasElement.width = videoElement.videoWidth;
                canvasElement.height = videoElement.videoHeight;
                
                // Draw the video frame to the canvas
                const ctx = canvasElement.getContext('2d');
                ctx.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                
                // Add watermark with coordinates and timestamp
                addWatermark(ctx, canvasElement.width, canvasElement.height, latitude, longitude);
                
                // Convert canvas to blob
                canvasElement.toBlob(blob => {
                    // Create a File object from the blob
                    const file = new File([blob], `photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    
                    // Create a FileList object
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    
                    // Set the file input's files
                    input.files = dataTransfer.files;
                    
                    // Trigger the change event to update the preview
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                    
                    // Update preview image if applicable
                    const previewId = 'preview_' + inputId;
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.src = URL.createObjectURL(file);
                        preview.style.display = 'block';
                    }
                    
                    // Update file info if applicable
                    const fileInfoId = 'file_info_' + inputId;
                    const fileInfo = document.getElementById(fileInfoId);
                    if (fileInfo) {
                        fileInfo.value = file.name;
                    }
                    
                    // Cleanup
                    cleanup(stream);
                }, 'image/jpeg', 0.9);
            });
            
            // Cancel and cleanup
            cancelButton.addEventListener('click', () => {
                cleanup(stream);
            });
        })
        .catch(error => {
            console.error('Error accessing camera:', error);
            alert('Tidak dapat mengakses kamera. Silakan pilih file gambar secara manual.');
            cleanup();
            input.click(); // Fallback to file input
        });
            
        // Cleanup function
        function cleanup(stream) {
            // Stop all video tracks
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            
            // Remove DOM elements
            document.body.removeChild(videoElement);
            document.body.removeChild(canvasElement);
            document.body.removeChild(captureButton);
            document.body.removeChild(cancelButton);
        }
    } else {
        // If the browser doesn't support MediaDevices API, fallback to the file input
        console.warn('MediaDevices API not supported');
        input.click();
    }
}

function setupImagePreview() {
    document.getElementById('foto_koneksi_odp').addEventListener('change', previewImage);
    document.getElementById('foto_redaman_pelanggan').addEventListener('change', previewImage);
    document.getElementById('foto_instalasi').addEventListener('change', previewImage);
    document.getElementById('foto_rumah').addEventListener('change', previewImage);
}

function setupPelanggan() {
    var selectedValue = $('#id_pelanggan').val();

    $.ajax({
        url: '<?= base_url('instalasi/get_data_pelanggan') ?>',
        method: 'POST',
        data: {
            id_pelanggan: selectedValue,
            <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(data) {
            $.each(data, function(index, item) {
                // Insert selected value into the input field
                $('#alamat_pelanggan').val(item.alamat_pemasangan);
                $('#no_hp_pelanggan').val(item.whatsapp);
            });
        }
    });
}

function previewImage(event) {
    const input = event.target;
    const previewId = 'preview_' + input.id;
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
    $('.select2').select2();
    bsCustomFileInput.init();
    
    setupImagePreview();
    setupPelanggan();
});
</script>