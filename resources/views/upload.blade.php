<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3>Upload File Nasabah dalam PDF </h3>
                
            </div>
            <div class="card-body">
                <button onclick="refreshDropZone()" class="btn btn-danger"><i class="fas fa-trash"></i> Clear All</button>
                <form method="post" action="{{url('admin/upload/store')}}" enctype="multipart/form-data" class="dropzone"
                    id="dropzone">
                    @csrf
                </form>
                <div id="keterangan_dropzone"></div>
            </div>
        </div>
            <!-- /.card -->
    </section>
</div>
<script>
    Dropzone.options.dropzone = {
    maxFilesize: 20,
    acceptedFiles: ".pdf",
    addRemoveLinks: true,
    timeout: 50000,
    success: function(file, response) {
        if (response.status == "gagal") {
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.message);
        }
        $('#keterangan_dropzone').append('<li>'+response.message+'</li>');
        console.log(response.data);
    },
    error: function(file, response) {
        return false;
    }
};
</script>