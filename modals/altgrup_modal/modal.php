<div class="modal fade" id="altgrup_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 35%; max-width: 35%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat" aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>ALT GRUP TANIMLA</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Ana Grup Adı</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="ana_grupid">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Alt Grup Adı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="altgrup_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control form-control-sm" id="aciklama" cols="30"
                                              rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="altgrup_ekle_button">Alt Grup Tanımla</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#altgrup_modal").modal("show");
            $.get("controller/altgrup_controller/sql.php?islem=anagrup_adi_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var anagrup_adi = item.ana_grup_adi
                        $("#ana_grupid").append("" +
                            "<option value='" + item.id + "'>" + anagrup_adi.toUpperCase() + "</option>" +
                            "");
                    });
                }
            })
        });


        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#altgrup_modal").modal("hide");
        })

        $("body").off("click", "#altgrup_ekle_button").on("click", "#altgrup_ekle_button", function (result) {
            var ana_grupid = $("#ana_grupid").val();
            var altgrup_adi = $("#altgrup_adi").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/altgrup_controller/sql.php?islem=alt_grup_ekle",
                type: "POST",
                data: {
                    ana_grupid: ana_grupid,
                    altgrup_adi: altgrup_adi,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Alt Grup Tanımlandı',
                            'success'
                        );
                        $.get("view/stok_alt_grup_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/stok_alt_grup_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                    }
                }
            })
        });

    </script>