<?php

$islem = $_GET["islem"];

if ($islem == "pos_cekim_modal_getir") {
    ?>
    <style>
        #pos_cekim_olustur_modal_new {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="pos_cekim_olustur_modal_new" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 65%; max-width: 65%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="pos_cekim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>POS ÇEKİM OLUŞTUR</div>
                        </div>
                        <div class="modal-body">
                            <div class="carileri_getir_pc_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
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
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Cari Tel</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="cari_tel"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Banka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="pos_id">
                                                <option value="">Banka Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Belge No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="pc_belge_no" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="islem_tarihi" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input style="text-align: right" type="text" id="tutar"
                                                   class="form-control form-control-sm">
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
                                            <label>Çekilen Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input style="text-align: right" type="text" id="cekilen_tutar"
                                                   class="form-control form-control-sm">
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
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="pos_cekim_list_table">
                                    <thead>
                                    <tr>
                                        <th id="pc_click1">Taksit</th>
                                        <th>Cari Adı</th>
                                        <th>POS Banka</th>
                                        <th>Taksit Tutarı</th>
                                        <th>Tahsil Tarihi</th>
                                        <th>Açıklama</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm" id="taksitlendir_main_button"><i
                                            class="fa fa-credit-card-alt"></i>
                                    Taksitlendir
                                </button>
                                <button class="btn btn-danger btn-sm" id="pos_cekim_vazgec"><i class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="pos_cekim_islemini_kaydet"><i
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

        $("body").off("click", "#pos_cekim_islemini_kaydet").on("click", "#pos_cekim_islemini_kaydet", function () {
            let new_arr = [];
            let son_tahsil = "";
            $(".pos_cekilen_urunler").each(function () {
                let taksit = $(this).find("td").eq(0).text();
                let taksit_tutari = $(this).find("td").eq(3).text();
                taksit_tutari = taksit_tutari.replace(/\./g, "").replace(",", ".");
                taksit_tutari = parseFloat(taksit_tutari);
                let tahsil_tarihi = $(this).find("td").eq(4).text();
                tahsil_tarihi = tahsil_tarihi.split("/");
                let gun = tahsil_tarihi[0];
                let ay = tahsil_tarihi[1];
                let yil = tahsil_tarihi[2];
                let arr = [yil, ay, gun];
                tahsil_tarihi = arr.join("-");
                let aciklama = $(this).find("td").eq(5).text();
                let newRow = {
                    'taksit': taksit,
                    'taksit_tutari': taksit_tutari,
                    'tahsil_tarihi': tahsil_tarihi,
                    'aciklama': aciklama,
                };
                son_tahsil = tahsil_tarihi;
                new_arr.push(newRow);
            });
            let cari_id = $("#pc_cari_kodu").attr("data-id");
            let pos_id = $("#pos_id").val();
            let belge_no = $("#pc_belge_no").val();
            let tarih = $("#islem_tarihi").val();
            let tutar = $("#tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let taksit_sayisi = $("#taksit_sayisi").val();
            let aciklama = $("#aciklama").val();

            $.ajax({
                url: "controller/pos_controller/sql.php?islem=pos_cekim_islemini_kaydet",
                type: "POST",
                data: {
                    cari_id: cari_id,
                    pos_id: pos_id,
                    belge_no: belge_no,
                    tarih: tarih,
                    tutar: tutar,
                    taksit_sayisi: taksit_sayisi,
                    tahsil_tarihi: son_tahsil,
                    aciklama: aciklama,
                    new_arr: new_arr
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            'Başarılı',
                            'POS Çekim İşlemi Başarı İle Gerçekleşti',
                            'success'
                        );
                        $.get("view/pos_cekimi_giris.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/pos_cekimi_giris.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#pos_cekim_olustur_modal_new").modal("hide");
                    } else {
                        $("#pos_cekim_olustur_modal_new").modal("hide");
                    }
                }
            });
        });

        $("#tutar").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let komisyon_orani = $("#pos_id option:selected").attr("komisyon_yuzde")
            komisyon_orani = parseFloat(komisyon_orani);


            let komisyon_miktari = tutar * (komisyon_orani / 100);
            let komisyonlu_tt = komisyon_miktari + tutar;
            if (isNaN(komisyon_miktari)) {
                komisyon_miktari = 0;
            }
            komisyon_miktari = komisyon_miktari.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            if (isNaN(komisyonlu_tt)) {
                komisyonlu_tt = 0;
            }
            komisyonlu_tt = komisyonlu_tt.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $("#komisyon_tutari").val(komisyon_miktari);
            $("#komisyonlu_tt").val(komisyonlu_tt);
            let taksit_sayisi = $("#taksit_sayisi").val();
            taksit_sayisi = taksit_sayisi.replace(/\./g, "").replace(",", ".");
            taksit_sayisi = parseFloat(taksit_sayisi);
            let aylik_taksit_first = tutar / taksit_sayisi;
            let aylik_taksit_thousand = tutar / taksit_sayisi;


            aylik_taksit_first = aylik_taksit_first.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            let cikan_snc = aylik_taksit_first;
            cikan_snc = cikan_snc.replace(/\./g, "").replace(",", ".");
            cikan_snc = parseFloat(cikan_snc);
            let total = cikan_snc * taksit_sayisi;
            let fark = tutar - total;
            aylik_taksit_thousand = fark + aylik_taksit_thousand;
            if (isNaN(aylik_taksit_thousand)) {
                aylik_taksit_thousand = 0;
            }
            aylik_taksit_thousand = aylik_taksit_thousand.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $("#cekilen_tutar").val(aylik_taksit_thousand);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#taksit_sayisi").focusout(function () {
            let taksit_sayisi = $(this).val();
            if (taksit_sayisi <= 0) {
                $("#taksit_sayisi").val("1");
            }
            taksit_sayisi = parseFloat(taksit_sayisi);
            let tutar = $("#tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let aylik_taksit_thousand = tutar / taksit_sayisi;
            let ilk_taksit = tutar / taksit_sayisi;
            ilk_taksit = ilk_taksit.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            let cikan_snc = ilk_taksit;
            cikan_snc = cikan_snc.replace(/\./g, "").replace(",", ".");
            cikan_snc = parseFloat(cikan_snc);
            let total = cikan_snc * taksit_sayisi;
            let fark = tutar - total;
            aylik_taksit_thousand = fark + aylik_taksit_thousand;
            if (isNaN(aylik_taksit_thousand)) {
                aylik_taksit_thousand = 0;
            }
            aylik_taksit_thousand = aylik_taksit_thousand.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $("#cekilen_tutar").val(aylik_taksit_thousand);
        });
        $("#cekilen_tutar").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#komisyon_tutari").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });
        $("#komisyonlu_tt").focusout(function () {
            let tutar = $(this).val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(tutar);
        });

        $("body").off("change", "#pos_id").on("change", "#pos_id", function () {
            let tutar = $("#tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let komisyon_orani = $("#pos_id option:selected").attr("komisyon_yuzde")
            komisyon_orani = parseFloat(komisyon_orani);
            let komisyon_miktari = tutar * (komisyon_orani / 100);
            let komisyonlu_tt = komisyon_miktari + tutar;
            if (isNaN(komisyon_miktari)) {
                komisyon_miktari = 0;
            }
            komisyon_miktari = komisyon_miktari.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            if (isNaN(komisyonlu_tt)) {
                komisyonlu_tt = 0;
            }
            komisyonlu_tt = komisyonlu_tt.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $("#komisyon_tutari").val(komisyon_miktari);
            $("#komisyonlu_tt").val(komisyonlu_tt);
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

        var table = "";

        $("body").off("click", "#taksitlendir_main_button").on("click", "#taksitlendir_main_button", function () {
            table.clear().draw(false);
            let basilacak_arr = [];


            let taksit_sayisi = $("#taksit_sayisi").val();
            taksit_sayisi = parseInt(taksit_sayisi);
            let cekilen_tutar = $("#cekilen_tutar").val();
            cekilen_tutar = cekilen_tutar.replace(/\./g, "").replace(",", ".");
            cekilen_tutar = parseFloat(cekilen_tutar);
            if (isNaN(cekilen_tutar)) {
                cekilen_tutar = 0;
            }
            cekilen_tutar = cekilen_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            let cari_adi = $("#cari_adi").val();
            let pos_banka = $("#pos_id option:selected").text();

            // kalan taksitler hesabı
            let girilen_tutar = $("#tutar").val();
            girilen_tutar = girilen_tutar.replace(/\./g, "").replace(",", ".");
            girilen_tutar = parseFloat(girilen_tutar);
            if (isNaN(girilen_tutar)) {
                girilen_tutar = 0;
            }
            let kalan_taksitler = girilen_tutar / taksit_sayisi;
            kalan_taksitler = parseFloat(kalan_taksitler);
            kalan_taksitler = kalan_taksitler.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });

            // vade_gunu hesabı

            let artacak_tarih = 0;
            let taksit_number = 1;

            let vade_gunu = $("#pos_id option:selected").attr("vade_tarihi");
            vade_gunu = parseInt(vade_gunu);
            var userInput = $("#islem_tarihi").val();
            var inputDate = new Date(userInput);
            inputDate.setDate(inputDate.getDate() + vade_gunu);
            var resultDate = inputDate.toISOString().slice(0, 10);
            let split = resultDate.split("-");
            let gun = split[2];
            let ay = split[1];
            let yil = split[0];
            let arr = [gun, ay, yil];
            let basilacak_tarih = arr.join("/");
            let aciklama = $("#aciklama").val();
            for (let i = 0; i < taksit_sayisi; i++) {
                if (i != 0) {
                    taksit_number += 1;
                    artacak_tarih += 30
                    let next_date = new Date(resultDate);
                    next_date.setDate(next_date.getDate() + artacak_tarih);
                    var resultDate2 = next_date.toISOString().slice(0, 10);
                    let split = resultDate2.split("-");
                    let gun = split[2];
                    let ay = split[1];
                    let yil = split[0];
                    let arr = [gun, ay, yil];
                    let basilacak_tarih = arr.join("/");
                    let newRow = {
                        'taksit': taksit_number,
                        'cari_adi': cari_adi,
                        'pos_banka': pos_banka,
                        'taksit_tutari': kalan_taksitler,
                        'tahsil_tarihi': basilacak_tarih,
                        'aciklama': aciklama,
                    };
                    basilacak_arr.push(newRow);
                } else {
                    let newRow = {
                        'taksit': taksit_number,
                        'cari_adi': cari_adi,
                        'pos_banka': pos_banka,
                        'taksit_tutari': cekilen_tutar,
                        'tahsil_tarihi': basilacak_tarih,
                        'aciklama': aciklama,
                    };
                    basilacak_arr.push(newRow);
                }
            }
            table.rows.add(basilacak_arr).draw(false);

        });

        $("body").off("click", ".pos_aciklama_alone").on("click", ".pos_aciklama_alone", function () {
            var tds = document.getElementsByClassName('pos_aciklama_alone');
            for (var i = 0; i < tds.length; i++) {
                tds[i].addEventListener('click', function () {
                    var td = this;
                    var oldValue = td.innerHTML;
                    td.innerHTML = '<input type="text" value="' + oldValue + '" />';
                    var input = td.querySelector('input');
                    input.focus();
                    input.addEventListener('blur', function () {
                        td.innerHTML = input.value;
                    });

                    input.addEventListener('keyup', function (event) {
                        if (event.keyCode === 13) { // Enter tuşuna basıldığında
                            td.innerHTML = input.value;
                        }
                    });
                });
            }
        })
        $(document).ready(function () {

            setTimeout(function () {
                $("#pc_click1").trigger("click");
            }, 500);

            $("#pos_cekim_olustur_modal_new").modal("show");

            table = $('#pos_cekim_list_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                searching: false,
                "paging": false,
                order: [0, ["asc"]],
                columns: [
                    {'data': 'taksit'},
                    {'data': 'cari_adi'},
                    {'data': 'pos_banka'},
                    {'data': 'taksit_tutari'},
                    {'data': 'tahsil_tarihi'},
                    {'data': 'aciklama'}
                ],
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("pos_cekilen_urunler");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                    $(row).find('td').eq(4).css('text-align', 'left');
                    $(row).find('td').eq(5).css('text-align', 'left');
                    $(row).find('td').eq(5).addClass("pos_aciklama_alone");
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $(document).ready(function () {
                $.get("controller/pos_controller/sql.php?islem=tanimli_pos_cihazlarini_getir", function (response) {
                    if (response != 2) {
                        var json = JSON.parse(response);
                        $("#pos_id").html("");
                        $("#pos_id").append("" +
                            "<option value=''>Banka Seçiniz...</option>" +
                            "");
                        json.forEach(function (item) {
                            $("#pos_id").append("" +
                                "<option vade_tarihi='" + item.vade_gunu + "' komisyon_yuzde='" + item.komisyon_orani + "' value='" + item.id + "'>" + item.banka_adi + "</option>" +
                                "");
                        })
                    }
                })
            })
        });

        $("body").off("click", "#pos_cekim_vazgec").on("click", "#pos_cekim_vazgec", function () {
            $("#pos_cekim_olustur_modal_new").modal("hide");
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
if ($islem == "carileri_getir") {
    ?>
    <div class="modal fade" id="pc_cari_liste_modal_getir"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 30%; max-width: 30%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">CARİ LİSTESİ

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

        $('input').click(function () {
            $(this).select();
        });
        var cari_table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#pc_cari_liste_modal_getir").modal("hide");
        })

        $(document).ready(function () {
            $("#pc_cari_liste_modal_getir").modal("show");

            setTimeout(function () {

                $("#click1").trigger("click");

            }, 300);

            cari_table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "cari_adi"},
                    {'data': "cari_kodu"},
                ],
                createdRow: function (row) {
                    $(row).addClass("cari_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
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
            var id = $(this).attr("data-id");
            var cari_adi = $(this).find("td").eq(0).text();
            var cari_kodu = $(this).find("td").eq(1).text();
            $(".secilen_cari").val(cari_kodu);
            $(".secilen_cari").attr("data-id", id);
            $(".cari_adi_getir").val(cari_adi);
            $(".cari_adi").val(cari_adi);
            $("#pc_cari_liste_modal_getir").modal("hide");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#pc_cari_kodu").attr("data-id", item.id);
                    $("#pc_cari_kodu").val(item.cari_kodu);
                    $("#cari_tel").val(item.telefon);
                    $("#cari_adi").val(item.cari_adi);
                }
            });
        })
    </script>
    <?php
}