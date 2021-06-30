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
                <button onclick="downloadExcel()" class="btn btn-primary"> Export Data </button>
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
function downloadExcel() {
    $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            url: '{{ url("admin/performance/export") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                loadingOpen('.content');
            },
            data: {
            },
            success: function(result, status, xhr) {
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'performance'+ (Math.floor(Math.random() * 90000) + 10000)+'.xlsx');

                // The actual download
                var blob = new Blob([result], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
                loadingClose('.content');
            }
        });
    }
</script>