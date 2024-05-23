<style>
    table {
        border-collapse: collapse; /* Tablo hücreleri arasındaki boşluğu kaldırır */
        width: 100%; /* Tabloyu tam ekran genişliğinde yapar (isteğe bağlı) */
    }


    th, td {
        padding: 8px; /* Hücre içeriğinin çerçeveye olan uzaklığını ayarlar (isteğe bağlı) */
        text-align: left; /* Hücre içeriğini ortalar (isteğe bağlı) */
    }

    th {
        background-color: #f2f2f2; /* Başlık hücrelerine arka plan rengi ekler (isteğe bağlı) */
    }

    tr {
        padding: 8px; /* Hücre içeriğinin çerçeveye olan uzaklığını ayarlar (isteğe bağlı) */
    }

</style>
<div class="ibox-container">
    <div class="cari_getir_div_ekstre"></div>
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>KAR ZARAR RAPORU</div>
        </div>
        <div class="col-12 row no-gutters mt-3">
            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-01") ?>"
                       class="form-control form-control-sm" id="bas_tarih">
            </div>
            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-t") ?>"
                       class="form-control form-control-sm" id="bit_tarih">
            </div>
            <div class="col-1 mx-3">
                <button class="btn btn-secondary btn-sm" id="kar_zarar_rapor_filter"><i class="fa fa-filter"></i>
                    Hazırla
                </button>
            </div>
            <div class="col-12 row mt-5">
                <div class="col-md-5">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link active"
                           aria-current="page"
                           id="">GELİRLER</a>
                    </nav>
                    <div class="col-12" style="padding-right: 0px !important;padding-left: 3px !important;">
                        <div class="col-12" style="padding: 0%">

                            <table class="table table-sm my_table2">
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">ÖZ MAL SATIŞ
                                        GELİRİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="ciro2"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Öz Mal Satış Toplamı</td>
                                    <td style="text-align: right" id="ciro">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">Kiralık
                                        Satış Gelirleri
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="kiralik_satis_geliri"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Kiralık Satış Toplamı</td>
                                    <td style="text-align: right" id="kiralik_satis"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Kiralık Alış Toplamı</td>
                                    <td style="text-align: right" id="kiralik_alis">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">DEPO HİZMET GELİRLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="total_depo_kazanc">0,00₺
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">EK HİZMET GELİRLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="total_ek_kazanc"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-center nav-link active"
                               aria-current="page"
                               id="">GİDERLER</a>
                        </nav>
                        <div class="col-12" style="padding: 0%">
                            <table class="table table-sm my_table">
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">MOTORİN</td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65;color: white;text-align: right"
                                        id="motorin_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Öz Mal Alış</td>
                                    <td style="text-align: right" id="oz_mal_motorin"></td>
                                    <td></td>
                                </tr>
<!--                                <tr>-->
<!--                                    <td style="text-align: left">Kiralık Alış</td>-->
<!--                                    <td style="text-align: right" id="kiralik_motorin">13.000.000,00 ₺</td>-->
<!--                                </tr>-->
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">Diğer
                                        Giderler
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="nakliye_zararlari_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Nakliye Zararları</td>
                                    <td style="text-align: right" id="nakliye_zararlari">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">PERSONEL
                                        MAAŞLARI
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="personel_maas_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Personel Maaşları</td>
                                    <td style="text-align: right" id="personel_maas">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">FAALİYET GİDERLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="faaliyet_total"></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">SANAYİ
                                        GİDERLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="sanayi_giderler_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Lastik</td>
                                    <td style="text-align: right" id="lastik_giderleri"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Akü</td>
                                    <td style="text-align: right" id="aku_faturalari">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Diğer</td>
                                    <td style="text-align: right" id="diger_sanayi">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">ARAÇ
                                        GİDERLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="arac_gider_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">HGS Giderleri</td>
                                    <td style="text-align: right" id="hgs_gider2"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">SGK Giderleri</td>
                                    <td style="text-align: right" id="sgk_toplam">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Vergi Ödemeleri</td>
                                    <td style="text-align: right" id="vergi_gider">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Yönetim Giderleri</td>
                                    <td style="text-align: right" id="yonetim_gider">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Araç Giderleri</td>
                                    <td style="text-align: right" id="arac_giderleri">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Kaza-Ceza Giderleri</td>
                                    <td style="text-align: right" id="kaza_ceza_giderleri">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">ÖDENEN
                                        PRİM
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="prim_tutari_total"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">Ödenen Prim</td>
                                    <td style="text-align: right" id="prim_tutari">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65 ">TAŞIT
                                        GİDERLERİ
                                    </td>
                                    <td style="background-color: #9DB2BF"></td>
                                    <td style="background-color: #374f65; color: white;text-align: right"
                                        id="tasit_gider_tot"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">YAKIT GİDERLERİ</td>
                                    <td style="text-align: right" id="binek_yakit">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">BAKIM GİDERLERİ</td>
                                    <td style="text-align: right" id="binek_bakim_toplam">13.000.000,00 ₺</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left">MTV V.S. GİDERLERİ</td>
                                    <td style="text-align: right" id="binek_mtv_vs">13.000.000,00 ₺</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="padding: 0%">
                    <div class="custom-navbar">
                        <nav class="nav nav-pills flex-column flex-sm-row ">
                            <div class="col-12 row no-gutters" style="padding: 0%">
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-left nav-link active"
                                       style="font-weight: bold;background-color: #9DB2BF;color: #374f65"
                                       aria-current="page"
                                       id="">TOPLAM GELİRLER</a>
                                </div>
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-right nav-link active"
                                       aria-current="page"
                                       id="toplam_gelirler">13.000.000,00 ₺</a>
                                </div>
                            </div>
                        </nav>
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <div class="col-12 row no-gutters" style="padding: 0%">
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-left nav-link active"
                                       style="font-weight: bold;background-color: #9DB2BF;color: #374f65"
                                       aria-current="page"
                                       id="">TOPLAM GİDERLER</a>
                                </div>
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-right nav-link active"
                                       aria-current="page"
                                       id="toplam_giderler">13.000.000,00 ₺</a>
                                </div>
                            </div>
                        </nav>
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <div class="col-12 row no-gutters" style="padding: 0%">
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-left nav-link active"
                                       style="font-weight: bold;background-color: #9DB2BF;color: #374f65"
                                       aria-current="page"
                                       id="">KAR / ZARAR</a>
                                </div>
                                <div class="col-6">
                                    <a class="flex-sm-fill text-sm-right nav-link active"
                                       aria-current="page"
                                       id="kar_zarar_toplami">13.000.000,00 ₺</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.get("controller/rapor_controller/sql.php?islem=kar_zarar_raporlarini_getir_sql", function (res) {
            if (res != 2) {
                var item = JSON.parse(res);

                let oz_mal_motorin = item.ozmal_motorin;
                oz_mal_motorin = parseFloat(oz_mal_motorin);
                if (isNaN(oz_mal_motorin)) {
                    oz_mal_motorin = 0;
                }
                oz_mal_motorin = oz_mal_motorin.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kiralik_motorin = item.kiralik_motorin;
                kiralik_motorin = parseFloat(kiralik_motorin);
                if (isNaN(kiralik_motorin)) {
                    kiralik_motorin = 0;
                }
                kiralik_motorin = kiralik_motorin.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let prim_tutari = item.prim_tutari;
                prim_tutari = parseFloat(prim_tutari);
                if (isNaN(prim_tutari)) {
                    prim_tutari = 0;
                }
                prim_tutari = prim_tutari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let personel_maas = item.personel_maas;
                personel_maas = parseFloat(personel_maas);
                if (isNaN(personel_maas)) {
                    personel_maas = 0;
                }
                personel_maas = personel_maas.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let hgs_gider = item.hgs_gider;
                hgs_gider = parseFloat(hgs_gider);
                if (isNaN(hgs_gider)) {
                    hgs_gider = 0;
                }
                hgs_gider = hgs_gider.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let lastik_giderleri = item.lastik_giderleri;
                lastik_giderleri = parseFloat(lastik_giderleri);
                if (isNaN(lastik_giderleri)) {
                    lastik_giderleri = 0;
                }
                lastik_giderleri = lastik_giderleri.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let aku_faturalari = item.aku_faturalari;
                aku_faturalari = parseFloat(aku_faturalari);
                if (isNaN(aku_faturalari)) {
                    aku_faturalari = 0;
                }
                aku_faturalari = aku_faturalari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let diger_sanayi = item.diger_sanayi;
                diger_sanayi = parseFloat(diger_sanayi);
                if (isNaN(diger_sanayi)) {
                    diger_sanayi = 0;
                }
                diger_sanayi = diger_sanayi.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let sgk_toplam = item.sgk_toplam;
                sgk_toplam = parseFloat(sgk_toplam);
                if (isNaN(sgk_toplam)) {
                    sgk_toplam = 0;
                }
                sgk_toplam = sgk_toplam.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let vergi_gider = item.vergi_gider;
                vergi_gider = parseFloat(vergi_gider);
                if (isNaN(vergi_gider)) {
                    vergi_gider = 0;
                }
                vergi_gider = vergi_gider.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let yonetim_gider = item.yonetim_gider;
                yonetim_gider = parseFloat(yonetim_gider);
                if (isNaN(yonetim_gider)) {
                    yonetim_gider = 0;
                }
                yonetim_gider = yonetim_gider.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let arac_giderleri = item.arac_giderleri;
                arac_giderleri = parseFloat(arac_giderleri);
                if (isNaN(arac_giderleri)) {
                    arac_giderleri = 0;
                }
                arac_giderleri = arac_giderleri.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kaza_ceza_giderleri = item.kaza_ceza_giderleri;
                kaza_ceza_giderleri = parseFloat(kaza_ceza_giderleri);
                if (isNaN(kaza_ceza_giderleri)) {
                    kaza_ceza_giderleri = 0;
                }
                kaza_ceza_giderleri = kaza_ceza_giderleri.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let genel_giderler = item.genel_giderler;
                genel_giderler = parseFloat(genel_giderler);
                if (isNaN(genel_giderler)) {
                    genel_giderler = 0;
                }
                genel_giderler = genel_giderler.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let lhb_toplam = item.lhb_toplam;
                lhb_toplam = parseFloat(lhb_toplam);
                if (isNaN(lhb_toplam)) {
                    lhb_toplam = 0;
                }
                lhb_toplam = lhb_toplam.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let nakliye_zararlari = item.nakliye_zararlari;
                nakliye_zararlari = parseFloat(nakliye_zararlari);
                if (isNaN(nakliye_zararlari)) {
                    nakliye_zararlari = 0;
                }
                nakliye_zararlari = nakliye_zararlari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let ciro = item.ciro;
                ciro = parseFloat(ciro);
                if (isNaN(ciro)) {
                    ciro = 0;
                }
                ciro = ciro.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kiralik_alis = item.kiralik_alis;
                kiralik_alis = parseFloat(kiralik_alis);
                if (isNaN(kiralik_alis)) {
                    kiralik_alis = 0;
                }
                kiralik_alis = kiralik_alis.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kiralik_satis = item.kiralik_satis;
                kiralik_satis = parseFloat(kiralik_satis);
                if (isNaN(kiralik_satis)) {
                    kiralik_satis = 0;
                }
                kiralik_satis = kiralik_satis.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let motorin_total = item.motorin_total;
                motorin_total = parseFloat(motorin_total);
                if (isNaN(motorin_total)) {
                    motorin_total = 0;
                }
                motorin_total = motorin_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let sanayi_giderler_total = item.sanayi_giderler_total;
                sanayi_giderler_total = parseFloat(sanayi_giderler_total);
                if (isNaN(sanayi_giderler_total)) {
                    sanayi_giderler_total = 0;
                }
                sanayi_giderler_total = sanayi_giderler_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let arac_gider_total = item.arac_gider_total;
                arac_gider_total = parseFloat(arac_gider_total);
                if (isNaN(arac_gider_total)) {
                    arac_gider_total = 0;
                }
                arac_gider_total = arac_gider_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let faaliyet_total = item.faaliyet_total;
                faaliyet_total = parseFloat(faaliyet_total);
                if (isNaN(faaliyet_total)) {
                    faaliyet_total = 0;
                }
                faaliyet_total = faaliyet_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let toplam_giderler = item.toplam_giderler;
                toplam_giderler = parseFloat(toplam_giderler);
                if (isNaN(toplam_giderler)) {
                    toplam_giderler = 0;
                }
                toplam_giderler = toplam_giderler.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kiralik_satis_geliri = item.kiralik_satis_geliri;
                kiralik_satis_geliri = parseFloat(kiralik_satis_geliri);
                if (isNaN(kiralik_satis_geliri)) {
                    kiralik_satis_geliri = 0;
                }
                kiralik_satis_geliri = kiralik_satis_geliri.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let binek_yakit = item.binek_yakit;
                binek_yakit = parseFloat(binek_yakit);
                if (isNaN(binek_yakit)) {
                    binek_yakit = 0;
                }
                binek_yakit = binek_yakit.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
                let binek_bakim_toplam = item.binek_bakim_toplam;
                binek_bakim_toplam = parseFloat(binek_bakim_toplam);
                if (isNaN(binek_bakim_toplam)) {
                    binek_bakim_toplam = 0;
                }
                binek_bakim_toplam = binek_bakim_toplam.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let toplam_gelirler = item.toplam_gelirler;
                toplam_gelirler = parseFloat(toplam_gelirler);
                if (isNaN(toplam_gelirler)) {
                    toplam_gelirler = 0;
                }
                toplam_gelirler = toplam_gelirler.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let binek_mtv_vs = item.binek_mtv_vs;
                binek_mtv_vs = parseFloat(binek_mtv_vs);
                if (isNaN(binek_mtv_vs)) {
                    binek_mtv_vs = 0;
                }
                binek_mtv_vs = binek_mtv_vs.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let kar_zarar_toplami = item.kar_zarar_toplami;
                kar_zarar_toplami = parseFloat(kar_zarar_toplami);
                if (isNaN(kar_zarar_toplami)) {
                    kar_zarar_toplami = 0;
                }
                kar_zarar_toplami = kar_zarar_toplami.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let tasit_gider_tot = item.tasit_gider_tot;
                tasit_gider_tot = parseFloat(tasit_gider_tot);
                if (isNaN(tasit_gider_tot)) {
                    tasit_gider_tot = 0;
                }
                tasit_gider_tot = tasit_gider_tot.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                let total_ek_kazanc = item.total_ek_kazanc;
                total_ek_kazanc = parseFloat(total_ek_kazanc);
                if (isNaN(total_ek_kazanc)) {
                    total_ek_kazanc = 0;
                }
                total_ek_kazanc = total_ek_kazanc.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });

                item["faaliyet_giderleri"].forEach(function (item2) {
                    let newrow = '' +
                        '<tr class="yeni_eklenen">' +
                        '<td style="text-align: left">' + item2.cari_unvan + '</td>' +
                        '<td style="text-align: right">' + item2.bakiye + ' ₺</td>' +
                        '<td></td>' +
                        '</tr>';

                    $('.my_table tbody tr').has('td:contains("FAALİYET GİDERLERİ")').nextAll().first().before(newrow);

                })

                item["ek_hizmet_arr"].forEach(function (item3) {
                    let newrow = '' +
                        '<tr class="yeni_eklenen">' +
                        '<td style="text-align: left">' + item3.stok_adi + '</td>' +
                        '<td style="text-align: right">' + item3.kazanc + ' ₺</td>' +
                        '<td></td>' +
                        '</tr>';

                    $('.my_table2 tbody tr').has('td:contains("EK HİZMET GELİRLERİ")').nextAll().first().before(newrow);
                })
                item["depo_arr"].forEach(function (item3) {
                    let newrow = '' +
                        '<tr class="yeni_eklenen">' +
                        '<td style="text-align: left">' + item3.stock_name + '</td>' +
                        '<td style="text-align: right">' + item3.net_kazanc + ' ₺</td>' +
                        '<td></td>' +
                        '</tr>';

                    $('.my_table2 tbody tr').has('td:contains("DEPO HİZMET GELİRLERİ")').nextAll().first().before(newrow);
                });
                let toplam_depo_geliri = item.toplam_depo_geliri;
                toplam_depo_geliri = parseFloat(toplam_depo_geliri);
                $("#oz_mal_motorin").html(oz_mal_motorin + " ₺");
                $("#kiralik_motorin").html(kiralik_motorin + " ₺");
                $("#prim_tutari").html(prim_tutari + " ₺");
                $("#prim_tutari_total").html(prim_tutari + " ₺");
                $("#personel_maas").html(personel_maas + " ₺");
                $("#personel_maas_total").html(personel_maas + " ₺");
                $("#hgs_gider").html(hgs_gider + " ₺");
                $("#hgs_gider_total").html(hgs_gider + " ₺");
                $("#hgs_gider2").html(hgs_gider + " ₺");
                $("#lastik_giderleri").html(lastik_giderleri + " ₺");
                $("#aku_faturalari").html(aku_faturalari + " ₺");
                $("#diger_sanayi").html(diger_sanayi + " ₺");
                $("#sgk_toplam").html(sgk_toplam + " ₺");
                $("#vergi_gider").html(vergi_gider + " ₺");
                $("#yonetim_gider").html(yonetim_gider + " ₺");
                $("#arac_giderleri").html(arac_giderleri + " ₺");
                $("#kaza_ceza_giderleri").html(kaza_ceza_giderleri + " ₺");
                $("#nakliye_zararlari").html(nakliye_zararlari + " ₺");
                $("#nakliye_zararlari_total").html(nakliye_zararlari + " ₺");
                $("#toplam_giderler").html(toplam_giderler + " ₺");
                $("#ciro").html(ciro + " ₺");
                $("#ciro2").html(ciro + " ₺");
                $("#kiralik_alis").html(kiralik_alis + " ₺");
                $("#kiralik_satis").html(kiralik_satis + " ₺");
                $("#motorin_total").html(motorin_total + " ₺");
                $("#sanayi_giderler_total").html(sanayi_giderler_total + " ₺");
                $("#arac_gider_total").html(arac_gider_total + " ₺");
                $("#faaliyet_total").html(faaliyet_total + " ₺");
                $("#kiralik_satis_geliri").html(kiralik_satis_geliri + " ₺");
                $("#toplam_gelirler").html(toplam_gelirler + " ₺");
                $("#binek_yakit").html(binek_yakit + " ₺");
                $("#kar_zarar_toplami").html(kar_zarar_toplami + " ₺");
                $("#binek_bakim_toplam").html(binek_bakim_toplam + " ₺");
                $("#binek_mtv_vs").html(binek_mtv_vs + " ₺");
                $("#tasit_gider_tot").html(tasit_gider_tot + " ₺");
                $("#total_ek_kazanc").html(total_ek_kazanc + " ₺");
                $("#total_depo_kazanc").html(toplam_depo_geliri.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " ₺");

            }
        })

        $("body").off("click", "#kar_zarar_rapor_filter").on("click", "#kar_zarar_rapor_filter", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();

            $.get("controller/rapor_controller/sql.php?islem=kar_zarar_raporlarini_getir_sql", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);

                    let oz_mal_motorin = item.ozmal_motorin;
                    oz_mal_motorin = parseFloat(oz_mal_motorin);
                    if (isNaN(oz_mal_motorin)) {
                        oz_mal_motorin = 0;
                    }
                    oz_mal_motorin = oz_mal_motorin.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kiralik_motorin = item.kiralik_motorin;
                    kiralik_motorin = parseFloat(kiralik_motorin);
                    if (isNaN(kiralik_motorin)) {
                        kiralik_motorin = 0;
                    }
                    kiralik_motorin = kiralik_motorin.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let prim_tutari = item.prim_tutari;
                    prim_tutari = parseFloat(prim_tutari);
                    if (isNaN(prim_tutari)) {
                        prim_tutari = 0;
                    }
                    prim_tutari = prim_tutari.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let personel_maas = item.personel_maas;
                    personel_maas = parseFloat(personel_maas);
                    if (isNaN(personel_maas)) {
                        personel_maas = 0;
                    }
                    personel_maas = personel_maas.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let hgs_gider = item.hgs_gider;
                    hgs_gider = parseFloat(hgs_gider);
                    if (isNaN(hgs_gider)) {
                        hgs_gider = 0;
                    }
                    hgs_gider = hgs_gider.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let lastik_giderleri = item.lastik_giderleri;
                    lastik_giderleri = parseFloat(lastik_giderleri);
                    if (isNaN(lastik_giderleri)) {
                        lastik_giderleri = 0;
                    }
                    lastik_giderleri = lastik_giderleri.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let aku_faturalari = item.aku_faturalari;
                    aku_faturalari = parseFloat(aku_faturalari);
                    if (isNaN(aku_faturalari)) {
                        aku_faturalari = 0;
                    }
                    aku_faturalari = aku_faturalari.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let diger_sanayi = item.diger_sanayi;
                    diger_sanayi = parseFloat(diger_sanayi);
                    if (isNaN(diger_sanayi)) {
                        diger_sanayi = 0;
                    }
                    diger_sanayi = diger_sanayi.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let sgk_toplam = item.sgk_toplam;
                    sgk_toplam = parseFloat(sgk_toplam);
                    if (isNaN(sgk_toplam)) {
                        sgk_toplam = 0;
                    }
                    sgk_toplam = sgk_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let vergi_gider = item.vergi_gider;
                    vergi_gider = parseFloat(vergi_gider);
                    if (isNaN(vergi_gider)) {
                        vergi_gider = 0;
                    }
                    vergi_gider = vergi_gider.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let yonetim_gider = item.yonetim_gider;
                    yonetim_gider = parseFloat(yonetim_gider);
                    if (isNaN(yonetim_gider)) {
                        yonetim_gider = 0;
                    }
                    yonetim_gider = yonetim_gider.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let arac_giderleri = item.arac_giderleri;
                    arac_giderleri = parseFloat(arac_giderleri);
                    if (isNaN(arac_giderleri)) {
                        arac_giderleri = 0;
                    }
                    arac_giderleri = arac_giderleri.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kaza_ceza_giderleri = item.kaza_ceza_giderleri;
                    kaza_ceza_giderleri = parseFloat(kaza_ceza_giderleri);
                    if (isNaN(kaza_ceza_giderleri)) {
                        kaza_ceza_giderleri = 0;
                    }
                    kaza_ceza_giderleri = kaza_ceza_giderleri.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let genel_giderler = item.genel_giderler;
                    genel_giderler = parseFloat(genel_giderler);
                    if (isNaN(genel_giderler)) {
                        genel_giderler = 0;
                    }
                    genel_giderler = genel_giderler.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let lhb_toplam = item.lhb_toplam;
                    lhb_toplam = parseFloat(lhb_toplam);
                    if (isNaN(lhb_toplam)) {
                        lhb_toplam = 0;
                    }
                    lhb_toplam = lhb_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let nakliye_zararlari = item.nakliye_zararlari;
                    nakliye_zararlari = parseFloat(nakliye_zararlari);
                    if (isNaN(nakliye_zararlari)) {
                        nakliye_zararlari = 0;
                    }
                    nakliye_zararlari = nakliye_zararlari.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let ciro = item.ciro;
                    ciro = parseFloat(ciro);
                    if (isNaN(ciro)) {
                        ciro = 0;
                    }
                    ciro = ciro.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kiralik_alis = item.kiralik_alis;
                    kiralik_alis = parseFloat(kiralik_alis);
                    if (isNaN(kiralik_alis)) {
                        kiralik_alis = 0;
                    }
                    kiralik_alis = kiralik_alis.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kiralik_satis = item.kiralik_satis;
                    kiralik_satis = parseFloat(kiralik_satis);
                    if (isNaN(kiralik_satis)) {
                        kiralik_satis = 0;
                    }
                    kiralik_satis = kiralik_satis.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let motorin_total = item.motorin_total;
                    motorin_total = parseFloat(motorin_total);
                    if (isNaN(motorin_total)) {
                        motorin_total = 0;
                    }
                    motorin_total = motorin_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let sanayi_giderler_total = item.sanayi_giderler_total;
                    sanayi_giderler_total = parseFloat(sanayi_giderler_total);
                    if (isNaN(sanayi_giderler_total)) {
                        sanayi_giderler_total = 0;
                    }
                    sanayi_giderler_total = sanayi_giderler_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let arac_gider_total = item.arac_gider_total;
                    arac_gider_total = parseFloat(arac_gider_total);
                    if (isNaN(arac_gider_total)) {
                        arac_gider_total = 0;
                    }
                    arac_gider_total = arac_gider_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let faaliyet_total = item.faaliyet_total;
                    faaliyet_total = parseFloat(faaliyet_total);
                    if (isNaN(faaliyet_total)) {
                        faaliyet_total = 0;
                    }
                    faaliyet_total = faaliyet_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let toplam_giderler = item.toplam_giderler;
                    toplam_giderler = parseFloat(toplam_giderler);
                    if (isNaN(toplam_giderler)) {
                        toplam_giderler = 0;
                    }
                    toplam_giderler = toplam_giderler.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kiralik_satis_geliri = item.kiralik_satis_geliri;
                    kiralik_satis_geliri = parseFloat(kiralik_satis_geliri);
                    if (isNaN(kiralik_satis_geliri)) {
                        kiralik_satis_geliri = 0;
                    }
                    kiralik_satis_geliri = kiralik_satis_geliri.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let toplam_gelirler = item.toplam_gelirler;
                    toplam_gelirler = parseFloat(toplam_gelirler);
                    if (isNaN(toplam_gelirler)) {
                        toplam_gelirler = 0;
                    }
                    toplam_gelirler = toplam_gelirler.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kar_zarar_toplami = item.kar_zarar_toplami;
                    kar_zarar_toplami = parseFloat(kar_zarar_toplami);
                    if (isNaN(kar_zarar_toplami)) {
                        kar_zarar_toplami = 0;
                    }
                    kar_zarar_toplami = kar_zarar_toplami.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let binek_bakim_toplam = item.binek_bakim_toplam;
                    binek_bakim_toplam = parseFloat(binek_bakim_toplam);
                    if (isNaN(binek_bakim_toplam)) {
                        binek_bakim_toplam = 0;
                    }
                    binek_bakim_toplam = binek_bakim_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let binek_yakit = item.binek_yakit;
                    binek_yakit = parseFloat(binek_yakit);
                    if (isNaN(binek_yakit)) {
                        binek_yakit = 0;
                    }
                    binek_yakit = binek_yakit.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let binek_mtv_vs = item.binek_mtv_vs;
                    binek_mtv_vs = parseFloat(binek_mtv_vs);
                    if (isNaN(binek_mtv_vs)) {
                        binek_mtv_vs = 0;
                    }
                    binek_mtv_vs = binek_mtv_vs.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let tasit_gider_tot = item.tasit_gider_tot;
                    tasit_gider_tot = parseFloat(tasit_gider_tot);
                    if (isNaN(tasit_gider_tot)) {
                        tasit_gider_tot = 0;
                    }
                    tasit_gider_tot = tasit_gider_tot.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let total_ek_kazanc = item.total_ek_kazanc;
                    total_ek_kazanc = parseFloat(total_ek_kazanc);
                    if (isNaN(total_ek_kazanc)) {
                        total_ek_kazanc = 0;
                    }
                    total_ek_kazanc = total_ek_kazanc.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    $(".yeni_eklenen").html("");
                    item["faaliyet_giderleri"].forEach(function (item2) {
                        let newrow = '' +
                            '<tr class="yeni_eklenen">' +
                            '<td style="text-align: left">' + item2.cari_unvan + '</td>' +
                            '<td style="text-align: right">' + item2.bakiye + ' ₺</td>' +
                            '<td></td>' +
                            '</tr>';

                        $('.my_table tbody tr').has('td:contains("FAALİYET GİDERLERİ")').nextAll().first().before(newrow);
                    })
                    item["ek_hizmet_arr"].forEach(function (item3) {
                        let newrow = '' +
                            '<tr class="yeni_eklenen">' +
                            '<td style="text-align: left">' + item3.stok_adi + '</td>' +
                            '<td style="text-align: right">' + item3.kazanc + ' ₺</td>' +
                            '<td></td>' +
                            '</tr>';

                        $('.my_table2').append(newrow);
                    })

                    item["depo_arr"].forEach(function (item3) {
                        let newrow = '' +
                            '<tr class="yeni_eklenen">' +
                            '<td style="text-align: left">' + item3.stock_name + '</td>' +
                            '<td style="text-align: right">' + item3.net_kazanc + ' ₺</td>' +
                            '<td></td>' +
                            '</tr>';

                        $('.my_table2 tbody tr').has('td:contains("DEPO HİZMET GELİRLERİ")').nextAll().first().before(newrow);
                    });
                    let toplam_depo_geliri = item.toplam_depo_geliri;
                    toplam_depo_geliri = parseFloat(toplam_depo_geliri);
                    $("#oz_mal_motorin").html(oz_mal_motorin + " ₺");
                    $("#kiralik_motorin").html(kiralik_motorin + " ₺");
                    $("#prim_tutari").html(prim_tutari + " ₺");
                    $("#prim_tutari_total").html(prim_tutari + " ₺");
                    $("#personel_maas").html(personel_maas + " ₺");
                    $("#personel_maas_total").html(personel_maas + " ₺");
                    $("#hgs_gider").html(hgs_gider + " ₺");
                    $("#hgs_gider_total").html(hgs_gider + " ₺");
                    $("#hgs_gider2").html(hgs_gider + " ₺");
                    $("#lastik_giderleri").html(lastik_giderleri + " ₺");
                    $("#aku_faturalari").html(aku_faturalari + " ₺");
                    $("#diger_sanayi").html(diger_sanayi + " ₺");
                    $("#sgk_toplam").html(sgk_toplam + " ₺");
                    $("#vergi_gider").html(vergi_gider + " ₺");
                    $("#yonetim_gider").html(yonetim_gider + " ₺");
                    $("#arac_giderleri").html(arac_giderleri + " ₺");
                    $("#kaza_ceza_giderleri").html(kaza_ceza_giderleri + " ₺");
                    $("#nakliye_zararlari").html(nakliye_zararlari + " ₺");
                    $("#nakliye_zararlari_total").html(nakliye_zararlari + " ₺");
                    $("#toplam_giderler").html(toplam_giderler + " ₺");
                    $("#ciro").html(ciro + " ₺");
                    $("#ciro2").html(ciro + " ₺");
                    $("#kiralik_alis").html(kiralik_alis + " ₺");
                    $("#kiralik_satis").html(kiralik_satis + " ₺");
                    $("#motorin_total").html(motorin_total + " ₺");
                    $("#sanayi_giderler_total").html(sanayi_giderler_total + " ₺");
                    $("#arac_gider_total").html(arac_gider_total + " ₺");
                    $("#faaliyet_total").html(faaliyet_total + " ₺");
                    $("#kiralik_satis_geliri").html(kiralik_satis_geliri + " ₺");
                    $("#toplam_gelirler").html(toplam_gelirler + " ₺");
                    $("#binek_yakit").html(binek_yakit + " ₺");
                    $("#kar_zarar_toplami").html(kar_zarar_toplami + " ₺");
                    $("#binek_bakim_toplam").html(binek_bakim_toplam + " ₺");
                    $("#binek_mtv_vs").html(binek_mtv_vs + " ₺");
                    $("#tasit_gider_tot").html(tasit_gider_tot + " ₺");
                    $("#total_ek_kazanc").html(total_ek_kazanc + " ₺");
                    $("#total_depo_kazanc").html(toplam_depo_geliri.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " ₺");
                }
            })
        });
    });
</script>