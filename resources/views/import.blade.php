<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3>Import Database </h3>
            </div>
            <div class="card-body">
            <button onclick="refreshDropZone()" class="btn btn-danger"><i class="fas fa-trash"></i> Clear All</button>
                <form method="post" action="/admin/import" method="post" enctype="multipart/form-data" class="dropzone"
                    id="dropzone">
                    @csrf
                </form>
                <div id="keterangan_dropzone"></div>
            </div>
        </div>
    </section>
</div>

<script>
Dropzone.options.dropzone = {
        maxFilesize: 100,
        acceptedFiles: ".xls, .xlsx",
        addRemoveLinks: true,
        timeout: 50000,
        success: function(file, response) {
            if (response.status == 422) {
                $(file.previewElement).addClass("dz-error").find('.dz-error-message').text('Gagal');
                $.each(response.error, function(i, val) {
                        error_text += '<li>' + val + '</li>' ;
                });
            $('#keterangan_dropzone').append('<li>' + response.file_name + ' gagal diimport. <ul>' + error_text +
                '</ul></li>');
        } else {
            $('#keterangan_dropzone').append('<li>' + response.file_name + ' berhasil diimport. Import : ' + response.import+
                ', Skip : ' + response.skip + '</li>');
        }
    },
    error: function(file, response) {
        $('#keterangan_dropzone').append('<li>'+file.name +' : ' +response +'</li>');
        return false;
    }
};
</script>