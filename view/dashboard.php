<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>SULAMA BİRLİĞİ</title>

    <!-- Fontfaces CSS-->
    <link href="../assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="../assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet"
          media="all">
    <link href="../assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
<style>
    a {
        font-weight: bold;
    }
</style>
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="#">
                        <img src="../assets/images/icon/logo.png" alt="CoolAdmin"/>
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="active has-sub">
                        <a class="js-arrow" href="">
                            <i class="fas fa-tachometer-alt"></i>Anasayfa</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-users"></i>Üye İşlemleri</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="uye_tanimla">Üye Tanımla</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="../assets/images/icon/logo.png" alt="Cool Admin"/>
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li class="has-sub">
                        <a class="js-arrow" href="">
                            <i class="fas fa-tachometer-alt"></i>ANASAYFA</a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-users"></i>ÜYE İŞLEMLERİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="uye_tanimla">Üye Tanımla</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-briefcase"></i>CARİ HESAP YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="cari_tanimla">Cari Tanımla</a>
                            </li>
                            <li>
                                <a href="#" id="">Cari İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="cari_acilis_fisi">Cari Açılış Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="mahsup_fisleri">Mahsup Fişi</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Cari Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="cari_raporlari">Cari Borç Alacak Durumu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cari_hesap_ekstre">Cari Hesap Ekstresi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cari_vadesine_gore_odeme">Vadesine Göre Tahsilat</a>
                                    </li>
                                    <li>
                                        <a href="#" id="aylik_tahsilat_listesi">Vadesine Göre Ödeme</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-barcode"></i>STOK HESAP YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="stok_tanimla_main">Stok Tanımla</a>
                            </li>
                            <li>
                                <a href="#" id="">Stok İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="stok_fire_cikis">Stok Fire Çıkışı</a>
                                    </li>
                                    <li>
                                        <a href="#" id="stok_sayim_fazlasi">Stok Sayım Fazlası</a>
                                    </li>
                                    <li>
                                        <a href="#" id="stok_acilis">Stok Açılış Fişi</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Stok Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="stok_raporlari">Stok Envanter Raporu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="stok_ekstresi">Stok Ekstresi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="stok_devir_hizi">Stok Devir Hızı</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-shopping-basket"></i>ALIŞ YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="alis_faturasi_getir_main">Alış Faturası</a>
                            </li>
                            <li>
                                <a href="#" id="irsaliyeler">Alış İrsaliyesi</a>
                            </li>
                            <li>
                                <a href="#" id="verilen_siparisler">Verilen Siparişler</a>
                            </li>
                            <li>
                                <a href="#" id="muhasebe_gider_faturalari">Gider Faturaları</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-shopping-cart"></i>SATIŞ YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="satis_faturasi_getir_admin">Satış Faturaları</a>
                            </li>
                            <li>
                                <a href="#" id="satis_irsaliye_getir">Satış İrsaliyesi</a>
                            </li>
                            <li>
                                <a href="#" id="alinan_siparisler">Alınan Siparişler</a>
                            </li>
                            <li>
                                <a href="#" id="perakende_satis">Perakende Satış</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-lira-sign"></i>NAKİT YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="">Kasa Tanımla</a>
                            </li>
                            <li>
                                <a href="#" id="kasa_tanimla_main">Kasa İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="kasa_acilis_fisi">Kasa Açılış Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kasa_tahsilat">Kasa Tahsilat</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kasa_odeme">Kasa Ödeme</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kasa_virman">Kasa Virman</a>
                                    </li>
                                    <li>
                                        <a href="#" id="bankaya_yatan">Bankaya Yatan</a>
                                    </li>
                                    <li>
                                        <a href="#" id="bankadan_cekilen">Bankadan Çekilen</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Kasa Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="kasa_hesap_ekstresi">Kasa Ekstresi</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa fa-university"></i>FİNANS YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="banka_tanimla_main">Banka Tanımla</a>
                            </li>
                            <li>
                                <a href="#" id="">Banka İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="banka_acilis_fisi">Banka Açılış Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="havale_giris">EFT/Havale Giriş</a>
                                    </li>
                                    <li>
                                        <a href="#" id="havale_cikis">EFT/Havale Çıkış</a>
                                    </li>
                                    <li>
                                        <a href="#" id="banka_virman">Banka Virman</a>
                                    </li>
                                    <li>
                                        <a href="#" id="doviz_alim">Döviz Alım</a>
                                    </li>
                                    <li>
                                        <a href="#" id="doviz_satim">Döviz Satım</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Pos İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="pos_hesap_tanim">Pos Tanımları</a>
                                    </li>
                                    <li>
                                        <a href="#" id="pos_cekimi_giris">Pos Çekimi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="pos_tahsil_main">Pos Tahsili</a>
                                    </li>
                                    <li>
                                        <a href="#" id="">Pos Raporları</a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                                            <li>
                                                <a href="pos_hesap_ekstresi">Pos Ekstresi</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Kredi Kartı İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="kredi_karti_tanimla">Kredi Kart Tanım</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kredi_kartindan_odeme">Karttan Ödeme</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kredi_kart_odemesi">Kart Borcu Ödeme</a>
                                    </li>
                                    <li>
                                        <a href="#" id="kredi_kart_acilis_fisi">Kredi Kart Açılış</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Banka Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="banka_hesap_ekstresi">Banka Ekstresi</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Kredi Kart Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="kredi_kart_hesap_ekstresi">Kredi Kart Ekstresi</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-list-alt"></i>ÇEK SENET</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="">Çek Stok</a>
                            </li>
                            <li>
                                <a href="#" id="">Çek İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="cek_acilis_fisi">Çek Açılış Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cek_senet_giris_bordrosu">Çek Giriş Bordrosu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cek_senet_cikis_bordrosu">Çek Çıkış Bordrosu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cek_senet_tahsil">Çek Tahsil</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cek_senet_odeme">Çek Ödeme</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Senet İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="senet_giris_bordrosu">Senet Açılış Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="senet_cikis_bordrosu">Senet Giriş Bordrosu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="senet_tahsil">Senet Tahsil</a>
                                    </li>
                                    <li>
                                        <a href="#" id="senet_odeme">Senet Ödeme</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Karşılıksız Çek İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="ciro_edilen_cek_karsiliksiz">Ciro Edilen Çek Karşılıksız</a>
                                    </li>
                                    <li>
                                        <a href="#" id="tahsile_verilen_cek_karsiliksiz">Tahsile Verilen Çek Karşılıksız</a>
                                    </li>
                                    <li>
                                        <a href="#" id="teminata_verilen_cek_karsiliksiz">Teminata Verilen Çek Karşılıksız</a>
                                    </li>
                                    <li>
                                        <a href="#" id="portfoydeki_karsiliksiz_cek">Portföydeki Çek Karşılıksız</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Çek Ve Senet Raporları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="verilen_cek_raporlari">Verilen Çek Ve Senet Listesi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="alinan_cek_raporlari">Alınan Çek Ve Senet Listesi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="odenecek_cek_ve_senetler">Ödenecek Çek Ve Senet Listesi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="karsiliksiz_cek_ve_senetler">Karşılıksız Çek Ve Senet Listesi</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-users"></i>PERSONEL YÖNETİMİ</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="">Personel İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="personel_tanimla">Personel Tanımla</a>
                                    </li>
                                    <li>
                                        <a href="#" id="maas_tahakkuk">Maaş Tahakkukları</a>
                                    </li>
                                    <li>
                                        <a href="#" id="personel_izin">Personel İzin</a>
                                    </li>
                                    <li>
                                        <a href="#" id="personel_devamsizlik">Personel Devamsızlık</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Personel Tanımları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="gorev_tanim">Görev Tanım</a>
                                    </li>
                                    <li>
                                        <a href="#" id="departman_tanim">Departman Tanım</a>
                                    </li>
                                    <li>
                                        <a href="#" id="meslek_tanim">Meslek Tanım</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-car"></i>TAŞITLAR</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="binek_arac_tanim">Araç Tanım</a>
                            </li>
                            <li>
                                <a href="#" id="">Yakıt İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="yakit_alim_fisleri">Yakıt Alım Fişi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="binek_yakit_alim_faturasi">Yakıt Alım Faturası</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Sanayi İşlemleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="binek_sanayi_fisleri">Sanayi Fişleri</a>
                                    </li>
                                    <li>
                                        <a href="#" id="binek_sanayi_faturalari">Sanayi Faturaları</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Araç Giderleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="binek_hgs_gideri">HGS Giderleri</a>
                                    </li>
                                    <li>
                                        <a href="#" id="binek_vergi_gider">Vergi Ve Diğer</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-file"></i>YÖNETİM RAPORLARI</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="bilanco_raporlari">Bilanço Raporları</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id=""><i class="fa fa-cog"></i>TANIMLAMALAR</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="#" id="">Cari Parametreleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="bilanco_tanimlari">Bilanço Tanımları</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cari_turu_tanim">Cari Türü</a>
                                    </li>
                                    <li>
                                        <a href="#" id="cari_grup_tanim">Cari Grubu</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Fatura Tanımları</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="fatura_turu_tanim">Fatura Türleri</a>
                                    </li>
                                    <li>
                                        <a href="#" id="fatura_tipi_tanim">Fatura Tipleri</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" id="">Stok Parametreleri</a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="#" id="birim_tanim">Birim</a>
                                    </li>
                                    <li>
                                        <a href="#" id="ana_grup">Stok Ana Grubu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="alt_grup">Stok Alt Grubu</a>
                                    </li>
                                    <li>
                                        <a href="#" id="marka_listesi_main">Marka Listesi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="model_listesi_main">Model Listesi</a>
                                    </li>
                                    <li>
                                        <a href="#" id="depo_listesi_main">Depolar</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#" id="users_root"><i class="fa fa-users"></i>KULLANICILAR</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header" action="" method="POST">
                            <input class="au-input au-input--xl" type="text" name="search" placeholder="Üye Ara..."/>
                            <button class="au-btn--submit" type="submit">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </form>
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="../assets/images/icon/avatar-01.jpg" alt="John Doe"/>
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#">john doe</a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <a href="#">
                                                    <img src="../assets/images/icon/avatar-01.jpg" alt="John Doe"/>
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#">john doe</a>
                                                </h5>
                                                <span class="email">johndoe@example.com</span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-account"></i>Account</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="#">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content admin-modal-icerik">
            <div class="getModals"></div>
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Anasayfa</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-25">
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c1">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-account-o"></i>
                                        </div>
                                        <div class="text">
                                            <h2>10368</h2>
                                            <span>members online</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart">
                                        <canvas id="widgetChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c2">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-shopping-cart"></i>
                                        </div>
                                        <div class="text">
                                            <h2>388,688</h2>
                                            <span>items solid</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart">
                                        <canvas id="widgetChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c3">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-calendar-note"></i>
                                        </div>
                                        <div class="text">
                                            <h2>1,086</h2>
                                            <span>this week</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart">
                                        <canvas id="widgetChart3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview-item overview-item--c4">
                                <div class="overview__inner">
                                    <div class="overview-box clearfix">
                                        <div class="icon">
                                            <i class="zmdi zmdi-money"></i>
                                        </div>
                                        <div class="text">
                                            <h2>$1,060,386</h2>
                                            <span>total earnings</span>
                                        </div>
                                    </div>
                                    <div class="overview-chart">
                                        <canvas id="widgetChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="au-card recent-report">
                                <div class="au-card-inner">
                                    <h3 class="title-2">recent reports</h3>
                                    <div class="chart-info">
                                        <div class="chart-info__left">
                                            <div class="chart-note">
                                                <span class="dot dot--blue"></span>
                                                <span>products</span>
                                            </div>
                                            <div class="chart-note mr-0">
                                                <span class="dot dot--green"></span>
                                                <span>services</span>
                                            </div>
                                        </div>
                                        <div class="chart-info__right">
                                            <div class="chart-statis">
                                                    <span class="index incre">
                                                        <i class="zmdi zmdi-long-arrow-up"></i>25%</span>
                                                <span class="label">products</span>
                                            </div>
                                            <div class="chart-statis mr-0">
                                                    <span class="index decre">
                                                        <i class="zmdi zmdi-long-arrow-down"></i>10%</span>
                                                <span class="label">services</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recent-report__chart">
                                        <canvas id="recent-rep-chart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="au-card chart-percent-card">
                                <div class="au-card-inner">
                                    <h3 class="title-2 tm-b-5">char by %</h3>
                                    <div class="row no-gutters">
                                        <div class="col-xl-6">
                                            <div class="chart-note-wrap">
                                                <div class="chart-note mr-0 d-block">
                                                    <span class="dot dot--blue"></span>
                                                    <span>products</span>
                                                </div>
                                                <div class="chart-note mr-0 d-block">
                                                    <span class="dot dot--red"></span>
                                                    <span>services</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="percent-chart">
                                                <canvas id="percent-chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="title-1 m-b-25">Earnings By Items</h2>
                            <div class="table-responsive table--no-card m-b-40">
                                <table class="table table-borderless table-striped table-earning">
                                    <thead>
                                    <tr>
                                        <th>date</th>
                                        <th>order ID</th>
                                        <th>name</th>
                                        <th class="text-right">price</th>
                                        <th class="text-right">quantity</th>
                                        <th class="text-right">total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>2018-09-29 05:57</td>
                                        <td>100398</td>
                                        <td>iPhone X 64Gb Grey</td>
                                        <td class="text-right">$999.00</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-28 01:22</td>
                                        <td>100397</td>
                                        <td>Samsung S8 Black</td>
                                        <td class="text-right">$756.00</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">$756.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-27 02:12</td>
                                        <td>100396</td>
                                        <td>Game Console Controller</td>
                                        <td class="text-right">$22.00</td>
                                        <td class="text-right">2</td>
                                        <td class="text-right">$44.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-26 23:06</td>
                                        <td>100395</td>
                                        <td>iPhone X 256Gb Black</td>
                                        <td class="text-right">$1199.00</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">$1199.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-25 19:03</td>
                                        <td>100393</td>
                                        <td>USB 3.0 Cable</td>
                                        <td class="text-right">$10.00</td>
                                        <td class="text-right">3</td>
                                        <td class="text-right">$30.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-29 05:57</td>
                                        <td>100392</td>
                                        <td>Smartwatch 4.0 LTE Wifi</td>
                                        <td class="text-right">$199.00</td>
                                        <td class="text-right">6</td>
                                        <td class="text-right">$1494.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-24 19:10</td>
                                        <td>100391</td>
                                        <td>Camera C430W 4k</td>
                                        <td class="text-right">$699.00</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">$699.00</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-22 00:43</td>
                                        <td>100393</td>
                                        <td>USB 3.0 Cable</td>
                                        <td class="text-right">$10.00</td>
                                        <td class="text-right">3</td>
                                        <td class="text-right">$30.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <h2 class="title-1 m-b-25">Top countries</h2>
                            <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                                <div class="au-card-inner">
                                    <div class="table-responsive">
                                        <table class="table table-top-countries">
                                            <tbody>
                                            <tr>
                                                <td>United States</td>
                                                <td class="text-right">$119,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>Australia</td>
                                                <td class="text-right">$70,261.65</td>
                                            </tr>
                                            <tr>
                                                <td>United Kingdom</td>
                                                <td class="text-right">$46,399.22</td>
                                            </tr>
                                            <tr>
                                                <td>Turkey</td>
                                                <td class="text-right">$35,364.90</td>
                                            </tr>
                                            <tr>
                                                <td>Germany</td>
                                                <td class="text-right">$20,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>France</td>
                                                <td class="text-right">$10,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>Australia</td>
                                                <td class="text-right">$5,366.96</td>
                                            </tr>
                                            <tr>
                                                <td>Italy</td>
                                                <td class="text-right">$1639.32</td>
                                            </tr>
                                            </tbody>
                                        </table>
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


</body>

</html>
<!-- end document-->
<script>
    $("body").off("click", "#uye_tanimla").on("click", "#uye_tanimla", function () {
        $.get("view/uye_tanim.php", function (getModal) {
            $(".admin-modal-icerik").html(getModal);
        })
    })
    $("body").off("click", "#cari_tanimla").on("click", "#cari_tanimla", function () {
        $.get("view/cari_tanimla.php", function (getModal) {
            $(".admin-modal-icerik").html(getModal);
        })
    })
    $("body").off("click", "#cari_acilis_fisi").on("click", "#cari_acilis_fisi", function () {
        $.get("view/cari_acilis_fisi.php", function (getModal) {
            $(".admin-modal-icerik").html(getModal);
        })
    })
    $("body").off("click", "#mahsup_fisleri").on("click", "#mahsup_fisleri", function () {
        $.get("view/mahsup_fisleri.php", function (getModal) {
            $(".admin-modal-icerik").html(getModal);
        })
    })
    $("body").off("click", "#cari_hesap_ekstre").on("click", "#cari_hesap_ekstre", function () {
        $.get("view/cari_hesap_ekstre.php", function (getModal) {
            $(".admin-modal-icerik").html(getModal);
        })
    })
    $("body").off("click", "#cari_raporlari").on("click", "#cari_raporlari", function () {
        $.get("view/cari_raporlari.php", function (getList) {
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

    $("body").off("click", "#bilanco_raporlari").on("click", "#bilanco_raporlari", function () {
        $.get("rapor_view/bilanco_raporlari.php", function (getList) {
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
    $("body").off("click", "#users_root").on("click", "#users_root", function () {
        $.get("admin_views/user_config.php", function (getList) {
            $(".admin-modal-icerik").html(getList);
        });
    });

</script>
