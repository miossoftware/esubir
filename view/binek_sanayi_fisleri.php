<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>SANAYİ FİŞLERİ</div>
        </div>
        <div class="col-12 row">
            <div class="mx-2">
                <button class="btn btn-success btn-sm" id="binek_sanayi_fisi_button"><i class="fa fa-plus"></i> Sanayi
                    Fişi Oluştur
                </button>
                <button class="btn btn-info btn-sm" id=""><i
                            class="fa fa-filter"></i> Hazırla
                </button>
            </div>
            <div class="col-12 row">
                <div class="col-12 row mx-1 mt-3">
                    <div class="col-md-3 row">

                        <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm bas_tarih_havale_cikis">
                        <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm mt-2 bit_tarih_havale_cikis">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="konteyner_siparis_main_list">
                <thead>
                <tr>
                    <th>Fiş No</th>
                    <th>Tarih</th>
                    <th>Cari Adı</th>
                    <th>Cari Kodu</th>
                    <th>Ara Toplam</th>
                    <th>Genel Toplam</th>
                    <th>Açıklama</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="ara_tot_sanayi_fis">0,00</th>
                <th style="text-align: right" class="genel_tot_sanayi_fis">0,00</th>
                <th></th>
                <th></th>
                <th></th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#konteyner_sefer_irsaliye_olustur_button").on("click", "#konteyner_sefer_irsaliye_olustur_button", function () {
        $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=yeni_sefer_irsaliyesi_olustur_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
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
        var table = $("#konteyner_siparis_main_list").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            columns: [
                {"data": "fis_no"},
                {"data": "tarih"},
                {"data": "cari_adi"},
                {"data": "cari_kodu"},
                {"data": "ara_toplam"},
                {"data": "genel_toplam"},
                {"data": "aciklama"},
                {"data": "durum"},
                {"data": "button"}
            ],
            createdRow: function (new_row, data) {
                $(new_row).find('td').css('text-align', 'left');
                $(new_row).find("td").eq(4).css("text-align", "right");
                $(new_row).find("td").eq(5).css("text-align", "right");
                if (data.durum == "Fiş Faturalandı") {
                    $(new_row).css("background-color", "#DDF7E3");
                    $(new_row).css("color", "gray");
                    $(new_row).find("td").eq(1).css("background-color", "#DDF7E3");
                }
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/arac_controller/sql.php?islem=tum_sanayi_fislerini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let ara_tot_sanayi_fis = 0;
                let genel_tot_sanayi_fis = 0;
                json.forEach(function (item) {
                    let durum = ""
                    if (item.status == 1) {
                        durum = "Bekliyor";
                    } else {
                        durum = "Fiş Faturalandı";
                    }

                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let ara_toplam = item.ara_toplam;
                    ara_toplam = parseFloat(ara_toplam);
                    ara_tot_sanayi_fis += ara_toplam;
                    ara_toplam = ara_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let genel_toplam = item.genel_toplam;
                    genel_toplam = parseFloat(genel_toplam);
                    genel_tot_sanayi_fis += genel_toplam;
                    genel_toplam = genel_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let newRow = {
                        fis_no: item.fis_no,
                        tarih: tarih,
                        cari_adi: item.cari_adi,
                        cari_kodu: item.cari_kodu,
                        ara_toplam: ara_toplam,
                        genel_toplam: genel_toplam,
                        aciklama: item.aciklama,
                        durum: durum,
                        button: "<button class='btn btn-sm binek_sanayi_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm binek_sanayi_fisi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".ara_tot_sanayi_fis").html(ara_tot_sanayi_fis.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
                $(".genel_tot_sanayi_fis").html(genel_tot_sanayi_fis.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
                table.rows.add(basilacak_arr).draw(false);
            }
        });
    });

    $("body").off("click", "#binek_sanayi_fisi_button").on("click", "#binek_sanayi_fisi_button", function () {
        $.get("modals/arac_modal/sanayi_fisi_modal.php?islem=sanayi_fisi_girisi_modal_getir", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".binek_sanayi_guncelle_button").on("click", ".binek_sanayi_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/binek_sanayi_cikis_fisi_page.php?islem=sanayi_fisi_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    })

    $("body").off("click", ".binek_sanayi_fisi_sil").on("click", ".binek_sanayi_fisi_sil", function () {
        let closest = $(this).closest("tr");
        var id = $(this).attr("data-id");
        if ($(closest).find("td").eq(7).text() == "Fiş Faturalandı") {
            Swal.fire(
                "Uyarı!",
                "Bu Yakıt Fişi Faturalanmıştır Lütfen Önce Faturayı Siliniz...",
                "warning"
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
                        url: "controller/arac_controller/sql.php?islem=sanayi_cikis_fisi_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300) {
                                    Swal.fire(
                                        'Uyarı!',
                                        'Cariye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Sanayi Fişi Silindi',
                                        'success'
                                    );
                                    $.get("view/binek_sanayi_fisleri.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/binek_sanayi_fisleri.php", function (getList) {
                                        $(".admin-modal-icerik").html("");
                                        $(".admin-modal-icerik").html(getList);
                                    })
                                }
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

</script>