<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form action="/admin/user/store" method="post" enctype="multipart/form-data" id="form_data">
            {{ csrf_field() }}
            <!-- Default box -->
            <div class="card col-8">
                <div class="card-header">
                    <h3 class="card-title">{{ $data['title'] }}</h3>
                </div>
                <div class="card-body">
                    @php
                    $id = 0;
                    if($data['user']->id != '') {
                    $id = $data['user']->id;
                    }
                    @endphp
                    <input type="hidden" value="{{ $id }}" name="id" id="id_user">
                    <input type="hidden" value="{{ $data['type'] }}" name="type">
                    <div class="alert alert-danger" id="validasi_element" style="display:none;">
                        <ul id="validasi_content"></ul>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" value="{{ $data['user']->name }}" name="name">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" value="{{ $data['user']->username }}" name="username">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $data['user']->email }}" name="email">
                    </div>
                    @if($data['type'] != 'setting')
                        @if($data['user']->id == 1)
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="role_id" readonly>
                                <option value="1" selected> Super Admin </option>
                            </select>
                        </div>
                        <input type="hidden" value="1" name="enable">
                        @else
                        <div class="form-group">
                            <select class="form-control" name="role_id">
                                @foreach(App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}" @if($data['user']->role_id == $role->id) selected
                                    @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enable / Disable</label>
                            <select class="form-control" name="enable">
                                <option value="1" @if($data['user']->enable == 1) selected @endif>Enable</option>
                                <option value="0" @if($data['user']->enable == 0) selected @endif>Disable</option>
                            </select>
                        </div>
                        @endif
                    @endif
                    @if($data['type'] == 'setting')
                    <div class="form-group">
                        <label>Password Lama *)</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label>Password Baru *)</label>
                        <input type="password" class="form-control" name="password_new" id="password_new">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru *)</label>
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm">
                    </div>
                    *) Diisi hanya saat Anda ingin mengganti password
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block col-4" onclick="simpan()">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>
<script>
function simpan() {
    event.preventDefault();
    var id_ = $('#id_user').val();
    var formData = new FormData($('#form_data')[0]);
    $.ajax({
        url: '{{ url("admin/user/store") }}',
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
                if (id_ > 0) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    if ($('#password').val() != '') {
                        $('#password').val('');
                        $('#password_new').val('');
                        $('#password_confirm').val('');
                    }
                } else {
                    window.open("admin/user/view/" + response.id, "_self");
                }
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