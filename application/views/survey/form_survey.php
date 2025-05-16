<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Form Survey</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('survey/teknisi_list') ?>">Daftar Tugas Survey</a></li>
                    <li class="breadcrumb-item active">Form Survey</li>
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
                                        <td>: <?= $survey_task->nama_lengkap ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Layanan</th>
                                        <td>: <?= $survey_task->jenis_layanan ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bandwidth</th>
                                        <td>: <?= $survey_task->bandwidth ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Whatsapp</th>
                                        <td>: 
                                            <a href="https://wa.me/<?= $survey_task->whatsapp ?>" target="_blank">
                                                <?= $survey_task->whatsapp ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Pemasangan</th>
                                        <td>: <?= $survey_task->alamat_pemasangan ?></td>
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
                            <a href="https://wa.me/<?= $survey_task->whatsapp ?>" target="_blank">
                                <?= $survey_task->whatsapp ?>
                            </a>
                        </p>
                        <a href="https://wa.me/<?= $survey_task->whatsapp ?>?text=Kami%20dari%20tim%20teknisi%20Gisaka%20Media%20akan%20melakukan%20survei%20pada%20tanggal%20<?= date('d-m-Y') ?>.%20Silakan%20hubungi%20kami%20jika%20ada%20pertanyaan." 
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
                        <h3 class="card-title">Form Survey</h3>
                    </div>
                    <form action="<?= site_url('survey/save_survey') ?>" method="post" enctype="multipart/form-data" id="surveyForm">
                        <input type="hidden" name="id_survey_teknisi" value="<?= $survey_task->id_survey_teknisi ?>">
                        <input type="hidden" name="id_registrasi_customer" value="<?= $survey_task->id_registrasi_customer ?>">
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label>Jenis Survey</label>
                                <select name="jenis_survey" class="form-control" required>
                                    <option value="on-site">On-site Survey (Survey langsung ke lokasi)</option>
                                    <option value="on-desk">On-Desk Survey (Survey tanpa kunjungan langsung)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="jarak_rumah_odp">Jarak Rumah ke ODP (meter) *</label>
                                <input type="number" class="form-control" id="jarak_rumah_odp" name="jarak_rumah_odp" min="0" required>
                                <small class="text-muted">Masukkan jarak lurus dari rumah pelanggan ke ODP terdekat (dalam meter)</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_odp">ODP Terdekat</label>
                                <select name="id_odp" id="id_odp" class="form-control select2" required>
    <option value="">- Pilih ODP -</option>
    <?php foreach ($odp_list as $odp) : ?>
        <option value="<?= $odp->id_odp ?>"><?= $odp->nama_odp ?> - <?= $odp->alamat ?> (<?= $odp->nama_wilayah ?>)</option>
    <?php endforeach; ?>
</select>
                            </div>
                            
                            <div class="form-group">
                                <label for="panjang_kabel">Panjang Kabel yang Dibutuhkan (meter)</label>
                                <input type="number" class="form-control" id="panjang_kabel" name="panjang_kabel" min="0">
                                <small class="text-muted">Masukkan panjang kabel yang dibutuhkan termasuk spare untuk maintenance (dalam meter)</small>
                            </div>
                            
                            <!-- Foto Rumah -->
                            <div class="form-group">
                                <label for="foto_rumah">Foto 1</label>
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
                                    <textarea class="form-control" id="deskripsi_foto_rumah" name="deskripsi_foto_rumah" rows="2" placeholder="Masukkan deskripsi foto 1 Contoh :foto keadaan rumah"></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto ODP -->
                            <div class="form-group">
                                <label for="foto_odp">Foto 2</label>
                                <div class="input-group">
                                    <input type="file" id="foto_odp" name="foto_odp" accept="image/*" class="d-none">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_odp">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_odp" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_odp">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_odp" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_odp">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_odp" name="deskripsi_foto_odp" rows="2" placeholder="Masukkan deskripsi foto 2 Contoh :Foto keadaan odp"></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto ODP Tersisa -->
                            <div class="form-group">
                                <label for="foto_odp_tersisa">Foto 3</label>
                                <div class="input-group">
                                    <input type="file" id="foto_odp_tersisa" name="foto_odp_tersisa" accept="image/*" class="d-none">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_odp_tersisa">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_odp_tersisa" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_odp_tersisa">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_odp_tersisa" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_odp_tersisa">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_odp_tersisa" name="deskripsi_foto_odp_tersisa" rows="2" placeholder="Masukkan deskripsi foto 3 Contoh :Keadaan kabel"></textarea>
                                </div>
                            </div>
                            
                            <!-- Foto Tambahan -->
                            <div class="form-group">
                                <label for="foto_tambahan">Foto 4</label>
                                <div class="input-group">
                                    <input type="file" id="foto_tambahan" name="foto_tambahan" accept="image/*" class="d-none" >
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info camera-btn" data-target="foto_tambahan">
                                            <i class="fas fa-camera"></i> Buka Kamera
                                        </button>
                                    </div>
                                    <input type="text" class="form-control file-info" id="file_info_foto_tambahan" placeholder="Tidak ada file yang dipilih" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary browse-btn" data-target="foto_tambahan">
                                            <i class="fas fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                <div class="mt-2">
                                    <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_tambahan" style="max-height: 150px; display: none;">
                                </div>
                                <div class="mt-2">
                                    <label for="deskripsi_foto_tambahan">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_foto_tambahan" name="deskripsi_foto_tambahan" rows="2" placeholder="Masukkan deskripsi foto 4 Contoh :Foto Teknis"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="catatan">Catatan Survey</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Masukkan catatan atau deskripsi tambahan tentang hasil survey"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="status_survey">Status Survey</label>
                                <select name="status_survey" id="status_survey" class="form-control">
                                    <option value="open">Open (Initial Survey)</option>
                                    <option value="covered">Covered (Ready for Installation)</option>
                                    <option value="not covered">Not Covered (Denied)</option>
                                    <option value="pending">pending (Pending)</option>
                                </select>
                                <small class="text-muted">Pilih "Covered" jika survey sudah lengkap dan siap untuk proses instalasi</small>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Simpan Data Survey</button>
                            <a href="<?= site_url('survey/teknisi_list') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Camera capture modal -->
<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="camera-container">
                    <video id="cameraPreview" autoplay playsinline style="width: 100%; max-height: 400px; display: none;"></video>
                    <canvas id="cameraCanvas" style="display: none;"></canvas>
                    <div id="cameraError" class="alert alert-warning" style="display: none;">
                        Kamera tidak tersedia atau tidak dapat diakses. Silakan periksa izin kamera atau gunakan fitur upload file.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="captureBtn" disabled>Ambil Foto</button>
            </div>
        </div>
    </div>
</div>

<script>
// Updated camera activation function with watermark
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
        videoElement.playsInline = true;
        
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
});
</script>
<script>
    $(document).ready(function() {
        $('#id_odp').select2({
            placeholder: "Cari ODP...",
            allowClear: true
        });
    });
</script>