<div class="container mt-4">
    <h1><?= $title ?> - <?= $router->name ?></h1>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Script Konfigurasi Mikrotik</h5>
            <button id="copy-script" class="btn btn-sm btn-primary">
                <i class="fa fa-copy"></i> Copy Script
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <p><strong>Instruksi:</strong></p>
                <p>1. Copy script di bawah ini</p>
                <p>2. Login ke RouterOS Mikrotik Anda menggunakan Winbox atau WebFig</p>
                <p>3. Buka Terminal</p>
                <p>4. Paste script dan tekan Enter</p>
                <p>5. Router Anda akan terhubung dengan RADIUS server</p>
            </div>
            
            <div class="bg-dark text-white p-3 rounded">
                <pre id="script-content"><?= $router->script ?></pre>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?= base_url('router') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#copy-script').click(function() {
        var scriptText = $('#script-content').text();
        
        // Membuat elemen textarea sementara
        var tempTextarea = $('<textarea>');
        $('body').append(tempTextarea);
        tempTextarea.val(scriptText).select();
        
        // Copy ke clipboard
        document.execCommand('copy');
        
        // Hapus textarea sementara
        tempTextarea.remove();
        
        // Ganti teks tombol sementara
        var $btn = $(this);
        $btn.html('<i class="fa fa-check"></i> Copied!');
        
        setTimeout(function() {
            $btn.html('<i class="fa fa-copy"></i> Copy Script');
        }, 2000);
    });
});
</script>