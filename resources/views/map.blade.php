<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form action="/admin/import" method="post" enctype="multipart/form-data">
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
                        <input name="no_rek" type="text" id="no_rek" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>