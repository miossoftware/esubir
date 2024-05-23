<?php

$islem = $_GET["islem"];

if ($islem == "kredi_kartlarini_getir") {
    ?>
    <div class="modal fade" id="kart_listesi_modal"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 30%; max-width: 30%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">Cari Listesi

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
        var table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kart_listesi_modal").modal("hide");
        })

        $(document).ready(function () {
            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_turu").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#kart_listesi_modal").modal("show");

            setTimeout(function () {

                $("#click1").trigger("click");

            }, 300);

            table = $('#fatura_cari_liste').DataTable({

                scrollY: '35vh',

                scrollX: true,

                "info": false,

                "paging": false,

                "dom": '<"pull-left"f><"pull-right"l>tip',

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "kart_adi"},
                    {'data': "kart_kodu"},
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

            $.get("controller/kart_controller/sql.php?islem=kredi_kartlarini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
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
            $("#kart_listesi_modal").modal("hide");
            $.get("controller/kart_controller/sql.php?islem=secilen_kart_bilgilerini_getir_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $(".secilen_kart").val(item.kart_kodu);
                    $(".secilen_kart").attr("data-id", item.id);
                    $(".kart_adi_getir").val(item.kart_adi);
                    $(".sube_adi_getir").val(item.kart_adi);
                }

            });

        })

    </script>
    <?php
}