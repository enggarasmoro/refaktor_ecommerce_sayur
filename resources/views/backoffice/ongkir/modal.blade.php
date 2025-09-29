<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ongkos Kirim</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="alert alert-danger alert-block" style="display: none;>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
            <form id="form" class="parsley-ongkir">
                @csrf
                <div class="modal-body p-4">
                    <?php $value = (isset($ongkir->id))?$ongkir->id:""; ?>
                    <input type="hidden" name="id" value="{{$value}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($ongkir->min_trans))?$ongkir->min_trans:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Minimal Transaksi</label>
                                <input type="number" min="0"  id="min_trans" name="min_trans" class="form-control"  value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($ongkir->ongkir))?$ongkir->ongkir:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Ongkir</label>
                                <input type="number" min="0"  id="ongkir" name="ongkir" class="form-control"  value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <?php $value = (isset($ongkir->status))?$ongkir->status:""; ?>
                            <p class="text-muted mt-3 mb-2">Status</p>
                            <div class="radio radio-info form-check-inline">
                                <input type="radio" id="status1" value= 1 name="status" {{($value == 1)?"checked":"checked"}}>
                                <label class="font-weight-bold text-dark text-2">Aktif</label>
                            </div>
                            <div class="radio form-check-inline">
                                <input type="radio" id="status2" value= 0 name="status" {{($value == 0)?"checked":""}}>
                                <label class="font-weight-bold text-dark text-2">Non Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#myModal").modal('show');
    $(".parsley-ongkir").parsley();
    $("#form").on("submit", (function(b) {
        b.preventDefault();
        var url;
        var type = "{{$type}}";
        if (type == "simpan") {
            url = "{{route('ongkir.create')}}"
        } else {
            url = "{{route('ongkir.edit')}}"
        }
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: !1,
            cache: !1,
            processData: !1,
            success: function(data) {
                // data = JSON.parse(c);
                if (data.errorsvalidation) {
                    $('.alert-danger').html('');
                    $.each(data.errorsvalidation, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                }else if(data.success){
                    $("#myModal").modal("hide");
                    Swal.fire({
                        title: "Sukses",
                        text: data.success,
                        type: "success"
                    }).then(function() {
                        $('#master_ongkir').DataTable().ajax.reload();
                    });
                } else {
                    $("#myModal").modal("hide");
                    Swal.fire({
                        title: "Error",
                        text: data.errors,
                        type: "error"
                    });
                }
            },
            error: function(c, e, d) {
                $("#myModal").modal("hide");
                Swal.fire("Error", "Gagal Memproses Data", "error")
            }
        });
        return !1
    }));
</script>