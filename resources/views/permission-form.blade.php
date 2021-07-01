<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <form action="/admin/permission/store" method="post" enctype="multipart/form-data" id="form_data">
            {{ csrf_field() }}
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $data['title'] . ' ' . $data['role']->name }} </h3>
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $data['role']->id }}" name="id" id="id_role">
                    <div class="alert alert-danger" id="validasi_element" style="display:none;">
                        <ul id="validasi_content"></ul>
                    </div>
                    <div class="row">
                        @foreach(array_chunk(App\Models\Role::roles(), 10, true) as $roles)
                        <div class="col-md-3">
                            @foreach($roles as $key => $value)

                                @if($data['role']->id == 1)
                                    @if($key == 'dashboard')
                                    <div class="form-group">
                                        <label>Dashboard</label>
                                        <div class="form-control">Dashboard Manager</div>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked disabled>
                                            <label class="form-check-label">{{ $value }}</label>
                                        </div>
                                    </div>
                                    @endif
                                @else
                                    @if($key == 'dashboard')
                                    <div class="form-group">
                                        <label>Dashboard</label>
                                        <select class="form-control" name="dashboard">
                                            <option value="">--Pilih Dashboard--</option>
                                            @foreach($value as $dKey => $dValue)
                                            <option value="{{ $dKey }}" @if(in_array($dKey, json_decode($data['role']->
                                                permissions))) selected @endif>{{ $dValue }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @else
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                onclick="permission({{ $data['role']->id }}, '{{ $key }}')" type="checkbox"
                                                name='{{ $key }}' @if(in_array($key, json_decode($data['role']->permissions)))
                                            checked @endif>
                                            <label class="form-check-label">{{ $value }}</label>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <a href="{{ url('admin/role') }}" class="btn btn-success btn-block col-4">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>
<script>
function permission(id, name) {
    $.ajax({
        url: '{{ url("admin/permission/store") }}',
        type: 'POST',
        dataType: 'JSON',
        data: {
            id: id,
            access: name,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            loadingOpen('.content');
        },
        success: function(response) {
            loadingClose('.content');
        }
    });
}
</script>