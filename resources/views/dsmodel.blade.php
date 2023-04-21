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
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <form action="/timmodel" method="GET">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="input1">Model:</label>

                                            <input type="text" name="model" id="model" list="cities"
                                                role="combobox" class="form-control" autocomplete="off" required>
                                            <datalist id="cities">
                                                <?php if($t->count()==0){?>
                                                <option>Không có model nào</option>
                                                <?php } else{ ?>
                                                @foreach ($t as $data)
                                                    <option value="{{ $data->tenmodel }}"></option>
                                                @endforeach
                                                <?php }?>

                                            </datalist>

                                            {{-- <select class="form-control" name="model" id="model">
                                        <option value="1">Chọn model để tìm kiếm</option>
                                        @foreach ($t as $data)
                                            <option value="{{ $data->mamodel }}">{{ $data->tenmodel }}</option>
                                        @endforeach
                                    </select> --}}
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
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">             
               
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
