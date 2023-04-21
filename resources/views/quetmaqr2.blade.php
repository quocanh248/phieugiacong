<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phiếu gia công</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->   
    <!-- Ionicons -->

    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/color.css">
    <!-- overlayScrollbars -->

    <!-- Daterange picker -->

</head>

<body>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">

                </div><!-- /.col -->
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Cấp tài khoản</a></li>
                        <!-- <li class="breadcrumb-item active">Admin</li> -->
                    </ol>
                </div> --}}
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-6" style="  position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%);">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Quét phiếu gia công</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12" style="text-align: right;">
                                <button id="reset-btn" style="float: right;" class="btn-primary float-right">Xóa</button>
                                <br>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="input1">Mã phiếu gia công:</label>
                                <form action="" id="form">
                                    <input type="text" id="input-qr" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="input2">Line:</label>
                                <input type="text" id="input0" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <label for="input2">Lot:</label>
                                <input type="text" id="inputlot" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">

                                <label for="input1">Model:</label>


                                <input type="text" id="input1" class="form-control" readonly>
                            </div>
                            <div class="col-4">
                                <label for="input2">Ver:</label>
                                <input type="text" id="input2" class="form-control" readonly>
                            </div>
                            <div class="col-4">
                                <label for="input3">Số thiết kế:</label>
                                <input type="text" id="input3" class="form-control" readonly>
                                <input type="text" id="input4" class="form-control" hidden>
                            </div>

                        </div>
                        @csrf
                        </form>
                        <br>
                        <br>

                        {{-- <input type="color" id="color-picker" value="#ffffff"
                            style="height: 65px;
                            width: 65px;                           
                            border-radius: 50%;
                            outline: none;                           
                            display: inline-block;" class="form-control"> --}}
                        <div id="color-picker" style=" height: 50px;  width: 50px; border-radius: 50%; border: 1px solid black; visibility:hidden;"></div>
                        <span id="error-message" style="color: red; font-size: 20px"></span>
                        <span id="error-1" style="color: red; font-size: 20px"></span>
                    </div>
                </div>
            </div>

        </div>
    </section>





    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#input-qr').focus();
        });
        var resetBtn = document.getElementById('reset-btn');
        resetBtn.addEventListener('click', function() {
            sessionStorage.removeItem('storedValues');
            storedValues = [];
            sessionStorage.removeItem('maline');
            maline = [];
            sessionStorage.removeItem('history');
            history = [];
            sessionStorage.removeItem('lot');
            lot = [];
            location.reload();
            input.focus();
        });
        var maline = JSON.parse(sessionStorage.getItem('maline'));
        if (maline != null) {
            input0.value = maline[0].line;
        }
        var inputlot = document.getElementById("inputlot");
        var lot = JSON.parse(sessionStorage.getItem('lot'));
        if (lot != null) {
            inputlot.value = lot[0].lot;
        }
        var input = document.getElementById("input-qr");

        var ip = input.value;
        var input1 = document.getElementById("input1");
        var input2 = document.getElementById("input2");
        var input3 = document.getElementById("input3");
        var input4 = document.getElementById("input4");

        var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));

        var color = document.getElementById("color-picker");
        input.addEventListener("change", function() {
            if (input.value == "   0 0                                              ") {
                input.value = "";
                input.focus();
            }
            // var regex = /^[a-zA-Z]\d{1}-[a-zA-Z]\d{1}$/; // biểu thức chính quy
            // var regex = /^[a-zA-Z]\w{1}-\d{1,2}$/; // biểu thức chính quy
            var regex = /^[a-zA-Z]+\d{1}-\d{2}$/;
            var regex1 = /^[a-zA-Z]{2}-\d{3}$/;
            if (regex.test(input.value) || regex1.test(input.value)) {
                console.log("Chuỗi hợp lệ");
                input0.value = input.value;
                document.getElementById("error-message").innerHTML = " ";
                var maline = JSON.parse(sessionStorage.getItem('maline'));
                if (maline == null) {
                    maline = [];
                    maline.push({
                        line: input0.value,

                    });
                    sessionStorage.setItem('maline', JSON
                        .stringify(maline));

                } else {
                    sessionStorage.removeItem('maline');
                    maline = [];
                    maline.push({
                        line: input0.value,
                    });
                    sessionStorage.setItem('maline', JSON
                        .stringify(maline));
                }
                input.value = "";
                input.focus();
            } else {
                if (input0.value == "") {
                    document.getElementById("error-message").innerHTML = "Yêu cầu nhập mã line";
                    input.value = "";
                    input.focus();
                } else {
                    var code = input.value;
                    var codes = code.split(" ");
                    input1.value = codes[0];

                    if (input1.value.length >= 10 && input1.value.length <= 11) {
                        // độ dài của chuỗi nằm trong khoảng từ 10 đến 11 ký tự
                        input2.value = codes[1];
                        let modelPrefix = codes[2].substring(0, 4);
                        input3.value = modelPrefix;
                        input4.value = codes[3];
                        inputlot.value = codes[5];
                        var lot = JSON.parse(sessionStorage.getItem('lot'));
                        if (lot == null) {
                            lot = [];
                            lot.push({
                                lot: inputlot.value,

                            });
                            sessionStorage.setItem('lot', JSON
                                .stringify(lot));

                        } else {
                            sessionStorage.removeItem('lot');
                            lot = [];
                            lot.push({
                                lot: inputlot.value,
                            });
                            sessionStorage.setItem('lot', JSON
                                .stringify(lot));
                        }
                        document.getElementById("error-message").innerHTML = " ";
                        var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));
                        var history = JSON.parse(sessionStorage.getItem('history'));
                        console.log(history);
                        if (history != null) {
                            if (history[0].input == code) {
                                console.log("đã quét");
                                document.getElementById("error-1").innerHTML = "Đã quét";
                            } else {
                                document.getElementById("error-1").innerHTML = " ";
                                history = [];
                                history.push({
                                    input: code,
                                });
                                sessionStorage.setItem('history', JSON.stringify(history));
                                // document.getElementById("error-message").innerHTML = " ";
                            }
                        } else {
                            history = [];
                            history.push({
                                input: code,
                            });
                            sessionStorage.setItem('history', JSON.stringify(history));
                        }
                    } else {
                        input.value = "";
                        input.focus();
                    }
                }

            }


        });
        // Nếu chưa có giá trị nào được lưu trước đó, tạo một mảng rỗng
        if (storedValues === null || storedValues === undefined) {
            storedValues = [];
            checkModelAndStoreValues2(function(result) {
                if (result === 1) {
                    document.getElementById("error-message").innerHTML =
                        "Hiện tại Chưa có model này vui lòng liên hệ quản lý!";
                    sessionStorage.removeItem('storedValues');
                    storedValues = [];
                    color.style.backgroundColor = "#ffffff";
                    input.value = "";
                    input.focus();

                } else if (result === 2) {
                    console.log("Res is not null");
                    var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));
                    let match = checkStoredValues(input2.value, input3.value);
                    if (match == false) {
                        console.log('No match found!');
                        document.getElementById("error-message").innerHTML =
                            "Hiện tại Chưa có model này vui lòng liên hệ quản lý!";
                        sessionStorage.removeItem('storedValues');
                        storedValues = [];
                        color.style.backgroundColor = "#ffffff";
                        input.value = "";
                        input.focus();
                    } else {
                        console.log('Match found!12');
                        // color.value = match;
                        color.style.backgroundColor= match;
                        color.style.visibility = "visible";
                        $(function() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                processData: false,
                                contentType: false,
                                type: 'GET',
                                dataType: 'JSON',
                                url: '/themlsquet/' + input1.value + '/' + input2
                                    .value + '/' +
                                    input3.value + '/' + input4.value + '/' + input0
                                    .value +'/'+ inputlot.value,
                                success: function(res) {

                                }
                            });
                        });

                        input.value = "";
                        input.focus();
                        // document.getElementById("error-message").innerHTML = " ";

                    }
                }
            });

        } else {
            input.addEventListener("change", function() {
                var input1 = document.getElementById("input1");
                var input2 = document.getElementById("input2");
                var input3 = document.getElementById("input3");
                var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));
                // console.log(storedValues);
                var model = storedValues[0].Model;
                if (input1.value == model) {
                    console.log('cùng model');
                    //Kiểm tra model mới có trong csdl chưa nếu chưa thì thêm vào sesion và csdl
                    //Nếu có rồi thì hiển màu sắc ra

                    let match = checkStoredValues(input2.value, input3.value);
                    console.log(match);
                    if (match == false) {
                        console.log('No match found!');
                        document.getElementById("error-message").innerHTML =
                            "Hiện tại Chưa có model này vui lòng liên hệ quản lý!";
                        sessionStorage.removeItem('storedValues');
                        storedValues = [];
                        color.style.backgroundColor = "#ffffff";
                        input.value = "";
                        input.focus();
                    } else {
                        console.log('Match found!');
                        color.style.backgroundColor = match;
                        color.style.visibility = "visible";
                        $(function() {
                            console.log(input2.value);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                processData: false,
                                contentType: false,
                                type: 'GET',
                                dataType: 'JSON',
                                url: '/themlsquet/' + input1.value + '/' + input2
                                    .value + '/' +
                                    input3.value + '/' + input4.value + '/' + input0
                                    .value +'/'+ inputlot.value,
                                success: function(res) {

                                }
                            });
                        });
                        input.value = "";
                        input.focus();

                    }


                } else {
                    console.log('Khác model');
                    //Nếu trong  session không có model sẽ xóa session hiện tại để chuyển sang session model mới   
                    sessionStorage.removeItem('storedValues');
                    storedValues = [];
                    var input1 = document.getElementById("input1");
                    var input2 = document.getElementById("input2");
                    var input3 = document.getElementById("input3");
                    $(function() {
                        storedValues = [];
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            processData: false,
                            contentType: false,
                            type: 'GET',
                            dataType: 'JSON',
                            url: '/checkmodel/' + $("#input1").val(),
                            success: function(res) {
                                console.log(res);
                                $.each(res, function(i, item) {
                                    if (item.tenmodel === input1.value &&
                                        item
                                        .tenversion === input2.value && item
                                        .tenthietke === input3.value) {
                                        color.value = item.mamau;

                                        storedValues.push({
                                            Model: input1.value,
                                            version: input2.value,
                                            designnumber: input3
                                                .value,
                                            color: item.mamau,
                                        });

                                    } else {
                                        storedValues.push({
                                            Model: item.tenmodel,
                                            version: item
                                                .tenversion,
                                            designnumber: item
                                                .tenthietke,
                                            color: item.mamau,
                                        });
                                    }
                                    sessionStorage.setItem('storedValues',
                                        JSON
                                        .stringify(storedValues));

                                });
                                console.log(storedValues);

                                if (storedValues == null) {
                                    console.log("k có ");
                                } else {
                                    var a = checkDuplicate(storedValues, input2
                                        .value, input3
                                        .value);
                                    console.log(a);
                                    if (a == 0) {
                                        document.getElementById("error-message")
                                            .innerHTML =
                                            "Hiện tại Chưa có model này vui lòng liên hệ quản lý!";
                                            color.style.backgroundColor = "#ffffff";
                                        input.value = "";
                                        input.focus();
                                    } else {
                                        //trùng
                                        color.style.backgroundColor = a;
                                        color.style.visibility = "visible";
                                        $(function() {
                                            console.log(input2.value);
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]'
                                                    ).attr(
                                                        'content'
                                                    )
                                                }
                                            });
                                            $.ajax({
                                                processData: false,
                                                contentType: false,
                                                type: 'GET',
                                                dataType: 'JSON',
                                                url: '/themlsquet/' +
                                                    input1
                                                    .value + '/' +
                                                    input2
                                                    .value + '/' +
                                                    input3
                                                    .value + '/' +
                                                    input4
                                                    .value + '/' +
                                                    input0.value+'/'+ inputlot.value,
                                                success: function(
                                                    res) {

                                                }
                                            });
                                        });
                                        input.value = "";
                                        input.focus();
                                    }
                                }

                            }
                        });




                    });



                }
            });
        }
        //hàm kiêm tra
        function checkDuplicate(arr, input2, input3) {
            // Lặp qua từng phần tử trong mảng
            for (let i = 0; i < arr.length; i++) {
                // Kiểm tra xem các giá trị của model.version và model.designnumber có trùng với các giá trị trong mảng hay không
                if (input2 === arr[i].version && input3 === arr[i].designnumber) {
                    // Nếu có ít nhất một phần tử trong mảng có giá trị trùng thì trả về 1
                    return arr[i].color;
                }
            }
            // Nếu không có phần tử nào trùng thì trả về 0
            return 0;
        }
        //hàm ktr version và thiết kế
        function checkStoredValues(input2, input3) {
            var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));
            for (let i = 0; i < storedValues.length; i++) {
                let model = storedValues[i];
                if (model.version === input2 && model.designnumber === input3) {
                    return model.color;
                }
            }
            return false;
        }
        //hàm lấy model trong csdl
        function checkModelAndStoreValues() {

            input.addEventListener("change", function() {

                $(function() {
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
                        url: '/checkmodel/' + $("#input1").val(),
                        success: function(res) {
                            if (res == null) {
                                return false;
                            } else {
                                $.each(res, function(i, item) {
                                    // Lặp qua các kết quả và thêm vào mảng storedValues
                                    // res.forEach(function(item) {
                                    storedValues.push({
                                        Model: item.tenmodel,
                                        version: item.tenversion,
                                        designnumber: item
                                            .tenthietke,
                                        color: item.mau,
                                    });
                                    sessionStorage.setItem('storedValues',
                                        JSON
                                        .stringify(
                                            storedValues));
                                    // });

                                });
                            }
                        }
                    });
                });
            });
        }
        //Hàm chuyển sang model mới
        function checkModelAndStoreValues2(callback) {
            input.addEventListener("change", function() {
                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: '/checkmodel/' + $("#input1").val(),
                        success: function(res) {
                            if (res.length < 1) {
                                callback(1);
                            } else {
                                let storedValues = JSON.parse(sessionStorage
                                    .getItem(
                                        'storedValues')) || [];

                                $.each(res, function(i, item) {
                                    const existingItem = storedValues.some(
                                        element =>
                                        element.Model === item.tenmodel);

                                    if (!existingItem) {
                                        sessionStorage.removeItem(
                                            'storedValues');
                                        storedValues = [];
                                        storedValues.push({
                                            Model: item.tenmodel,
                                            version: item
                                                .tenversion,
                                            designnumber: item
                                                .tenthietke,
                                            color: item.mamau
                                        });
                                        sessionStorage.setItem(
                                            'storedValues', JSON
                                            .stringify(storedValues));
                                    }
                                    // Nếu tìm thấy phần tử, kiểm tra các giá trị khác
                                    else {
                                        const isMatching = storedValues
                                            .some(
                                                element =>
                                                element.designnumber ===
                                                item
                                                .tenthietke &&
                                                element.version === item
                                                .tenversion
                                            );


                                        if (isMatching) {
                                            // document.getElementById(
                                            //         "error-message")
                                            //     .innerHTML = "Đã quét";

                                        }
                                        // Nếu các giá trị khác không trùng, thêm phần tử mới
                                        if (!isMatching) {
                                            storedValues.push({
                                                Model: item
                                                    .tenmodel,
                                                version: item
                                                    .tenversion,
                                                designnumber: item
                                                    .tenthietke,
                                                color: item.mamau
                                            });
                                            sessionStorage.setItem(
                                                'storedValues', JSON
                                                .stringify(storedValues)
                                            );
                                        }
                                    }
                                });
                                callback(2);
                            }
                        }
                    });
                });
            });
        }
    </script>


</body>

</html>
