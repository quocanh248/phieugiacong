@extends ('welcome')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Danh sách các Model</h1>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="/timmodel" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="input1">Model:</label>
                                        
                                            <input type="text" name="model" id="model" class="form-control"
                                                role="combobox" value="{{ $model[0]->tenmodel }}" list="cities"
                                                autocomplete="off" required>
                                            <datalist id="cities" role="listbox">
                                                @foreach ($t as $data)
                                                    <option value="{{ $data->tenmodel }}"></option>
                                                @endforeach

                                            </datalist>


                                        </div>
                                        <div class="col-5">
                                            <label for="input1">Ver:</label>
                                            <select class="form-control" name="version" id="version" required>
                                                <option value="{{ $model[0]->maversion }}">{{ $model[0]->tenversion }}
                                                </option>
                                                @foreach ($version as $data)
                                                    <?php if($model[0]->maversion != $data->maversion ) {?>
                                                    <option value="{{ $data->maversion }}">{{ $data->tenversion }}
                                                    </option>
                                                    <?php }?>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="input1"> Tìm </label>
                                            <br>
                                            <button type="submit" class="btn btn-bg bg-primary" name="tim"
                                                value="tim">Tìm</button>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="row">
                                        <input type="text" name="maversion" value="{{ $model[0]->maversion }}" hidden>
                                        <div class="col-4">
                                            <label for="input1"> Nâng cấp Ver </label>
                                            <br>
                                            <button type="submit" name="nangcap" value="{{ $model[0]->maversion }}"
                                                class="btn btn-bg bg-primary">NC</button>
                                        </div>
                                        <div class="col-4">
                                            <label for="input1"> Copy model </label>
                                            <br>
                                            <button type="submit" name="copy" value="{{ $model[0]->mamodel }}"
                                                class="btn btn-bg bg-primary">CP</button>
                                        </div>
                                        <div class="col-4">
                                            <label for="input1"> Xóa Ver </label>
                                            <br>
                                            <span class="btn btn-sm bg-danger">
                                                <a onclick="xoamodel()">
                                                    Xóa
                                                </a>
                                            </span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">

                <div class="card-body">

                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>

                                <th>Model</th>
                                <th>Ver</th>
                                <th>Số thiết kế</th>
                                <th>Màu</th>
                                <th></th>
                                <th>Người nhập</th>
                                <th>Ngày Cập nhật</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($model as $data)
                                <tr>

                                    <td>{{ $data->tenmodel }}</td>
                                    <td>{{ $data->tenversion }}</td>
                                    <td>{{ $data->tenthietke }}</td>
                                    <td>{{ $data->tenmau }}</td>

                                    <td><input style="background-color: transparent; border: none; outline: none;"
                                            type="color" name="col4[]" value="{{ $data->mamau }}"></td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->updated_at }}</td>
                                    <td>
                                        <span class="btn btn-sm bg-primary">
                                            <a
                                                href="/capnhatmodel/{{ $data->mamodel }}/{{ $data->maversion }}/{{ $data->mathietke }}">
                                               Sửa
                                            </a>
                                        </span>                                       
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <br>


                </div>
                <!-- /.card-body -->

            </div>
        </div>

        </div>
    </section>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.slim.js"
    integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

<script type="text/javascript">
    function xoamodel() {
        var i = document.getElementById("version").value;
        console.log(i);
        if (confirm('Xác nhận muốn xóa Ver?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                processData: false,
                contentType: false,
                type: 'GET',
                dataType: 'JSON',
                url: '/xoamodel/' + i,
                success: function(res) {
                    window.location.href = '/dsmodel';
                }
            });
            window.location.href = '/dsmodel';
        }
    }
</script>
<script type="text/javascript">
    function xoathietke(mathietke) {
       
        if (confirm('Xác nhận muốn xóa số thiết kế?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                processData: false,
                contentType: false,
                type: 'GET',
                dataType: 'JSON',
                url: '/xoathietke/' + mathietke,
                success: function(res) {
                    // window.location.href = window.location.href;
                }
            });
            window.location.href = window.location.href;
        }
    }
</script>
<script>
    $(function() {
        $("#model").change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                processData: false,
                contentType: false,
                type: 'GET',
                dataType: 'JSON',
                url: '/laythongtin/' + $("#model").val(),
                success: function(res) {
                    $('#version').empty();
                    console.log(res)
                    $.each(res, function(i, item) {
                        $('#version').append($('<option>', {
                            value: item.maversion,
                            text: item.tenversion,
                        }));
                    });
                }
            });
        });

        // $("#model").val('1').change();
    });
</script>
<script>
    $(function() {
        $("#model1").change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                processData: false,
                contentType: false,
                type: 'GET',
                dataType: 'JSON',
                url: '/laythongtin/' + $("#model1").val(),
                success: function(res) {
                    $('#version1').empty();
                    console.log(res)
                    $.each(res, function(i, item) {
                        $('#version1').append($('<option>', {
                            value: item.maversion,
                            text: item.tenversion,
                        }));
                    });
                }
            });
        });

        // $("#model").val('1').change();
    });
</script>
