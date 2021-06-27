<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporting</h3>
                <table class="table">
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Status Lapor
                                    </span>
                                </div>
                                <select name="status_lapor" id="status_lapor" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="1">Sudah lapor</option>
                                    <option value="0">Belum lapor</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div id="div_tanggal_lapor">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Tanggal awal
                                        </span>
                                    </div>
                                    <input type="date" class="form-control float-right" id="tanggal_lapor">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Tanggal akhir
                                        </span>
                                    </div>
                                    <input type="date" class="form-control float-right" id="tanggal_lapor_akhir">
                                </div>
                            </div>
                            <div class="select2-purple" id="div_status">
                                <select class="select2" multiple="multiple" data-placeholder="Pilih status"
                                    data-dropdown-css-class="select2-purple" style="width: 100%;" id="select_status">
                                    <option>Kosong</option>
                                    <option>Baru</option>
                                    <option>Indexing</option>
                                    <option>Update</option>
                                    <option>QC</option>
                                    <option>Salah</option>
                                    <option>Tolak</option>
                                </select>
                            </div>
                        </td>
                        <td><button onclick="downloadExcel()" class="btn btn-primary"> Export Data </button></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background: blue; color:white;">
                                        Set tanggal lapor
                                    </span>
                                </div>
                                <input type="date" class="form-control float-right" id="set_lapor">
                                <button class="btn btn-primary" onclick="setTanggalLapor()">SET</button>
                            </div>

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered display nowrap" id="datatable_serverside">
                    <thead class="text-center">
                        <tr>
                            <th>Aksi</th>
                            <th>CIF</th>
                            <th>No Rek</th>
                            <th>Nama</th>
                            <th>Operator Index</th>
                            <th>Operator Upload</th>
                            <th>Status</th>
                            <th>Tgl Selesai</th>
                            <th>Tgl Laporan</th>
                            <th>Jenis Kelamin</th>
                            <th>No Identitas</th>
                            <th>NPWP</th>
                            <th>Status Kawin</th>
                            <th>Agama</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </section>
</div>
<script>
function setTanggalLapor() {
    var ids = [];
    if ($('#set_lapor').val() == '') {
        alert('Pilih tanggal lapor dulu!');
    } else {
        if (confirm('Apakah anda yakin?')) {
            $('#datatable_serverside').find("input:checkbox[name=chkReport]:checked").each(function() {
                ids.push($(this).val());
            });
            $.ajax({
                url: '{{ url("admin/report/set-tanggal-lapor") }}',
                type: 'POST',
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ids: ids,
                    set_lapor: $('#set_lapor').val()
                },
                success: function(data) {
                    oTable.ajax.reload(null, false);
                    alert(data);
                }
            });
        }
    }
}

function downloadExcel() {
    $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            url: '{{ url("admin/report/export") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                loadingOpen('content');
            },
            data: {
                tanggal_lapor: $('#tanggal_lapor').val(),
                tanggal_lapor_akhir: $('#tanggal_lapor_akhir').val(),
                status_lapor: $('#status_lapor').val(),
                status: $('#select_status').val()
            },
            success: function(result, status, xhr) {
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'nasabah'+ (Math.floor(Math.random() * 90000) + 10000)+'.xlsx');

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
                loadingClose('content');
            }
        });
    }
    $('#div_tanggal_lapor').hide();
    $('#tanggal_lapor').on('change', function() {
        if ($('#tanggal_lapor_akhir').val() == '') {
            $('#tanggal_lapor_akhir').val($(this).val());
        }
        oTable.ajax.reload(null, false);
    });
    $('#tanggal_lapor_akhir').on('change', function() {
        oTable.ajax.reload(null, false);
    });
    $('#status_lapor').on('change', function() {
        if ($(this).val() == '1') {
            $('#div_tanggal_lapor').show();
            $('#select_status').val('');
            $('#select_status').trigger('change');
            $('#div_status').hide();
        }
        if ($(this).val() == '') {
            $('#tanggal_lapor').val('')
            $('#div_status').show();
            $('#div_tanggal_lapor').hide();
        }
        if ($(this).val() == '0') {
            $('#div_tanggal_lapor').hide();
            $('#select_status').val('');
            $('#select_status').trigger('change');
            $('#div_status').hide();
        }
        oTable.ajax.reload(null, false);
    });
    $('#select_status').on('change', function() {
        oTable.ajax.reload(null, false);
    })
    var oTable = $('#datatable_serverside').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        iDisplayInLength: 10,
        orderable: false,
        searchable: false,
        ajax: {
            url: '{{ url("admin/report/datatable") }}',
            type: 'POST',
            data: function(d) {
                d.tanggal_lapor = $('#tanggal_lapor').val();
                d.tanggal_lapor_akhir = $('#tanggal_lapor_akhir').val();
                d.status_lapor = $('#status_lapor').val();
                d.status = $('#select_status').val();
            },
        },
        columns: [{
                name: "aksi"
            },
            {
                name: "cif"
            },
            {
                name: "no_rek"
            },
            {
                name: "nama"
            },
            {
                name: "index_user"
            },
            {
                name: "upload_user"
            },
            {
                name: "status"
            },
            {
                name: "index_time"
            },
            {
                name: "tanggal_lapor"
            },
            {
                name: "jenis_kelamin"
            },
            {
                name: "no_identitas"
            },
            {
                name: "npwp"
            },
            {
                name: "status_kawin"
            },
            {
                name: "agama"
            }
        ]
    });
</script>