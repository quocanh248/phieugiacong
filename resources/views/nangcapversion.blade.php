@extends ('welcome')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Nâng cấp Ver</h1>
                </div>
            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="nangcapver" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="input1">Model:</label>
                                            <input type="text" name="model" id="model"
                                                value="{{ $version[0]->tenmodel }}" readonly class="form-control"
                                                autocomplete="off" required>

                                        </div>
                                        <div class="col-6">
                                            <label for="input1">Ver:</label>                                          
                                            <datalist id="version12">
                                                @foreach ($model as $data)
                                                    <option value="{{ $data->tenversion }}"></option>
                                                @endforeach
                                            </datalist>
                                            <input type="text" name="version" id="version" list="version12"
                                                value="{{ $version[0]->tenversion }}" class="form-control"
                                                autocomplete="off" required>
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

                                        <div class="col-6">
                                            <label for="input1"> Nâng cấp </label>
                                            <br>
                                            <button type="submit" name="nangcap123" value="{{ $version[0]->mamodel }}"
                                                class="btn btn-bg bg-primary"><i class="fa-solid fa-angles-up"></i></button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">

                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Số thiết kế</th>
                                    <th>Màu</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($version as $data)
                                    <tr>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col3[]" value="{{ $data->tenthietke }}"></td>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col4[]" value="{{ $data->tenmau }}"></td>
                                        {{-- <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="color" name="col5[]" value="{{ $data->mamau }}"></td> --}}
                                        <td>
                                            <div
                                                style=" height: 30px;  width: 30px; border-radius: 50%; border: 1px solid black; background-color:{{ $data->mamau }}">
                                            </div>
                                        </td>
                                        <td id="xoa"> <span class="btn btn-sm bg-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </span></td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <br>


                    </div> <!-- /.card-body -->

                </div>
            </form>
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
<script>
    $(document).ready(function() {
        $('tbody').on('click', '#xoa', function() {
            $(this).parent().remove(); // Xóa phần tử <tr></tr> chứa td được click
        });
    });
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
