<style>
#canvas_container {
    width: 100%;
    height: 500px;
    overflow: auto;
    background: #333;
    text-align: center;
    border: solid 3px;
}

.content-wrapper.kanban .card.card-row {
    width: 500px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
</script>
<form method="POST" action="{{ url('admin/nasabah/store') }}" id="form_data">
    @csrf
    <div class="content-wrapper kanban">
        @if($data['nasabah'] == [] )
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Indexing</h3>
                </div>
                <div class="card-body text-center">
                    <div style="height:300px">
                        <h1>BELUM ADA DATA BARU</h1>
                    </div>
                </div>
            </div>
        </section>
        @else
        <!-- Main content -->
        <section class="content pb-3">
            <div class="container-fluid h-100">
                <div class="alert alert-danger" id="validasi_element" style="display:none;">
                    <ul id="validasi_content"></ul>
                </div>
                @if($data['file'] == '')
                <div class="card card-row card-primary card-tabs" style="width:700px">
                    <div class=" card-header">
                        <h3 class="card-title">Indexing</h3>
                    </div>
                    <div class="card-body text-center">
                        <div style="height:300px">
                            <h1>FILE BELUM DIUPLOAD</h1>
                        </div>
                    </div>
                </div>
                @else
                <div class="card card-row card-primary card-tabs" style="width:700px">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="pt-2 px-3">
                                <h3 class="card-title">File Nasabah</h3>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="qr-tab" data-toggle="pill" href="#qr" role="tab"
                                    aria-controls="qr" aria-selected="true">QR</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ktp-tab" data-toggle="pill" href="#ktp" role="tab"
                                    aria-controls="ktp" aria-selected="false">KTP</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="formulir-tab" data-toggle="pill" href="#formulir" role="tab"
                                    aria-controls="formulir" aria-selected="false">Formulir</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="kk-tab" data-toggle="pill" href="#kk" role="tab"
                                    aria-controls="kk" aria-selected="false">KK</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="tab-pane fade show active" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                                <div id="canvas_container">
                                    <canvas id="pdf_qr"></canvas>
                                </div>
                                <div id="zoom_controls">
                                    <button class="btn btn-secondary" onclick="zoomIn('pdf_qr')">+</button>
                                    <button class="btn btn-secondary" onclick="zoomOut('pdf_qr')">-</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ktp" role="tabpanel" aria-labelledby="ktp-tab">
                                <div id="canvas_container">
                                    <canvas id="pdf_ktp"></canvas>
                                </div>
                                <div id="zoom_controls">
                                    <button class="btn btn-secondary" onclick="zoomIn('pdf_ktp')">+</button>
                                    <button class="btn btn-secondary" onclick="zoomOut('pdf_ktp')">-</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="formulir" role="tabpanel" aria-labelledby="formulir-tab">
                                <div id="canvas_container">
                                    <canvas id="pdf_formulir"></canvas>
                                </div>
                                <div id="zoom_controls">
                                    <button class="btn btn-secondary" onclick="zoomIn('pdf_formulir')">+</button>
                                    <button class="btn btn-secondary" onclick="zoomOut('pdf_formulir')">-</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="kk" role="tabpanel" aria-labelledby="kk-tab">
                                <div id="canvas_container">
                                    <canvas id="pdf_kk"></canvas>
                                </div>
                                <div id="zoom_controls">
                                    <button class="btn btn-secondary" onclick="zoomIn('pdf_kk')">+</button>
                                    <button class="btn btn-secondary" onclick="zoomOut('pdf_kk')">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                @endif
                <div class="card card-row card-secondary">
                    <input type="hidden" name="id_nasabah" value="{{ $data['nasabah']->id }}">
                    <input type="hidden" id="stream_pdf" value="{{ url('admin/nasabah/stream_pdf?id='. $data['nasabah']->nama_file ) }}">
                    <div class="card-header">
                        <span> CIF number : {{ $data['nasabah']->cif }} </span>
                        <span style="float:right"> No Rekening : {{ $data['nasabah']->no_rek }}</span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Nama
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->nama}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        No KTP
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->no_identitas}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="no_identitas">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Alamat
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->alamat_1}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="alamat_1">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        RT
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->rt}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="rt">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        RW
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->rw}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="rw">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Provinsi
                                    </span>
                                </div>
                                <select name="provinsi_id" class="form-control" @if(session("role_id")!=3) disabled
                                    @endif id="provinsi_id">
                                    @foreach(App\Models\Provinsi::all() as $provinsi)
                                    <option value="{{ $provinsi->id }}" @if($data['nasabah']->provinsi_id ==
                                        $provinsi->id) selected @endif>{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kota / Kabupaten
                                    </span>
                                </div>
                                @if(session('role_id') != 3)
                                <input type="text"
                                    value="{{ $data['nasabah']->kabupaten ? $data['nasabah']->kabupaten->name : ''}}"
                                    class="form-control" disabled>
                                @else
                                <select name="kabupaten_id" class="form-control" id="kabupaten_id">
                                @if($data['nasabah']->kabupaten)
                                <option value="{{ $data['nasabah']->kabupaten->id }}" selected>{{$data['nasabah']->kabupaten->name}}</option>
                                @endif
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kecamatan
                                    </span>
                                </div>
                                @if(session('role_id') != 3)
                                <input type="text"
                                    value="{{ $data['nasabah']->kecamatan ? $data['nasabah']->kecamatan->name : ''}}"
                                    class="form-control" disabled>
                                @else
                                <select name="kecamatan_id" class="form-control" id="kecamatan_id">
                                @if($data['nasabah']->kecamatan)
                                <option value="{{ $data['nasabah']->kecamatan->id }}" selected>{{$data['nasabah']->kecamatan->name}}</option>
                                @endif
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kelurahan
                                    </span>
                                </div>
                                @if(session('role_id') != 3)
                                <input type="text"
                                    value="{{ $data['nasabah']->kelurahan ? $data['nasabah']->kelurahan->name : ''}}"
                                    class="form-control" disabled>
                                @else
                                <select name="kelurahan_id" class="form-control" id="kelurahan_id">
                                @if($data['nasabah']->kelurahan)
                                <option value="{{ $data['nasabah']->kelurahan->id }}" selected>{{$data['nasabah']->kelurahan->name}}</option>
                                @endif
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Nomor HP
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->telp_hp}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="telp_hp">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Email
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->email}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Nama Ibu Kandung
                                    </span>
                                </div>
                                <input type="text" value="{{ $data['nasabah']->nama_ibu_kandung}}" class="form-control"
                                    @if(session("role_id")!=3) readonly @endif name="nama_ibu_kandung">
                            </div>
                        </div>
                        <div class="form-group">
                            @if(session("role_id") == 3)
                            <button class="btn btn-primary" type="submit" onclick="simpan()">Update</button>
                            @endif
                            @if(session("role_id") == 4)
                            <input type="hidden" id="status" name="status">
                            <input type='submit' class="btn btn-danger" onclick="simpan('tolak')" value="Tolak">
                            <input type='submit' class="btn btn-warning" onclick="simpan('salah')" value="Salah">
                            <input type='submit' class="btn btn-success" onclick="simpan('benar')" value="Benar">
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @endif
    </div>
</form>
<script>
var qr = {
    pdf: null,
    currentPage: 1,
    zoom: 1
}
var ktp = {
    pdf: null,
    currentPage: 2,
    zoom: 2
}
var formulir = {
    pdf: null,
    currentPage: 3,
    zoom: 1
}
var kk = {
    pdf: null,
    currentPage: 4,
    zoom: 1
}
pdfjsLib.getDocument($('#stream_pdf').val()).then((pdf) => {
    qr.pdf = pdf;
    ktp.pdf = pdf;
    formulir.pdf = pdf;
    kk.pdf = pdf;
    renderOnCanvas("pdf_qr", qr);
    renderOnCanvas("pdf_ktp", ktp);
    renderOnCanvas("pdf_formulir", formulir);
    renderOnCanvas("pdf_kk", kk);
});

select2AutoSuggest('#kabupaten_id', 'kabupaten', 'provinsi_id');
select2AutoSuggest('#kecamatan_id', 'kecamatan', 'kabupaten_id');
select2AutoSuggest('#kelurahan_id', 'kelurahan', 'kecamatan_id');

function zoomIn(name) {
    event.preventDefault();
    if (name == "pdf_qr") {
        state = qr;
    }
    if (name == "pdf_ktp") {
        state = ktp;
    }
    if (name == "pdf_formulir") {
        state = formulir;
    }
    if (name == "pdf_kk") {
        state = kk;
    }
    state.zoom += 0.5;
    renderOnCanvas(name, state);
}

function zoomOut(name) {
    event.preventDefault();
    if (name == "pdf_qr") {
        state = qr;
    }
    if (name == "pdf_ktp") {
        state = ktp;
    }
    if (name == "pdf_formulir") {
        state = formulir;
    }
    if (name == "pdf_kk") {
        state = kk;
    }
    state.zoom -= 0.5;
    renderOnCanvas(name, state);
}

function renderOnCanvas(canvas_name, state) {
    state.pdf.getPage(state.currentPage).then((page) => {

        var canvas = document.getElementById(canvas_name);
        var ctx = canvas.getContext('2d');

        var viewport = page.getViewport(state.zoom);

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        page.render({
            canvasContext: ctx,
            viewport: viewport
        });
    });
}



function simpan(qc = null) {
    event.preventDefault();
    $('#status').val(qc);
    var formData = new FormData($('#form_data')[0]);
    $.ajax({
        url: '{{ url("admin/nasabah/store") }}',
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
                window.open('{{ url('') }}' + "/admin/nasabah/" + response.page, "_self");
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

// more