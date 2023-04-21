@extends ('welcome')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
              
                <div class="col-sm-9">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Nhập bằng excel</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form action="docexcel" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="excel_file" class="form-control" id="file" required>
                                    <br>
                                    <button type="submit" class="btn-primary">Đọc file</button>
                                </form>
                            </div>

                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-sm-3">
                    <!-- Form Element sizes -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">File Mẫu</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group" style="height:90px">
                                <a href="/mauexcelmodel" class="btn btn-bg bg-success">Tải file</a>
                            </div>

                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>

            <!-- /.row -->
            <div class="card card-success" id="table-data" style="display: none;">
                <div class="card-header">
                    <h3 class="card-title">Dữ liệu excel</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="themmodelexcel">
                        @csrf
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Phiên bản</th>
                                    <th>Số thiết kế</th>
                                    <th>Màu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $count = 0;
                             if(!empty($results)){                          
                                ?>
                                @foreach ($results[0] as $data)
                                    <?php if($count > 0) {?>
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col1[]" value="{{ $data[0] }}"></td>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col2[]" value="{{ $data[1] }}"></td>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col3[]" value="{{ $data[2] }}"></td>
                                        <td><input style="background-color: transparent; border: none; outline: none;"
                                                type="text" name="col4[]" value="{{ $data[3] }}"></td>
                                    </tr>
                                    <?php  }$count ++;?>
                                @endforeach
                                <?php }?>
                            </tbody>
                        </table>
                        <br>
                        <button type="submit" class="btn btn-sm btn-success">Thêm vào CSDL</button>
                    </form>
                </div>
               
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
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
