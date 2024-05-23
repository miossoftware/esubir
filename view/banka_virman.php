<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BANKA VİRMAN (TRANSFER)</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_banka_virman_ekle"><i class="fa fa-plus"></i> Yeni
                Transfer
            </button>
            <button class="btn btn-info btn-sm" id="banka_virman_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_banka_virman">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_banka_virman">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="banka_virman_table">
            <thead>
            <tr>
                <th>Transfer Tarihi</th>
                <th>Alan Banka</th>
                <th>Gönderen Banka</th>
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
                        <th style="text-align: center">Toplam Transfer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="giris_tl" style="text-align: right">0,00 TL</td>
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
        var table = $('#banka_virman_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/banka_controller/sql.php?islem=virmanlari_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let transfer = 0;
                json.forEach(function (item) {
                    let virman_tarihi = item.virman_tarihi;
                    virman_tarihi = virman_tarihi.split(" ");
                    virman_tarihi = virman_tarihi[0];
                    virman_tarihi = virman_tarihi.split("-");
                    let gun = virman_tarihi[2];
                    let ay = virman_tarihi[1];
                    let yil = virman_tarihi[0];
                    let arr = [gun, ay, yil];
                    virman_tarihi = arr.join("/");
                    var gonderilen_miktar = item.gonderilen_miktar;
                    gonderilen_miktar = parseFloat(gonderilen_miktar);
                    transfer += gonderilen_miktar;
                    gonderilen_miktar = gonderilen_miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    var new_row = table.row.add([virman_tarihi, item.alan_banka, item.gonderen_banka, gonderilen_miktar, item.aciklama, "<button class='btn btn-sm banka_virman_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm virman_iptal_et' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                })
                transfer = transfer.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $(".giris_tl").html("");
                $(".giris_tl").html(transfer);
            }
        });

        $("body").off("click", ".banka_virman_guncelle_button").on("click", ".banka_virman_guncelle_button", function () {
            let id = $(this).attr("data-id");
            $.get("modals/banka_modal/yeni_banka_virman_ekle.php?islem=banka_virman_guncelle", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        })

        $("body").off("click", "#banka_virman_filtrele").on("click", "#banka_virman_filtrele", function () {
            let bas_tarih = $(".bas_tarih_banka_virman").val();
            let bit_tarih = $(".bit_tarih_banka_virman").val();
            $.get("controller/banka_controller/sql.php?islem=virmanlari_getir_sql",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih
                }
                , function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        let transfer = 0;
                        table.clear().draw(false);
                        json.forEach(function (item) {
                            var gonderilen_miktar = item.gonderilen_miktar;
                            gonderilen_miktar = parseFloat(gonderilen_miktar);
                            transfer += gonderilen_miktar;
                            gonderilen_miktar = gonderilen_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            let virman_tarihi = item.virman_tarihi;
                            virman_tarihi = virman_tarihi.split(" ");
                            virman_tarihi = virman_tarihi[0];
                            virman_tarihi = virman_tarihi.split("-");
                            let gun = virman_tarihi[2];
                            let ay = virman_tarihi[1];
                            let yil = virman_tarihi[0];
                            let arr = [gun, ay, yil];
                            virman_tarihi = arr.join("/");

                            var new_row = table.row.add([virman_tarihi, item.alan_banka, item.gonderen_banka, gonderilen_miktar, item.aciklama, "<button class='btn btn-sm banka_virman_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm virman_iptal_et' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(4).css('text-align', 'left');
                        })
                        transfer = transfer.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".giris_tl").html("");
                        $(".giris_tl").html(transfer);
                    }
                });
        });

    });

    $("body").off("click", ".virman_iptal_et").on("click", ".virman_iptal_et", function () {
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
                        url: "controller/banka_controller/sql.php?islem=virman_cikart",
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
                                $.get("view/banka_virman.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/banka_virman.php", function (getList) {
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

    $("body").off("click", "#yeni_banka_virman_ekle").on("click", "#yeni_banka_virman_ekle", function () {
        $.get("modals/banka_modal/yeni_banka_virman_ekle.php?islem=yeni_banka_virman_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>