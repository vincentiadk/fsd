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
                                <a href="/admin/user/view/0" class="btn btn-primary"> Tambah </a>
                            </div>
                            <table class="table table-striped table-bordered nowrap" id="datatable_serverside"
                                style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
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
                    <h4 class="modal-title" id="myModalLabel50">Konfirmasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Anda yakin akan <span id="spanLock"></span>? </h4>
                    <p id="pLock" style="color:orange"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btn_save_lock">Ya</button>
                    <button type="button" class="btn btn-danger" onclick="cancel()" id="btn_cancel_lock">Batal</button>
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
        url: '{{ url("admin/user/datatable") }}',
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
            name: 'username',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'email',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'role',
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

function disableUser(id) {
    getUser(id, 0);
    $('#modal_confirmation').modal('show');
}

function enableUser(id) {
    getUser(id, 1);
    $('#modal_confirmation').modal('show');
}

function getUser(id, type) {
    $.ajax({
        url: '{{ url("admin/select2/user") }}',
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
            if (type == 1) {
                $('#spanLock').html('<b>membuka blokir</b> User : ' + response.name);
                $('#pLock').html(
                    '*) Setelah dibuka blokir, user dapat login ke dalam sistem dan melakukan pekerjaannya kembali.'
                );
                $('#btn_save_lock').attr('onclick', 'doDisableEnable(' + id + ', 1)');
            } else {
                $('#spanLock').html('<b>memblokir</b> User : ' + response.name);
                $('#pLock').html('*) Setelah diblokir, user <b>tidak dapat</b> login ke dalam sistem.');
                $('#btn_save_lock').attr('onclick', 'doDisableEnable(' + id + ', 0)');
            }
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

function doDisableEnable(id, type) {
    if (type == 1) {
        var ajax_url = '{{ url("admin/user/enable") }}';
    } else {
        var ajax_url = '{{ url("admin/user/disable") }}';
    }
    $.ajax({
        url: ajax_url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
            id: id,
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
            $('#modal_confirmation').modal('hide');
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