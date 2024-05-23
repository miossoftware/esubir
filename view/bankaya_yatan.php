<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BANKAYA YATAN</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="bankaya_para_yatir"><i class="fa fa-plus"></i> Bankaya Para
                Yatır
            </button>
            <button class="btn btn-info btn-sm" id="bankaya_yatan_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_bankaya_yatan">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_bankaya_yatan">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="bankaya_gonderilen_para_table">
            <thead>
            <tr>
                <th>Gönderilen Tarih</th>
                <th>Gönderen Kasa</th>
                <th>Yatan Banka Hesabı</th>
                <th>Gönderilen Tutar</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-12 row no-gutters mt-1">
        <div class="col-12 row mt-2 no-gutters">
            <div class="col-3"></div>
            <div class="col-md-1">
                <table class="table table-sm table-bordered display" style="background-color: white">
                    <tr>
                        <th>Döviz Türü</th>
                    </tr>
                    <tr>
                        <th>TL</th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Yatan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="tahsilat_tl" style="text-align: right">0,00 TL</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
        var table = $('#bankaya_gonderilen_para_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("stok_list_selected");
            },
            "order": [[0, 'desc']],
            columnDefs: [
                { targets: 0, type: "date-eu" }
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/kasa_controller/sql.php?islem=bankaya_yatirilan_paralari_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let toplam_yatan = 0;

                json.forEach(function (item) {
                    let gonderilen_tutar = item.gonderilen_tutar;
                    gonderilen_tutar = parseFloat(gonderilen_tutar);
                    toplam_yatan += gonderilen_tutar;
                    gonderilen_tutar = gonderilen_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let gonderilen_tarih = item.insert_datetime;
                    gonderilen_tarih = gonderilen_tarih.split(" ");
                    gonderilen_tarih = gonderilen_tarih[0];
                    gonderilen_tarih = gonderilen_tarih.split("-");
                    var gun = gonderilen_tarih[2];
                    var ay = gonderilen_tarih[1];
                    var yil = gonderilen_tarih[0];
                    var arr = [gun, ay, yil];
                    gonderilen_tarih = arr.join("/");

                    var new_row = table.row.add([gonderilen_tarih, item.kasa_adi, item.banka_adi, gonderilen_tutar, item.aciklama, "<button class='btn btn-sm bankaya_yatan_guncelle_button' style='background-color: #F6FA70' data-id='"+item.id+"'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm transfer_iptal' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                });
                toplam_yatan = toplam_yatan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $(".tahsilat_tl").html("");
                $(".tahsilat_tl").html(toplam_yatan);
            }
        });

        $("body").off("click",".bankaya_yatan_guncelle_button").on("click",".bankaya_yatan_guncelle_button",function (){
            let id = $(this).attr("data-id");
            $.get("modals/kasa_modal/bankaya_gonderilen_modal.php?islem=bankaya_para_gonder_guncelle_modal",{id:id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        });

        $("body").off("click","#bankaya_yatan_filtrele").on("click","#bankaya_yatan_filtrele",function (){
            let bas_tarih = $(".bas_tarih_bankaya_yatan").val();
            let bit_tarih = $(".bit_tarih_bankaya_yatan").val();
            $.get("controller/kasa_controller/sql.php?islem=bankaya_yatirilan_paralari_getir_sql",
                {
                    bas_tarih:bas_tarih,
                    bit_tarih:bit_tarih
                }
                , function (result) {
                table.clear().draw(false);
                if (result != 2) {
                    var json = JSON.parse(result);
                    let toplam_yatan = 0;
                    json.forEach(function (item) {
                        let gonderilen_tutar = item.gonderilen_tutar;
                        gonderilen_tutar = parseFloat(gonderilen_tutar);
                        toplam_yatan += gonderilen_tutar;
                        gonderilen_tutar = gonderilen_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        let gonderilen_tarih = item.insert_datetime;
                        gonderilen_tarih = gonderilen_tarih.split(" ");
                        gonderilen_tarih = gonderilen_tarih[0];
                        gonderilen_tarih = gonderilen_tarih.split("-");
                        var gun = gonderilen_tarih[2];
                        var ay = gonderilen_tarih[1];
                        var yil = gonderilen_tarih[0];
                        var arr = [gun, ay, yil];
                        gonderilen_tarih = arr.join("/");

                        var new_row = table.row.add([gonderilen_tarih, item.kasa_adi, item.banka_adi, gonderilen_tutar, item.aciklama, "<button class='btn btn-sm bankaya_yatan_guncelle_button' style='background-color: #F6FA70' data-id='"+item.id+"'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm transfer_iptal' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $(new_row).find('td').eq(0).css('text-align', 'left');
                        $(new_row).find('td').eq(1).css('text-align', 'left');
                        $(new_row).find('td').eq(2).css('text-align', 'left');
                        $(new_row).find('td').eq(4).css('text-align', 'left');
                    });
                    toplam_yatan = toplam_yatan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $(".tahsilat_tl").html("");
                    $(".tahsilat_tl").html(toplam_yatan);
                }
            })
        });
    });

    $("body").off("click", ".transfer_iptal").on("click", ".transfer_iptal", function () {
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
                        url: "controller/kasa_controller/sql.php?islem=kasadan_bankaya_iptal_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Aktarım Fişi Silindi',
                                    'success'
                                );
                                $.get("view/bankaya_yatan.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/bankaya_yatan.php", function (getList) {
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
    })

    $("body").off("click", "#bankaya_para_yatir").on("click", "#bankaya_para_yatir", function () {
        $.get("modals/kasa_modal/bankaya_gonderilen_modal.php?islem=bankaya_para_gonder_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

</script>