@extends ('welcome')

@section('content')
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật Model ASSY</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <form action="/capnhatassy" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">Model</label>
                                    <select class="form-control" name="model" id="model" @readonly(true)>
                                        <option value="{{ $version->mamodel }}">{{ $version->tenmodel }}
                                        </option>


                                    </select>
                                    {{-- <input type="text" name="model" id="model"class="form-control" readonly  value="{{ $version->tenmodel }}"> --}}

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">Ver</label>
                                    <select class="form-control" name="version" id="version" readonly>
                                        <option value="{{ $thietke->maversion }}">{{ $thietke->tenversion }}
                                        </option>


                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">ASSY</label>
                                    <input type="text" name="assy" id="assy" class="form-control"
                                        autocomplete="off" required value="{{ $thietke->assy }}">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">Số thiết kế</label>
                                    <input type="text" name="thietke" id="thietke" class="form-control"
                                        autocomplete="off" required value="{{ $thietke->tenthietke }}">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">Màu:</label>
                                    <select class="form-control" name="mau" id="mau">
                                        <option value="{{ $mau->mamau }}">{{ $mau->tenmau }}
                                        </option>
                                        @foreach ($maus as $data)
                                            <option value="{{ $data->mamau }}">{{ $data->tenmau }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="input1">Màu:</label>
                                    <div id="rsmau" class="form-control" style="background-color: {{ $mau->mamau }}">
                                        <b></b>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-10">
                                    <label for="input1">  </label>
                                    <button type="submit" id="capnhat" name="capnhat" value="{{ $thietke->mathietke }}"
                                        class="btn-primary">Cập nhật</button>
                                </div>
                                {{-- <div class="col-2">
                                    <button type="submit" name="tim" value="tim" class="btn btn-bg bg-primary"><i class="fa-solid fa-angles-left"></i></button>
                                    <label for="input1"> Quay lại </label>                                   
                                </div> --}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        //Lấy màu
        var mau = document.getElementById("mau");
        var rsmau = document.getElementById("rsmau");
        mau.addEventListener("change", function() {
            var t = mau.value;
            rsmau.style.backgroundColor = t;
        });
    </script>
@endsection
