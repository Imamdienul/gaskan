<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Form instalasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('instalasi/teknisi_list') ?>">Daftar Tugas instalasi</a></li>
                    <li class="breadcrumb-item active">Form instalasi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>: <?= $activation_task->nama_lengkap ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Layanan</th>
                                        <td>: <?= $activation_task->jenis_layanan ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bandwidth</th>
                                        <td>: <?= $activation_task->bandwidth ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Whatsapp</th>
                                        <td>: 
                                            <a href="https://wa.me/<?= $activation_task->whatsapp ?>" target="_blank">
                                                <?= $activation_task->whatsapp ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pemasangan</th>
                                        <td>: <?= $activation_task->alamat_pemasangan ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pesan Instan -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pesan Instan ke Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <p>
                            Kami dari tim teknisi Gisaka Media akan melakukan survei pada tanggal <strong><?= date('d-m-Y') ?></strong>.
                            Jika ada pertanyaan, silakan hubungi kami melalui WhatsApp: 
                            <a href="https://wa.me/<?= $activation_task->whatsapp ?>" target="_blank">
                                <?= $activation_task->whatsapp ?>
                            </a>
                        </p>
                        <a href="https://wa.me/<?= $activation_task->whatsapp ?>?text=Kami%20dari%20tim%20teknisi%20Gisaka%20Media%20akan%20melakukan%20survei%20pada%20tanggal%20<?= date('d-m-Y') ?>.%20Silakan%20hubungi%20kami%20jika%20ada%20pertanyaan." 
                           target="_blank" class="btn btn-success">
                            Kirim Pesan WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    
        <div class="row">   
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Form instalasi</h3>
                    </div>
                    <form action="<?= site_url('instalasi/save_instalasi') ?>" method="post" enctype="multipart/form-data" id="instalasiForm">
                        <input type="hidden" name="id_teknisi" value="<?= $activation_task->id_teknisi ?>">
                        <input type="hidden" name="id_registrasi_customer" value="<?= $activation_task->id_registrasi_customer ?>">
                        <div class="card-body">
                            <div class="form-group required">
                                <label class="control-label" for="ftgl_pmsngn">Tanggal Pemasangan</label>
                                <div class="d-flex gap-2">
                                    <input type="date" class="form-control <?= form_error('ftgl_pmsngn') ? 'is-invalid' : '' ?>" id="ftgl_pmsngn" name="ftgl_pmsngn" value="<?= date('Y-m-d') ?>">
                                    <input type="time" class="form-control <?= form_error('fjam_pmsngn') ? 'is-invalid' : '' ?>" id="fjam_pmsngn" name="fjam_pmsngn" value="<?= date('H:i') ?>">
                                </div>
                                <div class="invalid-feedback">
                                    <?= form_error('ftgl_pmsngn') ?>
                                    <?= form_error('fjam_pmsngn') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_area">Area</label>
                                <select name="id_area" id="id_area" class="form-control select2" required>
                                    <option value="">- Pilih Area -</option>
                                    <?php foreach ($area as $ar) : ?>
                                        <option value="<?= $ar->id_wilayah ?>"><?= $ar->nama_wilayah ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_paket">Paket</label>
                                <select name="id_paket" id="id_paket" class="form-control select2" required>
                                    <option value="">- Pilih Paket -</option>
                                    <?php foreach ($paket as $pk) : ?>
                                        <option value="<?= $pk->id_paket ?>"><?= $pk->nama_paket ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        
                            <div class="form-group required">
                                <label for="odp">ODP Terdekat</label>
                                <select name="odp" id="id_odp" class="form-control select2" required>
                                    <option value="">- Pilih ODP -</option>
                                    <?php foreach ($odp_list as $odp) : ?>
                                        <option value="<?= $odp->id_odp ?>"><?= $odp->nama_odp ?> - <?= $odp->alamat ?> (<?= $odp->nama_wilayah ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        
                            <div class="form-group required">
                                <label for="port_odp">Port ODP</label>
                                <input type="text" class="form-control" id="port_odp" name="port_odp" placeholder="Masukkan Port ODP" required>
                            </div>
                        
                            <div class="form-group required">
                                <label for="pjg_kabel">Panjang Kabel (m)</label>
                                <input type="number" class="form-control" id="pjg_kabel" name="pjg_kabel" placeholder="Masukkan Panjang Kabel" required>
                            </div>
                        
                            <div class="form-group required">
                                <label for="no_roll_kabel">Nomor Roll Kabel</label>
                                <input type="text" class="form-control" id="no_roll_kabel" name="no_roll_kabel" placeholder="Masukkan Nomor Roll Kabel" required>
                            </div>
                            
                            <div class="form-group required">
                                <label for="merk_modem">Merk Modem/Router/ONT</label>
                                <input type="text" class="form-control" id="merk_modem" name="merk_modem" placeholder="Masukkan Merk Modem/Router/ONT" required>
                            </div>
                            
                            <div class="form-group required">
                                <label for="tipe_modem">Tipe Modem/Router/ONT</label>
                                <input type="text" class="form-control" id="tipe_modem" name="tipe_modem" placeholder="Masukkan Tipe Modem/Router/ONT" required>
                            </div>
                            
                            <div class="form-group required">
                                <label for="sn_modem">SN Modem/Router/ONT</label>
                                <input type="text" class="form-control" id="sn_modem"  name="sn_modem" placeholder="Masukkan SN Modem/Router/ONT" required>
                            </div>
                            
                            <div class="form-group required">
                                <label for="mac_modem">MAC Addres Modem/Router/ONT</label>
                                <input type="text" class="form-control" id="mac_modem" name="mac_modem" placeholder="Masukkan MAC Addres Modem/Router/ONT" required>
                            </div>
                            
                            <div class="form-group required">
                                <label for="mac_modem">Redaman Pelanggan</label>
                                <input type="number" class="form-control" id="redaman_plnggn" name="redaman_plnggn" placeholder="Masukkan Redaman Pelanggan" required>
                            </div>
                            
                            <!-- Foto Koneksi ODP -->
                            <div class="form-group">
                                <label for="foto_koneksi_odp">Foto Koneksi ODP</label>
                                <div class="input-group">
                                    <input type="file" id="foto_koneksi_odp" name="foto_koneksi_odp" accept="image/*" class="d-none" >
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_koneksi_odp">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_foto_koneksi_odp" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_koneksi_odp">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 10MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_koneksi_odp" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_koneksi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_koneksi" name="deskripsi_foto_koneksi" rows="2" placeholder="Masukkan deskripsi foto Koneksi ODP Contoh :foto kondisi ODP dalam keadaan terbuka setelah pemasangan koneksi ke pelanggan."></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto Redaman Pelanggan -->
                            <div class="form-group">
                                <label for="foto_redaman_pelanggan">Foto Redaman Pelanggan</label>
                                <div class="input-group">
                                    <input type="file" id="foto_redaman_pelanggan" name="foto_redaman_pelanggan" accept="image/*" class="d-none">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_redaman_pelanggan">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_redaman" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_redaman_pelanggan">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_redaman_pelanggan" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_redaman">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_redaman" name="deskripsi_foto_redaman" rows="2" placeholder="Masukkan deskripsi foto Redaman Pelanggan Contoh :Foto redaman di rumah pelanggan"></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto Instalasi -->
                            <div class="form-group">
                                <label for="foto_instalasi">Foto Instalasi</label>
                                <div class="input-group">
                                    <input type="file" id="foto_instalasi" name="foto_instalasi" accept="image/*" class="d-none">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_instalasi">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_instalasi" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_instalasi">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_instalasi" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_instalasi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_instalasi" name="deskripsi_foto_instalasi" rows="2" placeholder="Masukkan deskripsi foto instalasi Contoh :Foto ONT dan Roset setelah di pasang."></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto Rumah -->
                            <div class="form-group">
                                <label for="foto_rumah">Foto Rumah</label>
                                <div class="input-group">
                                    <input type="file" id="foto_rumah" name="foto_rumah" accept="image/*" class="d-none" >
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_rumah">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_rumah" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_rumah">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_rumah" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_rumah">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_rumah" name="deskripsi_foto_rumah" rows="2" placeholder="Masukkan deskripsi foto Rumah Contoh :Foto Rumah / Kantor Pelanggan"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="catatan">Note</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="Masukkan catatan atau deskripsi tambahan tentang hasil instalasi pelanggan"></textarea>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Simpan Data instalasi</button>
                            <a href="<?= site_url('instalasi/teknisi_list') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
// Enhanced camera activation function with professional Gisaka Media watermark
function activateCamera(inputId) {
    const input = document.getElementById(inputId);
    
    // Check if the browser supports the MediaDevices API
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Create video element for camera feed
        const videoElement = document.createElement('video');
        videoElement.style.position = 'fixed';
        videoElement.style.top = '0';
        videoElement.style.left = '0';
        videoElement.style.width = '100%';
        videoElement.style.height = '100%';
        videoElement.style.zIndex = '9999';
        videoElement.style.backgroundColor = '#000';
        videoElement.autoplay = true;
        videoElement.playsInline = true;
        
        // Create canvas for capturing photos
        const canvasElement = document.createElement('canvas');
        canvasElement.style.display = 'none';
        
        // Create UI controls
        const captureButton = document.createElement('button');
        captureButton.textContent = 'Ambil Foto';
        captureButton.style.position = 'fixed';
        captureButton.style.bottom = '20px';
        captureButton.style.left = '50%';
        captureButton.style.transform = 'translateX(-50%)';
        captureButton.style.zIndex = '10000';
        captureButton.style.padding = '12px 24px';
        captureButton.style.backgroundColor = '#007bff';
        captureButton.style.color = '#fff';
        captureButton.style.border = 'none';
        captureButton.style.borderRadius = '5px';
        captureButton.style.fontSize = '16px';
        captureButton.style.fontWeight = 'bold';
        captureButton.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        
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
        cancelButton.style.fontSize = '14px';
        cancelButton.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        
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
        statusText.style.padding = '8px 15px';
        statusText.style.borderRadius = '5px';
        statusText.style.fontSize = '14px';
        statusText.textContent = 'Mendapatkan lokasi...';
        document.body.appendChild(statusText);
        
        // Get geolocation
        let latitude = null;
        let longitude = null;
        let locationAddress = "Mencari alamat...";
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    statusText.textContent = `Lokasi: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
                    
                    // Attempt to get address using reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                locationAddress = data.display_name;
                                statusText.textContent = `Lokasi: ${locationAddress.substring(0, 50)}...`;
                            }
                        })
                        .catch(error => {
                            console.error('Error getting address:', error);
                        });
                },
                (error) => {
                    console.error('Error getting location:', error);
                    statusText.textContent = 'Tidak dapat mendapatkan lokasi';
                },
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            statusText.textContent = 'Geolocation tidak didukung oleh browser ini';
        }
        
        // Create and load Gisaka Media logo
        const gisakaLogo = new Image();
gisakaLogo.crossOrigin = "anonymous"; // Tambahkan ini untuk menghindari masalah CORS saat menggambar ke canvas
gisakaLogo.src = 'https://gisaka.media/logogisaka.png';
        // Enhanced watermark function
        function addWatermark(ctx, width, height, lat, long, address) {
            // Save the current context state
            ctx.save();
            
            // Create watermark background
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.fillRect(0, height - (height/6), width, height/6);
            
            // Add Gisaka Media logo
            const logoHeight = height/12;
            const logoWidth = logoHeight * 3;
            const logoY = height - (height/6) + 10;
            const logoX = width - logoWidth - 10;
            
            try {
                ctx.drawImage(gisakaLogo, logoX, logoY, logoWidth, logoHeight);
            } catch(e) {
                console.error('Error drawing logo:', e);
                // Fallback to text logo if image fails
                ctx.font = `bold ${Math.floor(height/25)}px Arial`;
                ctx.fillStyle = '#fff';
                ctx.textAlign = 'right';
                ctx.fillText("GISAKA", width - 80, height - (height/10));
                ctx.fillStyle = '#ff8a00';
                ctx.fillText("MEDIA", width - 10, height - (height/10));
            }
            
            // Add watermark information
            ctx.fillStyle = 'white';
            ctx.font = `${Math.floor(height/45)}px Arial`;
            ctx.textAlign = 'left';
            
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
            
            // Information positioning
            const margin = 15;
            let yPos = height - (height/6) + 25;
            const lineHeight = Math.floor(height/38);
            
            // Date and time
            ctx.fillText(`Tanggal: ${dateTimeString}`, margin, yPos);
            yPos += lineHeight;
            
            // Coordinates
            if (lat && long) {
                ctx.fillText(`Koordinat: ${lat.toFixed(6)}, ${long.toFixed(6)}`, margin, yPos);
                yPos += lineHeight;
            }
            
            // Address (with text wrapping)
            if (address && address !== "Mencari alamat...") {
                const maxWidth = width - logoWidth - 30;
                ctx.fillText("Lokasi:", margin, yPos);
                yPos += lineHeight;
                
                const words = address.split(' ');
                let line = '';
                
                for (let i = 0; i < words.length; i++) {
                    const testLine = line + words[i] + ' ';
                    const metrics = ctx.measureText(testLine);
                    
                    if (metrics.width > maxWidth && i > 0) {
                        ctx.fillText(line, margin + 10, yPos);
                        line = words[i] + ' ';
                        yPos += lineHeight;
                        
                        // Prevent text from going too far
                        if (yPos > height - 10) break;
                    } else {
                        line = testLine;
                    }
                }
                ctx.fillText(line, margin + 10, yPos);
            }
            
            // Add technician name if available
            const technicianName = document.getElementById('technician_name')?.value || 
                         "<?= $this->session->userdata('nama_user') ?>";
            if (technicianName) {
                yPos = height - margin;
                ctx.fillText(`Teknisi: ${technicianName}`, margin, yPos);
            }
            
            // Restore the context state
            ctx.restore();
        }
        
        // Get user media with correct constraints
        navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: { ideal: 'environment' },
                width: { ideal: 1920 },
                height: { ideal: 1080 }
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
                addWatermark(ctx, canvasElement.width, canvasElement.height, latitude, longitude, locationAddress);
                
                // Convert canvas to blob
                canvasElement.toBlob(blob => {
                    // Create a File object from the blob
                    const file = new File([blob], `GISAKA_MEDIA_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    
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
                }, 'image/jpeg', 0.95);
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
            document.body.removeChild(statusText);
        }
    } else {
        // If the browser doesn't support MediaDevices API, fallback to the file input
        console.warn('MediaDevices API not supported');
        input.click();
    }
}

// Event listeners for the camera and browse buttons
document.addEventListener('DOMContentLoaded', function() {
    // Camera buttons
    const cameraButtons = document.querySelectorAll('.camera-btn');
    cameraButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            activateCamera(targetId);
        });
    });
    
    // Browse buttons
    const browseButtons = document.querySelectorAll('.browse-btn');
    browseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).click();
        });
    });
    
    // File input change events
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileInfoId = 'file_info_' + this.id;
            const previewId = 'preview_' + this.id;
            
            const fileInfo = document.getElementById(fileInfoId);
            const preview = document.getElementById(previewId);
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Update file info
                if (fileInfo) {
                    fileInfo.value = file.name;
                }
                
                // Update preview
                if (preview) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                }
            } else {
                // Clear if no file selected
                if (fileInfo) {
                    fileInfo.value = 'Tidak ada file yang dipilih';
                }
                
                if (preview) {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }
        });
    });
    
    // Initialize Select2 if jQuery is available
    if (typeof $ !== 'undefined') {
        $('#id_odp').select2({
            placeholder: "Cari ODP...",
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
    }
});
</script>