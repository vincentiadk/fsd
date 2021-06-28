<div class="content-wrapper">
    <form action="/admin/map/store" method="post" enctype="multipart/form-data" id="form_data">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">

                        {{ csrf_field() }}
                        <!-- Default box -->
                        <div class="card card-row card-primary card-tabs">
                            <div class="card-header">
                                <h3 class="card-title">Map Simpan</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger" id="validasi_element" style="display:none;">
                                    <ul id="validasi_content"></ul>
                                </div>
                                <div class="form-group">
                                    <label>Map</label>
                                    <input name="map" type="text" id="map_simpan" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Dokumen</label>
                                    <input type="text" id="no_rek" class="form-control">
                                </div>
                                <div class="form-group">
                                    <select multiple class="form-control" readonly id="no_rek_choose" name="no_rek[]" style="min-height:150px">
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" onclick="simpan()">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-row card-secondary card-tabs">
                            <div class="card-header">
                                <h3 class="card-title">Isi Map</h3>
                            </div>
                            <div class="card-body">
                                <div id="isi_map" style="min-height: 400px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>
</div>
<script>
$('#no_rek').on({
    keyup: function() {
        typed_into = true;
        if ($(this).val().length == 11) {
            $('#no_rek_choose').append('<option value="' + $(this).val() + '" selected>' + $(this).val() +
                '</option>');
            $(this).val('');
        }
    },
    change: function() {
        if (typed_into) {
            typed_into = false; //reset type listener
        } else { //barcode
            if ($(this).val().length == 11) {
                $('#no_rek_choose').append('<option value="' + $(this).val() + '" selected>' + $(this)
                    .val() +
                    '</option>');
                $(this).val('');
            }
        }
    },
});

function getRekening() {
    $.ajax({
        url: '{{ url("admin/select2/map") }}',
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            map: $('#map_simpan').val()
        },
        success: function(response) {
            $('#isi_map').html('');
            $.each(response, function(i, val) {
                $('#isi_map').append('<li>' + val.no_rek +' | ' +val.nama+ ' </li>');
            })
        }
    });
}
$('#map_simpan').on({
    change: function() {
        getRekening();
    }
});

function simpan() {
    event.preventDefault();
    var id_ = $('#id_user').val();
    var formData = new FormData($('#form_data')[0]);
    $.ajax({
        url: '{{ url("admin/map/store") }}',
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            loadingOpen('.content');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.content');
            if (response.status == 200) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            } else if (response.status == 422) {
                $('#validasi_element').show();
                Toast.fire({
                    icon: 'info',
                    title: 'Validasi'
                });

                $.each(response.error, function(i, val) {
                    $('#validasi_content').append('<li>' + val + '</li>');
                })
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: response.message
                });
            }
            $('#no_rek_choose').html('');
            getRekening();
        },
        error: function() {
            loadingClose('.content');
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }

    });
}
</script>