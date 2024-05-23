<?php

$islem = $_GET["islem"];

if ($islem == "yeni_kredi_kullan_modal") {
    ?>
    <style>
        #kredi_acilis_fisi_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="kredi_acilis_fisi_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="kredi_acilis_fisi_modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KREDİ AÇILIŞ FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="carileri_getir_pc_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Açılış Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="acilis_tarihi" style="background-color: white"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kullanım Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="kullanim_tarihi" style="background-color: white"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kredi Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="kredi_kodu" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kullanım Nedeni</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="kullanim_nedeni"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="banka_ids">
                                                <option value="">Banka Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Belge No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="belge_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kredi Tutarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right" value="0,00"
                                                   class="form-control form-control-sm" id="kredi_tutari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Faiz Oranı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right" value="0,00"
                                                   class="form-control form-control-sm" id="faiz_orani">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>İlk Ödeme Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="ilk_odeme_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Ödenecek Toplam</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" value="0,00" class="form-control form-control-sm"
                                                   id="odenecek_toplam" style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kredi Kesintisi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input value="0,00" type="text" class="form-control form-control-sm"
                                                   id="kredi_kesintisi" style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Taksit Sayısı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input style="text-align: right" value="1" type="number" id="taksit_sayisi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="pc_cari_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="pc_cariler_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="cari_adi"
                                                   style="font-weight: bold"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="aciklama" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100  nowrap" id="kredi_taksitleri_table"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="clikcable123" style="width: 0px !important;">Taksit</th>
                                        <th>Vadesi</th>
                                        <th>Ana Para</th>
                                        <th>Faiz Tutarı</th>
                                        <th>Toplam Ödeme</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="kredi_acilis_fisi_modal_kapat"><i
                                            class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="kredi_acilis_fisi_kaydet"><i
                                            class="fa fa-plus"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        var table = "";
        $(document).ready(function () {
            $("#kredi_acilis_fisi_modal").modal("show");

            Swal.fire(
                "Uyarı!",
                "Lütfen Açılış Tarihinizi Banka Hareketlerinizi Düzgün Etkilenecek Şekilde Giriniz...",
                "info"
            );

            $.get("controller/kredi_controller/sql.php?islem=son_kredi_kodu_sql", function (res) {
                if (res != 2) {
                    $("#kredi_kodu").val(res);
                } else {
                    $("#kredi_kodu").val("KREDİ.001");
                }
            })

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_ids").append("" +
                            "<option value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "")
                    })
                }
            })

            setTimeout(function () {
                $("#clikcable123").trigger("click");
            }, 500);

            table = $('#kredi_taksitleri_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                searching: false,
                "paging": false,
                order: [0, ["asc"]],
                columns: [
                    {'data': 'taksit'},
                    {'data': 'vade_tarihi'},
                    {'data': 'ana_para'},
                    {'data': 'faiz_tutari'},
                    {'data': 'toplam_odeme'}
                ],
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).find('td').eq(0).css('text-align', 'center');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).addClass("kredi_kullanim_list")
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });

            flatpickr("#kullanim_tarihi", {
                maxDate: "today",
                locale: "tr",
                dateFormat: "d.m.Y",
                defaultDate: "today"
            });
        });

        $("body").off("click", "#kredi_acilis_fisi_modal_kapat").on("click", "#kredi_acilis_fisi_modal_kapat", function () {
            $("#kredi_acilis_fisi_modal").modal("hide");
        });
        $("body").off("click", "#kredi_acilis_fisi_kaydet").on("click", "#kredi_acilis_fisi_kaydet", function () {
            let gidecek_arr = [];
            $(".kredi_kullanim_list").each(function () {
                let taksit = $(this).find("td").eq(0).text();
                let vade_tarih = $(this).find("td").eq(1).text();
                vade_tarih = vade_tarih.split("/");
                let g = vade_tarih[0];
                let a = vade_tarih[1];
                let y = vade_tarih[2];
                let arr = [y, a, g];
                vade_tarih = arr.join("-");

                let ana_para = $(this).find("td").eq(2).text();
                ana_para = ana_para.replace(/\./g, "").replace(",", ".");
                ana_para = parseFloat(ana_para);
                let faiz_tutari = $(this).find("td").eq(3).text();
                faiz_tutari = faiz_tutari.replace(/\./g, "").replace(",", ".");
                faiz_tutari = parseFloat(faiz_tutari);
                let toplam_odeme = $(this).find("td").eq(4).text();
                toplam_odeme = toplam_odeme.replace(/\./g, "").replace(",", ".");
                toplam_odeme = parseFloat(toplam_odeme);


                let newRow = {
                    taksit: taksit,
                    vade_tarih: vade_tarih,
                    ana_para: ana_para,
                    faiz_tutari: faiz_tutari,
                    toplam_odeme: toplam_odeme
                };
                gidecek_arr.push(newRow);
            });

            let kullanim_tarihi = $("#kullanim_tarihi").val();
            let acilis_tarihi = $("#acilis_tarihi").val();
            kullanim_tarihi = kullanim_tarihi.split(".");
            let g = kullanim_tarihi[0];
            let a = kullanim_tarihi[1];
            let y = kullanim_tarihi[2];
            let arr1 = [y, a, g];
            kullanim_tarihi = arr1.join("-");
            let kredi_kodu = $("#kredi_kodu").val();
            let kullanim_nedeni = $("#kullanim_nedeni").val();
            let banka_ids = $("#banka_ids").val();
            let belge_no = $("#belge_no").val();
            let kredi_tutari = $("#kredi_tutari").val();
            kredi_tutari = kredi_tutari.replace(/\./g, "").replace(",", ".");
            kredi_tutari = parseFloat(kredi_tutari);
            let faiz_orani = $("#faiz_orani").val();
            faiz_orani = faiz_orani.replace(/\./g, "").replace(",", ".");
            faiz_orani = parseFloat(faiz_orani);
            let odenecek_toplam = $("#odenecek_toplam").val();
            odenecek_toplam = odenecek_toplam.replace(/\./g, "").replace(",", ".");
            odenecek_toplam = parseFloat(odenecek_toplam);
            let kredi_kesintisi = $("#kredi_kesintisi").val();
            kredi_kesintisi = kredi_kesintisi.replace(/\./g, "").replace(",", ".");
            kredi_kesintisi = parseFloat(kredi_kesintisi);
            let ilk_odeme_tarihi = $("#ilk_odeme_tarihi").val();
            let taksit_sayisi = $("#taksit_sayisi").val();
            let pc_cari_kodu = $("#pc_cari_kodu").attr("data-id");
            let aciklama = $("#aciklama").val();

            if (pc_cari_kodu == undefined || pc_cari_kodu == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Kredi Carisi Belirtiniz",
                    'warning'
                )
            } else if (banka_ids == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Banka Belirtiniz",
                    'warning'
                )
            } else {
                $.ajax({
                    url: "controller/kredi_controller/sql.php?islem=kredi_acilisi_yap_sql",
                    type: "POST",
                    data: {
                        kullanim_tarihi: kullanim_tarihi,
                        kullanim_nedeni: kullanim_nedeni,
                        kredi_kodu: kredi_kodu,
                        acilis_tarihi: acilis_tarihi,
                        banka_id: banka_ids,
                        belge_no: belge_no,
                        kredi_tutari: kredi_tutari,
                        faiz_orani: faiz_orani,
                        odenecek_toplam: odenecek_toplam,
                        kredi_kesintisi: kredi_kesintisi,
                        ilk_odeme_tarih: ilk_odeme_tarihi,
                        taksit_sayisi: taksit_sayisi,
                        cari_id: pc_cari_kodu,
                        aciklama: aciklama,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Kredi Kullanımı Kaydedildi",
                                "success"
                            );
                            $("#kredi_acilis_fisi_modal").modal("hide");
                            $.get("view/kredi_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/kredi_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        }
                    }
                });
            }
        });

        $("#kredi_tutari").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#faiz_orani").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#odenecek_toplam").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#kredi_kesintisi").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });


        $("#pc_cari_kodu").keyup(function () {
            let cari_kodu = $(this).val();
            $.get("controller/pos_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql", {cari_kodu: cari_kodu}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#pc_cari_kodu").attr("data-id", item.id)
                    $("#pc_cari_kodu").val(item.cari_kodu)
                    $("#cari_tel").val(item.telefon)
                    $("#cari_adi").val(item.cari_adi)
                } else {
                    $("#pc_cari_kodu").attr("data-id", "")
                    $("#cari_tel").val("")
                    $("#cari_adi").val("")
                }
            })
        });
        $("input").click(function () {
            $(this).select();
        })

        $("body").off("click", "#pos_cekim_vazgec").on("click", "#pos_cekim_vazgec", function () {
            $("#yeni_kredi_cekimi_olustur_modal").modal("hide");
        });

        $("body").off("focusout", "#taksit_sayisi").on("focusout", "#taksit_sayisi", function () {
            let taksit_sayisi = $(this).val();

            let kredi_tutari = $("#kredi_tutari").val();
            kredi_tutari = kredi_tutari.replace(/\./g, "").replace(",", ".");
            kredi_tutari = parseFloat(kredi_tutari);

            let odenecek_toplam = $("#odenecek_toplam").val();
            odenecek_toplam = odenecek_toplam.replace(/\./g, "").replace(",", ".");
            odenecek_toplam = parseFloat(odenecek_toplam);

            let vade_tarihi = $("#ilk_odeme_tarihi").val();
            let vadeTarihiDate = new Date(vade_tarihi);

            let ana_para = kredi_tutari / taksit_sayisi;
            let faiz_tutari = (odenecek_toplam - kredi_tutari) / taksit_sayisi;
            let toplam_odenecek = ana_para + faiz_tutari;
            table.clear().draw(false);
            let basilacak_arr = [];
            for (let i = 1; i <= taksit_sayisi; i++) {
                let vade_tarihi = vadeTarihiDate.toLocaleDateString("tr-TR");
                vade_tarihi = vade_tarihi.split(".");
                let g = vade_tarihi[0];
                let a = vade_tarihi[1];
                let y = vade_tarihi[2];
                let arr = [g, a, y];
                vade_tarihi = arr.join("/");

                let newRow = {
                    taksit: i,
                    vade_tarihi: vade_tarihi,
                    ana_para: ana_para.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}),
                    faiz_tutari: faiz_tutari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }),
                    toplam_odeme: toplam_odenecek.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })
                };
                vadeTarihiDate.setMonth(vadeTarihiDate.getMonth() + 1);
                basilacak_arr.push(newRow);
            }
            table.rows.add(basilacak_arr).draw(faiz_tutari);
        });

        $("body").off("click", "#pc_cariler_button").on("click", "#pc_cariler_button", function () {
            $.get("modals/pos_modal/yeni_pos_cekimi_modal.php?islem=carileri_getir", function (getModal) {
                $(".carileri_getir_pc_div").html("");
                $(".carileri_getir_pc_div").html(getModal);
            })
        });

    </script>

    <?php
}