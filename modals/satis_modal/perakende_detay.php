<?php

$islem = $_GET["islem"];

if ($islem == "perakende_detay_getir_modal") {
    ?>
    <div class="modal fade" id="perakende_satis_detay_sayfasi" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="perakende_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>PERAKENDE SATIŞ DETAY</div>
                        </div>
                        <div class="modal-body">
                            <div class="perakende_satis_kasalar_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="col-12 row mt-2">
                                        <div class="form-group row mt-2">
                                            <div class="col-md-4">
                                                <label>Müşteri</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" disabled
                                                       id="musteri_adi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Telefon</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="telefon"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>E-Posta</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="e_posta"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi Dairesi</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" disabled
                                                       id="vergi_dairesi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi No</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="vergi_no"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control form-control-sm" style="resize: none" disabled
                                                      id="aciklama"
                                                      rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control form-control-sm" style="resize: none" disabled
                                                      id="adres"
                                                      rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row mt-1 ">
                                    <div style="border: 1px solid #000" class="col-9 ">
                                        <table class="table table-sm table-bordered w-100 display nowrap"
                                               style="cursor:pointer;font-size: 13px;"
                                               id="perakende_kalemleri_listesi">
                                            <thead>
                                            <tr>
                                                <th id="stok_kodu_click">Stok Kodu</th>
                                                <th>Stok Adı</th>
                                                <th>Birim</th>
                                                <th>Miktar</th>
                                                <th>Birim Fiyat</th>
                                                <th>KDV (%)</th>
                                                <th>KDV Tutar</th>
                                                <th>İskonto (%)</th>
                                                <th>İskonto Tutar</th>
                                                <th>Ara Toplam</th>
                                                <th>Toplam</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div style="border: 1px solid #000;" class="col-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Fatura No</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-sm" id="fatura_no"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Fatura Tarihi</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" value="<?= date("Y-m-d") ?>"
                                                       class="form-control form-control-sm" id="fatura_tarihi" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Depo</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="custom-select custom-select-sm" id="perakende_depoid"
                                                        disabled>
                                                    <option value="">Depo Seçiniz...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>İskonto Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="iskonto_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>KDV Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="kdv_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Ara Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="toplam_ara_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label style="font-weight: bold; font-size: 15px">Genel Toplam</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text"
                                                       style=" text-align: right; font-size: 20px; font-weight: bold"
                                                       value="0,00" disabled class="form-control form-control-sm"
                                                       id="toplam_genel_toplam">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>


        var perakende_table = "";

        $("body").off("click", "#perakende_vazgec").on("click", "#perakende_vazgec", function () {
            $("#perakende_satis_detay_sayfasi").modal("hide");
        });

        $(document).ready(function () {
            setTimeout(function () {
                $("#stok_kodu_click").trigger("click");
            }, 500);
            $("#perakende_satis_detay_sayfasi").modal("show");
            perakende_table = $("#perakende_kalemleri_listesi").DataTable({
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                scrollX: true,
                scrollY: "55vh",
                paging: false,
                searching: false,
                info: false,
                "initComplete": function () {
                    $('#cari_table').addClass('myCustomStyle');
                },
                createdRow: function (row) {
                    $(row).addClass("perakende_listesi");
                    $(row).find("td").css("text-transform", "uppercase");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(2).css("text-align", "left");
                }
            });

            $.get("controller/satis_controller/sql.php?islem=depolari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let selected = "";
                        if (item.varsayilan_depo == 1) {
                            selected = "selected";
                        }
                        $("#perakende_depoid").append("" +
                            "<option value='" + item.id + "'>" + item.depo_adi + "</option>" +
                            "");
                    })
                }
            })

            $.get("controller/perakende_controller/sql.php?islem=secilen_kayit_bilgilerini_getir", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#musteri_adi").val(item.musteri_adi);
                    $("#telefon").val(item.telefon);
                    $("#e_posta").val(item.e_mail);
                    $("#vergi_dairesi").val(item.vergi_dairesi)
                    $("#vergi_no").val(item.vergi_no)
                    $("#aciklama").val(item.aciklama)
                    $("#adres").val(item.adres)
                    $("#fatura_no").val(item.fatura_no);
                    let fatura_tarihi = item.fatura_tarihi;
                    fatura_tarihi = fatura_tarihi.split(" ");
                    fatura_tarihi = fatura_tarihi[0];
                    $("#fatura_tarihi").val(fatura_tarihi);
                    setTimeout(function () {
                        $("#perakende_depoid").val(item.depo_id)
                    }, 300);

                    let iskonto = item.toplam_iskonto;
                    iskonto = parseFloat(iskonto);

                    let kdv = item.toplam_kdv;
                    kdv = parseFloat(kdv);

                    let araToplam = item.toplam_ara_toplam;
                    araToplam = parseFloat(araToplam);

                    let toplam_genel_toplam = item.toplam_genel_toplam;
                    toplam_genel_toplam = parseFloat(toplam_genel_toplam);

                    $("#iskonto_toplam").val(iskonto.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));

                    $("#kdv_toplam").val(kdv.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));

                    $("#toplam_ara_toplam").val(araToplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));

                    $("#toplam_genel_toplam").val(toplam_genel_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));
                }
            })

            $.get("controller/perakende_controller/sql.php?islem=perakende_satis_urunleri_getir_sql", {satis_id: "<?=$_GET["id"]?>"}, function (response) {
                if (response != 2) {
                    var json = JSON.parse(response);
                    json.forEach(function (item) {
                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        let birim_fiyat = item.birim_fiyat;
                        birim_fiyat = parseFloat(birim_fiyat);
                        birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let kdv_oran = item.kdv_oran;
                        kdv_oran = parseFloat(kdv_oran);
                        kdv_oran = kdv_oran.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let kdv_tutar = item.kdv_tutar;
                        kdv_tutar = parseFloat(kdv_tutar);
                        kdv_tutar = kdv_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let iskonto_oran = item.iskonto_oran;
                        iskonto_oran = parseFloat(iskonto_oran);
                        iskonto_oran = iskonto_oran.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let iskonto_tutar = item.iskonto_tutar;
                        iskonto_tutar = parseFloat(iskonto_tutar);
                        iskonto_tutar = iskonto_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let ara_toplam = item.ara_toplam;
                        ara_toplam = parseFloat(ara_toplam);
                        ara_toplam = ara_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let genel_toplam = item.genel_toplam;
                        genel_toplam = parseFloat(genel_toplam);
                        genel_toplam = genel_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        perakende_table.row.add([item.stok_kodu, item.stok_adi, item.birim, miktar, birim_fiyat, kdv_oran, kdv_tutar, iskonto_oran, iskonto_tutar, ara_toplam, genel_toplam]).draw(false);
                    });
                }
            })
        })
    </script>
    <?php
}