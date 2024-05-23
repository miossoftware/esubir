<input type="hidden" value="<?=date("Y-m-01")?>" id="bas_tarih">
<input type="hidden" value="<?=date("Y-m-d")?>" id="bit_tarih">
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="toplam_alacak">0,00</h2>
                    <div class="m-b-5">TOPLAM ALACAK</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="toplam_borc">0,00</h2>
                    <div class="m-b-5">TOPLAM BORÇ</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="musteri_tahsilatlari">0,00</h2>
                    <div class="m-b-5">TAHSİLATLAR</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="">0,00</h2>
                    <div class="m-b-5">CARİ ÖDEMELER</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $.get("controller/ekstre_controller/sql.php?islem=cari_borc_alacak_durumu_filtrele",
        {
            bas_tarih: $("#bas_tarih").val(),
            bit_tarih: $("#bit_tarih").val()
        }
        , function (result) {
            if (result != 2) {
                let toplam_borc = 0;
                let toplam_alacak = 0;
                var json = JSON.parse(result);
                let arr = [];
                json.forEach(function (item) {
                    let borc = item.borc;
                    borc = parseFloat(borc);
                    let alacak = item.alacak;
                    alacak = parseFloat(alacak)
                    let bakiye = parseFloat(borc) - parseFloat(alacak);
                    if (isNaN(bakiye)) {
                        bakiye = 0;
                    }
                    if (isNaN(borc)) {
                        borc = 0;
                    }
                    if (isNaN(alacak)) {
                        alacak = 0;
                    }
                    let b_durum = "";
                    if (bakiye > 0) {
                        b_durum = "B";
                    } else if (bakiye < 0) {
                        b_durum = "A";
                        bakiye = -bakiye
                    } else {
                        b_durum = "YOK";
                    }
                    if (bakiye == 0) {

                    } else {
                        toplam_borc += borc;
                        toplam_alacak += alacak;
                        borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        alacak = alacak.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        bakiye = bakiye.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        var newRecord = {
                            cari_kodu: item.cari_kodu,
                            cari_unvan: item.cari_unvan,
                            bilanco_kodu: item.bilanco_kodu,
                            cari_grubu: item.cari_grubu,
                            borc: borc,
                            alacak: alacak,
                            bakiye: bakiye,
                            b_durum: b_durum
                        };
                        arr.push(newRecord);
                    }
                })
                let b_durum = "";
                let bakiye = toplam_alacak - toplam_borc;
                if (bakiye < 0){
                    bakiye = -bakiye
                    b_durum = "B";
                }else {
                    b_durum = "A";
                }

                bakiye = bakiye.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                toplam_borc = toplam_borc.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                $("#toplam_alacak").html(toplam_alacak);
                $("#toplam_borc").html(toplam_borc);
            }
        });

    $.get("konteyner/controller/siparis_controller/sql.php?islem=toplam_siparis_getir_sql", function (res) {
        if (res != 2) {
            let item = JSON.parse(res);
            // BURADA TOPLAM SİPARİŞLER HAFTALIK ÖDENECEK ÇEKLER VS. GİBİ BİLGİLER ÇEKİLİYOR
            $("#siparis_sayisi").html(item.siparis_sayisi);
            $("#odenecek_cekler").html(item.haftalik_odenecek_cek);
            $("#kk_odeme_haftalik").html(item.kk_odeme_haftalik);
            $("#musteri_tahsilatlari").html(item.toplam_musteri_tahsilatlari);
        }
    })
</script>