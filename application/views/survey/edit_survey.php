<!-- application/views/survey/edit_survey.php -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Hasil Survey</h3>
                <div class="card-tools">
                    <a href="<?= site_url('survey/detail_survey/' . encrypt_url($customer->id_registrasi_customer)) ?>" class="btn btn-secondary">
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

                <form action="<?= site_url('survey/update_survey') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_survey_pelanggan" value="<?= $survey->id_survey_pelanggan ?>">
                    <input type="hidden" name="id_survey_teknisi" value="<?= $survey->id_survey_teknisi ?>">
                    <input type="hidden" name="id_registrasi_customer" value="<?= $customer->id_registrasi_customer ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_survey">Jenis Survey <span class="text-danger">*</span></label>
                                <select name="jenis_survey" id="jenis_survey" class="form-control" required>
                                    <option value="on-site" <?= $survey->jenis_survey == 'on-site' ? 'selected' : '' ?>>on-site</option>
                                    <option value="on-desk" <?= $survey->jenis_survey == 'on-desk' ? 'selected' : '' ?>>On-desk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_odp">ODP <span class="text-danger">*</span></label>
<select name="id_odp" id="id_odp" class="form-control select2" required>
    <option value="">Pilih ODP</option>
    <?php foreach ($odp_list as $odp) : ?>
        <option value="<?= $odp->id_odp ?>" <?= $survey->id_odp == $odp->id_odp ? 'selected' : '' ?>>
            <?= $odp->nama_odp ?> - <?= $odp->alamat ?> (<?= $odp->terpakai ?>/<?= $odp->kapasitas ?>)
        </option>
    <?php endforeach; ?>
</select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jarak_rumah_odp">Jarak Rumah ke ODP (meter) <span class="text-danger">*</span></label>
                                <input type="number" name="jarak_rumah_odp" id="jarak_rumah_odp" class="form-control" value="<?= $survey->jarak_rumah_odp ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="panjang_kabel">Panjang Kabel (meter)</label>
                                <input type="number" name="panjang_kabel" id="panjang_kabel" class="form-control" value="<?= $survey->panjang_kabel ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Foto-foto Survey -->
                    <div class="card mt-4">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Foto-foto Survey</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Foto Rumah -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_rumah">Foto 1</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_rumah" name="foto_rumah" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_rumah">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info" onclick="activateCamera('foto_rumah')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($survey->foto_rumah)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/survey/' . $survey->foto_rumah) ?>" alt="Foto Rumah" class="img-thumbnail preview-img" id="preview_foto_rumah" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_rumah" value="<?= $survey->foto_rumah ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_rumah" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_rumah">Deskripsi</label>
                                        <textarea name="deskripsi_foto_rumah" id="deskripsi_foto_rumah" class="form-control" rows="2"><?= $survey->deskripsi_foto_rumah ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Foto ODP -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_odp">Foto 2</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_odp" name="foto_odp" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_odp">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info" onclick="activateCamera('foto_odp')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($survey->foto_odp)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/survey/' . $survey->foto_odp) ?>" alt="Foto ODP" class="img-thumbnail preview-img" id="preview_foto_odp" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_odp" value="<?= $survey->foto_odp ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_odp" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_odp">Deskripsi</label>
                                        <textarea name="deskripsi_foto_odp" id="deskripsi_foto_odp" class="form-control" rows="2"><?= $survey->deskripsi_foto_odp ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <!-- Foto ODP Tersisa -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_odp_tersisa">Foto 3</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_odp_tersisa" name="foto_odp_tersisa" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_odp_tersisa">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info" onclick="activateCamera('foto_odp_tersisa')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($survey->foto_odp_tersisa)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/survey/' . $survey->foto_odp_tersisa) ?>" alt="Foto ODP Tersisa" class="img-thumbnail preview-img" id="preview_foto_odp_tersisa" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_odp_tersisa" value="<?= $survey->foto_odp_tersisa ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_odp_tersisa" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_odp_tersisa">Deskripsi</label>
                                        <textarea name="deskripsi_foto_odp_tersisa" id="deskripsi_foto_odp_tersisa" class="form-control" rows="2"><?= $survey->deskripsi_foto_odp_tersisa ?></textarea>
                                    </div>
                                </div>
                                
                                <!-- Foto Tambahan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto_tambahan">Foto 4</label>
                                        <div class="d-flex flex-column">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_tambahan" name="foto_tambahan" accept="image/*" capture="environment">
                                                    <label class="custom-file-label" for="foto_tambahan">Pilih file</label>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-info" onclick="activateCamera('foto_tambahan')">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                            </div>
                                        </div>
                                        <?php if (!empty($survey->foto_tambahan)) : ?>
                                            <div class="mt-2">
                                                <img src="<?= base_url('uploads/survey/' . $survey->foto_tambahan) ?>" alt="Foto Tambahan" class="img-thumbnail preview-img" id="preview_foto_tambahan" style="max-height: 100px">
                                                <input type="hidden" name="old_foto_tambahan" value="<?= $survey->foto_tambahan ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2">
                                                <img src="" alt="Preview" class="img-thumbnail preview-img" id="preview_foto_tambahan" style="max-height: 100px; display: none;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_foto_tambahan">Deskripsi</label>
                                        <textarea name="deskripsi_foto_tambahan" id="deskripsi_foto_tambahan" class="form-control" rows="2"><?= $survey->deskripsi_foto_tambahan ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="catatan">Catatan Survey</label>
                        <textarea name="catatan" id="catatan" rows="4" class="form-control"><?= $survey->catatan ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status_survey">Status Survey <span class="text-danger">*</span></label>
                        <select name="status_survey" id="status_survey" class="form-control" required>
                            <option value="open" <?= $survey->status_survey == 'open' ? 'selected' : '' ?>>open</option>
                            <option value="covered" <?= $survey->status_survey == 'covered' ? 'selected' : '' ?>>covered</option>
                            <option value="pending" <?= $survey->status_survey == 'pending' ? 'selected' : '' ?>>pending</option>
                            <option value="not covered" <?= $survey->status_survey == 'not covered' ? 'selected' : '' ?>>not covered</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_survey">Tanggal Survey</label>
                        <input type="datetime-local" name="tanggal_survey" id="tanggal_survey" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($survey->tanggal_survey)) ?>">
                    </div>

                    <div class="form-group text-right">
                        <a href="<?= site_url('survey/detail_survey/' . encrypt_url($customer->id_registrasi_customer)) ?>" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
        
        // Get user media
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false })
            .then(stream => {
                videoElement.srcObject = stream;
                
                // Capture photo when button is clicked
                captureButton.addEventListener('click', () => {
                    // Set canvas dimensions to match video
                    canvasElement.width = videoElement.videoWidth;
                    canvasElement.height = videoElement.videoHeight;
                    
                    // Draw the video frame to the canvas
                    canvasElement.getContext('2d').drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                    
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
                        
                        // Update the file input label
                        const label = input.nextElementSibling;
                        if (label && label.classList.contains('custom-file-label')) {
                            label.textContent = file.name;
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
    document.getElementById('foto_rumah').addEventListener('change', previewImage);
    document.getElementById('foto_odp').addEventListener('change', previewImage);
    document.getElementById('foto_odp_tersisa').addEventListener('change', previewImage);
    document.getElementById('foto_tambahan').addEventListener('change', previewImage);
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