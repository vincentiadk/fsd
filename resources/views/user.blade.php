<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Management</h3>
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
                            <a href="/admin/user/view/0" class="btn btn-primary"> Tambah </a>
                        </div>
                            <table class="table table-striped table-bordered nowrap" id="datatable_serverside" style="width:100%">
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
</div>
<script>
$('#datatable_serverside').DataTable({
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
        type: 'POST',
    },
    columns: [
        {
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
</script>