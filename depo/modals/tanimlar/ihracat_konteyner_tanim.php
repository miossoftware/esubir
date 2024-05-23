<?php


$islem = $_GET["islem"];

if ($islem == "ihracat_konteyner_tanimla_modal") {
    ?>
    <style>
        #ihracat_konteyner_tanim {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="ihracat_konteyner_tanim" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="ihracat_konteyner_tanim_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="kayitli_siparisler_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cari Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="cari_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="cari_getir_modal_irsaliye"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Epro. Referans</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="siparis_ep_ref">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="tum_siparisleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Referans No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="acenta_ref">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="ihracat_siparisleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Beyanname No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="beyanname_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="ithalat_siparisleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" id="konteynerleri_getir_button"><i
                                            class="fa fa-filter"></i> Hazırla
                                </button>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_table_list">
                                    <thead>
                                    <tr>
                                        <th id="trigger1">No</th>
                                        <th>Konteyner No</th>
                                        <th>Konteyner Tipi</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="ihracat_konteyner_tanim_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteynerleri_tanit_button"><i
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
            $("#ihracat_konteyner_tanim").modal("show");

            setTimeout(function () {
                $("#trigger1").trigger("click");
            }, 500);

            var konteyner_table = $('#konteyner_table_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                order: [0, ["asc"]],
                createdRow: function (row) {
                    $(row).addClass("tanimlanan_konteynerler_list");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "right");
                    $(row).find("td").eq(7).css("text-align", "right");
                },
                columns: [
                    {'data': 'no'},
                    {'data': 'konteyner_no'},
                    {'data': 'konteyner_tipi'},
                    {'data': 'islem'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
                $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                    $("#carileri_getir_irsaliye").html("");
                    $("#carileri_getir_irsaliye").html(getModal);
                })
            });

            $("body").off("click", "#konteynerleri_getir_button").on("click", "#konteynerleri_getir_button", function () {
                let siparis_id = $("#siparis_ep_ref").attr("data-id");
                let epro_ref = $("#siparis_ep_ref").val();
                let beyanname_no = $("#beyanname_no").val();
                let referans_no = $("#referans_no").val();

                $.get("depo/controller/ihracat_controller/sql.php?islem=tanitilacak_konteynerler_sql", {
                    siparis_id: siparis_id,
                    epro_ref: epro_ref,
                    beyanname_no: beyanname_no,
                    referans_no: referans_no
                }, function (res) {
                    if (res != 2) {
                        var json = JSON.parse(res);

                        let basilacak = [];
                        let no = 1;
                        konteyner_table.clear().draw(false);
                        json.forEach(function (item) {
                            for (let i = 0; i < item.konteyner_sayisi; i++) {
                                let arr = {
                                    no: no,
                                    konteyner_no: "<input type='text' class='form-control form-control-sm col-9'>",
                                    konteyner_tipi: item.konteyner_tipi,
                                    islem: "<button class='btn btn-danger btn-sm tanitilan_konteyner_sil_sql'><i class='fa fa-trash'></i></button>"
                                };
                                basilacak.push(arr);
                                no += 1;
                            }
                        })
                        konteyner_table.rows.add(basilacak).draw(false);
                    }
                })
            });
        });

        $("body").off("click", "#konteynerleri_tanit_button").on("click", "#konteynerleri_tanit_button", function () {
            let tipi = "";
            let epro_ref = $("#siparis_ep_ref").val();
            let siparis_id = $("#siparis_ep_ref").attr("data-id");
            let cari_id = $("#cari_id").attr("data-id");
            let gidecek_arr = [];

            let desen = 'İTH';
            if (epro_ref.match(desen)) {
                tipi = "İTHALAT";
            } else {
                tipi = "İHRACAT";
            }

            $(".tanimlanan_konteynerler_list").each(function () {
                let konteyner_no = $(this).find("td:eq(1) input").val();
                let konteyner_tipi = $(this).find("td").eq(2).text();
                let newRow = {
                    konteyner_tipi: konteyner_tipi,
                    konteyner_no: konteyner_no
                };
                gidecek_arr.push(newRow);
            });

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/ihracat_controller/sql.php?islem=konteynerleri_tanit_sql",
                    type: "POST",
                    data: {
                        tipi: tipi,
                        cari_id: cari_id,
                        siparis_id: siparis_id,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Konteynerler Tanımlandı",
                                "success"
                            );
                            $("#ihracat_konteyner_tanim").modal("hide");
                            $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#ihracat_siparisleri_getir_button").on("click", "#ihracat_siparisleri_getir_button", function () {
            $.get("depo/modals/ihracat_modal/ihracat_konteyner_tanim.php?islem=ihracat_kayitli_siparisleri_getir_modal", function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            });
        });

        $("body").off("click", "#ithalat_siparisleri_getir_button").on("click", "#ithalat_siparisleri_getir_button", function () {
            $.get("depo/modals/ihracat_modal/ihracat_konteyner_tanim.php?islem=kayitli_siparisleri_getir_modal", function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            });
        });

        $("body").off("click", "#tum_siparisleri_getir_button").on("click", "#tum_siparisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            $.get("depo/modals/konteyner_modal/ic_yukleme_konteyner_giris_yap.php?islem=is_emirlerini_getir_sql", {
                cari_id: cari_id,
                modul: "konteyner_tanim"
            }, function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            })
        });

        $("body").off("click", "#ihracat_konteyner_tanim_kapat").on("click", "#ihracat_konteyner_tanim_kapat", function () {
            $("#ihracat_konteyner_tanim").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "ihracat_kayitli_siparisleri_getir_modal") {
    ?>
    <div class="modal fade" id="depo_siparisleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_siparisleri_getir_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SİPARİŞLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_depo_siparsileri_table_list">
                                <thead>
                                <tr>
                                    <th id="click1">Acenta</th>
                                    <th>Referans</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>CUT - OFF Tarihi</th>
                                    <th>Ardiyesiz Giriş</th>
                                    <th>Alım Yeri</th>
                                    <th>Epro Ref.</th>
                                    <th>Açıklama</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#depo_siparisleri_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#is_emri_depo_siparsileri_table_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "acente"},
                    {'data': "acente_ref"},
                    {'data': "siparis_tarihi"},
                    {'data': "cut_of_tarihi"},
                    {'data': "ardiyesiz_giris_tarihi"},
                    {'data': "alim_yeri"},
                    {'data': "epro_ref"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_siparis_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/ihracat_controller/sql.php?islem=ihracat_siparislerini_getir_sql2", {cari_id: "<?=$_GET["cari_id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/ihracat_controller/sql.php?islem=guncellenecek_siparis_ana_bilgi", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#acenta_ref").val(item.acente_ref);
                    $("#beyanname_no").val("");
                    $("#acenta").val(item.acente);
                    let siparis_tarihi = item.siparis_tarihi;
                    siparis_tarihi = siparis_tarihi.split(" ");
                    let cutt_off_tarihi = item.cutt_off_tarihi;
                    $("#tipi").val("İHRACAT");
                    cutt_off_tarihi = cutt_off_tarihi.split(" ");
                    let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                    ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                    $("#siparis_tarihi").val(siparis_tarihi[0]);
                    $("#cut_off_tarihi").val(cutt_off_tarihi[0]);
                    $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi[0]);
                    $("#aciklama").val(item.aciklama);
                    $("#alim_yeri").val(item.alim_yeri);
                }
            })
            $.get("depo/controller/ihracat_controller/sql.php?islem=siparis_ihracat_urun_bilgisi_sql", {id: id}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        $("#ep_ref").val(item.epro_ref);
                        $("#siparis_ep_ref").attr("data-id", id);
                        $("#siparis_ep_ref").val(item.epro_ref);
                        $("#depo_ihracat_urun_ekle").prop("disabled", true);
                    });
                }
            });
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_siparisleri_getir_modal_kapat").on("click", "#depo_siparisleri_getir_modal_kapat", function () {
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "kayitli_siparisleri_getir_modal") {
    ?>
    <div class="modal fade" id="depo_ithalat_siparislerini_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_ithalat_siparislerini_getir_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SİPARİŞLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_depo_siparsileri_table_list">
                                <thead>
                                <tr>
                                    <th id="click1">Acenta</th>
                                    <th>Beyanname No</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>Demoraj Tarihi</th>
                                    <th>Alım Yeri</th>
                                    <th>Epro Ref.</th>
                                    <th>Açıklama</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#depo_ithalat_siparislerini_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#is_emri_depo_siparsileri_table_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "acente"},
                    {'data': "beyanname_no"},
                    {'data': "siparis_tarihi"},
                    {'data': "demoraj_tarihi"},
                    {'data': "alim_yeri"},
                    {'data': "epro_ref"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_siparis_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/ithalat_controller/sql.php?islem=ithalat_siparislerini_getir_sql2", {cari_id: "<?=$_GET["cari_id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/ithalat_controller/sql.php?islem=guncellenecek_siparis_ana_bilgi", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#acenta_ref").val("");
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#acenta").val(item.acente);
                    let siparis_tarihi = item.siparis_tarihi;
                    $("#tipi").val("İTHALAT");
                    siparis_tarihi = siparis_tarihi.split(" ");
                    let demoraj_tarihi = item.demoraj_tarihi;
                    demoraj_tarihi = demoraj_tarihi.split(" ");
                    $("#siparis_tarihi").val(siparis_tarihi[0]);
                    $("#demoraj_tarihi").val(demoraj_tarihi[0]);
                    $("#aciklama").val(item.aciklama);
                    $("#alim_yeri").val(item.alim_yeri);
                }
            })
            $.get("depo/controller/ithalat_controller/sql.php?islem=siparis_ihracat_urun_bilgisi_sql", {id: id}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        $("#ep_ref").val(item.epro_ref);
                        $("#siparis_ep_ref").attr("data-id", id);
                        $("#siparis_ep_ref").val(item.epro_ref);
                        $("#depo_ihracat_urun_ekle").prop("disabled", true);
                    });
                }
            });
            $("#depo_ithalat_siparislerini_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_ithalat_siparislerini_getir_modal_kapat").on("click", "#depo_ithalat_siparislerini_getir_modal_kapat", function () {
            $("#depo_ithalat_siparislerini_getir_modal").modal("hide");
        });

    </script>
    <?php
}