<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h3>Upload File Nasabah dalam PDF </h3>
        <form method="post" action="{{url('admin/upload/store')}}" enctype="multipart/form-data" class="dropzone"
            id="dropzone">
            @csrf
        </form>
        <!-- /.card -->
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div id="keterangan"></div>
            </div>
    </section>
</div>
<script>
Dropzone.options.dropzone = {
    maxFilesize: 10,
    acceptedFiles: ".pdf",
    addRemoveLinks: true,
    timeout: 50000,
    success: function(file, response) {
        if (response.status == "gagal") {
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.message);
        }
        $('#keterangan').append('<li>'+response.message+'</li>');
        console.log(response.data);
    },
    error: function(file, response) {
        return false;
    }
};
</script>