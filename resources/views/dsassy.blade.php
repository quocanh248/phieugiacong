@extends ('welcome')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Danh sách các Model ASSY</h1>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <form action="/timassy" method="GET">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="input1">Model:</label>

                                            <input type="text" name="model" id="model" list="cities"
                                                role="combobox" class="form-control" autocomplete="off" required>
                                            <datalist id="cities">
                                                @foreach ($model as $data)
                                                    <option value="{{ $data->tenmodel }}"></option>
                                                @endforeach

                                            </datalist>
                                        </div>
                                        <div class="col-5">
                                            <label for="input1">Ver:</label>
                                            <select class="form-control" name="version" id="version" required>
                                                <option value="">Chọn model để tìm kiếm</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <label for="input1"> Tìm </label>
                                            <br>
                                            <button type="submit" name="tim" value="tim"
                                                class="btn btn-bg bg-primary">Tìm</button>
                                        </div>


                                    </div>
                                </div>
                            </form>
                            <span id="error-1" style="color: red; font-size: 20px"></span>
                        </div>
                    </div>
                </div>

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


<script type="text/javascript">
    function xoamodel(id) {
        var i = id;
        console.log(i);
        if (confirm('Xác nhận muốn xóa Model?')) {
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
                url: '/getverassy/' + $("#model").val(),
                success: function(res) {
                    $('#version').empty();
                    console.log(res);
                    if (typeof res === 'object' && Object.keys(res).length > 0) {
                        $.each(res, function(i, item) {
                            $('#version').append($('<option>', {
                                value: item.maversion,
                                text: item.tenversion,
                            }));
                        });
                        document.getElementById("error-1").innerHTML = "";
                    } else {
                        console.log("Model này không có assy");
                        document.getElementById("error-1").innerHTML = "Model này không có assy";
                    }                   
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
