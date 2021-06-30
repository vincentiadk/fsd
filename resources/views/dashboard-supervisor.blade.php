<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>
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
                            <table class="table table-striped table-bordered nowrap" id="datatable_realtime" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Dikerjakan</th>
                                        <th>Benar</th>
                                        <th>Salah</th>
                                        <th>Ditolak</th>
                                        <th>Tunggu</th>
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
$('#datatable_realtime').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    order: [
        [0, 'desc']
    ],
    iDisplayInLength: 10,
    ajax: {
        url: '{{ url("admin/dashboard/datatable-realtime") }}',
        data: {},
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: 'POST',
    },
    columns: [
        {
            name: 'tanggal',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'dikerjakan',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'benar',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'salah',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'ditolak',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            name: 'tunggu',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        }
    ]
});
</script>