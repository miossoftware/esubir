<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>MAHSUP FİŞLERİ</div>
    </div>

    <div class="col-12 row ">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_mahsup_fisi_main"><i class="fa fa-plus"></i> Yeni Mahsup
                Fişi
            </button>
            <button class="btn btn-info btn-sm" id="mahsup_fisi_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_mahsup">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_mahsup">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="mahsup_table">
            <thead>
            <tr>
                <th>Belge No</th>
                <th>İşlem Tarihi</th>
                <th>Açıklama</th>
                <th>Toplam Borç</th>
                <th>Toplam Alacak</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM İŞLEM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_islem">0,00</th>
                <th style="text-align: right; font-size: 14px;"></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var parts = dateString.split('/');
                return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#mahsup_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[1, 'desc']],
            "info": false,
            "paging": false,
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            columns: [
                {"data": "belge_no"},
                {"data": "islem_tarihi"},
                {"data": "aciklama"},
                {"data": "borc"},
                {"data": "alacak"},
                {"data": "button"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/cari_controller/sql.php?islem=mahsup_fislerini_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let toplam_islem = 0;
                json.forEach(function (item) {
                    var alacak = item.toplam_alacak;
                    alacak = parseFloat(alacak);
                    alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    var borc = item.toplam_borc;
                    borc = parseFloat(borc);
                    toplam_islem += borc;
                    borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    var islem_tarihi = item.islem_tarihi;
                    if (islem_tarihi != null){
                        var split = islem_tarihi.split(" ");
                        var split_cikti = split[0];
                        var split2 = split_cikti.split("-");
                        var gun = split2[2];
                        var ay = split2[1];
                        var yil = split2[0];
                        var arr = [gun, ay, yil];
                        islem_tarihi = arr.join("/");
                    }
                    let newRow = {
                        belge_no: item.belge_no,
                        islem_tarihi: islem_tarihi,
                        aciklama: item.aciklama,
                        borc: borc + " " + item.doviz_tur,
                        alacak: alacak + " " + item.doviz_tur,
                        button: "<button style='background-color: #F6FA70' class='btn btn-sm mahsup_detay_getir' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button>  <button class='btn btn-danger btn-sm mahsup_fisi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                toplam_islem = toplam_islem.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $(".toplam_islem").html("");
                $(".toplam_islem").html(toplam_islem);
                table.rows.add(basilacak_arr).draw(false);
            }
        })
        $("body").off("click","#mahsup_fisi_filtrele").on("click","#mahsup_fisi_filtrele",function (){
            var bas_tarih = $(".bas_tarih_mahsup").val();
            var bit_tarih = $(".bit_tarih_mahsup").val();
            let toplam_islem = 0;
            $.get("controller/cari_controller/sql.php?islem=mahsup_fislerini_getir",
                {
                    bas_tarih:bas_tarih,
                    bit_tarih:bit_tarih
                }
                ,function (result) {
                if (result != 2) {
                    table.clear().draw(false);
                    var json = JSON.parse(result);
                    var basilacak_arr = [];
                    json.forEach(function (item) {
                        var alacak = item.toplam_alacak;
                        alacak = parseFloat(alacak);
                        toplam_islem += alacak;
                        alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        var borc = item.toplam_borc;
                        borc = parseFloat(borc);
                        borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        var islem_tarihi = item.islem_tarihi;
                        var split = islem_tarihi.split(" ");
                        var split_cikti = split[0];
                        var split2 = split_cikti.split("-");
                        var gun = split2[2];
                        var ay = split2[1];
                        var yil = split2[0];
                        var arr = [gun, ay, yil];
                        islem_tarihi = arr.join("/");
                        let newRow = {
                            belge_no: item.belge_no,
                            islem_tarihi: islem_tarihi,
                            aciklama: item.aciklama,
                            borc: borc + " " + item.doviz_tur,
                            alacak: alacak + " " + item.doviz_tur,
                            button: "<button style='background-color: #F6FA70' class='btn btn-sm mahsup_detay_getir' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button>  <button class='btn btn-danger btn-sm mahsup_fisi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRow);

                    });
                    toplam_islem = toplam_islem.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $(".toplam_islem").html("");
                    $(".toplam_islem").html(toplam_islem);
                    table.rows.add(basilacak_arr).draw(false);
                }
            })
        })
    })

    $("body").off("click", ".mahsup_detay_getir").on("click", ".mahsup_detay_getir", function () {
        var id = $(this).attr("data-id");
        $.get("modals/cari_modal/mahsup_page.php?islem=mahsup_bilgileri_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", ".mahsup_fisi_sil").on("click", ".mahsup_fisi_sil", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Cariyi seçiniz',
                'warning'
            );
        } else {
            Swal.fire({
                title: 'Silme Nedeni Giriniz',
                input: 'text',
                inputPlaceholder: 'Silme Nedeni',
                showCancelButton: true,
                confirmButtonText: 'Tamam',
                cancelButtonText: 'İptal',
                allowOutsideClick: false,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silme Nedeni Boş Bırakılamaz';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const delete_detail = result.value;
                    $.ajax({
                        url: "controller/cari_controller/sql.php?islem=mahsup_acilis_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Mahsup Fişi Silindi',
                                    'success'
                                );
                                $.get("view/mahsup_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/mahsup_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        }
    });

    $("body").off("click", "#yeni_mahsup_fisi_main").on("click", "#yeni_mahsup_fisi_main", function () {
        $.get("modals/cari_modal/mahsup_modal.php?islem=yeni_mahsup_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });


</script>