<?php

$islem = $_GET["islem"];
if ($islem == "kasa_tahsilat_modal") {
    ?>
    <div class="modal fade" id="kasa_tahsilat_ekle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Kasa Tahsilat (Giriş)
                    <button type="button" class="btn-close btn-close-white" id="tahsilat_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>KASA TAHSİLAT (GİRİŞ)</div>
                    </div>
                <div class="modal-body">
                    <div class="kasa_cari_listesi_div"></div>
                    <div class="col-12 row mt-2 no-gutters">
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Kasa Adı</label>
                            <select class="custom-select custom-select-sm" id="kasa_adi">
                                <option value="">Seçiniz...</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Belge
                                No</label>
                            <input type="text" class="form-control form-control-sm" id="belge_no">
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Döviz
                                Türü</label>
                            <select class="custom-select custom-select-sm" id="doviz_turu_kasa">
                                <option value="">Seçiniz...</option>
                                <option value="TL" selected>TL</option>
                                <option value="USD" id="usd_bas">USD</option>
                                <option value="EURO" id="eur_bas">EURO</option>
                                <option value="GBP" id="gbp_bas">GBP</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Döviz
                                Kuru</label>
                            <input type="text" class="form-control form-control-sm" value="1.00" id="doviz_kuru_kasa">
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;İşlem
                                Tarihi</label>
                            <input type="date" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm"
                                   id="islem_tarihi">
                        </div>
                        <div class="col-md-2">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Açıklama"
                                   id="ust_aciklama">
                        </div>
                    </div>
                    <div class="col-12 row mt-2 no-gutters">
                        <div class="col-md-2">
                            <label style="font-weight: bold;font-size: 10px">Cari Kodu</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="cari_kodu_getir"
                                       placeholder="Cari Kodu">
                                <div class="input-group-append">
                                    <button class="btn btn-warning btn-sm"
                                            id="kasa_cari_liste_main">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mx-2">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                Adı</label>
                            <input type="text" class="form-control form-control-sm" disabled placeholder="Cari Adı"
                                   id="cari_adi">
                        </div>
                        <div class="col-md-1 mx-2">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tutar</label>
                            <input type="text" class="form-control form-control-sm tahsilat_guncelle_tutar"
                                   id="tahsilat_tutar"
                                   placeholder="Tutar">
                        </div>
                        <div class="col-md-2">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                            <input type="text" class="form-control form-control-sm" id="alt_aciklama"
                                   placeholder="Açıklama">
                        </div>
                        <div class="col-md-2 mt-4 row">
                            <button style="width: 100% !important;"
                                    class="btn btn-success btn-sm mx-5" id="kasa_tahsilat_ekle"><i
                                        class="fa fa-plus"></i> Ekle
                            </button>
                            <button style="background-color: #F6FA70;width: 100% !important;"
                                    class="btn btn-sm mx-5 mt-1"
                                    id="tahsilat_kaydi_guncelle"><i
                                        class="fa fa-refresh"></i> Kaydı Güncelle
                            </button>
                        </div>
                    </div>
                    <div class="col-12 row mt-2">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="cari_table">
                            <thead>
                            <tr>
                                <th id="clickbait">Cari Kodu</th>
                                <th>Cari Adı</th>
                                <th>Açıklama</th>
                                <th>Döviz Türü</th>
                                <th>Kur Fiyati</th>
                                <th>Tutar</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="tahsilat_vazgec"><i class="fa fa-close"></i>
                        Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm" id="tahsilatı_kaydet"><i class="fa fa-plus"></i>
                        Kaydet
                    </button>
                </div>
                </div>
                </div>

            </div>
        </div>
    </div>
    <script>
    $('input').click(function() {
                $(this).select();
            });
        var table = "";
        $("body").off("click", "#kasa_tahsilat_ekle").on("click", "#kasa_tahsilat_ekle", function () {
            var kasa_adi = $("#kasa_adi").val();
            var doviz_tur = $("#doviz_turu_kasa").val();
            var doviz_kuru = $("#doviz_kuru_kasa").val();
            var cari_id = $("#cari_kodu_getir").attr("data-id");
            let cari_kodu = $("#cari_kodu_getir").val();
            var aciklama = $("#alt_aciklama").val();
            var tutar = $("#tahsilat_tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            var tahsilat_id = $("#kasa_tahsilat_ekle").attr("data-id");

            if (kasa_adi == "") {
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
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Lütfen Bir Kasa Seçiniz'
                });
            } else {
                $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=kasa_tahsilat_urun_ekle_sql",
                    type: "POST",
                    data: {
                        kasa_id: kasa_adi,
                        doviz_kuru: doviz_kuru,
                        cari_kodu: cari_kodu,
                        doviz_tur: doviz_tur,
                        cari_id: cari_id,
                        aciklama: aciklama,
                        tutar: tutar,
                        tahsilat_id: tahsilat_id
                    },
                    success: function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);
                            table.clear().draw(false);
                            json.forEach(function (item) {
                                var tutar = item.tutar;
                                tutar = tutar.replace(/\./g, "").replace(",", ".");
                                tutar = parseFloat(tutar);
                                tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                                var kur_fiyat = item.doviz_kuru;
                                kur_fiyat = parseFloat(kur_fiyat);
                                kur_fiyat = kur_fiyat.toLocaleString("tr-TR", {minimumFractionDigits: 4})
                                $("#kasa_tahsilat_ekle").attr("data-id", item.tahsilat_id);

                                let cari_kodu = "";
                                let cari_adi = "";
                                if (item.cari_kodu != null){
                                    cari_kodu = item.cari_kodu;
                                    cari_adi = item.cari_adi;
                                }else {
                                    cari_kodu = item.tc_no;
                                    cari_adi = item.uye_adi
                                }

                                var tahsilat_id = table.row.add([cari_kodu, cari_adi, item.aciklama, item.doviz_turu, kur_fiyat, tutar, "<button class='btn btn-danger tahsilat_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button"]).draw(false).node();
                                $(tahsilat_id).attr("data-id", item.id);
                                $(tahsilat_id).attr("cari", item.cari_id)
                                $("#tahsilat_kaydi_guncelle").attr("data-id", "");
                                $("#cari_kodu_getir").val("");
                                $("#cari_kodu_getir").attr("data-id", "");
                                $("#cari_adi_getir").val("");
                                $("#alt_aciklama").val("");
                                $("#tahsilat_tutar").val("");
                            });
                        }
                    }
                })
            }
        });

        $("body").off("click", "#tahsilat_kaydi_guncelle").on("click", "#tahsilat_kaydi_guncelle", function () {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=tahsilat_kaydi_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        var kasa_adi = $("#kasa_adi").val();
                        var doviz_tur = $("#doviz_turu_kasa").val();
                        var doviz_kuru = $("#doviz_kuru_kasa").val();
                        var cari_id = $("#cari_kodu_getir").attr("data-id");
                        var aciklama = $("#alt_aciklama").val();
                        var tutar = $(".tahsilat_guncelle_tutar").val();
                        tutar = tutar.replace(/\./g, "").replace(",", ".");
                        tutar = parseFloat(tutar);
                        var tahsilat_id = $("#kasa_tahsilat_ekle").attr("data-id");
                        if (kasa_adi == "") {
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
                            })

                            Toast.fire({
                                icon: 'warning',
                                title: 'Lütfen Bir Kasa Seçiniz'
                            });
                        } else {
                            $.ajax({
                                url: "controller/kasa_controller/sql.php?islem=kasa_tahsilat_urun_ekle_sql",
                                type: "POST",
                                data: {
                                    kasa_id: kasa_adi,
                                    doviz_kuru: doviz_kuru,
                                    doviz_tur: doviz_tur,
                                    cari_id: cari_id,
                                    aciklama: aciklama,
                                    tutar: tutar,
                                    tahsilat_id: tahsilat_id
                                },
                                success: function (result) {
                                    if (result != 2) {
                                        var json = JSON.parse(result);
                                        table.clear().draw(false);
                                        json.forEach(function (item) {
                                            var tutar = item.tutar;
                                            tutar = tutar.replace(/\./g, "").replace(",", ".");
                                            tutar = parseFloat(tutar);
                                            tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                                            var kur_fiyat = item.doviz_kuru;
                                            kur_fiyat = parseFloat(kur_fiyat);
                                            kur_fiyat = kur_fiyat.toLocaleString("tr-TR", {minimumFractionDigits: 4})
                                            $("#kasa_tahsilat_ekle").attr("data-id", item.tahsilat_id);
                                            var tahsilat_id = table.row.add([item.cari_kodu, item.cari_adi, item.aciklama, item.doviz_turu, kur_fiyat, tutar, "<button class='btn btn-danger tahsilat_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button"]).draw(false).node();
                                            $(tahsilat_id).attr("data-id", item.id);
                                            $(tahsilat_id).attr("cari", item.cari_id)
                                            $("#tahsilat_kaydi_guncelle").attr("data-id", "");
                                            $("#cari_kodu_getir").val("");
                                            $("#cari_kodu_getir").attr("data-id", "");
                                            $("#cari_adi_getir").val("");
                                            $("#alt_aciklama").val("");
                                            $("#tahsilat_tutar").val("");
                                        });
                                    }
                                }
                            })
                        }
                    }
                }
            });
        });

        $("body").off("click", "#tahsilat_vazgec").on("click", "#tahsilat_vazgec", function () {
            let tahsilat_id = $("#kasa_tahsilat_ekle").attr("data-id");
            if (tahsilat_id != "") {
                $.ajax({
                    url: 'controller/kasa_controller/sql.php?islem=tahsilat_iptal_et_sql',
                    type: "POST",
                    data: {
                        id: tahsilat_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#kasa_tahsilat_ekle_modal").modal("hide");
                        }else {
                            $("#kasa_tahsilat_ekle_modal").modal("hide");
                        }
                    }
                });
            } else {
                $("#kasa_tahsilat_ekle_modal").modal("hide");
            }
        });

        $("body").off("click", ".tahsilat_sil").on("click", ".tahsilat_sil", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=tahsilat_kaydi_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        table.row(row).remove().draw();
                    }
                }
            });
        });

        $("body").off("click", "#tahsilatı_kaydet").on("click", "#tahsilatı_kaydet", function () {
            var id = $("#kasa_tahsilat_ekle").attr("data-id");
            var aciklama = $("#ust_aciklama").val();
            var belge_no = $("#belge_no").val();
            var islem_tarihi = $("#islem_tarihi").val();
            var doviz_tur = $("#doviz_turu_kasa").val();
            var doviz_kuru = $("#doviz_kuru_kasa").val();

            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=kasa_tahsilati_kaydet",
                type: "POST",
                data: {
                    id: id,
                    aciklama: aciklama,
                    belge_no: belge_no,
                    islem_tarihi: islem_tarihi,
                    doviz_turu: doviz_tur,
                    doviz_kuru: doviz_kuru
                },
                success: function (result) {
                    if (result == 1) {
                        $("#kasa_tahsilat_ekle_modal").modal("hide");
                        $.get("view/kasa_tahsilat.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("view/kasa_tahsilat.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    } else {
                        $("#kasa_tahsilat_ekle_modal").modal("hide");
                    }
                }
            });
        })

        $("body").off("click", "#kasa_cari_liste_main").on("click", "#kasa_cari_liste_main", function () {
            $.get("modals/kasa_modal/kasa_tahsilat_modal.php?islem=kasa_cari_listesi_getir_modal", function (getModal) {
                $(".kasa_cari_listesi_div").html("");
                $(".kasa_cari_listesi_div").html(getModal);
            })
        });

        $("body").off("change", "#doviz_turu_kasa").on("change", "#doviz_turu_kasa", function () {
            var value = $(this).val();
            if (value == "TL") {
                $("#doviz_kuru_kasa").val("1.00");
            } else if (value == "EURO") {
                var eur_kur = $("#doviz_turu_kasa option:selected").attr("eur");
                $("#doviz_kuru_kasa").val(eur_kur);
            } else if (value == "USD") {
                var usd_kur = $("#doviz_turu_kasa option:selected").attr("usd");
                $("#doviz_kuru_kasa").val(usd_kur);
            } else if (value == "GBP") {
                var gbp_kur = $("#doviz_turu_kasa option:selected").attr("gbp");
                $("#doviz_kuru_kasa").val(gbp_kur);
            } else {
                $("#doviz_kuru_kasa").val("");
            }
        });


        $("body").off("click", ".tahsilat_selected").on("click", ".tahsilat_selected", function () {
            var id = $(this).attr("data-id");
            var cari_id = $(this).attr("cari");
            var cari_kodu = $(this).find('td').eq(0).text();
            var cari_adi = $(this).find('td').eq(1).text();
            var aciklama = $(this).find('td').eq(2).text();
            var tutar = $(this).find('td').eq(5).text();
            $("#tahsilat_kaydi_guncelle").attr("data-id", id);
            $("#cari_kodu_getir").val(cari_kodu);
            $("#cari_kodu_getir").attr("data-id", cari_id);
            $("#cari_adi_getir").val(cari_adi);
            $("#alt_aciklama").val(aciklama);
            $("#tahsilat_tutar").val(tutar);
        });


        $(document).ready(function () {
            setTimeout(function () {
                $("#clickbait").trigger("click");
            }, 500);
            $("#kasa_tahsilat_ekle_modal").modal("show");
            table = $('#cari_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                searching: false,
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("tahsilat_selected");
                }
            })

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {
                var item = JSON.parse(result);
                var usd = item.USD[0];
                var eur = item.EUR[0];
                var gbp = item.GBP[0];
                $("#usd_bas").attr("usd", usd);
                $("#eur_bas").attr("eur", eur);
                $("#gbp_bas").attr("gbp", gbp);
            });

            $.get("controller/kasa_controller/sql.php?islem=kasalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let varsayilan = "";
                        if (item.varsayilan_kasa == 1) {
                            varsayilan = "selected";
                        }
                        $("#kasa_adi").append("" +
                            "<option value='" + item.id + "' " + varsayilan + ">" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })

            $.get("controller/kasa_controller/sql.php?islem=son_belge_noyu_getir_sql",function (res){
                $("#belge_no").val(res);
            });

            $("#tahsilat_tutar").focusout(function () {
                var val = $(this).val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                $("#tahsilat_tutar").val(val);
            });

            $("#cari_kodu_getir").keyup(function () {
                var cari_kodu = $(this).val();
                $.get("controller/kasa_controller/sql.php?islem=cari_kodu_bilgileri_getir", {cari_kodu: cari_kodu}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $("#cari_kodu_getir").attr("data-id", item.id);
                        $("#cari_adi").val(item.cari_adi);
                        $("#cari_kodu_getir").val(item.cari_kodu);
                    } else {
                        $("#cari_kodu_getir").attr("data-id", "");
                        $("#cari_adi").val("");
                    }
                })
            })
        })
    </script>
    <?php
}
if ($islem == "kasa_cari_listesi_getir_modal") {
    ?>
    <div class="modal fade" id="kasa_cari_listesi_getir_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Cari Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="fatura_cari_liste">
                            <thead>
                            <tr>
                                <th id="click1">Cari Adı</th>
                                <th>Cari Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cari_table = "";
        $(document).ready(function () {
            $("#kasa_cari_listesi_getir_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            cari_table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                columns:[
                  {'data':'cari_adi'},
                  {'data':'cari_kodu'}
                ],
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row,data) {
                    $(row).addClass("cari_select");
                    $(row).find("td").css("text-align","left");
                    $(row).attr("data-id",data.id);
                }
            })
            $.get("controller/alis_controller/sql.php?islem=carileri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    cari_table.rows.add(json).draw(false);
                }
            })
        })

        $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
            var cari_adi = $(this).find("td").eq(0).text();
            var cari_kodu = $(this).find("td").eq(1).text();
            var id = $(this).attr("data-id");

            $("#cari_kodu_getir").attr("data-id", id);
            $("#cari_adi").val(cari_adi);
            $("#cari_kodu_getir").val(cari_kodu);
            $("#tahsilat_tutar").focus();
            $("#kasa_cari_listesi_getir_modal").modal("hide");
        })

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kasa_cari_listesi_getir_modal").modal("hide");
        })
    </script>
    <?php
}