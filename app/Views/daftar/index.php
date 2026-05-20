<?= $this->extend('layout/dashboard_layout') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <h1><i class="fas fa-clipboard-list"></i> Pendaftaran Turnamen</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Pendaftaran</h4>
        <div style="display:flex;gap:8px">
            <button class="nav-tab active" data-tab="tab-pending" id="tab-btn-pending">Menunggu</button>
            <button class="nav-tab" data-tab="tab-lunas" id="tab-btn-lunas">Lunas</button>
        </div>
    </div>
    <div class="card-body-inner" style="padding:0">
        <div class="tab-pane active" id="tab-pending">
            <?= view('daftar/tabel', ['daftar_list' => $pending_list]) ?>
        </div>
        <div class="tab-pane" id="tab-lunas">
            <?= view('daftar/tabel', ['daftar_list' => $lunas_list]) ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('[data-tab]').forEach(function(btn){
    btn.addEventListener('click',function(){
        document.querySelectorAll('[data-tab]').forEach(b=>b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});
</script>

<?= $this->endSection() ?>