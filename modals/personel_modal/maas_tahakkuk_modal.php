<?php

$islem = $_GET["islem"];

if ($islem == "yeni_tahakkuk_ekle_modal") {
    ?>
    <div class="modal fade" id="personel_tahakkuk_olustur_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tahakkuk_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAAŞ TAHAKKUK</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label>İşlem Tarihi</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="islem_tarihi" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control form-control-sm" style="resize: none"
                                                  id="aciklama" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-info btn-sm" id="maas_hesapla"><i class="fa fa-calculator"
                                                                                             aria-hidden="true"></i>
                                        Hesapla
                                    </button>
                                </div>
                                <div class="col-12 mt-5">
                                    <table class="table table-sm table-bordered w-100 display nowrap"
                                           id="hesaplanan_maaslar" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="click_1">Personel Kodu</th>
                                            <th>Adı Soyadı</th>
                                            <th>Açıklama</th>
                                            <th>Tutar</th>
                                        </tr>
                                        </thead>
                                        <tfoot style="background-color: white">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right" class="maaslar_toplami">0,00</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="tahakkuk_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="tahakkuk_onayla"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var table = "";
        $(document).ready(function () {
            setTimeout(function () {
                $("#click_1").trigger("click");
            }, 500);
            $("#personel_tahakkuk_olustur_modal").modal("show");
            table = $('#hesaplanan_maaslar').DataTable({
                scrollX: true,
                scrollY: '25vh',
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).addClass("tum_maaslar")
                },
                searching: false,
                order: [[0, 'desc']],
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
        })

        function getAyBasindakiTarih(tarih) {
            var parts = tarih.split("-");
            var yil = parseInt(parts[0]);
            var ay = parseInt(parts[1]);
            var ayBasindakiTarih = yil + "-" + ("0" + ay).slice(-2) + "-01";
            return ayBasindakiTarih;
        }

        $("body").off("click", "#maas_hesapla").on("click", "#maas_hesapla", function () {
            let aciklama = $("#aciklama").val();
            let islem_tarihi = $("#islem_tarihi").val();
            var now = new Date(); // Şu anki tarihi alır

            var year = now.getFullYear(); // Yılı alır
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Ayı alır ve iki haneli hale getirir

            var baslangic = year + '-' + month + '-01';

            let bas_tarih = new Date(baslangic);
            let bit_tarih = new Date(islem_tarihi);
            let farkMilisaniye = bit_tarih.getTime() - bas_tarih.getTime();
            let farkGun = Math.ceil(farkMilisaniye / (1000 * 60 * 60 * 24));
            var selectedDate = new Date(islem_tarihi);
            var ayin_son_gunumu = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0);
            farkGun = farkGun + 1;
            if (isNaN(farkGun)) {
                farkGun = 0;
            }
            if (farkGun < 0) {
                var gonderilenTarih = new Date(islem_tarihi); // Gönderilen tarih örneği
                var ayBasindakiTarih = new Date(getAyBasindakiTarih(islem_tarihi)); // Ay başındaki tarih örneği

                var farkMilisaniye1 = Math.abs(ayBasindakiTarih - gonderilenTarih);
                farkGun = Math.ceil(farkMilisaniye1 / (1000 * 60 * 60 * 24));
            }
            $.ajax({
                url: "controller/personel_controller/sql.php?islem=personel_maaslarini_getir",
                type: "POST",
                data: {
                    islem_tarihi: islem_tarihi
                },
                success: function (result) {
                    if (result !== 2) {
                        table.clear().draw(false);
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            let ise_baslangic = item.is_basi_tarih1;
                            ise_baslangic = ise_baslangic.split(" ");
                            let bas_tarih = new Date(ise_baslangic[0]);
                            let bit_tarih1 = new Date(islem_tarihi);
                            let farkMilisaniye1 = bit_tarih1.getTime() - bas_tarih.getTime();
                            let farkGun1 = Math.ceil(farkMilisaniye1 / (1000 * 60 * 60 * 24)); // işe başlama tarihinden geçen gün sayısı
                            if (isNaN(farkGun1)) {
                                farkGun1 = 0;
                            }
                            if (item.devamsizlik_suresi > 30) {
                                let devamsizlik_bas = item.devamsizlik_bas;
                                let selectedDate = new Date(devamsizlik_bas);

                                let firstDayOfMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);

// İki tarih arasındaki milisaniye farkını al
                                let timeDifference = selectedDate.getTime() - firstDayOfMonth.getTime();

// Milisaniye farkını gün, saat, dakika, saniye olarak dönüştür
                                let daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                                let hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                let minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                                let secondsDifference = Math.floor((timeDifference % (1000 * 60)) / 1000);

                                let gunluk_ucret = 0;
                                gunluk_ucret = parseFloat(item.gunluk_ucret) * parseFloat(daysDifference);
                                if (isNaN(gunluk_ucret)) {
                                    gunluk_ucret = 0;
                                }
                                gunluk_ucret = gunluk_ucret.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                var new_tab = table.row.add([item.personel_kodu, item.ad_soyad, aciklama, gunluk_ucret]).draw(false).node()
                                $(new_tab).find("td").eq(0).css("text-align", "left");
                                $(new_tab).find("td").eq(1).css("text-align", "left");
                                $(new_tab).find("td").eq(2).css("text-align", "left");
                                $(new_tab).find("td").eq(2).addClass("aciklama_design");
                                $(new_tab).find("td").eq(3).addClass("tutar_design");
                            } else {
                                if (farkGun1 > 30) {
                                    let gelmedigi_gun_ucreti = parseFloat(item.gunluk_ucret) * parseFloat(item.devamsizlik_suresi);
                                    let gunluk_ucret = 0;
                                    if ((selectedDate.getDate() === ayin_son_gunumu.getDate())) {
                                        gunluk_ucret = parseFloat(item.net_maas);
                                    } else {
                                        gunluk_ucret = parseFloat(item.gunluk_ucret) * parseFloat(farkGun);
                                    }
                                    if (isNaN(gelmedigi_gun_ucreti)) {
                                        gelmedigi_gun_ucreti = 0;
                                    }
                                    let hesap = 0;
                                    if (item.personel_status == 1) {
                                        hesap = gunluk_ucret - gelmedigi_gun_ucreti;
                                    } else {
                                        hesap = gunluk_ucret;
                                    }
                                    hesap = hesap.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                    var new_tab2 = table.row.add([item.personel_kodu, item.ad_soyad, aciklama, hesap]).draw(false).node()
                                    $(new_tab2).find("td").eq(0).css("text-align", "left");
                                    $(new_tab2).find("td").eq(1).css("text-align", "left");
                                    $(new_tab2).find("td").eq(2).css("text-align", "left");
                                    $(new_tab2).find("td").eq(2).addClass("aciklama_design");
                                    $(new_tab2).find("td").eq(3).addClass("tutar_design");
                                } else {
                                    // İŞE YENİ BAŞLAYAN PERSONEL İÇİN
                                    let gelmedigi_gun = parseFloat(item.gunluk_ucret) * parseFloat(item.devamsizlik_suresi);
                                    let gunluk = 0;
                                    if ((selectedDate.getDate() === ayin_son_gunumu.getDate()) && (item.devamsizlik_suresi == null || item.devamsizlik_suresi == 0)) {
                                        gunluk = parseFloat(item.net_maas);
                                    } else {
                                        gunluk = parseFloat(item.gunluk_ucret) * parseFloat(farkGun1);
                                    }

                                    if (isNaN(gelmedigi_gun)) {
                                        gelmedigi_gun = 0;
                                    }

                                    var hesap = 0;
                                    if (item.personel_status == 1) {
                                        hesap = gunluk - gelmedigi_gun;
                                    } else {
                                        hesap = gunluk;
                                    }
                                    hesap = hesap.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                    var new_tab2 = table.row.add([item.personel_kodu, item.ad_soyad, aciklama, hesap]).draw(false).node()
                                    $(new_tab2).find("td").eq(0).css("text-align", "left");
                                    $(new_tab2).find("td").eq(1).css("text-align", "left");
                                    $(new_tab2).find("td").eq(2).css("text-align", "left");
                                    $(new_tab2).find("td").eq(2).addClass("aciklama_design");
                                    $(new_tab2).find("td").eq(3).addClass("tutar_design");
                                }
                            }
                        });
                        farkGun = 0;
                    }

                    let toplam_tutar = 0;

                    $(".tum_maaslar").each(function () {
                        let tutar = $(this).find("td").eq(3).text();
                        tutar = tutar.replace(/\./g, "").replace(",", ".");
                        tutar = parseFloat(tutar);
                        if (isNaN(tutar)) {
                            tutar = 0;
                        }

                        toplam_tutar += tutar;
                    });

                    $(".maaslar_toplami").html(toplam_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));

                }
            })
        });

        $("body").off("click", ".aciklama_design").on("click", ".aciklama_design", function () {
            var tds = document.getElementsByClassName('aciklama_design');
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

        $("body").off("click", ".tutar_design").on("click", ".tutar_design", function () {
            var tds = document.getElementsByClassName('tutar_design');
            for (var i = 0; i < tds.length; i++) {
                tds[i].addEventListener('click', function () {
                    var td = this;
                    var oldValue = td.innerHTML;
                    td.innerHTML = '<input type="text" value="' + oldValue + '" />';
                    var input = td.querySelector('input');
                    input.focus();
                    input.addEventListener('blur', function () {
                        let tutar = input.value;
                        tutar = tutar.replace(/\./g, "").replace(",", ".");
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        td.innerHTML = tutar;

                        let toplam_tutar = 0;
                        $(".tum_maaslar").each(function () {
                            let tutar = $(this).find("td").eq(3).text();
                            tutar = tutar.replace(/\./g, "").replace(",", ".");
                            tutar = parseFloat(tutar);
                            if (isNaN(tutar)) {
                                tutar = 0;
                            }

                            toplam_tutar += tutar;
                        });
                        $(".maaslar_toplami").html(toplam_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                    });

                    input.addEventListener('keyup', function (event) {
                        if (event.keyCode === 13) { // Enter tuşuna basıldığında
                            td.innerHTML = input.value;
                        }
                    });
                });
            }
        });

        $("body").off("click", "#tahakkuk_onayla").on("click", "#tahakkuk_onayla", function () {
            let arr = [];
            let islem_tarihi = $("#islem_tarihi").val();
            $(".tum_maaslar").each(function (item) {
                let personel_kodu = $(this).find("td").eq(0).text();
                let tutar = $(this).find("td").eq(3).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let aciklama = $(this).find("td").eq(2).text();
                arr.push({personel_kodu: personel_kodu, tutar: tutar, aciklama: aciklama, islem_tarihi: islem_tarihi})
            })
            $.ajax({
                url: "controller/personel_controller/sql.php?islem=personel_maas_ekle_sql",
                type: "POST",
                data: {
                    arr: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#personel_tahakkuk_olustur_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Maaşlar Hesaplara İşlendi',
                            'success'
                        );
                        $.get("view/maas_tahakkuk.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/maas_tahakkuk.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        $("#personel_tahakkuk_olustur_modal").modal("hide");
                    }
                }
            })
        })

        $("body").off("click", "#tahakkuk_vazgec").on("click", "#tahakkuk_vazgec", function () {
            $("#personel_tahakkuk_olustur_modal").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "tahakkuk_guncelle_modal_getir") {
    ?>
    <div class="modal fade" id="personel_tahakkuk_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tahakkuk_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAAŞ TAHAKKUK</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label>İşlem Tarihi</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" id="islem_tarihi" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-3">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control form-control-sm" style="resize: none"
                                                  id="aciklama" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <table class="table table-sm table-bordered w-100 display nowrap"
                                           id="hesaplanan_maaslar" style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="click_1">Personel Kodu</th>
                                            <th>Adı Soyadı</th>
                                            <th>Açıklama</th>
                                            <th>Tutar</th>
                                        </tr>
                                        </thead>
                                        <tfoot style="background-color: white">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right" class="maaslar_toplami">0,00</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="tahakkuk_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="tahakkuk_guncelle"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var table = "";
        $(document).ready(function () {
            setTimeout(function () {
                $("#click_1").trigger("click");
            }, 500);
            $("#personel_tahakkuk_guncelle_modal").modal("show");
            table = $('#hesaplanan_maaslar').DataTable({
                scrollX: true,
                scrollY: '25vh',
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).addClass("tum_maaslar")
                },
                searching: false,
                order: [[0, 'desc']],
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });

            $.get("controller/personel_controller/sql.php?islem=ana_bilgiler", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#aciklama").val(item.aciklama);
                    let islem_tarihi = item.olusturma_tarihi;
                    if (islem_tarihi != null) {
                        islem_tarihi = islem_tarihi.split(" ");
                    }
                    $("#islem_tarihi").val(islem_tarihi[0]);
                }
            })

            $.get("controller/personel_controller/sql.php?islem=tahakkuklari_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let tutar = item.tutar;
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        var new_tab2 = table.row.add([item.personel_kodu, item.ad_soyad, item.aciklama, tutar]).draw(false).node()
                        $(new_tab2).find("td").eq(0).css("text-align", "left");
                        $(new_tab2).find("td").eq(1).css("text-align", "left");
                        $(new_tab2).find("td").eq(2).css("text-align", "left");
                        $(new_tab2).find("td").eq(2).addClass("aciklama_design");
                        $(new_tab2).find("td").eq(3).addClass("tutar_design");
                        $(new_tab2).attr("data-id", item.id);


                        let toplam_tutar = 0;
                        $(".tum_maaslar").each(function () {
                            let tutar = $(this).find("td").eq(3).text();
                            tutar = tutar.replace(/\./g, "").replace(",", ".");
                            tutar = parseFloat(tutar);
                            if (isNaN(tutar)) {
                                tutar = 0;
                            }

                            toplam_tutar += tutar;
                        });
                        $(".maaslar_toplami").html(toplam_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                    })
                }
            })
        })

        $("body").off("click", ".aciklama_design").on("click", ".aciklama_design", function () {
            var tds = document.getElementsByClassName('aciklama_design');
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

        $("body").off("click", ".tutar_design").on("click", ".tutar_design", function () {
            var tds = document.getElementsByClassName('tutar_design');
            for (var i = 0; i < tds.length; i++) {
                tds[i].addEventListener('click', function () {
                    var td = this;
                    var oldValue = td.innerHTML;
                    td.innerHTML = '<input type="text" value="' + oldValue + '" />';
                    var input = td.querySelector('input');
                    input.focus();
                    input.addEventListener('blur', function () {
                        let tutar = input.value;
                        tutar = tutar.replace(/\./g, "").replace(",", ".");
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        td.innerHTML = tutar;

                        let toplam_tutar = 0;
                        $(".tum_maaslar").each(function () {
                            let tutar = $(this).find("td").eq(3).text();
                            tutar = tutar.replace(/\./g, "").replace(",", ".");
                            tutar = parseFloat(tutar);
                            if (isNaN(tutar)) {
                                tutar = 0;
                            }

                            toplam_tutar += tutar;
                        });
                        $(".maaslar_toplami").html(toplam_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                    });

                    input.addEventListener('keyup', function (event) {
                        if (event.keyCode === 13) { // Enter tuşuna basıldığında
                            td.innerHTML = input.value;
                        }
                    });
                });
            }
        });

        $("body").off("click", "#tahakkuk_guncelle").on("click", "#tahakkuk_guncelle", function () {
            let arr = [];
            let islem_tarihi = $("#islem_tarihi").val();
            $(".tum_maaslar").each(function (item) {
                let personel_kodu = $(this).find("td").eq(0).text();
                let tutar = $(this).find("td").eq(3).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let aciklama = $(this).find("td").eq(2).text();
                let id = $(this).attr("data-id");
                arr.push({
                    personel_kodu: personel_kodu,
                    tutar: tutar,
                    aciklama: aciklama,
                    islem_tarihi: islem_tarihi,
                    id: id
                })
            })
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/personel_controller/sql.php?islem=personel_maas_guncelle_sql",
                type: "POST",
                data: {
                    arr: arr,
                    aciklama: aciklama,
                    islem_tarihi: islem_tarihi,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (result) {
                    if (result == 1) {
                        $("#personel_tahakkuk_guncelle_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Maaşlar Güncellendi',
                            'success'
                        );
                        $.get("view/maas_tahakkuk.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/maas_tahakkuk.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        $("#personel_tahakkuk_guncelle_modal").modal("hide");
                    }
                }
            })
        })

        $("body").off("click", "#tahakkuk_vazgec").on("click", "#tahakkuk_vazgec", function () {
            $("#personel_tahakkuk_guncelle_modal").modal("hide");
        })

    </script>
    <?php
}