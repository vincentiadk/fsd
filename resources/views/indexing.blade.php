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
<form method="POST" action="{{ url('admin/nasabah/store') }}">
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
        </section>
        @else
        <!-- Main content -->
        <section class="content pb-3">
            <div class="container-fluid h-100">
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
                <div class="card card-row card-secondary">
                    <input type="hidden" name="id_nasabah" value="{{ $data['nasabah']->id }}">
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Provinsi
                                    </span>
                                </div>
                                <input type="text"
                                    value="{{ $data['nasabah']->provinsi ? $data['nasabah']->provinsi->name : ''}}"
                                    class="form-control" @if(session("role_id")==4) readonly @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kota / Kabupaten
                                    </span>
                                </div>
                                <input type="text"
                                    value="{{ $data['nasabah']->kabupaten ? $data['nasabah']->kabupaten->name : ''}}"
                                    class="form-control" @if(session("role_id")==4) readonly @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kecamatan
                                    </span>
                                </div>
                                <input type="text"
                                    value="{{ $data['nasabah']->kecamatan ? $data['nasabah']->kecamatan->name : ''}}"
                                    class="form-control" @if(session("role_id")==4) readonly @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Kelurahan
                                    </span>
                                </div>
                                <input type="text"
                                    value="{{ $data['nasabah']->kelurahan ? $data['nasabah']->kelurahan->name : '' }}"
                                    class="form-control" @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
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
                                    @if(session("role_id")==4) readonly @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            @if(session("role_id") == 3)
                            <button class="btn btn-primary" type="submit">Update</button>
                            @endif
                            @if(session("role_id") == 4)
                            <input type='button' name="submit" class="btn btn-warning" value="Salah">
                            <input type='button' name="submit" class="btn btn-danger" value="Tolak">
                            <input type='button' name="submit" class="btn btn-success" value="Benar">
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
pdfjsLib.getDocument('{{ $data["file"] }}').then((pdf) => {
    qr.pdf = pdf;
    ktp.pdf = pdf;
    formulir.pdf = pdf;
    kk.pdf = pdf;
    renderOnCanvas("pdf_qr", qr);
    renderOnCanvas("pdf_ktp", ktp);
    renderOnCanvas("pdf_formulir", formulir);
    renderOnCanvas("pdf_kk", kk);
});

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
</script>

// more