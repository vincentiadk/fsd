<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
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
                            <table class="table table-bordered table-hover nowrap" id="datatable_serverside" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Tuntas</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
<script>
$('#datatable_serverside').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    bAutoWidth: true,
    order: [
        [0, 'desc']
    ],
    iDisplayInLength: 10,
    ajax: {
        url: '{{ url("admin/dashboard/datatable-tuntas") }}',
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
            name: 'tuntas',
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
    ]
});
</script>