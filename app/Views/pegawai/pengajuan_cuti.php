<?= $this->extend('template/pegawai_template') ?>
<?= $this->section('content') ?>
<div class="content">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Pengajuan Cuti PJLP</h4>
            </div>
            <!-- create card -->
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success - </strong>
                            <?php echo session()->getFlashdata('success'); ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Failed - </strong>
                            <?php echo session()->getFlashdata('error'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="row mb-2">
                            <h3>Sisa Cuti Tahunan Anda : <?= $sisa_cuti ?> Hari</h3>
                            <div class="col-12">
                                <form action="/api/cuti" class="needs-validation" novalidate method="post"
                                    enctype="multipart/form-data">
                                    <div class="row mb-2">

                                        <div class="col">
                                            <label for="" class="form-label">Tipe Cuti</label>
                                            <select id="tipe_cuti" class="form-select select2" name="tipe_cuti"
                                                required>
                                                <option value="tahunan">Cuti Tahunan</option>
                                                <option value="cuti mendadak">Cuti Mendadak</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="example-date" class="form-label">Start
                                                Date</label>
                                            <input class="form-control" type="date" id="date_start"
                                                data-date-format="yyyy-mm-d" value="<?= $date ?>" name="date_start"
                                                required>

                                        </div>
                                        <div class="col">
                                            <label for="example-date" class="form-label">End
                                                Date</label>
                                            <input class="form-control" data-date-format="yyyy-mm-d" id="date_end"
                                                type="date" name="date_end" required>
                                            <p class="text-danger" id="info" style="display:None">Cuti mendadak tidak
                                                boleh lebih dari 2 hari
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="example-date" class="form-label">Keterangan</label>
                                            <textarea class="form-control mb-2" id="keterangan" name="keterangan"
                                                rows="3" placeholder="Keterangan" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col">
                                            <input type="submit" id="minta_cuti" onclick="cek_mendadak()"
                                                class="btn btn-primary" value="Kirim Permintaan"></input>
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
    <script>
    function cek_mendadak() {
        var date_start = new Date($('#date_start').val());
        var date_end = new Date($('#date_end').val());
        // hitung waktu
        var timeDiff = Math.abs(date_end.getTime() - date_start.getTime());
        // cek jarak waktu
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        if (diffDays > 2) {
            // show error in end_date
            $('#date_end').addClass('is-invalid');
            $('#info').show("slow").delay(1300).hide("slow");
            $('#date_end').val('');
            return false
        } else {
            $('#date_end').removeClass('is-invalid');
            $('#info').hide();
        }
    }
    $(document).ready(function() {
        $('#tipe_cuti').change(function() {
            var tipe_cuti = $('#tipe_cuti').val();
            if (tipe_cuti == 'tahunan') {
                $('#date_start').val('<?= $date ?>');
                $('#date_end').removeClass('is-invalid');
                $('#info').hide();
            } else {
                $('#date_start').val('');

            }
        });

    })
    </script>
</div>
<?= $this->endSection() ?>