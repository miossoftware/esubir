<?php

$islem = $_GET["islem"];
if ($islem == "uye_tahakkuk_yap_modal") {
    ?>
    <style>
        #hesaplanan_maaslar th:first-child {
            width: 0% !important;
        }

        #hesaplanan_maaslar th:nth-child(2) {
            width: 0% !important;
        }

        #hesaplanan_maaslar th:nth-child(3) {
            width: 10% !important;
        }
    </style>
    <div class="modal fade" id="uye_tahakkuk_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tahakkuk_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYE TAHAKKUK</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-8">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label>İşlem Tarihi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="date" id="islem_tarihi" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary btn-sm mx-2" id="uye_odenek_hesapla"><i
                                                            class="fa fa-calculator"
                                                            aria-hidden="true"></i>
                                                    Hesapla
                                                </button>
                                                <button class="btn btn-info btn-sm mx-2" id="all_select"><i
                                                            class="fa fa-check"
                                                            aria-hidden="true"></i>
                                                    Hepsini Seç
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="ana_aciklama">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-12 mt-5">
                                    <table class="table table-sm table-bordered w-100 display"
                                           id="hesaplanan_maaslar" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th>Seç</th>
                                            <th>Tarih</th>
                                            <th id="click_1">TC No</th>
                                            <th>Adı Soyadı</th>
                                            <th>Tarife Adı</th>
                                            <th>Açıklama</th>
                                            <th>Tutar</th>
                                        </tr>
                                        </thead>
                                        <tfoot style="background-color: white">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right">TOPLAM: <span class="uye_tah_toplami">0,00</span>
                                        </th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="tahakkuk_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="uye_tahakkuk_kaydet"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#click_1").trigger("click");
            }, 500);
            $("#uye_tahakkuk_modal").modal("show");
            var table = $('#hesaplanan_maaslar').DataTable({
                scrollX: true,
                scrollY: '25vh',
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).addClass("tum_uye_tahakkuklari")
                    $(row).find("td").css("text-align", "left");
                },
                columns: [
                    {'data': 'sec', 'width': '20px'},
                    {'data': 'tarih'},
                    {'data': 'tc_no'},
                    {'data': 'uye_adi'},
                    {'data': 'tarife_adi'},
                    {'data': 'aciklama'},
                    {'data': 'tutar'}
                ],
                searching: false,
                order: [[0, 'desc']],
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
            $("body").off("click", "#uye_odenek_hesapla").on("click", "#uye_odenek_hesapla", function () {
                $.get("controller/uye_controller/sql.php?islem=uyelerin_tahakkuklarini_getir_sql", function (res) {
                    if (res != 2) {
                        var json = JSON.parse(res);
                        let gidecek_arr = [];
                        let tarih = "<?=date("Y-m-d")?>";
                        let uye_tah_toplami = 0;
                        table.clear().draw(false);
                        json.forEach(function (item) {
                            let toplam_borc = item.uyenin_toplam_borcu;
                            toplam_borc = parseFloat(toplam_borc);
                            uye_tah_toplami += toplam_borc;
                            toplam_borc = toplam_borc.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            let newRow = {
                                sec: '<input type="checkbox" class="col-9"/>',
                                tarih: '<input type="date" class="form-control form-control-sm col-9" style="width: 75% !important;" value="' + tarih + '" />',
                                tc_no: item.tc_no,
                                uye_adi: item.uye_adi,
                                tarife_adi: item.tarife_adi,
                                aciklama: "<input type='text' style='width: 100% !important;' class='form-control form-control-sm col-11' />",
                                tutar: '<input type="text" style="text-align: right" class="form-control form-control-sm col-9 tutar"  style="width: 75% !important;" value="' + toplam_borc + '" />'
                            };
                            gidecek_arr.push(newRow);
                        });
                        $(".uye_tah_toplami").html(uye_tah_toplami.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                        table.rows.add(gidecek_arr).draw(false);
                    }
                })
            });
        });

        $("body").off("focusout", ".tutar").on("focusout", ".tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("click", "#all_select").on("click", "#all_select", function () {
            $("input").prop("checked", true);
        });

        $("body").off("click", "#uye_tahakkuk_kaydet").on("click", "#uye_tahakkuk_kaydet", function () {
            let islem_tarihi = $("#islem_tarihi").val();
            let aciklama = $("#ana_aciklama").val();
            let gidecek_arr = [];
            $(".tum_uye_tahakkuklari").each(function () {
                if ($(this).find("td:eq(0) input").prop("checked")) {
                    let tarih = $(this).find("td:eq(1) input").val();
                    let tc_no = $(this).find("td").eq(2).text();
                    let aciklama = $(this).find("td:eq(5) input").val();
                    let tarife_adi = $(this).find("td:eq(4)").text();
                    let tutar = $(this).find("td:eq(6) input").val();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);

                    let newRow = {
                        tarih: tarih,
                        tc_no: tc_no,
                        tarife_adi: tarife_adi,
                        aciklama: aciklama,
                        tutar: tutar,
                    };
                    gidecek_arr.push(newRow);
                }
            });
            if (islem_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen İşlem Tarihi Giriniz...",
                    "warning"
                );
            } else if (gidecek_arr.length === 0) {
                Swal.fire(
                    "Uyarı!",
                    "Listede Herhangi Bir Veri Seçilmemiştir",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=tahakkuk_kaydet_sql",
                    type: "POST",
                    data: {
                        islem_tarihi: islem_tarihi,
                        aciklama: aciklama,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Tahakkuk Kaydedildi",
                                "success"
                            );
                            $("#uye_tahakkuk_modal").modal("hide");
                            $.get("view/uye_tahakkuk_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_tahakkuk_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            })
                        }
                    }
                });
            }
        });


        $("body").off("click", "#tahakkuk_vazgec").on("click", "#tahakkuk_vazgec", function () {
            $("#uye_tahakkuk_modal").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "bireysel_tahakkuk_islemi") {
    ?>
    <div class="modal fade" id="bireysel_tahakkuk_islem_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tahakkuk_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİREYSEL TAHAKKUK</div>
                        </div>
                        <div class="modal-body">
                            <div class="gider_kasalar_div"></div>
                            <div class="get-user-modal"></div>
                            <div class="tarifeler-div"></div>
                            <div class="col-12 row mx-1">
                                <table class="table table-sm table-bordered w-100 display nowrap edit_list"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="bireysel_tahakkuklar_table">
                                    <thead>
                                    <tr>
                                        <th class="clicker1234" style="width: 1% !important;">Tarih</th>
                                        <th>Üye</th>
                                        <th style="text-align: center">Ödeme</th>
                                        <th>Tarife</th>
                                        <th>Tutar</th>
                                        <th>Açıklama</th>
                                        <th style="width: 0% !important;">İşlem</th>
                                    </tr>
                                    </thead>
                                    <tfoot style="background-color: white">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right" class="toplam_tahakkuk">0,00</th>
                                    <th></th>
                                    <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="tahakkuk_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="bireysel_tahakkuk_kaydet"><i
                                        class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var bireysel_tahakkuk_table = "";
        $(document).ready(function () {
            setTimeout(function () {
                $(".clicker1234").trigger("click");
            }, 500);
            $("#bireysel_tahakkuk_islem_modal").modal("show");
            bireysel_tahakkuk_table = $('#bireysel_tahakkuklar_table').DataTable({
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                scrollX: true,
                scrollY: "25vh",
                paging: false,
                autoWidth: false,
                info: false,
                createdRow: function (row) {
                    $(row).find("td").css("text-transform", "uppercase");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "right");
                    $(row).addClass("bireysel_tahakkuk")
                }
            });

            bireysel_tahakkuk_table.row.add(["<input type='date' class='form-control form-control-sm col-9' value='<?=date("Y-m-d")?>'/>", "<div class='input-group'><input type='number' oninput='limitLength(this,11)' class='form-control form-control-sm col-9 uye_id' placeholder='TC No..'><div class='input-group-append'><button class='btn btn-warning btn-sm uyeleri_getir_button'><i class='fa fa-ellipsis-h'></i></button></div></div>", "<div class='row no-gutters'><div class='col'> <select class='custom-select custom-select-sm odeme_yontemi' style='width: 65% !important; height: 60% !important;'>" +
            "<option value=''>Ödeme Yöntemi Belirtiniz...</option>" +
            "<option value='Havale'>Havale</option>" +
            "<option value='Kart'>Kredi Kartı</option>" +
            "</select> </div> <div class='col'> <div class='input-group'><input type='text' class='form-control form-control-sm col-9 ' banka_id='' kart_id='' placeholder='Ödeme Yöntemi Seçiniz..'><div class='input-group-append'><button class='btn btn-warning btn-sm payment_selected'><i class='fa fa-ellipsis-h'></i></button></div></div> </div> </div>",
                "<div class='input-group'><input type='text' class='form-control form-control-sm col-9 tarife_id' placeholder='Tarife Kodu Giriniz...'><div class='input-group-append'><button class='btn btn-warning btn-sm tarife_kodu_button'><i class='fa fa-ellipsis-h'></i></button></div></div>",
                "<input type='text' class='form-control form-control-sm col-9 tahakkuk_tutari' value='0,00' style='text-align: right' placeholder='Tutar'/>",
                "<input type='text' class='form-control form-control-sm col-9' placeholder='Açıklama'/>",
                "<button class='btn btn-success btn-sm yeni_satir_ekle'><i class='fa fa-plus'></i></button> <button class='btn btn-danger btn-sm sgk_gider_fisi_eksilt_list_button'><i class='fa fa-trash'></i></button>"]).draw(false);
        });

        $("body").off("click", ".yeni_satir_ekle").on("click", ".yeni_satir_ekle", function () {
            bireysel_tahakkuk_table.row.add(["<input type='date' class='form-control form-control-sm col-9' value='<?=date("Y-m-d")?>'/>", "<div class='input-group'><input type='number' oninput='limitLength(this,11)' class='form-control form-control-sm col-9 uye_id' placeholder='TC No..'><div class='input-group-append'><button class='btn btn-warning btn-sm uyeleri_getir_button'><i class='fa fa-ellipsis-h'></i></button></div></div>", "<div class='row no-gutters'><div class='col'> <select class='custom-select custom-select-sm odeme_yontemi' style='width: 65% !important; height: 60% !important;'>" +
            "<option value=''>Ödeme Yöntemi Belirtiniz...</option>" +
            "<option value='Havale'>Havale</option>" +
            "<option value='Kart'>Kredi Kartı</option>" +
            "</select> </div> <div class='col'> <div class='input-group'><input type='text' class='form-control form-control-sm col-9'  banka_id='' kart_id='' placeholder='Ödeme Yöntemi Giriniz...'><div class='input-group-append'><button class='btn btn-warning btn-sm payment_selected'><i class='fa fa-ellipsis-h'></i></button></div></div> </div> </div>",
                "<div class='input-group'><input type='text' class='form-control form-control-sm col-9 tarife_id' placeholder='Tarife Kodu Giriniz...'><div class='input-group-append'><button class='btn btn-warning btn-sm tarife_kodu_button'><i class='fa fa-ellipsis-h'></i></button></div></div>",
                "<input type='text' class='form-control form-control-sm col-9 tahakkuk_tutari' value='0,00' style='text-align: right' placeholder='Tutar'/>",
                "<input type='text' class='form-control form-control-sm col-9' placeholder='Açıklama'/>",
                "<button class='btn btn-success btn-sm yeni_satir_ekle'><i class='fa fa-plus'></i></button> <button class='btn btn-danger btn-sm sgk_gider_fisi_eksilt_list_button'><i class='fa fa-trash'></i></button>"]).draw(false);

            $('#bireysel_tahakkuklar_table tbody tr:last').find('td:eq(0) input').focus();
        });

        $("body").off("click", "#tahakkuk_vazgec").on("click", "#tahakkuk_vazgec", function () {
            $("#bireysel_tahakkuk_islem_modal").modal("hide");
        });

        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        }

        $("body").off("click", ".uyeleri_getir_button").on("click", ".uyeleri_getir_button", function () {
            $(".uye_id").removeClass("selected_user");
            let closest = $(this).closest("tr");
            let className = $(closest).find("td:eq(1) input");
            $(className).addClass("selected_user");
            $.get("modals/uye_modal/modal.php?islem=uyeleri_getir_modal", function (getModal) {
                $(".get-user-modal").html(getModal);
            })
        })

        $("body").off("click", ".payment_selected").on("click", ".payment_selected", function () {
            let closest = $(this).closest("tr");
            let className = $(closest).find("td:eq(2) input");
            if ($(className).hasClass("kasa_id")) {
                $(".kasa_id").removeClass("kasa_click");
                $(className).addClass("kasa_click");
                $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kasalari_getir_modal", function (getModal) {
                    $(".gider_kasalar_div").html("");
                    $(".gider_kasalar_div").html(getModal);
                });
            } else if ($(className).hasClass("banka_id")) {
                $(".banka_id").removeClass("banka_click");
                $(className).addClass("banka_click");
                $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=bankalari_getir_modal", function (getModal) {
                    $(".gider_kasalar_div").html("");
                    $(".gider_kasalar_div").html(getModal);
                });
            } else if ($(className).hasClass("kredi_kart_id")) {
                $(".kasa_id").removeClass("kart_click");
                $(className).addClass("kart_click");
                $.get("modals/uye_modal/tahakkuk_modal.php?islem=poslari_getir_modal", function (getModal) {
                    $(".gider_kasalar_div").html("");
                    $(".gider_kasalar_div").html(getModal);
                });
            }
        });


        $("body").off("keyup", ".uye_id").on("keyup", ".uye_id", function () {
            let tc_no = $(this).val();
            let this_s = $(this);
            $.get("controller/uye_controller/sql.php?islem=uye_bilgileri_getir_sql", {cari_kodu: tc_no}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $(this_s).attr("data-id", item.id);
                    $(this_s).val(item.tc_no);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Üye Bulundu'
                    });
                }
            })
        });

        $("body").off("click", ".tarife_kodu_button").on("click", ".tarife_kodu_button", function () {
            let tr = $(this).closest("tr");
            $(".tarife_id").removeClass("secilen_input");
            $(tr).find("td:eq(3) input").addClass("secilen_input");
            $.get("modals/uye_modal/tahakkuk_modal.php?islem=tarifeleri_getir_modal", function (getModal) {
                $(".tarifeler-div").html(getModal);
            })
        });

        $("body").off("keyup", ".tarife_id").on("keyup", ".tarife_id", function () {
            let tc_no = $(this).val();
            let this_s = $(this);
            $.get("controller/uye_controller/sql.php?islem=tarife_bilgilerini_getir_sql", {tarife_kodu: tc_no}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $(this_s).attr("data-id", item.id);
                    $(this_s).val(item.tarife_adi);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Tarife Bulundu'
                    });
                }
            })
        });

        $("body").off("click", "#bireysel_tahakkuk_kaydet").on("click", "#bireysel_tahakkuk_kaydet", function () {
            let gidecek_arr = [];
            $(".bireysel_tahakkuk").each(function () {
                let tarih = $(this).find("td:eq(0) input").val();
                let uye_id = $(this).find("td:eq(1) input").attr("data-id");
                let kasa_id = $(this).find("td:eq(2) input").attr("kasa_id");
                let banka_id = $(this).find("td:eq(2) input").attr("banka_id");
                let pos_id = $(this).find("td:eq(2) input").attr("kart_id");
                let tarife_id = $(this).find("td:eq(3) input").attr("data-id");
                let tutar = $(this).find("td:eq(4) input").val();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let aciklama = $(this).find("td:eq(5) input").val();
                let newRow = {
                    tarih: tarih,
                    uye_id: uye_id,
                    kasa_id: kasa_id,
                    banka_id: banka_id,
                    tarife_id: tarife_id,
                    pos_id: pos_id,
                    tutar: tutar,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            if (gidecek_arr.length === 0) {
                Swal.fire(
                    "Uyarı!",
                    "Listede Herhangi Bir Veri Bulunamadı",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=bireysel_tahakkuk_kaydet_sql",
                    type: "POST",
                    data: {
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Bireysel Tahakkuk Kaydedildi",
                                "success"
                            );
                            $("#bireysel_tahakkuk_islem_modal").modal("hide");
                            $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        }
                    }
                });
            }
        });

        $("body").off("focusout", ".tahakkuk_tutari").on("focusout", ".tahakkuk_tutari", function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }

            let toplam = 0;
            $(".bireysel_tahakkuk").each(function () {
                let val = $(this).find("td:eq(4) input").val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                toplam += val;
            });
            toplam = parseFloat(toplam);
            toplam = toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

            $(".toplam_tahakkuk").html(toplam);

            $(this).val(tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("keyup", ".kredi_kart_id").on("keyup", ".kredi_kart_id", function () {
            let val = $(this).val();
            let this_s = $(this);
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kredi_karti_getir_sql", {kart_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $(this_s).val(item.kart_adi);
                    $(this_s).attr("kart_id", item.id);
                } else {
                    $(this_s).attr("kart_id", "");
                }
            })
        });

        $("body").off("keyup", ".kasa_id").on("keyup", ".kasa_id", function () {
            let val = $(this).val();
            let this_s = $(this);
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kasalari_getir_sql", {kasa_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $(this_s).val(item.kasa_adi);
                    $(this_s).attr("kasa_id", item.id);
                } else {
                    $(this_s).attr("kasa_id", "");
                }
            })
        });

        $("body").off("keyup", ".banka_id").on("keyup", ".banka_id", function () {
            let val = $(this).val();
            let this_s = $(this);
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=bankalari_getir_sql", {banka_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $(this_s).val(item.banka_adi);
                    $(this_s).attr("banka_id", item.id);
                } else {
                    $(this_s).attr("banka_id", "");
                }
            })
        });

        $("body").off("change", ".odeme_yontemi").on("change", ".odeme_yontemi", function () {
            let val = $(this).val();
            let closest = $(this).closest("tr");
            if (val == "Nakit") {
                let input = $(closest).find("td:eq(2) input");
                input.prop("disabled", false);
                input.attr("placeholder", "Kasa Kodu Giriniz...");
                input.removeClass("banka_id");
                input.removeClass("kredi_kart_id");
                input.addClass("kasa_id");
                input.val("");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else if (val == "Havale") {
                let input = $(closest).find("td:eq(2) input");
                input.prop("disabled", false);
                input.val("");
                input.attr("placeholder", "Banka Kodu Giriniz...");
                input.removeClass("kasa_id");
                input.removeClass("kredi_kart_id");
                input.addClass("banka_id");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else if (val == "Kart") {
                let input = $(closest).find("td:eq(2) input");
                input.removeClass("banka_id");
                input.val("");
                input.removeClass("kasa_id");
                input.addClass("kredi_kart_id");
                input.prop("disabled", false);
                input.attr("placeholder", "Kredi Kart Kodu Giriniz...");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else {
                let input = $(closest).find("td:eq(2) input");
                input.val("");
                input.prop("disabled", true);
                input.removeClass("banka_id");
                input.removeClass("kasa_id");
                input.removeClass("kredi_kart_id");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            }
        });

    </script>
    <?php
}
if ($islem == "tarifeleri_getir_modal") {
    ?>
    <div class="modal fade" id="tarifeleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_secim_vazgec_modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TARİFELER</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="tarife_getir_modal">
                                    <thead>
                                    <tr>
                                        <th id="click1">Tarife Kodu</th>
                                        <th>Tarife Adı</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#tarifeleri_getir_modal").modal("show");
            //secilen_input
            var table = $('#tarife_getir_modal').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "tarife_kodu"},
                    {'data': "tarife_adi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("tarife_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });

            $.get("controller/uye_controller/sql.php?islem=tum_tarifeleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

        });

        $("body").off("click", ".tarife_selected").on("click", ".tarife_selected", function () {
            let id = $(this).attr("data-id");
            let tarife_adi = $(this).find("td").eq(1).text();
            $(".secilen_input").val(tarife_adi);
            $(".secilen_input").attr("data-id", id);
            $("#tarife_id").val(tarife_adi);
            $("#tarife_id").attr("data-id", id);
            $("#tarifeleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#tarife_secim_vazgec_modal").on("click", "#tarife_secim_vazgec_modal", function () {
            $("#tarifeleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "bireysel_tahakkuk_guncelle_modal") {
    ?>
    <div class="modal fade" id="uye_acilis_fisi_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="uye_acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİREYSEL TAHAKKUK GÜNCELLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="tarifeler-div"></div>
                            <div id="uyeleri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarih</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" id="tarih"
                                           value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>TC No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="tc_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="uye_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Üye Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="uye_adi" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Ödeme Yöntemi</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm odeme_yontemi" id="odeme_yontemi">
                                        <option value="">Ödeme Yöntemi Belirtiniz...</option>
                                        <option value="Havale">Havale</option>
                                        <option value="Kart">Kredi Kartı</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Ödenen Yer</label>
                                </div>
                                <div class="col-md-7">
                                    <div class='input-group'><input type='text' id="odenen_yer"
                                                                    class='form-control form-control-sm kasa_id'
                                                                    kasa_id='' banka_id='' kart_id=''
                                                                    placeholder='Kasa Giriniz...'>
                                        <div class='input-group-append'>
                                            <button class='btn btn-warning btn-sm payment_selected'
                                                    id="odenen_yerleri_getir"><i
                                                        class='fa fa-ellipsis-h'></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="tarife_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="tarifeleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tutar"
                                           style="text-align: right">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="uye_acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="bireysel_tahakkuk_guncelle"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#uye_acilis_fisi_ekle_modal").modal("show");

            $.get("controller/uye_controller/sql.php?islem=bireysel_tahakkuk_detayini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    $("#tarih").val(tarih[0]);
                    $("#tc_no").val(item.tc_no);
                    $("#tc_no").attr("data-id", item.uye_id);
                    $("#uye_adi").val(item.uye_adi);
                    let odeme_yontemi = "";
                    let adi = "";
                    if (item.banka_adi != null) {
                        odeme_yontemi = "Havale";
                        adi = item.banka_adi;
                    } else if (item.kasa_adi != null) {
                        odeme_yontemi = "Nakit";
                        adi = item.kasa_adi
                    } else if (item.pos_adi != null) {
                        odeme_yontemi = "Kart"
                        adi = item.pos_adi
                    }
                    $("#odeme_yontemi").val(odeme_yontemi);
                    $("#odenen_yer").attr("kasa_id", item.kasa_id);
                    $("#odenen_yer").attr("banka_id", item.banka_id);
                    $("#odenen_yer").attr("kart_id", item.pos_id);
                    $("#odenen_yer").val(adi);
                    $("#tarife_id").attr("data-id", item.tarife_id);
                    $("#tarife_id").val(item.tarife_adi);
                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    $("#tutar").val(tutar);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#odenen_yerleri_getir").on("click", "#odenen_yerleri_getir", function () {
            let odeme_yontemi = $("#odeme_yontemi").val();
            if (odeme_yontemi == "Nakit") {
                $.get("modals/uye_modal/tahakkuk_modal.php?islem=kasalari_getir_modal", function (getModal) {
                    $(".tarifeler-div").html(getModal);
                });
            } else if (odeme_yontemi == "Havale") {
                $.get("modals/uye_modal/tahakkuk_modal.php?islem=bankalari_getir_modal", function (getModal) {
                    $(".tarifeler-div").html(getModal);
                });
            } else if (odeme_yontemi == "Kart") {
                $.get("modals/uye_modal/tahakkuk_modal.php?islem=poslari_getir_modal", function (getModal) {
                    $(".tarifeler-div").html(getModal);
                });
            }
        });

        $("body").off("click", "#tarifeleri_getir_button").on("click", "#tarifeleri_getir_button", function () {
            $.get("modals/uye_modal/tahakkuk_modal.php?islem=tarifeleri_getir_modal", function (getModal) {
                $(".tarifeler-div").html(getModal);
            });
        });

        $("body").off("click", "#uye_acilis_vazgec").on("click", "#uye_acilis_vazgec", function () {
            $("#uye_acilis_fisi_ekle_modal").modal("hide");
        });

        $("body").off("click", "#uye_getir_button").on("click", "#uye_getir_button", function () {
            $.get("modals/uye_modal/modal.php?islem=uyeleri_getir_modal", function (getModal) {
                $("#uyeleri_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#bireysel_tahakkuk_guncelle").on("click", "#bireysel_tahakkuk_guncelle", function () {
            let tarih = $("#tarih").val();
            let uye_id = $("#tc_no").attr("data-id");
            let banka_id = $("#odenen_yer").attr("banka_id");
            let kasa_id = $("#odenen_yer").attr("kasa_id");
            let pos_id = $("#odenen_yer").attr("kart_id");
            let tarife_id = $("#tarife_id").attr("data-id");
            let tutar = $("#tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let aciklama = $("#aciklama").val();
            if (tarih == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Tarih Giriniz...",
                    "warning"
                );
            } else if (uye_id == undefined || uye_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Üye Seçiniz...",
                    "warning"
                );
            } else if (tarife_id == undefined || tarife_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Tarife Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=bireysel_tahakkuk_guncelle",
                    type: "POST",
                    data: {
                        tarih: tarih,
                        uye_id: uye_id,
                        banka_id: banka_id,
                        kasa_id: kasa_id,
                        pos_id: pos_id,
                        tarife_id: tarife_id,
                        tutar: tutar,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Bireysel Tahakkuk Güncellendi",
                                "success"
                            );
                            $("#uye_acilis_fisi_ekle_modal").modal("hide");
                            $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        }
                    }
                });
            }
        });

        $("body").off("focusout", "#tutar").on("focusout", "#tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("change", ".odeme_yontemi").on("change", ".odeme_yontemi", function () {
            let val = $(this).val();
            if (val == "Nakit") {
                let input = $("#odenen_yer");
                input.prop("disabled", false);
                input.attr("placeholder", "Kasa Kodu Giriniz...");
                input.removeClass("banka_id");
                input.removeClass("kredi_kart_id");
                input.addClass("kasa_id");
                input.val("");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else if (val == "Havale") {
                let input = $("#odenen_yer");
                input.prop("disabled", false);
                input.val("");
                input.attr("placeholder", "Banka Kodu Giriniz...");
                input.removeClass("kasa_id");
                input.removeClass("kredi_kart_id");
                input.addClass("banka_id");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else if (val == "Kart") {
                let input = $("#odenen_yer");
                input.removeClass("banka_id");
                input.val("");
                input.removeClass("kasa_id");
                input.addClass("kredi_kart_id");
                input.prop("disabled", false);
                input.attr("placeholder", "Kredi Kart Kodu Giriniz...");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            } else {
                let input = $("#odenen_yer");
                input.val("");
                input.prop("disabled", true);
                input.removeClass("banka_id");
                input.removeClass("kasa_id");
                input.removeClass("kredi_kart_id");
                input.attr("banka_id", "");
                input.attr("kasa_id", "");
                input.attr("kart_id", "");
            }
        });

    </script>
    <?php
}
if ($islem == "kasalari_getir_modal") {
    ?>
    <div class="modal fade" id="konteyner_kasa_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Kasa Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="kasa_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Kasa Adı</th>
                                <th>Kasa Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#konteyner_kasa_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#konteyner_kasa_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#kasa_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "kasa_adi"},
                    {'data': "kasa_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("kasa_selected_for_reports");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".kasa_selected_for_reports").on("click", ".kasa_selected_for_reports", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();

                $(".kasa_adi_getir").val(banka_adi);
                $("#odenen_yer").attr("kasa_id", id);
                $("#odenen_yer").val(banka_adi);
                $("#konteyner_kasa_listesi_modal").modal("hide");
            });

            $.get("controller/kasa_controller/sql.php?islem=kasalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "bankalari_getir_modal") {
    ?>
    <div class="modal fade" id="bankalar_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Banka Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Şube Adı</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#bankalar_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#bankalar_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"},
                    {'data': "sube_adi"},
                ],
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                $("#odenen_yer").attr("banka_id", id);
                $("#odenen_yer").val(banka_adi);
                $("#bankalar_listesi_modal").modal("hide");
            });

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "poslari_getir_modal") {
    ?>
    <div class="modal fade" id="pos_cihazlar_listesi"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">POS Cihazı Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">POS Banka</th>
                                <th>Banka Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#pos_cihazlar_listesi").modal("hide");
        })
        $(document).ready(function () {
            $("#pos_cihazlar_listesi").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("pos_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".pos_selected").on("click", ".pos_selected", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                $("#odenen_yer").attr("kart_id", id);
                $("#odenen_yer").val(banka_adi);
                $(".kart_click").val(banka_adi)
                $(".kart_click").attr("kart_id", id);
                $("#pos_cihazlar_listesi").modal("hide");
            });

            $.get("controller/pos_controller/sql.php?islem=poslari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}