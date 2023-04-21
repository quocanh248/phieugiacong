@extends ('welcome')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-5">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Nhập ASSY tay</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-6">
                                        <label for="input1">Model:</label>
                                        <datalist id="cities">
                                            @foreach ($model as $data)
                                                <option value="{{ $data->tenmodel }}"></option>
                                            @endforeach

                                        </datalist>
                                        <input type="text" name="model" id="model" list="cities"
                                            class="form-control" autocomplete="off" required>

                                    </div>
                                    <div class="col-6">
                                        <label for="input1">Ver:</label>

                                        <datalist id="version">

                                        </datalist>
                                        <input type="text" name="version" id="versions" list="version"
                                            class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="input1">ASSY:</label>
                                        <datalist id="assys">

                                        </datalist>
                                        <input type="text" name="assy" id="assy" list="assys"
                                            class="form-control" autocomplete="off" required>

                                    </div>
                                    <div class="col-6">
                                        <label for="input1">Số thiết kế:</label>
                                        <datalist id="thietke">

                                        </datalist>
                                        <input type="text" name="thietke12" id="thietkes" list="thietke"
                                            class="form-control" autocomplete="off" required>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input1">Màu:</label>
                                        <select class="form-control" name="mau" id="mau">


                                            @foreach ($mau as $data)
                                                <option value="{{ $data->mamau }}">{{ $data->tenmau }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">

                                        {{-- <input type="color" name="thietke" id="rsmau" readonly  class="form-control"> --}}
                                        <div id="rsmau" class="form-control" style="background-color:#ff7fbf"></div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-11">
                                        <button type="submit" id="nhapassy" class="btn-primary">Nhập</button>
                                    </div>

                                    <div class="col-1">
                                        <button type="button" class="btn-danger" id="clear">Xóa</button>
                                    </div>
                                </div>
                                <span id="error-message" style="color: red;"></span>

                            </div>

                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->

                <!--/.col (right) -->
                <div class="col-md-7">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Model ASSY vừa thêm</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Model-Ver</th>
                                        <th>ASSY</th>
                                        <th>Số thiết kế</th>
                                        <th>Màu</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                    $datanew = Session::get('dataassynew');
                 
                  
                     if(!empty($datanew))   {                  

                        ?>
                                    @foreach ($datanew as $data)
                                        <tr>

                                            <td>{{ $data->tenmodel }}-{{ $data->tenversion }}</td>
                                            <td>{{ $data->assy }}</td>
                                            <td>{{ $data->tenthietke }}</td>
                                            <td><input style="background-color: transparent; border: none; outline: none;"
                                                    type="color" name="col4[]" value="{{ $data->mamau }}"></td>

                                        </tr>
                                    @endforeach
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('errol'))
                <div class="alert alert-danger">
                    {{ session('errol') }}
                </div>
            @endif

        </div><!-- /.container-fluid -->
    </section>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var model = document.getElementById("model");
        var version123 = document.getElementById("versions");
        var thietke = document.getElementById("thietkes");
        var mau = document.getElementById("mau");
        var assy = document.getElementById("assy");
        var submit = document.getElementById('nhapassy');
        submit.addEventListener('click', function() {
            const modelValue = model.value.trim();
            // Kiểm tra độ dài của giá trị
            if (modelValue.length < 10 || modelValue.length > 11) {
                document.getElementById("error-message").innerHTML =
                    "Tên model phải ít nhất 10 và nhiều nhất là 11 ký tự";
                $('input[type="text"]').val('');
            } else {
                $(document).ready(function() {
                    $.ajax({
                        url: '/nhapassytay',
                        method: 'POST',
                        data: {
                            model: model.value,
                            version: version123.value,
                            thietke12: thietke.value,
                            assy: assy.value,
                            mau: mau.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
                var dataold1 = JSON.parse(sessionStorage.getItem('dataold'));
                dataold1 = [];
                dataold1.push({
                    Model: model.value,
                    version: version123.value,
                    assy: assy.value,
                });
                sessionStorage.setItem('dataold1', JSON.stringify(dataold1));
                location.reload();
            }

        });
        var dataold1 = JSON.parse(sessionStorage.getItem('dataold1'));
        // Kiểm tra nếu dataold không rỗng thì gán giá trị cho input
        if (dataold1 !== null) {
            model.value = dataold1[0].Model;
            version123.value = dataold1[0].version;
            assy.value = dataold1[0].assy;
            $(function() {
                console.log(version123.value, model.value)
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
                    url: '/laythongtinthietke/' + model.value + '/' + version123.value + '/' + assy.value,
                    success: function(res) {
                        $('#thietke').empty();
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#thietke').append($('<option>', {
                                value: item.tenthietke,
                            }));
                        });
                    }
                });


            });
        }
    </script>

    <script>
        $(function() {
            $("#model").change(function() {

                // Xóa tất cả các tùy chọn
                document.getElementById('versions').value = "";

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
                    url: '/laythongtinversion/' + $("#model").val(),
                    success: function(res) {
                        $('#version').empty();
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#version').append($('<option>', {
                                value: item.tenversion,
                            }));
                        });
                    }
                });
            });

            // $("#model").val('1').change();
        });
        $(function() {
            $("#versions").change(function() {
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
                    url: '/laythongtinassy/' + $("#model").val() + '/' + $("#versions").val(),
                    success: function(res) {
                        $('#assys').empty();
                       
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#assys').append($('<option>', {
                                value: item.assy,
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
            $("#assy").change(function() {
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
                    url: '/laythongtinthietke/' + $("#model").val() + '/' + $("#versions").val() + 
                        '/' + $("#assy").val(),
                    success: function(res) {
                        $('#thietke').empty();
                        console.log(res)
                        $.each(res, function(i, item) {
                            $('#thietke').append($('<option>', {
                                value: item.tenthietke,
                            }));
                        });
                    }
                });
            });

            // $("#model").val('1').change();
        });
    </script>

    <script>
        //xóa dữ liệu trên các input
        var resetBtn = document.getElementById('clear');
        resetBtn.addEventListener('click', function() {
            $('input[type="text"]').val('');
            $('#thietkes').val('');
        });
        //Lấy màu
        var mau = document.getElementById("mau");
        var rsmau = document.getElementById("rsmau");
        mau.addEventListener("change", function() {
            var t = mau.value;
            rsmau.style.backgroundColor = t;
        });
    </script>
    <script>
        var rowCount = document.getElementById("example1").getElementsByTagName("tbody")[0].getElementsByTagName("tr")
            .length;
        console.log(rowCount);
        // Nếu có ít nhất một dòng, hiển thị div chứa bảng
        if (rowCount > 0) {
            document.getElementById("table-data").style.display = "block";
        }
    </script>
@endsection
