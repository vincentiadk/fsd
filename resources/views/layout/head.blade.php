<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>-->
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/waitMe/waitMe.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/dropzone/min/dropzone.min.css') }}">
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('template/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('template/plugins/waitMe/waitMe.min.js') }}"></script>
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!--<script src="{{ asset('template/dist/js/demo.js') }}"></script>-->
</head>
<script>

bsCustomFileInput.init();

function loadingOpen(selector) {
    $(selector).waitMe({
        effect: 'progressBar',
        text: 'Mohon Tunggu ...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000'
    });
}

function loadingClose(selector) {
    $(selector).waitMe('hide');
}

const Toast = Swal.mixin({
    toast: true,
    position: 'middle-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function refreshDropZone() {
    var myDropzone = Dropzone.forElement("#dropzone");
    myDropzone.removeAllFiles(true);
    $('#keterangan_dropzone').html('');
}

function select2AutoSuggest(selector, endpoint, sourcepoint = '') {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 1,
        allowClear: true,
        cache: true,
        ajax: {
            url: '{{ url("admin/select2") }}' + '/' + endpoint,
            type: 'POST',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    sourcepoint: $('#' + sourcepoint).val()
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        }
    });
}

function select2AutoSuggestMultiple(selector, endpoint) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 3,
        allowClear: true,
        multiple: true,
        cache: true,
        ajax: {
            url: '{{ url("admin/select2") }}' + '/' + endpoint,
            type: 'POST',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        }
    });
}

function select2AutoSuggestTags(selector, endpoint) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 3,
        allowClear: true,
        tags: true,
        cache: true,
        ajax: {
            url: '{{ url("admin/select2") }}' + '/' + endpoint,
            type: 'POST',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            } else {
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }
    });
}
</script>