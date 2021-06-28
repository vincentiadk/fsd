<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form action="/admin/map/store" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Map Simpan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Map</label>
                        <input name="map_simpan" type="text" id="map_simpan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dokumen</label>
                        <select name="no_rek"  class="form-control">
                            @foreach($data['nasabah'] as $nasabah)
                            <option value="{{ $nasabah->id }}" > {{ $nasabah->no_rek }} </option>>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Simpan</button>    
                <div class="form-group">
                    </div>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>