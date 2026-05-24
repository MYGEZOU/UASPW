<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-upload"></i> <?= esc($title) ?></h1>
</div>

<div style="max-width:600px;margin:0 auto">
    <div class="card">
        <div class="card-header">
            <h4>Upload Bukti Pembayaran Pendaftaran</h4>
        </div>
        <form action="<?= base_url('pembayaran/upload/'.$daftar['id_daftar']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card-body-inner">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px;"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div style="margin-bottom: 20px; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 8px;">
                <p style="margin: 0 0 5px 0;"><strong>Turnamen:</strong> <?= esc($turnamen['nama_turnamen']) ?> (<?= esc($turnamen['nama_game']) ?>)</p>
                <p style="margin: 0 0 5px 0;"><strong>Tanggal Daftar:</strong> <?= date('d M Y H:i', strtotime($daftar['tanggal_daftar'])) ?></p>
                <p style="margin: 0; font-size: 18px; color: #4facfe;"><strong>Total Dibayar: Rp <?= number_format($turnamen['biaya_pendaftaran'], 0, ',', '.') ?></strong></p>
            </div>
                
                <div class="form-group">
                    <label class="form-label">Metode Pembayaran (Transfer Ke)</label>
                    <select class="form-control" id="pilih_metode" onchange="showRekening()" required>
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="mandiri">Transfer Bank MANDIRI</option>
                        <option value="dana">DANA</option>
                        <option value="gopay">GoPay</option>
                        <option value="ovo">OVO</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>
                
                <div id="info_rekening" class="alert-info-form" style="display:none; text-align:center; padding:20px;">
                    <p style="margin:0 0 5px 0; font-size:12px; color:var(--text-muted)">Silakan transfer nominal sesuai tagihan ke rekening berikut:</p>
                    <h2 id="nomor_rekening" style="margin:5px 0; color:#fff; letter-spacing:2px; font-weight:800;"></h2>
                    <p style="margin:0; font-size:14px; font-weight:600; color:#5383fe" id="nama_rekening"></p>
                    <div id="qris_container" style="display:none; margin-top:15px;">
                        <img src="<?= base_url('uploads/QRIS.jpeg') ?>" alt="QRIS Barcode" width="200" height="200" loading="lazy" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">File Bukti Transfer (JPG/PNG, Max 2MB)</label>
                    <div style="border: 2px dashed rgba(255,255,255,.15); border-radius: 12px; padding: 20px; text-align:center; transition: border-color .2s; cursor:pointer; position:relative;" id="dropzone" onclick="document.getElementById('buktiInput').click()">
                        <div id="preview_placeholder">
                            <i class="fas fa-cloud-upload-alt" style="font-size:32px; color:rgba(255,255,255,.2); display:block; margin-bottom:8px;"></i>
                            <p style="margin:0; font-size:13px; color:rgba(255,255,255,.35)">Klik atau drag & drop gambar di sini</p>
                            <p style="margin:4px 0 0; font-size:11px; color:rgba(255,255,255,.2)">JPG, PNG, PDF — Maks 2MB</p>
                        </div>
                        <img id="preview_img" src="" alt="Preview" style="display:none; max-width:100%; max-height:220px; border-radius:8px; margin:0 auto;">
                        <input type="file" id="buktiInput" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                               style="position:absolute; opacity:0; width:0; height:0;" onchange="previewFile(this)">
                    </div>
                    <div id="file_name_info" style="margin-top:6px; font-size:11px; color:rgba(255,255,255,.4); display:none;"></div>
                </div>
                
                <?php if(!empty($daftar['bukti_pembayaran'])): ?>
                <div class="form-group" style="margin-top: 15px;">
                    <label class="form-label">Bukti Sebelumnya:</label><br>
                    <a href="<?= base_url('uploads/bukti_pembayaran/' . $daftar['bukti_pembayaran']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat File</a>
                    <span style="color:#aaa; font-size:12px; margin-left:10px;">Mengupload baru akan menimpa file ini.</span>
                </div>
                <?php endif; ?>

            </div>
            <div class="card-footer-inner" style="display:flex; gap:10px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload & Simpan</button>
                <a href="<?= base_url('pembayaran/saya') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
function showRekening() {
    const metode = document.getElementById('pilih_metode').value;
    const info = document.getElementById('info_rekening');
    const no = document.getElementById('nomor_rekening');
    const nama = document.getElementById('nama_rekening');
    const methods = {
        mandiri:   { no: '1060019317398',   nama: 'a.n. SATRIA DARZKINE RKT (MANDIRI)' },
        dana:  { no: '0822 6518 0375',     nama: 'a.n. SATRIA DARZKINE RKT  (DANA)' },
        gopay: { no: '0822 6518 0375',     nama: 'a.n. SATRIA DARZKINE RKT  (GoPay)' },
        ovo:   { no: '0822 6518 0375',     nama: 'a.n. SATRIA DARZKINE RKT  (OVO)' },
        qris:  { no: '0822 6518 0375',     nama: 'a.n. kopi sat (QRIS)' },
    };
    if (methods[metode]) {
        no.innerText = methods[metode].no;
        nama.innerText = methods[metode].nama;
        info.style.display = 'block';
        
        if (metode === 'qris') {
            document.getElementById('qris_container').style.display = 'block';
            no.style.display = 'none';
        } else {
            document.getElementById('qris_container').style.display = 'none';
            no.style.display = 'block';
        }
    } else {
        info.style.display = 'none';
    }
}

function previewFile(input) {
    const file = input.files[0];
    const preview = document.getElementById('preview_img');
    const placeholder = document.getElementById('preview_placeholder');
    const info = document.getElementById('file_name_info');
    const dropzone = document.getElementById('dropzone');
    if (!file) return;
    info.textContent = `📎 ${file.name} (${(file.size/1024).toFixed(1)} KB)`;
    info.style.display = 'block';
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            dropzone.style.borderColor = 'rgba(83,131,254,.5)';
            dropzone.style.background = 'rgba(83,131,254,.05)';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        placeholder.innerHTML = '<i class="fas fa-file-pdf" style="font-size:40px; color:#FF4B2B; display:block; margin-bottom:8px;"></i><p style="margin:0; color:rgba(255,255,255,.6)">File PDF dipilih</p>';
        dropzone.style.borderColor = 'rgba(255,75,43,.4)';
    }
}

// Drag & drop support
const dz = document.getElementById('dropzone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.style.borderColor = 'rgba(83,131,254,.6)'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor = 'rgba(255,255,255,.15)'; });
dz.addEventListener('drop', e => {
    e.preventDefault();
    const inp = document.getElementById('buktiInput');
    const dt = new DataTransfer();
    dt.items.add(e.dataTransfer.files[0]);
    inp.files = dt.files;
    previewFile(inp);
});
</script>

<?= $this->endSection() ?>
