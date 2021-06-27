<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form action="/admin/import" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Import File Excel</h3>

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
                    <div class="form-group">
                        <label for="exampleInputFile">File Excel</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input name="excel" type="file" class="custom-file-input" id="exampleInputFile"
                                    accept=".xls,.xlsx">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>