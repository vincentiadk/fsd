<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered display nowrap" id="datatable_serverside">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama user</th>
                            <th>Role</th>
                            <th>Upload</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Tolak</th>
                            <th>QC</th>
                            <th>Indexing</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </section>
</div>
<script>
$('.select2').select2({
    placeholder: '-- Pilih --'
});


var oTable = $('#datatable_serverside').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    iDisplayInLength: 10,
    orderable: false,
    searchable: false,
    ajax: {
        url: '{{ url("admin/performance/datatable") }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: function(d) {
            /*d.tanggal_lapor = $('#tanggal_lapor').val();
            d.tanggal_lapor_akhir = $('#tanggal_lapor_akhir').val();
            d.status_lapor = $('#status_lapor').val();
            d.status = $('#select_status').val();*/
        },
    },
    columns: [{
            name: "nomor"
        },
        {
            name: "role"
        },
        {
            name: "upload"
        },
        {
            name: "benar"
        },
        {
            name: "salah"
        },
        {
            name: "tolak"
        },
        {
            name: "qc"
        },
        {
            name: "indexing"
        },
        {
            name: "tuntas"
        },
    ]
});
</script>