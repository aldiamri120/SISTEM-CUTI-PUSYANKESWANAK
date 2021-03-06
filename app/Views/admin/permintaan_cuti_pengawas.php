<?= $this->extend('template/admin_template') ?>
<?= $this->section('content') ?>
<div class="content">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Pengajuan Cuti Pengawas</h4>
            </div>
            <!-- create card -->
            <div class="container">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                    role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success - </strong>
                    <?php echo session()->getFlashdata('success'); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Failed - </strong>
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
                <?php endif; ?>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Pegawai</h5>
                            <!-- ganti form method post dengan AJAX -->
                            <div class="text-danger" id="notif" style="display:none">Maaf, NIK yang Anda masukkan tidak
                                berada
                                di lokasi
                                kerja
                                Anda.</div>
                            <div class="text-danger" id="notif2" style="display:none">Maaf, NIK tidak terdaftar</div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK">
                                </div>
                                <div class="col-lg-2">
                                    <input type="button" id="ceknik" class="btn btn-primary" value="Cek">
                                </div>
                            </div>

                            <div class="col-lg-2 mt-2">
                                <label for="" class="form-label">Nama Pegawai</label>
                                <input type="text" id="nama" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ajukan Cuti</h5>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <form action="/api/cuti" class="needs-validation" novalidate method="post"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="id_pegawai" id="id_pegawai" class="form-control">

                                        <div class="row mb-2">

                                            <div class="col">
                                                <label for="" class="form-label">Tipe Cuti</label>
                                                <select id="tipe_cuti" class="form-select select2" name="tipe_cuti"
                                                    required>
                                                    <option value="cuti melahirkan">Cuti Melahirkan</option>
                                                    <option value="cuti kecelakaan kerja">Cuti Kecelakaan
                                                        Kerja</option>
                                                    <option value="sakit rawat inap">Sakit Rawat Inap
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="example-date" class="form-label">Start
                                                    Date</label>
                                                <input class="form-control" type="date" id="date_start"
                                                    data-date-format="yyyy-mm-d" name="date_start" required>

                                            </div>
                                            <div class="col">
                                                <label for="example-date" class="form-label">End
                                                    Date</label>
                                                <input class="form-control" data-date-format="yyyy-mm-d" id="date_end"
                                                    type="date" name="date_end" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="example-date" class="form-label">Keterangan</label>
                                                <textarea class="form-control mb-2" id="keterangan" name="keterangan"
                                                    rows="3" placeholder="Keterangan" required></textarea>
                                            </div>
                                        </div>

                                        <?php if (session()->role == 'admin' and session()->nama_jabatan == 'pengawas') : ?>
                                        <div class="row" id="dk">
                                            <div class="col">
                                                <label for="example-date" class="form-label">Dokumen</label>
                                                <input type="file" class="form-control" id="dokumen" name="dokumen">
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <input type="submit" id="minta_cuti" class="btn btn-primary"
                                                    value="Kirim Permintaan"></input>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#tipe_cuti').change(function() {
            var tipe_cuti = $('#tipe_cuti').val();
            if (tipe_cuti == 'tahunan') {
                $('#date_start').val('<?= $date ?>');
                $('#dk').hide();
                $('#dokumen').removeAttr('required');
            } else {
                $('#date_start').val('');
                $('#dk').show();
                $('#dokumen').attr('required', 'true');
            }
        });
        $('#ceknik').click(function() {
            var nik = $('#nik').val();
            $.ajax({
                url: '/api/cekNIK',
                type: 'POST',
                data: {
                    nik: nik
                },
                success: function(data) {
                    res = JSON.parse(data);
                    if (res.status == 1) {
                        $('#nama').val(res.data
                            .nama);
                        $('#id_pegawai').val(res.data
                            .id_user);
                        $('#notif').hide();
                        $('#notif2').hide();
                    } else if (res.status == 3) {
                        $('#notif2').show();
                        $('#nama').val('');
                        $('#id_pegawai').val('');
                    } else {
                        $('#notif').show();
                        $('#nama').val('');
                        $('#id_pegawai').val('');
                    }
                }
            });
        });
    })
    </script>
</div>
<?= $this->endSection() ?>