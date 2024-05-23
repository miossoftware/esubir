<?php

$islem = $_GET["islem"];

if ($islem == "pos_tahsil_modal_getir") {
    ?>
    <div class="modal fade" id="tahsil_edilecek_pos_islemleri"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">TAHSİL EDİLECEK POS İŞLEMLERİ
                    <button type="button" class="btn-close btn-close-white" id="tahsil_modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="col-12 row no-gutters">
                        <div class="col-2">
                            <input id="islem_tarihi" type="date" class="form-control form-control-sm"
                                   value="<?= date("Y-m-d") ?>">
                        </div>
                        <div class="col-4">
                            <input id="pos_tahsil_aciklama" placeholder="Açıklama" type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="tahsile_verilen_cek_senetler_list">
                            <thead>
                            <tr>
                                <th id="click125">Seç</th>
                                <th>Kaçıncı Taksit</th>
                                <th>Tarih</th>
                                <th>Cari Adı</th>
                                <th>POS Banka</th>
                                <th>Vade Tarihi</th>
                                <th>Taksit Tutarı</th>
                                <th>Açıklama</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="tahsil_modal_kapat"><i class="fa fa-close"></i> Kapat
                    </button>
                    <button class="btn btn-success btn-sm" id="secilenleri_hesaba_gecir_main_button"><i
                                class="fa fa-check"></i> Seçilenleri Tahsil Et
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var pos_tahsil_table = "";
        $(document).ready(function () {
            $("#tahsil_edilecek_pos_islemleri").modal("show");
            setTimeout(function () {
                $("#click125").trigger("click");
            }, 500);
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
            pos_tahsil_table = $('#tahsile_verilen_cek_senetler_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "order": [[1, 'asc']],
                columns: [
                    {"data": "sec"},
                    {"data": "taksit"},
                    {"data": "tarih"},
                    {"data": "cari_adi"},
                    {"data": "banka_adi"},
                    {"data": "vade_tarihi"},
                    {"data": "taksit_tutari"},
                    {"data": "aciklama"},
                ],
                createdRow: function (row) {
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(2).css("text-align", "left");
                    $(row).find("td").eq(3).css("text-align", "left");
                    $(row).find("td").eq(4).css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "left");
                },
                "rowCallback": function (row, data) {
                    $(row).attr("pos_cekimid", data.id);
                    $(row).attr("komisyon_orani", data.komisyon_orani);
                    $(row).attr("pos_id", data.pos_id);
                    $(row).attr("cari_id", data.cari_id);
                },
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
            $.get("controller/pos_controller/sql.php?islem=tahsil_edilebilir_pos_islemleri", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    var basilacak_arr = [];
                    json.forEach(function (item) {

                        let tarih = item.kayit_tarih;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let gun = tarih[2];
                        let ay = tarih[1];
                        let yil = tarih[0];
                        let arr = [gun, ay, yil];
                        tarih = arr.join("/");

                        let tahsil_tarihi = item.tahsil_tarihi;
                        tahsil_tarihi = tahsil_tarihi.split(" ");
                        tahsil_tarihi = tahsil_tarihi[0];
                        tahsil_tarihi = tahsil_tarihi.split("-");
                        let gun1 = tahsil_tarihi[2];
                        let ay1 = tahsil_tarihi[1];
                        let yil1 = tahsil_tarihi[0];
                        let arr1 = [gun1, ay1, yil1];
                        tahsil_tarihi = arr1.join("/");

                        let tutar = item.taksit_tutari;
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let newRow = {
                            'sec': "<input type='checkbox' class='col-6 secilen_pos_islemleri' data-id='" + item.id + "'/>",
                            'tarih': tarih,
                            'cari_adi': item.cari_adi,
                            'banka_adi': item.banka_adi,
                            'vade_tarihi': tahsil_tarihi,
                            'taksit': item.taksit,
                            'taksit_tutari': tutar,
                            'aciklama': item.aciklama,
                            'cekim_id': item.cekim_id,
                            'cari_id': item.cari_id,
                            'id': item.id,
                            'pos_id': item.pid,
                            'komisyon_orani': item.komisyon_orani
                        };
                        basilacak_arr.push(newRow);
                    });
                    pos_tahsil_table.rows.add(basilacak_arr).draw(false);
                }
            })
        })

        $("body").off("click", ".secilen_pos_islemleri").on("click", ".secilen_pos_islemleri", function () {
            let closest = $(this).closest("tr");
            if ($(this).prop("checked")) {
                closest.addClass("pos_tahsil_secildi");
            } else {
                closest.removeClass("pos_tahsil_secildi");
            }

        });

        $("body").off("click", "#secilenleri_hesaba_gecir_main_button").on("click", "#secilenleri_hesaba_gecir_main_button", function () {
            var basilacak_arr = [];
            $(".pos_tahsil_secildi").each(function () {

                let pos_cekimid = $(this).attr("pos_cekimid");
                let kesim_tarihi = $(this).find("td").eq(2).text();
                kesim_tarihi = kesim_tarihi.split("/");
                let gun = kesim_tarihi[0];
                let ay = kesim_tarihi[1];
                let yil = kesim_tarihi[2];
                let arr = [yil, ay, gun];
                kesim_tarihi = arr.join("-");

                let cari_id = $(this).attr("cari_id");
                let vade_tarih = $(this).find("td").eq(5).text();
                vade_tarih = vade_tarih.split("/");
                let gun1 = vade_tarih[0];
                let ay1 = vade_tarih[1];
                let yil1 = vade_tarih[2];
                let arr1 = [yil1, ay1, gun1];
                vade_tarih = arr1.join("-");
                let vade_tarih2 = $(this).find("td").eq(5).text();
                var vadeTarihi = new Date(vade_tarih2);
                var simdikiTarih = new Date();
                let tutar = $(this).find("td").eq(6).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let islem_tarihi = $("#islem_tarihi").val();
                let pos_id = $(this).attr("pos_id");
                let komisyon_orani = $(this).attr("komisyon_orani");
                komisyon_orani = parseFloat(komisyon_orani);
                let aciklama = $("#pos_tahsil_aciklama").val();
                // Vade tarihi henüz gelmemişse uyarı veriyoruz
                if (simdikiTarih < vadeTarihi) {
                    let kesilen_komisyon = tutar * (komisyon_orani / 100);
                    kesilen_komisyon = kesilen_komisyon.toFixed(2);
                    let newRow = {
                        'pos_cekimid': pos_cekimid,
                        'kesim_tarih': kesim_tarihi,
                        'cari_id': cari_id,
                        'vade_tarihi': vade_tarih,
                        'tutar': tutar,
                        'pos_id': pos_id,
                        'kesilen_komisyon': kesilen_komisyon,
                        'islem_tarihi': islem_tarihi,
                        'aciklama': aciklama,
                    };
                    basilacak_arr.push(newRow);
                } else {
                    let newRow = {
                        'pos_cekimid': pos_cekimid,
                        'kesim_tarih': kesim_tarihi,
                        'cari_id': cari_id,
                        'vade_tarihi': vade_tarih,
                        'tutar': tutar,
                        'kesilen_komisyon': 0,
                        'pos_id': pos_id,
                        'islem_tarihi': islem_tarihi,
                        'aciklama': aciklama,
                    };
                    basilacak_arr.push(newRow);
                }
            });
            $.ajax({
                url:'controller/pos_controller/sql.php?islem=tahsilleri_kaydet_sql',
                type:"POST",
                data:{
                    arr:basilacak_arr
                },
                success:function (result){
                    if (result == 1){
                        Swal.fire(
                            'Başarılı',
                            'Tahiller Başarı İle Gerçekleşti',
                            'success'
                        );
                        $.get("view/pos_tahsil_main.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/pos_tahsil_main.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#tahsil_edilecek_pos_islemleri").modal("hide");
                    }else {
                        Swal.fire(
                            'Oops..',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                        $("#tahsil_edilecek_pos_islemleri").modal("hide");
                    }
                }
            });
        });

        $("body").off("click", "#tahsil_modal_kapat").on("click", "#tahsil_modal_kapat", function () {
            $("#tahsil_edilecek_pos_islemleri").modal("hide");
        });

    </script>
    <?php
}