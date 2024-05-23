<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>SAHAYA SER</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="sahaya_urun_ser_button">Ürün Ser <i class="fa fa-plus"></i>
            </button>
            <button class="btn btn-success btn-sm" id="sahaya_konteyner_ser_button">Konteyner Ser <i
                        class="fa fa-plus"></i></button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
            <div class="mt-2"></div>
            <nav class="nav nav-pills flex-column flex-sm-row">
                <a class="flex-sm-fill text-sm-center nav-link active cari_page_color" aria-current="page"
                   id="sahadaki_urunler" style="font-weight: bold">SAHADAKİ ÜRÜNLER</a>
                <a class="flex-sm-fill text-sm-center nav-link cari_page_color" style="font-weight: bold"
                   id="sahadaki_konteynerler">SAHADAKİ KONTEYNERLER</a>
                <a class="flex-sm-fill text-sm-center nav-link cari_page_color" style="font-weight: bold"
                   id="sahadaki_araclar">SAHADAKİ ARAÇLAR</a>
            </nav>
        </div>
        <div class="sahadaki_urunler">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100 nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="sahadaki_urunler_listesi">
                    <thead>
                    <tr>
                        <th>Giriş Tarihi</th>
                        <th>Cari Adı</th>
                        <th>Konteyner No</th>
                        <th>Plaka No</th>
                        <th>Sürücü Adı</th>
                        <th>Epro. Referans</th>
                        <th>Miktar</th>
                        <th>Birim</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="sahadaki_konteynerler" style="display: none">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100 nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="sahadaki_konteynerler_listesi">
                    <thead>
                    <tr>
                        <th class="click1020">Giriş Tarihi</th>
                        <th>Bulunduğu Yer</th>
                        <th>Konteyner No</th>
                        <th>Cari Adı</th>
                        <th>Referans</th>
                        <th>Beyanname No</th>
                        <th>Konteyner Tipi</th>
                        <th>Durumu</th>
                        <th>CUT-OFF Tarihi</th>
                        <th>Ardiyesiz Giriş Tarihi</th>
                        <th>Demoraj Tarihi</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="sahadaki_araclar" style="display: none">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100 nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="sahadaki_araclar_listesi">
                    <thead>
                    <tr>
                        <th class="click1020">Giriş Tarihi</th>
                        <th>Plaka No</th>
                        <th>Sürücü Adı</th>
                        <th>Sürücü Tel</th>
                        <th>Cari Adı</th>
                        <th>Referans</th>
                        <th>Beyanname No</th>
                        <th>Miktar</th>
                        <th>Birim</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "#sahadaki_urunler").on("click", "#sahadaki_urunler", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".sahadaki_urunler").show();
        $(".sahadaki_konteynerler").hide();
        $(".sahadaki_araclar").hide();
        $(".paging_ekstre").html("");
    })

    $("body").off("click", "#sahadaki_konteynerler").on("click", "#sahadaki_konteynerler", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".sahadaki_urunler").hide();
        $(".sahadaki_konteynerler").show();
        $(".sahadaki_araclar").hide();
        $(".paging_ekstre").html("");

        setTimeout(function () {
            $(".click1020").trigger("click");
        }, 500)
    });
    $("body").off("click", "#sahadaki_araclar").on("click", "#sahadaki_araclar", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".sahadaki_urunler").hide();
        $(".sahadaki_konteynerler").hide();
        $(".sahadaki_araclar").show();
        $(".paging_ekstre").html("");

        setTimeout(function () {
            $(".click1020").trigger("click");
        }, 500)
    });

    $(document).ready(function () {
        $.extend($.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var dateArray = dateString.split('/');
                var formattedDate = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                return Date.parse(formattedDate) || 0;
            },
            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#sahadaki_urunler_listesi').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "giris_tarihi"},
                {"data": "cari_adi"},
                {"data": "konteyner_no"},
                {"data": "plaka_no"},
                {"data": "surucu_adi"},
                {"data": "epro_ref"},
                {"data": "miktar"},
                {"data": "birim_adi"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'right');
                $(row).find('td').eq(7).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        var targetColumns2 = [5, 6, 7, 12, 13, 14];
        var sahadaki_araclar = $('#sahadaki_araclar_listesi').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "giris_tarihi"},
                {"data": "plaka_no"},
                {"data": "surucu_adi"},
                {"data": "surucu_tel"},
                {"data": "cari_adi"},
                {"data": "referans_no"},
                {"data": "beyanname_no"},
                {"data": "miktar"},
                {"data": "birim_adi"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_tum_urunleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        });
        $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_araclari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                sahadaki_araclar.rows.add(json).draw(false);
            }
        });
        $.extend($.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var dateArray = dateString.split('/');
                var formattedDate = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                return Date.parse(formattedDate) || 0;
            },
            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var targetColumns1 = [5, 6, 7, 12, 13, 14];
        var konteyner_table = $('#sahadaki_konteynerler_listesi').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "giris_tarihi"},
                {"data": "bulundugu_yer"},
                {"data": "konteyner_no"},
                {"data": "cari_adi"},
                {"data": "referans"},
                {"data": "beyanname_no"},
                {"data": "konteyner_tipi"},
                {"data": "durumu"},
                {"data": "cut_off_tarihi"},
                {"data": "ardiyesiz_giris_tarihi"},
                {"data": "demoraj_tarihi"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_konteynerleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                konteyner_table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".sahadaki_konteyneri_sil_button").on("click", ".sahadaki_konteyneri_sil_button", function () {
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
                        url: "depo/controller/puantor_controller/sql.php?islem=sahadaki_konteyneri_sil_sql",
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
                                        'Adreste Konteyner Bulunuyor Lütfen Önce Konteynerleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Sahadaki Konteyner Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/sahaya_urun_ser.php", function (getList) {
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

    $("body").off("click", ".sahadaki_urunu_sil_button").on("click", ".sahadaki_urunu_sil_button", function () {
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
                        url: "depo/controller/puantor_controller/sql.php?islem=sahadaki_urunu_sil_sql",
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
                                        'Adreste Konteyner Bulunuyor Lütfen Önce Konteynerleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Sahadaki Ürün Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/sahaya_urun_ser.php", function (getList) {
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

    $("body").off("click", "#sahaya_urun_ser_button").on("click", "#sahaya_urun_ser_button", function () {
        $.get("depo/modals/puantor_modal/sahaya_urun_ser.php?islem=sahaya_yeni_urun_ser_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#sahaya_konteyner_ser_button").on("click", "#sahaya_konteyner_ser_button", function () {
        $.get("depo/modals/puantor_modal/sahaya_konteyner_ser.php?islem=sahaya_yeni_konteyner_ser_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>