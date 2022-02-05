function cekAkhirPengajuanCuti() {
    // ajax
    $.ajax({
        url: '/api/cekAkhirPengajuan',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
        }
    });
}
cekAkhirPengajuanCuti()
setInterval(cekAkhirPengajuanCuti, 1200);