<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KASA VİRMAN (TRANSFER)</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_virma_ekle"><i class="fa fa-plus"></i> Yeni Transfer
            </button>
            <button class="btn btn-info btn-sm" id="kasa_virman_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_kasa_virman">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_kasa_virman">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="kasa_virman_table">
            <thead>
            <tr>
                <th>Transfer Tarihi</th>
                <th>Alan Kasa</th>
                <th>Gönderen Kasa</th>
                <th>Transfer Miktarı</th>
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
                        <th style="text-align: center">Genel Toplam</th>
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
        var table = $('#kasa_virman_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            "info": false,
            bAutoWidth: false,
            aoColumns: [
                {sWidth: '0%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '2%'},
                {sWidth: '0%'}
            ],
            createdRow: function (row, data, dataIndex) {
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })
        $.get("controller/kasa_controller/sql.php?islem=virmanlari_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let toplam_miktar = 0;
                json.forEach(function (item) {
                    var insert_date = item.insert_datetime;
                    var split = insert_date.split(" ");
                    var cikti = split[0];
                    var split2 = cikti.split("-");
                    var gun = split2[2]
                    var ay = split2[1]
                    var yil = split2[0]
                    var arr = [gun, ay, yil];
                    var insert_datetime = arr.join("/");

                    var miktar = item.gonderilen_miktar;
                    miktar = parseFloat(miktar);
                    toplam_miktar += miktar;
                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                    var new_row = table.row.add([insert_datetime, item.alan_kasa_adi, item.kasa_adi, miktar, item.aciklama, "<button class='btn btn-sm kasa_virman_guncelle_sql' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm kasa_virman_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                    $(new_row).find('td').eq(5).css('text-align', 'left');
                })
                toplam_miktar = toplam_miktar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $(".tahsilat_tl").html("");
                $(".tahsilat_tl").html(toplam_miktar);
            }
        })

        $("body").off("click", ".kasa_virman_guncelle_sql").on("click", ".kasa_virman_guncelle_sql", function () {
            let id = $(this).attr("data-id");
            $.get("modals/kasa_modal/kasa_virman_modal.php?islem=yeni_virman_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        });

        $("body").off("click", "#kasa_virman_filtrele").on("click", "#kasa_virman_filtrele", function () {
            let bas_tarih = $(".bas_tarih_kasa_virman").val();
            let bit_tarih = $(".bit_tarih_kasa_virman").val();
            $.get("controller/kasa_controller/sql.php?islem=virmanlari_getir_sql",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih
                }
                , function (result) {
                    table.clear().draw(false);
                    if (result != 2) {
                        var json = JSON.parse(result);
                        let toplam_miktar = 0;
                        json.forEach(function (item) {
                            var insert_date = item.insert_datetime;
                            var split = insert_date.split(" ");
                            var cikti = split[0];
                            var split2 = cikti.split("-");
                            var gun = split2[2]
                            var ay = split2[1]
                            var yil = split2[0]
                            var arr = [gun, ay, yil];
                            var insert_datetime = arr.join("/");

                            var miktar = item.gonderilen_miktar;
                            miktar = parseFloat(miktar);
                            toplam_miktar += miktar;
                            miktar = miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            var new_row = table.row.add([insert_datetime, item.alan_kasa_adi, item.kasa_adi, miktar, item.aciklama, "<button class='btn btn-sm kasa_virman_guncelle_sql' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm kasa_virman_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(4).css('text-align', 'left');
                            $(new_row).find('td').eq(5).css('text-align', 'left');
                        })
                        toplam_miktar = toplam_miktar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".tahsilat_tl").html("");
                        $(".tahsilat_tl").html(toplam_miktar);
                    } else {
                        table.clear().draw(false);
                    }
                })
        });
    });


    $("body").off("click", ".kasa_virman_sil").on("click", ".kasa_virman_sil", function () {
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
                        url: "controller/kasa_controller/sql.php?islem=virman_cikart",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Virman Fişi Silindi',
                                    'success'
                                );
                                $.get("view/kasa_virman.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/kasa_virman.php", function (getList) {
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

    $("body").off("click", "#yeni_virma_ekle").on("click", "#yeni_virma_ekle", function () {
        $.get("modals/kasa_modal/kasa_virman_modal.php?islem=yeni_virman_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>