@extends ('welcome')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">LS quét phiếu gia công</h1>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="/timlsquet" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-8">
                                            
                                            <label for="input1">Ngày quét:</label>
                                            <input type="date" name="date" id="date" value="{{$date}}" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-4">
                                            <label for="input1"> Tìm </label>
                                            <br>
                                            <button type="submit" name="tim" value="tim"
                                                class="btn btn-bg bg-primary">Tìm</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-12">
                                            <label for="input1"> Xuất Excel </label>
                                            <br>
                                            <button type="submit" name="xuatexcel" value="tim"
                                                class="btn btn-bg bg-success">Tải về</button>
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
                                <th>Lot</th>
                                <th>Model</th>
                                <th>Ver</th>
                                <th>Số thiết kế</th>
                                <th>STT</th>
                                <th>Mã line</th>                                
                                <th>Ngày quét</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($lsquet as $data)
                                <tr>
                                    <td>{{ $data->lot }}</td>
                                    <td>{{ $data->tenmodel }}</td>
                                    <td>{{ $data->tenversion }}</td>
                                    <td>{{ $data->tenthietke }}</td>
                                    <td>{{ $data->stt }}</td>
                                    <td>{{ $data->maline }}</td>                                    
                                    <td>{{ $data->updated_at }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<script type="text/javascript">
    function xoamodel(id) {
        var i = id;
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
    function xoathietke(id, mathietke) {
        var i = id;
        console.log(i);
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
                url: '/xoathietke/' + i + '/' + mathietke,
                success: function(res) {
                    window.location.href = window.location.href;
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
