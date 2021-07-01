<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger" id="validasi_element" style="display:none;">
                                <ul id="validasi_content"></ul>
                            </div>
                            <div style="float:right" class="row">
                                <a href="" class="btn btn-primary" onclick="tambah()"> Tambah </a>
                            </div>
                            <table class="table table-striped table-bordered nowrap" id="datatable_serverside"
                                style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <div class="modal animated bounceInRight text-left" id="modal_confirmation" data-backdrop="static" role="dialog"
        aria-labelledby="myModalLabel50" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" id="id_role" name="id_rol">
                    <div class="form-group">
                        <label>Nama Role Akses</label>
                        <input type="text" class="form-control" id="role_name" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="simpan()">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="cancel()" id="btn_cancel">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var oTable = $('#datatable_serverside').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    order: [
        [0, 'desc']
    ],
    iDisplayInLength: 10,
    ajax: {
        url: '{{ url("admin/role/datatable") }}',
        data: {},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
    },
    columns: [{
            name: 'no',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'nama',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'aksi',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        }
    ]
});
function edit(id) {
    $('#modal_confirmation').modal('show');
    getRole(id);
}
function tambah() {
    $('#modal_confirmation').modal('show');
}
function cancel() {
    $('#id_role').val('');
    $('#role_name').value('');
    $('#modal_confirmation').modal('hide');
  }
function getRole(id) {
    event.preventDefault();
    $.ajax({
        url: '{{ url("admin/select2/role") }}',
        type: 'POST',
        dataType: 'JSON',
        data : {
            id : id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            loadingOpen('.modal-content');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.modal-content');
            $('#id_role').val(response.id);
            $('#role_name').val(response.name);
        },
        error: function() {
            loadingClose('.modal-content');
            cancel();
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    })
}

function simpan() {
    $.ajax({
        url: '{{ url("admin/role/store") }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
            id: $('#id_role').val(),
            name: $('#role_name').val(),
        },
        dataType: 'JSON',
        beforeSend: function() {
            loadingOpen('.modal-content');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.modal-content');
            if (response.status == 200) {
                oTable.ajax.reload(null, false);
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            } else if (response.status == 422) {
                Toast.fire({
                    icon: 'info',
                    title: 'Validasi'
                });
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: response.message
                });
            }
            cancel();
        },
        error: function() {
            loadingClose('.modal-content');
            cancel();
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    })
}
</script>