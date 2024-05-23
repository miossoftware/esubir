<style>
    #oz_mal_kiralik {
        width: 100% !important;
        height: 95% !important;
    }
</style>
<div class="page-wrapper">
    <!-- START HEADER-->
    <header class="header" style="background-color: #374f65">
        <div class="page-brand">
        </div>
        <div class="flexbox flex-1">
            <!-- START TOP-LEFT TOOLBAR-->
            <ul class="nav navbar-toolbar" style="color: white">
                <li>
                    <a class="nav-link sidebar-toggler js-sidebar-toggler" style="color: white"><i class="ti-menu"></i></a>
                </li>
            </ul>
            <ul class="nav navbar-toolbar">
                <li class="dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                        <img src="./assets/img/admin-avatar4.png"/>
                        <span style="color: white"><?= $_SESSION["name_surname"] ?><i
                                    class="fa fa-angle-down m-l-5"></i></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href=""><i class="fa fa-user"></i>Hesabım</a>
                        <a class="dropdown-item" href=""><i class="fa fa-cog"></i>Ayarlar</a>
                        <a class="dropdown-item" href=""><i class="fa fa-support"></i>Destek</a>
                        <li class="dropdown-divider"></li>
                        <a class="dropdown-item" style="cursor: pointer" id="cikis_yap"><i class="fa fa-power-off"></i>Çıkış
                            Yap</a>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    <!-- END HEADER-->
    <!-- START SIDEBAR-->
    <nav class="page-sidebar" id="sidebar">
        <div id="sidebar-collapse">
            <div class="admin-block d-flex">
                <div>
                    <img src="./assets/img/admin-avatar.png" width="45px"/>
                </div>
                <div class="admin-info">
                    <div class="font-strong"><?= mb_strtoupper($_SESSION["name_surname"]) ?></div>
                    <small><?php if ($_SESSION["user_root"] == 1) {
                            echo "Yönetici";
                        } else {
                            echo 'Kullanıcı';
                        } ?></small></div>
            </div>
            <ul class="side-menu metismenu">
                <li>
                    <a class="active" href="" style="cursor: pointer; color: white"><i
                                class="sidebar-item-icon fa fa-th-large"></i>
                        <span class="nav-label">Anasayfa</span>
                    </a>
                </li>
                <li class="heading">Modüller</li>
                <li>
                    <a href=""><i class="sidebar-item-icon fa fa-calculator"></i>
                        <span class="nav-label" style="font-weight: bold; color: white" id="click1020">MUHASEBE</span><i
                                class="fa fa-angle-left arrow"></i></a>
                    <ul>
                        <li>
                            <a href="" id=""><i class="sidebar-item-icon fa fa-briefcase"></i>
                                <span class="nav-label" style=" color: white">ÜYE YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="uye_tanim">Üye Tanımla</a>
                                </li>
                                <li>
                                    <a href="">Üye İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="bireysel_tahakkuk_islemleri">Bireysel
                                                Tahakkuk İşlemleri</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="uye_acilis_fisi">Üye Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="uye_tahakkuk_islemleri">Üye
                                                Tahakkuk İşlemleri</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Üye Raporları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="cursor: pointer; color: white" id="uye_hesap_ekstresi">Üye Hesap
                                                Ekstresi</a>
                                        </li>
                                        <li>
                                            <a style="cursor: pointer; color: white" id="uye_borc_alacak_durumu">Üye
                                                Borç Alacak Durumu</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Tanımlamalar<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="cursor: pointer; color: white" id="uye_tarife_tanim">Tarifeler</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" id=""><i class="sidebar-item-icon fa fa-briefcase"></i>
                                <span class="nav-label" style=" color: white">CARİ HESAP YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="cari_tanimla">Cari Tanımla</a>
                                </li>
                                <li>
                                    <a href="">Cari İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cari_acilis_fisi">Cari Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="mahsup_fisleri">Mahsup Fişi</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Cari Raporları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="cursor: pointer; color: white" id="cari_hesap_ekstre">Cari Hesap
                                                Ekstresi</a>
                                        </li>
                                        <li>
                                            <a style="cursor: pointer; color: white" id="cari_raporlari">Cari Borç
                                                Alacak Durumu</a>
                                        </li>
                                        <li>
                                            <a style="cursor: pointer; color: white" id="cari_vadesin_gore_tahsilat">Vadesine
                                                Göre Tahsilat Listesi</a>
                                        </li>
                                        <li>
                                            <a style="cursor: pointer; color: white" id="cari_vadesine_gore_odeme">Vadesine
                                                Göre Ödeme Listesi</a>
                                        </li>
                                        <li>
                                            <a style="cursor: pointer; color: white" id="aylik_tahsilat_listesi">Aylık
                                                Tahsilat Listesi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-barcode"></i>
                                <span class="nav-label" style=" color: white">STOK/HİZMET YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="stok_tanimla_main">Stok Tanımla</a>
                                </li>
                                <li>
                                    <a href="">Stok İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_fire_cikis">Stok Fire
                                                Çıkışı</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_sayim_fazlasi">Stok Sayım
                                                Fazlası</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_acilis">Stok Açılış
                                                Fişi</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                <li>
                                    <a style="cursor: pointer;color: white" id="">Stok Raporları<i
                                                class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_raporlari">Stok Envanter
                                                Raporu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_ekstresi">Stok
                                                Ekstresi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="stok_devir_hizi">Stok Devir
                                                Hızı</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="">Cari Stok Analizi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="">Kritik Seviye Listesi</a>
                                        </li>
                                    </ul>
                                </li>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-basket"></i>
                                <span class="nav-label" style=" color: white">ALIŞ YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="alis_faturasi_getir_main">Alış
                                        Faturası</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="irsaliyeler">Alış İrsaliyesi</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="verilen_siparisler">Verilen
                                        Siparişler</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="muhasebe_gider_faturalari">Gider
                                        Faturaları</a>
                                </li>
                                <li>
                                    <a href="">Alış Faturası Raporları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="cursor: pointer; color: white" id="saticilara_gore_ft">Satıcılara
                                                Göre Fatura
                                                Listesi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                                <span class="nav-label" style=" color: white">SATIŞ YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="satis_faturasi_getir_admin">Satış
                                        Faturası</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="satis_irsaliye_getir">Satış
                                        İrsaliye</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="alinan_siparisler">Alınan Sipariş</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="perakende_satis">Perakende Satış</a>
                                </li>
                                <li>
                                    <a href="">Satış Faturası Raporları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="cursor: pointer; color: white"
                                               id="musterilere_gore_fatura_listesi">Müşteriye Göre Fatura
                                                Listesi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label" style=" color: white">NAKİT YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="kasa_tanimla_main">Kasa Tanımla</a>
                                </li>
                                <li>
                                    <a href="">Kasa İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kasa_acilis_fisi">Kasa Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kasa_tahsilat">Kasa
                                                Tahsilat</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kasa_odeme">Kasa Ödeme</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kasa_virman">Kasa Virman</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="bankaya_yatan">Bankaya
                                                Yatan</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="bankadan_cekilen">Bankadan
                                                Çekilen</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Kasa Raporları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kasa_hesap_ekstresi">Kasa Hesap
                                                Ekstersi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa fa-university"></i>
                                <span class="nav-label" style=" color: white">FİNANS YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="banka_tanimla_main">Banka Tanımla</a>
                                </li>
                                <li>
                                    <a href="">Banka İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="banka_acilis_fisi">Banka Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="havale_giris">EFT/Havale
                                                Giriş</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="havale_cikis">EFT/Havale
                                                Çıkış</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="banka_virman">Banka Virman</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="doviz_alim">Döviz Alım</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="doviz_satim">Döviz Satım</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Kredi İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_acilis_fisi">Kredi Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="yeni_kredi_kullanimi">Yeni
                                                Kredi Kullanımı</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_taksit_odeme">Kredi
                                                Taksit Ödeme</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_ekstresi">Kredi
                                                Ekstresi</a>
                                        </li>
                                        <!--                                        <li>-->
                                        <!--                                            <a style="color: white; cursor: pointer" id="">Kredi Durum Raporu</a>-->
                                        <!--                                        </li>-->
                                    </ul>
                                </li>
                                <li>
                                    <a href="">POS İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="pos_hesap_tanim">POS Hesap
                                                Tanımları</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="pos_cekimi_giris">POS
                                                Çekimi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="pos_tahsil_main">POS
                                                Tahsili</a>
                                        </li>
                                        <li>
                                            <a href="">POS Raporları<i class="fa fa-angle-left arrow"></i></a>
                                            <ul class="nav-2-level collapse">
                                                <li>
                                                    <a style="color: white; cursor: pointer" id="pos_hesap_ekstresi">POS
                                                        Hesap Ekstresi</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Kredi Kartı İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_karti_tanimla">Kredi
                                                Kartı Tanımları</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_kartindan_odeme">Kredi
                                                Kartından Ödeme</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_kart_odemesi">Kredi Kart
                                                Ödemesi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_kart_acilis_fisi">Kredi
                                                Kart Açılış Fişi</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-angle-left arrow"></i> Banka Raporları</a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="banka_hesap_ekstresi">Banka
                                                Hesap Ekstresi</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-angle-left arrow"></i> Kredi Kart Ekstresi</a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="kredi_kart_hesap_ekstresi">Kredi
                                                Kart Ekstresi</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-list-alt"></i>
                                <span class="nav-label" style=" color: white">ÇEK SENET</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="cek_stok_giris">Çek Stok</a>
                                </li>
                                <li>
                                    <a href="">Çek İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cek_acilis_fisi">Çek Açılış
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cek_senet_giris_bordrosu">Çek
                                                Giriş Bordrosu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cek_senet_cikis_bordrosu">Çek
                                                Çıkış Bordrosu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cek_senet_tahsil">Çek
                                                Tahsil</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cek_senet_odeme">Çek Ödeme</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Senet İşlemleri <i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="senet_giris_bordrosu">Senet
                                                Giriş Bordrosu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="senet_cikis_bordrosu">Senet
                                                Çıkış Bordrosu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="senet_tahsil">Senet Tahsil</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="senet_odeme">Senet Ödeme</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Karşılıksız Çek İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="ciro_edilen_cek_karsiliksiz">Ciro
                                                Edilen Çek Karşılıksız</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer"
                                               id="tahsile_verilen_cek_karsiliksiz">Tahsile Verilen Çek Karşılıksız</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer"
                                               id="teminata_verilen_cek_karsiliksiz">Teminata Verilen Çek
                                                Karşılıksız</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="portfoydeki_karsiliksiz_cek">Portföydeki
                                                Çek Karşılıksız</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-angle-left arrow"></i> Çek Ve Senet Raporları</a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="verilen_cek_raporlari">Verilen
                                                Çek Ve Senet Listesi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="alinan_cek_raporlari">Alınan
                                                Çek Ve Senet Listesi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="odenecek_cek_ve_senetler">Ödenecek
                                                Çek Ve Senetler</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="karsiliksiz_cek_ve_senetler">Karşılısız
                                                Çek Ve Senetler</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-users"></i>
                                <span class="nav-label" style=" color: white">PERSONEL YÖNETİMİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="">Personel İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="personel_tanimla">Personel
                                                Tanımla</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="maas_tahakkuk">Maaş
                                                Tahakkukları</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="personel_izin">Personel
                                                İzin</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="personel_devamsizlik">Personel
                                                Devamsızlık</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Personel Tanımları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="gorev_tanim">Görev Tanım</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="departman_tanim">Departman
                                                Tanım</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="meslek_tanim">Meslek Tanım</a>
                                        </li>
                                        <!--                                <li>-->
                                        <!--                                    <a style="color: white; cursor: pointer" id="servis_tanim">Servis Tanım</a>-->
                                        <!--                                </li>-->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-car"></i>
                                <span class="nav-label" style=" color: white">TAŞITLAR</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="binek_arac_tanim">Araç Tanım</a>
                                </li>
                                <li>
                                    <a href="">Yakıt İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="yakit_alim_fisleri">Yakıt Alım
                                                Fişi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="binek_yakit_alim_faturasi">Yakıt
                                                Alım Faturası</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Sanayi İşlemleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="binek_sanayi_fisleri">Sanayi
                                                Fişleri</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="binek_sanayi_faturalari">Sanayi
                                                Faturaları</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Araç Giderleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="binek_hgs_gideri">HGS
                                                Gideri</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="binek_vergi_gider">Vergi Ve
                                                Diğer</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-file"></i>
                                <span class="nav-label" style=" color: white">YÖNETİM RAPORLARI</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="bilanco_raporlari">Bilanço
                                        Raporları</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-cog"></i>
                                <span class="nav-label" style=" color: white">TANIMLAMALAR</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a href="">Cari Parametreleri<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="bilanco_tanimlari">Bilanço
                                                Tanımları</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cari_turu_tanim">Cari Türü
                                                Ekle</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="cari_grup_tanim">Cari Grubu
                                                Ekle</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Fatura Tanımları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="fatura_turu_tanim">Fatura Türü
                                                Tanımları</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="fatura_tipi_tanim">Fatura Tipi
                                                Tanımları</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Stok Tanımları<i class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="birim_tanim">Birim</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="ana_grup">Stok Ana Grubu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="alt_grup">Stok Alt Grubu</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="marka_listesi_main">Marka
                                                Listesi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="model_listesi_main">Model
                                                Listesi</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="depo_listesi_main">Depolar</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:" id="users_root"><i class="sidebar-item-icon fa fa-user"></i>
                                <span class="nav-label" style=" color: white">KULLANICILAR</span></a>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-send"></i>
                                <span class="nav-label" style=" color: white">SMS GÖNDER</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="sms_gonder_page">Toplu SMS Gönder</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="toplu_borc_sms_page">Toplu Borç SMS Gönder</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="gonderilen_sms_raporlari">Gönderilen SMS Raporları</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--                <li>-->
                <!--                    <a href=""><i class="sidebar-item-icon fa fa-pie-chart"></i>-->
                <!--                        <span class="nav-label" style="font-weight: bold; color: white">DEPO HİZMETLERİ</span><i class="fa fa-angle-left arrow"></i></a>-->
                <!--                    <ul>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cube"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">ACENTE HİZMETLERİ</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="acente_konteyner_giris">Konteyner Giriş</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="acente_konteyner_cikis">Konteyner Çıkış</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depo_acente_tanimlari">Hizmet Tanımları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depo_acente_kondisyon_tanimlari">Kondisyon Tanımları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="konteyner_toplu_tanim">Konteyner Toplu-->
                <!--                                        Tanım</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="estimate_islemleri">Estimate İşlemleri</a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cube"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">DEPO HİZMETLERİ</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depo_ithalat_is_emri">Özmal Depo İş Emri</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="kiralik_depo_is_emri">Kiralık Depo İş Emri</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer"-->
                <!--                                       id="is_emri_konteyner_tanim">Konteyner Tanım</a>-->
                <!--                                </li>-->
                <!--                                <!--                                <li>-->-->
                <!--                                <!--                                    <a style="color: white; cursor: pointer"-->
                -->
                <!--                                <!--                                       id="gelmesi_beklenen_konteynerler_listesi">Gelmesi Beklenen Konteynerler</a>-->
                -->
                <!--                                <!--                                </li>-->-->
                <!--                                <li>-->
                <!--                                    <a style="color: white;cursor:pointer;" id="konteyner_giris_main"><span class="nav-label">Konteyner Giriş</span></a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white;cursor:pointer;" id="konteyner_cikis_main"><span class="nav-label">Konteyner Çıkış</span></a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white;cursor:pointer;" id="depo_arac_tanim"><span class="nav-label">Araç Tanım</span></a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white;cursor:pointer;" id="arac_giris_main"><span class="nav-label">Araç Giriş</span></a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-check"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">PUANTÖR İŞLEMLERİ</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="acente_puantor_islemleri">Acente İşlemleri</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="sahaya_urun_ser">Sahaya Serme-->
                <!--                                        İşlemleri</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="konteynere_urun_aktar">Konteynere Ürün-->
                <!--                                        Aktar</a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-shopping-basket"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">FATURALANDIRMA</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a href="#" id=""><span class="nav-label" id="" style=" color: white">ALIŞ YÖNETİMİ</span><i-->
                <!--                                                class="fa fa-angle-left arrow"></i></a>-->
                <!--                                    <ul>-->
                <!--                                        <li>-->
                <!--                                            <a style="color: white; cursor: pointer" id="depo_alis_faturasi_main">Alış-->
                <!--                                                Faturası</a>-->
                <!--                                        </li>-->
                <!--                                        <li>-->
                <!--                                            <a style="color: white; cursor: pointer" id="alis_hizmet_listesi">Alış-->
                <!--                                                Hizmet Listesi</a>-->
                <!--                                        </li>-->
                <!--                                    </ul>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a href="#" id=""><span class="nav-label" id="" style=" color: white">SATIŞ YÖNETİMİ</span><i-->
                <!--                                                class="fa fa-angle-left arrow"></i></a>-->
                <!--                                    <ul>-->
                <!--                                        <li>-->
                <!--                                            <a style="color: white; cursor: pointer" id="depo_satis_faturasi_main">Satış-->
                <!--                                                Faturası</a>-->
                <!--                                        </li>-->
                <!--                                        <li>-->
                <!--                                            <a style="color: white; cursor: pointer" id="gelmesi_beklenen_faturalar">Satış-->
                <!--                                                Hizmet Listesi</a>-->
                <!--                                        </li>-->
                <!--                                    </ul>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fas fa fa-hand-lizard-o"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">YAKIT İŞLEMLERİ</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depo_yakit_islemleri">Depo Yakıt İşlemleri</a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-file"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">RAPORLAR</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="is_emri_bazli_raporlar">İTHALAT Raporları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="is_emri_ihracat_raporlari">İHRACAT Raporları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="forklift_raporlari">Forklift Raporları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="makine_hareket_raporlari">Makine Hareket Raporları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depo_personel_raporlari">Personel Raporları</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depodaki_konteynerler_raporu">Depodaki Konteynerler</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="depodaki_bulunan_urun_raporlari">Depoda Bulunan Ürünler</a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                        <li>-->
                <!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cog"></i>-->
                <!--                                <span class="nav-label" id="" style=" color: white">TANIMLAMALAR</span><i-->
                <!--                                        class="fa fa-angle-left arrow"></i></a>-->
                <!--                            <ul>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="konteyner_adres_tanimi">Adres-->
                <!--                                        Tanımlama</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="mal_cinsi_tanimi">Mal Cinsi Tanımı</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="forklift_tanim_button">Forklift-->
                <!--                                        Tanım</a>-->
                <!--                                </li>-->
                <!--                                <li>-->
                <!--                                    <a style="color: white; cursor: pointer" id="kalmar_tanim_button">Kalmar Tanım</a>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </li>-->
            </ul>
        </div>
    </nav>
    <div class="content-wrapper" style="background-color: #9DB2BF;">
        <div class="admin-modal-icerik">
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="siparis_sayisi">0</h2>
                                <div class="m-b-5">SİPARİŞLERİM</div>
                                <i class="ti-shopping-cart widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-info color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="odenecek_cekler">0,00</h2>
                                <div class="m-b-5">ÖDENECEK ÇEKLER</div>
                                <i class="fa fa-turkish-lira widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="kk_odeme_haftalik">0</h2>
                                <div class="m-b-5">KREDİ KARTI ÖDEMELERİ</div>
                                <i class="fa fa-turkish-lira widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="musteri_tahsilatlari">0,00</h2>
                                <div class="m-b-5">MÜŞTERİ TAHSİLATLARI</div>
                                <i class="ti-bar-chart widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong">0,00</h2>
                                <div class="m-b-5">POS TAHSİLAT</div>
                                <i class="ti-shopping-cart widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-info color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="kasalar">0,00</h2>
                                <div class="m-b-5">KASA</div>
                                <i class="fa fa-turkish-lira widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="bankalar">0,00</h2>
                                <div class="m-b-5">BANKALAR</div>
                                <i class="fa fa-turkish-lira widget-stat-icon"></i>
                                <!--                                <div><i class="fa fa-level-up m-r-5"></i><small>22% higher</small></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="cari_odemeleri">0,00</h2>
                                <div class="m-b-5">CARİ ÖDEMELER</div>
                                <i class="fa fa-money widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="background-color: oldlace">
                    <canvas id="aylik_sefer_sayi"></canvas>
                </div>
                <div class="col-lg-6" style="background-color: oldlace;">
                    <canvas id="oz_mal_kiralik"></canvas>
                    <!--                   BURDAKAİ CANVASI TEKRARDAN GÖZDEN GEÇİR ÇOK ÇİRKİN DURDU-->
                </div>
            </div>
            <div class="row" style="background-color: oldlace">
                <div class="col-12 row mt-3">
                    <table class="table table-bordered" style="cursor:pointer;font-size: 13px;background-color: white"
                           id="konteyner_siparis_main_list">
                        <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Sipariş Tarihi</th>
                            <th>Müşteri Adı</th>
                            <th>Tipi</th>
                            <th>Yükleme Tarihi</th>
                            <th>Güzergah</th>
                            <th>İl</th>
                            <th>Konteyner No</th>
                            <th>Referans No</th>
                            <th>Alım Yeri</th>
                            <th>İhracat Firması</th>
                            <th>Konteyner Tipi</th>
                            <th>Acenta</th>
                            <th>Açıklama</th>
                            <th>Aktarma Plaka</th>
                            <th>Aktarma Sürücü</th>
                            <th>Plaka No</th>
                            <th>Dorse Plaka</th>
                            <th>Sürücü</th>
                            <th>Yükleme Adres</th>
                            <th>Durum</th>
                            <th>İptal Sebebi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
<script src="assets/js/app.min.js" type="text/javascript"></script>
<script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $("#click1020").trigger("click");
        }, 1);

        var ctx = document.getElementById('aylik_sefer_sayi').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                datasets: [{
                    label: '',
                    data: [12, 19, 3, 5, 15, 8, 10, 20, 25, 13, 8, 10],
                    backgroundColor: ['#F99417', "#64CCC5", "#0802A3", "#D80032", "#F8DE22", "#F99417", "#64CCC5", "#D80032", "#F8DE22", "#F99417", "#D80032", "#F8DE22",],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        var table = $("#konteyner_siparis_main_list").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[4, 'asc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {"data": "siparis_no"},
                {"data": "siparis_tarihi"},
                {"data": "musteri_adi"},
                {"data": "tipi"},
                {"data": "yukleme_tarihi"},
                {"data": "guzergah"},
                {"data": "yukleme_il"},
                {"data": "konteyner_no"},
                {"data": "referans_no"},
                {"data": "alim_yeri_main"},
                {"data": "alim_yeri"},
                {"data": "konteyner_tipi"},
                {"data": "hat_acenta"},
                {"data": "aciklama"},
                {"data": "aktarma_plaka"},
                {"data": "aktarma_surucu"},
                {"data": "plaka_no"},
                {"data": "dorse_plaka"},
                {"data": "surucu_adi"},
                {"data": "yukleme_adres"},
                {"data": "durum"},
                {"data": "iptal_sebebi"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("konteyner/controller/siparis_controller/sql.php?islem=siparisleri_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                var basilacak_arr = [];

                json.forEach(function (item) {
                    let siparis_tarihi = item.siparis_tarihi;
                    siparis_tarihi = siparis_tarihi.split(" ");
                    siparis_tarihi = siparis_tarihi[0];
                    siparis_tarihi = siparis_tarihi.split("-");
                    let gun1 = siparis_tarihi[2];
                    let ay1 = siparis_tarihi[1];
                    let yil1 = siparis_tarihi[0];
                    let arr3 = [gun1, ay1, yil1];
                    siparis_tarihi = arr3.join("/");

                    let yukleme_tarihi = item.yukleme_tarihi;
                    yukleme_tarihi = yukleme_tarihi.split(" ");
                    let saati = yukleme_tarihi[1];
                    yukleme_tarihi = yukleme_tarihi[0];
                    yukleme_tarihi = yukleme_tarihi.split("-");
                    let gun = yukleme_tarihi[2];
                    let ay = yukleme_tarihi[1];
                    let yil = yukleme_tarihi[0];
                    let arr = [gun, ay, yil];
                    let yeni = arr.join("/");
                    yukleme_tarihi = yeni + " " + saati
                    let durum = "";
                    if (item.siparis_durum == 1) {
                        durum = "Bekliyor";
                    } else if (item.siparis_durum == 2) {
                        durum = "İrsaliyesi Kesildi";
                    } else {
                        durum = "İptal Edildi";
                    }
                    let konteyner_no = "";
                    let konteyner_harf = item.konteyner_no_harf;
                    let konteyner_rakam1 = item.konteyner_no_rakam1;
                    let konteyner_rakam = item.konteyner_no;
                    konteyner_no = konteyner_harf + " " + konteyner_rakam1 + "-" + konteyner_rakam;

                    let tipi = "";
                    if (item.tipi == 1) {
                        tipi = "İhracat";
                    } else if (item.tipi == 2) {
                        tipi = "İthalat";
                    } else if (item.tipi == 3) {
                        tipi = "Kargo";
                    }

                    let konteyner_tipi = "";

                    if (item.konteyner_tipi == 1) {
                        konteyner_tipi = "20 DC";
                    } else if (item.konteyner_tipi == 2) {
                        konteyner_tipi = "40 DC";
                    } else if (item.konteyner_tipi == 3) {
                        konteyner_tipi = "20 OT";
                    } else if (item.konteyner_tipi == 4) {
                        konteyner_tipi = "40 OT";
                    } else if (item.konteyner_tipi == 5) {
                        konteyner_tipi = "20 RF";
                    } else if (item.konteyner_tipi == 6) {
                        konteyner_tipi = "40 RF";
                    } else if (item.konteyner_tipi == 7) {
                        konteyner_tipi = "40 HC RF";
                    } else if (item.konteyner_tipi == 8) {
                        konteyner_tipi = "40 HC";
                    } else if (item.konteyner_tipi == 9) {
                        konteyner_tipi = "20 TANK";
                    } else if (item.konteyner_tipi == 10) {
                        konteyner_tipi = "20 VENTİLATED";
                    } else if (item.konteyner_tipi == 11) {
                        konteyner_tipi = "40 HC PAL. WIDE";
                    } else if (item.konteyner_tipi == 12) {
                        konteyner_tipi = "20 FLAT";
                    } else if (item.konteyner_tipi == 13) {
                        konteyner_tipi = "40 FLAT";
                    } else if (item.konteyner_tipi == 14) {
                        konteyner_tipi = "40 HC FLAT";
                    } else if (item.konteyner_tipi == 15) {
                        konteyner_tipi = "20 PLATFORM";
                    } else if (item.konteyner_tipi == 16) {
                        konteyner_tipi = "40 PLATFORM";
                    } else if (item.konteyner_tipi == 17) {
                        konteyner_tipi = "45 HC";
                    } else if (item.konteyner_tipi == 18) {
                        konteyner_tipi = "KARGO";
                    }


                    let newRow = {
                        siparis_no: item.siparis_no,
                        siparis_tarihi: siparis_tarihi,
                        musteri_kodu: item.musteri_kodu,
                        musteri_adi: item.musteri_unvani,
                        tipi: tipi,
                        yukleme_tarihi: yukleme_tarihi,
                        guzergah: item.guzergah_adi,
                        konteyner_no: konteyner_no,
                        referans_no: item.referans_no,
                        konteyner_tipi: konteyner_tipi,
                        aktarma_plaka: item.aktarma_plaka_no,
                        aktarma_surucu: item.aktarma_surucu,
                        yukleme_il: item.yukleme_il,
                        plaka_no: item.tasima_plaka_no,
                        dorse_plaka: item.dorse_adi,
                        surucu_adi: item.surucu_adi,
                        hat_acenta: item.hat_acenta,
                        yukleme_firmasi: item.yukleme_firmasi,
                        alim_yeri_main: item.alim_yeri_main,
                        alim_yeri: item.alim_yeri,
                        yukleme_adres: item.yukleme_adres,
                        aciklama: item.siparis_aciklama,
                        durum: durum,
                        iptal_sebebi: item.silme_nedeni,
                        button: "<button class='btn btn-secondary btn-sm siparis_guncelle_main_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm konteyner_siparis_iptali_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                table.rows.add(basilacak_arr).draw(false);
            }
        })
        var ctx2 = document.getElementById('oz_mal_kiralik').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Öz Mal', 'Kiralık'],
                datasets: [{
                    data: [60, 40],
                    backgroundColor: ['#F99417', "#64CCC5"]
                }]
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
                $("#cari_odemeleri").html(item.cari_odemeleri);
            }
        })
        $.get("controller/rapor_controller/sql.php?islem=bilanco_tutarlarini_getir_sql", {
            secilen_ay: "<?=date("m")?>",
            secilen_yil: "<?=date("Y")?>"
        }, function (res) {
            if (res != 2) {
                let item = JSON.parse(res);
                let kasalar = item.kasalar;
                kasalar = parseFloat(kasalar);
                kasalar = kasalar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                let bankalar = item.bankalar;
                bankalar = parseFloat(bankalar);
                bankalar = bankalar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $("#kasalar").html(kasalar);
                $("#bankalar").html(bankalar);
            }
        })
    });

    $("body").off("click", "#nakliye_depolama_cikis").on("click", "#nakliye_depolama_cikis", function () {
        $.get("depo/view/nakliye_depolama_cikis.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_giris_main").on("click", "#konteyner_giris_main", function () {
        $.get("depo/view/konteyner_giris_main.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_giris_main").on("click", "#arac_giris_main", function () {
        $.get("depo/view/arac_giris_main.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_cikis_main").on("click", "#konteyner_cikis_main", function () {
        $.get("depo/view/konteyner_cikis_main.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_arac_tanim").on("click", "#depo_arac_tanim", function () {
        $.get("depo/view/depo_arac_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_siparis_islemleri").on("click", "#depo_siparis_islemleri", function () {
        $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#forklift_tanim_button").on("click", "#forklift_tanim_button", function () {
        $.get("depo/view/forklift_tanim.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kalmar_tanim_button").on("click", "#kalmar_tanim_button", function () {
        $.get("depo/view/kalmar_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sahaya_urun_ser").on("click", "#sahaya_urun_ser", function () {
        $.get("depo/view/sahaya_urun_ser.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_puantor_islemleri").on("click", "#acente_puantor_islemleri", function () {
        $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sahaya_konteyner_ser").on("click", "#sahaya_konteyner_ser", function () {
        $.get("depo/view/sahaya_konteyner_ser.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteynere_urun_aktar").on("click", "#konteynere_urun_aktar", function () {
        $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gelmesi_beklenen_faturalar").on("click", "#gelmesi_beklenen_faturalar", function () {
        $.get("depo/view/gelmesi_beklenen_faturalar.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#alis_hizmet_listesi").on("click", "#alis_hizmet_listesi", function () {
        $.get("depo/view/alis_hizmet_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_alis_faturasi_main").on("click", "#depo_alis_faturasi_main", function () {
        $.get("depo/view/depo_alis_faturasi_main.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_satis_faturasi_main").on("click", "#depo_satis_faturasi_main", function () {
        $.get("depo/view/depo_satis_faturasi_main.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_bazli_raporlar").on("click", "#is_emri_bazli_raporlar", function () {
        $.get("depo/view/is_emri_bazli_raporlar.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_yakit_islemleri").on("click", "#depo_yakit_islemleri", function () {
        $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_ihracat_raporlari").on("click", "#is_emri_ihracat_raporlari", function () {
        $.get("depo/view/is_emri_ihracat_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#forklift_raporlari").on("click", "#forklift_raporlari", function () {
        $.get("depo/rapor_view/forklift_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#makine_hareket_raporlari").on("click", "#makine_hareket_raporlari", function () {
        $.get("depo/rapor_view/makine_hareket_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_personel_raporlari").on("click", "#depo_personel_raporlari", function () {
        $.get("depo/rapor_view/depo_personel_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depodaki_konteynerler_raporu").on("click", "#depodaki_konteynerler_raporu", function () {
        $.get("depo/rapor_view/depodaki_konteynerler_raporu.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depodaki_bulunan_urun_raporlari").on("click", "#depodaki_bulunan_urun_raporlari", function () {
        $.get("depo/rapor_view/depodaki_bulunan_urun_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_ithalat_siparis").on("click", "#depo_ithalat_siparis", function () {
        $.get("depo/view/depo_ithalat_siparis.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_ithalat_is_emri").on("click", "#depo_ithalat_is_emri", function () {
        $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kiralik_depo_is_emri").on("click", "#kiralik_depo_is_emri", function () {
        $.get("depo/view/kiralik_depo_is_emri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_adres_tanimi").on("click", "#konteyner_adres_tanimi", function () {
        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#mal_cinsi_tanimi").on("click", "#mal_cinsi_tanimi", function () {
        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_konteyner_giris").on("click", "#depo_konteyner_giris", function () {
        $.get("depo/view/depo_konteyner_giris.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_konteyner_tanim").on("click", "#is_emri_konteyner_tanim", function () {
        $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gelmesi_beklenen_konteynerler_listesi").on("click", "#gelmesi_beklenen_konteynerler_listesi", function () {
        $.get("depo/view/gelmesi_beklenen_konteynerler_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_toplu_tanim").on("click", "#konteyner_toplu_tanim", function () {
        $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_acente_kondisyon_tanimlari").on("click", "#depo_acente_kondisyon_tanimlari", function () {
        $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_acente_tanimlari").on("click", "#depo_acente_tanimlari", function () {
        $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_konteyner_giris").on("click", "#acente_konteyner_giris", function () {
        $.get("depo/view/acente_konteyner_giris.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_konteyner_cikis").on("click", "#acente_konteyner_cikis", function () {
        $.get("depo/view/acente_konteyner_cikis.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#estimate_islemleri").on("click", "#estimate_islemleri", function () {
        $.get("depo/view/estimate_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#prim_kazanc_listesi").on("click", "#prim_kazanc_listesi", function () {
        $.get("konteyner/view/prim_kazanc_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_bazli_sanayi_gider_raporu").on("click", "#arac_bazli_sanayi_gider_raporu", function () {
        $.get("konteyner/view/arac_bazli_sanayi_gider_raporu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#tum_araclar_raporu").on("click", "#tum_araclar_raporu", function () {
        $.get("konteyner/view/tum_araclar_raporu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#firma_bazli_sanayi_gider_raporu").on("click", "#firma_bazli_sanayi_gider_raporu", function () {
        $.get("konteyner/view/firma_bazli_sanayi_gider_raporu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#odenmemis_primler_listesi").on("click", "#odenmemis_primler_listesi", function () {
        $.get("konteyner/view/odenmemis_primler_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#bilanco_raporlari").on("click", "#bilanco_raporlari", function () {
        $.get("rapor_view/bilanco_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_hesaplari").on("click", "#arac_hesaplari", function () {
        $.get("rapor_view/arac_hesaplari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kar_zarar_raporu").on("click", "#kar_zarar_raporu", function () {
        $.get("rapor_view/kar_zarar_raporu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_vadesin_gore_tahsilat").on("click", "#cari_vadesin_gore_tahsilat", function () {
        $(".modal-icerik").html("");
        $(".admin-modal-icerik").html("");
        $.get("modals/cari_diger_modal/vadesine_gore_tahsilat.php?islem=vade_kriterleri_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#aylik_tahsilat_listesi").on("click", "#aylik_tahsilat_listesi", function () {
        $(".modal-icerik").html("");
        $(".admin-modal-icerik").html("");
        $.get("modals/cari_diger_modal/aylik_tahsilat.php?islem=aylik_tahsilat_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#cari_vadesine_gore_odeme").on("click", "#cari_vadesine_gore_odeme", function () {
        $(".modal-icerik").html("");
        $(".admin-modal-icerik").html("");
        $.get("modals/cari_diger_modal/vadesine_gore_odeme.php?islem=vade_kriterleri_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#users_root").on("click", "#users_root", function () {
        $.get("admin_views/user_config.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sms_gonder_page").on("click", "#sms_gonder_page", function () {
        $.get("modals/sms_modal/sms_gonder.php?islem=toplu_sms_gonder_modal", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".modal-icerik").html("");
            $(".getModals").html(getList);
        });
    });
    $("body").off("click", "#toplu_borc_sms_page").on("click", "#toplu_borc_sms_page", function () {
        $.get("modals/sms_modal/toplu_borc_sms_page.php?islem=toplu_sms_gonder_modal", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".modal-icerik").html("");
            $(".getModals").html(getList);
        });
    });
    $("body").off("click", "#gonderilen_sms_raporlari").on("click", "#gonderilen_sms_raporlari", function () {
        $.get("view/gonderilen_sms_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_fire_cikis").on("click", "#stok_fire_cikis", function () {
        $.get("view/stok_fire.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_arac_tanim").on("click", "#binek_arac_tanim", function () {
        $.get("view/binek_arac_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_alim_fisleri").on("click", "#yakit_alim_fisleri", function () {
        $.get("view/yakit_alim_fisleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_yakit_alim_faturasi").on("click", "#binek_yakit_alim_faturasi", function () {
        $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_sanayi_fisleri").on("click", "#binek_sanayi_fisleri", function () {
        $.get("view/binek_sanayi_fisleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#araclara_stok_cikisi").on("click", "#araclara_stok_cikisi", function () {
        $.get("konteyner/view/araclara_stok_cikisi.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#araclara_stok_cikisi").on("click", "#araclara_stok_cikisi", function () {
        $.get("konteyner/view/araclara_stok_cikisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_sanayi_faturalari").on("click", "#binek_sanayi_faturalari", function () {
        $.get("view/binek_sanayi_faturalari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_hgs_gideri").on("click", "#binek_hgs_gideri", function () {
        $.get("view/binek_hgs_gideri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#binek_vergi_gider").on("click", "#binek_vergi_gider", function () {
        $.get("view/binek_vergi_gider.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_sayim_fazlasi").on("click", "#stok_sayim_fazlasi", function () {
        $.get("view/stok_sayim_fazlasi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kartindan_odeme").on("click", "#kredi_kartindan_odeme", function () {
        $.get("view/kredi_kartindan_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_acilis_tahsil_odeme").on("click", "#cek_acilis_tahsil_odeme", function () {
        $.get("view/cek_acilis_tahsil_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_acilis_fisi").on("click", "#cek_acilis_fisi", function () {
        $.get("view/cek_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kart_acilis_fisi").on("click", "#kredi_kart_acilis_fisi", function () {
        $.get("view/kredi_kart_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_odeme").on("click", "#cek_senet_odeme", function () {
        $.get("view/cek_senet_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#muhasebe_gider_faturalari").on("click", "#muhasebe_gider_faturalari", function () {
        $.get("view/muhasebe_gider_faturalari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#saticilara_gore_ft").on("click", "#saticilara_gore_ft", function () {
        $.get("view/saticilara_gore_ft.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_depolama_islemleri").on("click", "#nakliye_depolama_islemleri", function () {
        $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gecmis_konteyner_girisleri").on("click", "#gecmis_konteyner_girisleri", function () {
        $.get("depo/view/gecmis_konteyner_girisleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#toplu_siparis_listesi").on("click", "#toplu_siparis_listesi", function () {
        $.get("konteyner/view/toplu_siparis_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#surucu_prim_raporlari").on("click", "#surucu_prim_raporlari", function () {
        $.get("konteyner/view/surucu_prim_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_odeme").on("click", "#senet_odeme", function () {
        $.get("view/senet_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kart_hesap_ekstresi").on("click", "#kredi_kart_hesap_ekstresi", function () {
        $.get("view/kredi_kart_hesap_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_takma_main").on("click", "#lastik_takma_main", function () {
        $.get("konteyner/view/lastik_takma.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_cekimi_giris").on("click", "#pos_cekimi_giris", function () {
        $.get("view/pos_cekimi_giris.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kart_odemesi").on("click", "#kredi_kart_odemesi", function () {
        $.get("view/kredi_kart_odemesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_cikis_fisleri").on("click", "#yakit_cikis_fisleri", function () {
        $.get("konteyner/view/yakit_cikis_fisleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_alis_irsaliye").on("click", "#lastik_alis_irsaliye", function () {
        $.get("konteyner/view/lastik_alis_irsaliye.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_alis_fatura").on("click", "#lastik_alis_fatura", function () {
        $.get("konteyner/view/lastik_alis_yap.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#tum_sefer_irsaliye_listesi").on("click", "#tum_sefer_irsaliye_listesi", function () {
        $.get("konteyner/view/tum_sefer_irsaliye_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#surucu_prim_odeme").on("click", "#surucu_prim_odeme", function () {
        $.get("konteyner/view/surucu_prim_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sanayi_fisleri").on("click", "#sanayi_fisleri", function () {
        $.get("konteyner/view/sanayi_fisleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sanayi_faturalandir").on("click", "#sanayi_faturalandir", function () {
        $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yonetim_giderleri").on("click", "#yonetim_giderleri", function () {
        $.get("konteyner/view/yonetim_giderleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_fis_faturasi").on("click", "#yakit_fis_faturasi", function () {
        $.get("konteyner/view/yakit_fis_faturasi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_vergi_giderleri").on("click", "#arac_vergi_giderleri", function () {
        $.get("konteyner/view/arac_vergi_giderleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_gider").on("click", "#arac_gider", function () {
        $.get("konteyner/view/arac_gider.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_hgs_giderleri").on("click", "#arac_hgs_giderleri", function () {
        $.get("konteyner/view/arac_hgs_giderleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_kaza_ceza_giderleri").on("click", "#arac_kaza_ceza_giderleri", function () {
        $.get("konteyner/view/arac_kaza_ceza_giderleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_sgk_giderleri").on("click", "#arac_sgk_giderleri", function () {
        $.get("konteyner/view/arac_sgk_giderleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#portfoydeki_karsiliksiz_cek").on("click", "#portfoydeki_karsiliksiz_cek", function () {
        $.get("view/portfoydeki_karsiliksiz_cek.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_hesap_tanim").on("click", "#pos_hesap_tanim", function () {
        $.get("view/pos_hesap_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_tanimla_main").on("click", "#arac_tanimla_main", function () {
        $.get("konteyner/view/arac_tanimla.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_deposu_tanimla_main").on("click", "#yakit_deposu_tanimla_main", function () {
        $.get("konteyner/view/yakit_deposu_tanimla.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kiralik_yakit_cikis_fisleri_list").on("click", "#kiralik_yakit_cikis_fisleri_list", function () {
        $.get("konteyner/view/kiralik_yakit_cikis_fisleri_list.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_toplu_irsaliye_islemleri").on("click", "#nakliye_toplu_irsaliye_islemleri", function () {
        $.get("konteyner/view/nakliye_toplu_irsaliye_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_irsaliye_islemleri").on("click", "#nakliye_irsaliye_islemleri", function () {
        $.get("konteyner/view/nakliye_irsaliye_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#siparis_islemleri_nakliye").on("click", "#siparis_islemleri_nakliye", function () {
        $.get("konteyner/view/siparis_islemleri_nakliye.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_tahsil").on("click", "#senet_tahsil", function () {
        $.get("view/senet_tahsil.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_giris_bordrosu").on("click", "#senet_giris_bordrosu", function () {
        $.get("view/senet_giris_bordrosu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_karti_tanimla").on("click", "#kredi_karti_tanimla", function () {
        $.get("view/kredi_karti_tanimla.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_tahsil_main").on("click", "#pos_tahsil_main", function () {
        $.get("view/pos_tahsil_main.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_giris_bordrosu").on("click", "#cek_senet_giris_bordrosu", function () {
        $.get("view/cek_senet_giris_bordrosu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_cikis_bordrosu").on("click", "#senet_cikis_bordrosu", function () {
        $.get("view/senet_cikis_bordrosu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_stok_giris").on("click", "#cek_stok_giris", function () {
        $.get("view/cek_stok_giris.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#tahsile_verilen_cek_karsiliksiz").on("click", "#tahsile_verilen_cek_karsiliksiz", function () {
        $.get("view/tahsile_verilen_cek_karsiliksiz.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#teminata_verilen_cek_karsiliksiz").on("click", "#teminata_verilen_cek_karsiliksiz", function () {
        $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_tahsil").on("click", "#cek_senet_tahsil", function () {
        $.get("view/cek_senet_tahsil.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_turu_tanim").on("click", "#cari_turu_tanim", function () {
        $.get("view/cari_turu_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#perakende_satis").on("click", "#perakende_satis", function () {
        $.get("view/perakende_satis.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_cikis_bordrosu").on("click", "#cek_senet_cikis_bordrosu", function () {
        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_hesap_ekstre").on("click", "#cari_hesap_ekstre", function () {
        $.get("view/cari_hesap_ekstre.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_hesap_ekstresi").on("click", "#kasa_hesap_ekstresi", function () {
        $.get("view/kasa_hesap_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#verilen_cek_raporlari").on("click", "#verilen_cek_raporlari", function () {
        $.get("view/verilen_cek_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#alinan_cek_raporlari").on("click", "#alinan_cek_raporlari", function () {
        $.get("view/alinan_cek_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#odenecek_cek_ve_senetler").on("click", "#odenecek_cek_ve_senetler", function () {
        $.get("view/odenecek_cek_ve_senetler.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#karsiliksiz_cek_ve_senetler").on("click", "#karsiliksiz_cek_ve_senetler", function () {
        $.get("view/karsiliksiz_cek_ve_senetler.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#fatura_turu_tanim").on("click", "#fatura_turu_tanim", function () {
        $.get("view/fatura_turu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_hesap_ekstresi").on("click", "#banka_hesap_ekstresi", function () {
        $.get("view/banka_hesap_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#fatura_tipi_tanim").on("click", "#fatura_tipi_tanim", function () {
        $.get("view/fatura_tipi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_grup_tanim").on("click", "#cari_grup_tanim", function () {
        $.get("view/cari_grup_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#havale_cikis").on("click", "#havale_cikis", function () {
        $.get("view/havale_cikis.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_izin").on("click", "#personel_izin", function () {
        $.get("view/personel_izin.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#maas_tahakkuk").on("click", "#maas_tahakkuk", function () {
        $.get("view/maas_tahakkuk.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#servis_tanim").on("click", "#servis_tanim", function () {
        $.get("view/servis_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#departman_tanim").on("click", "#departman_tanim", function () {
        $.get("view/departman_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#bankadan_cekilen").on("click", "#bankadan_cekilen", function () {
        $.get("view/bankadan_cekilen.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gorev_tanim").on("click", "#gorev_tanim", function () {
        $.get("view/gorev_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#meslek_tanim").on("click", "#meslek_tanim", function () {
        $.get("view/meslek_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_devamsizlik").on("click", "#personel_devamsizlik", function () {
        $.get("view/personel_devamsizlik.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_raporlari").on("click", "#stok_raporlari", function () {
        $.get("view/stok_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_devir_hizi").on("click", "#stok_devir_hizi", function () {
        $.get("view/stok_devir_hizi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#havale_giris").on("click", "#havale_giris", function () {
        $.get("view/havale_giris.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_virman").on("click", "#banka_virman", function () {
        $.get("view/banka_virman.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#doviz_alim").on("click", "#doviz_alim", function () {
        $.get("view/doviz_alim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#doviz_satim").on("click", "#doviz_satim", function () {
        $.get("view/doviz_satim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_raporlari").on("click", "#cari_raporlari", function () {
        $.get("view/cari_raporlari.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_acilis").on("click", "#stok_acilis", function () {
        $.get("view/stok_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_acilis_fisi").on("click", "#banka_acilis_fisi", function () {
        $.get("view/banka_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#bankaya_yatan").on("click", "#bankaya_yatan", function () {
        $.get("view/bankaya_yatan.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_tanimla").on("click", "#personel_tanimla", function () {
        $.get("view/personel_tanimla.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_odeme").on("click", "#kasa_odeme", function () {
        $.get("view/kasa_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_virman").on("click", "#kasa_virman", function () {
        $.get("view/kasa_virman.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_acilis_fisi").on("click", "#kasa_acilis_fisi", function () {
        $.get("view/kasa_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_tahsilat").on("click", "#kasa_tahsilat", function () {
        $.get("view/kasa_tahsilat.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#mahsup_fisleri").on("click", "#mahsup_fisleri", function () {
        $.get("view/mahsup_fisleri.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_acilis_fisi").on("click", "#cari_acilis_fisi", function () {
        $.get("view/cari_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#satis_irsaliye_getir").on("click", "#satis_irsaliye_getir", function () {
        $.get("view/satis_irsaliye.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#mailler_main").on("click", "#mailler_main", function () {
        $.get("admin_views/mails.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#birim_tanim").on("click", "#birim_tanim", function () {
        $.get("view/birim_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#ana_grup").on("click", "#ana_grup", function () {
        $.get("view/stok_ana_grup_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#alt_grup").on("click", "#alt_grup", function () {
        $.get("view/stok_alt_grup_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#marka_listesi_main").on("click", "#marka_listesi_main", function () {
        $.get("view/marka_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#ciro_edilen_cek_karsiliksiz").on("click", "#ciro_edilen_cek_karsiliksiz", function () {
        $.get("view/ciro_edilen_cek_karsiliksiz.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#model_listesi_main").on("click", "#model_listesi_main", function () {
        $.get("view/model_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#depo_listesi_main").on("click", "#depo_listesi_main", function () {
        $.get("view/depolar.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#bilanco_tanimlari").on("click", "#bilanco_tanimlari", function () {
        $.get("view/bilanco.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#kasa_tanimla_main").on("click", "#kasa_tanimla_main", function () {
        $.get("view/kasa_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#musterilere_gore_fatura_listesi").on("click", "#musterilere_gore_fatura_listesi", function () {
        $.get("view/musterilere_gore_fatura_listesi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#banka_tanimla_main").on("click", "#banka_tanimla_main", function () {
        $.get("view/banka_tanim.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#alis_faturasi_getir_main").on("click", "#alis_faturasi_getir_main", function () {
        $.get("view/alis_fatura.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#verilen_siparisler").on("click", "#verilen_siparisler", function () {
        $.get("view/verilen_siparisler.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#cari_tanimla").on("click", "#cari_tanimla", function () {
        $.get("view/add_cari_page.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#uye_tanim").on("click", "#uye_tanim", function () {
        $.get("view/uye_tanim.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#uye_acilis_fisi").on("click", "#uye_acilis_fisi", function () {
        $.get("view/uye_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });

    $("body").off("click", "#bireysel_tahakkuk_islemleri").on("click", "#bireysel_tahakkuk_islemleri", function () {
        $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });

    $("body").off("click", "#uye_hesap_ekstresi").on("click", "#uye_hesap_ekstresi", function () {
        $.get("view/uye_hesap_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });

    $("body").off("click", "#uye_borc_alacak_durumu").on("click", "#uye_borc_alacak_durumu", function () {
        $.get("view/uye_borc_alacak_durumu.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });

    $("body").off("click", "#uye_tahakkuk_islemleri").on("click", "#uye_tahakkuk_islemleri", function () {
        $.get("view/uye_tahakkuk_islemleri.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });

    $("body").off("click", "#uye_tarife_tanim").on("click", "#uye_tarife_tanim", function () {
        $.get("view/uye_tarife_tanim.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    });
    $("body").off("click", "#cari_dashboard").on("click", "#cari_dashboard", function () {
        $.get("dashboard_views/cari_dashboard.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#konteyner_dashboard").on("click", "#konteyner_dashboard", function () {
        $.get("dashboard_views/konteyner_dashboard.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#alinan_siparisler").on("click", "#alinan_siparisler", function () {
        $.get("view/satis_siparis.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#satis_faturasi_getir_admin").on("click", "#satis_faturasi_getir_admin", function () {
        $.get("view/satis_fatura.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#stok_tanimla_main").on("click", "#stok_tanimla_main", function () {
        $.get("view/add_stok_page.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#stok_ekstresi").on("click", "#stok_ekstresi", function () {
        $.get("view/stok_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#yeni_kredi_kullanimi").on("click", "#yeni_kredi_kullanimi", function () {
        $.get("view/yeni_kredi_kullanimi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#kredi_acilis_fisi").on("click", "#kredi_acilis_fisi", function () {
        $.get("view/kredi_acilis_fisi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#kredi_taksit_odeme").on("click", "#kredi_taksit_odeme", function () {
        $.get("view/kredi_taksit_odeme.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#kredi_ekstresi").on("click", "#kredi_ekstresi", function () {
        $.get("view/kredi_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#pos_hesap_ekstresi").on("click", "#pos_hesap_ekstresi", function () {
        $.get("view/pos_hesap_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#irsaliyeler").on("click", "#irsaliyeler", function () {
        $.get("view/irsaliye_olustur.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#yakit_ekstresi").on("click", "#yakit_ekstresi", function () {
        $.get("rapor_view/yakit_ekstresi.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#aylik_yakit_tutar_bazinda").on("click", "#aylik_yakit_tutar_bazinda", function () {
        $.get("rapor_view/aylik_yakit_tutar_bazinda.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#aylik_yakit_litre_bazinda").on("click", "#aylik_yakit_litre_bazinda", function () {
        $.get("rapor_view/aylik_yakit_litre_bazinda.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#toplam_yakit_gideri_arac").on("click", "#toplam_yakit_gideri_arac", function () {
        $.get("rapor_view/toplam_yakit_gideri_arac.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#toplam_yakit_gideri_surucu").on("click", "#toplam_yakit_gideri_surucu", function () {
        $.get("rapor_view/toplam_yakit_gideri_surucu.php", function (getList) {
            $(".admin-modal-icerik").html("");
            $(".admin-modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#cikis_yap").on("click", "#cikis_yap", function () {
        $.ajax({
            url: "controller/sql.php?islem=logout",
            type: "POST",
            data: {},
            success: function (result) {
                if (result != 2) {
                    Swal.fire(
                        'Başarılı!',
                        'Güvenli Çıkış Sağlanıyor',
                        'success'
                    );
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                }
            }
        });
    });
</script>