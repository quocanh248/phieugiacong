<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phiếu gia công</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->    
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <!-- Ionicons -->

    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/color.css">
    <!-- overlayScrollbars -->

    <!-- Daterange picker -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .ball {
            background-color: var(--ball-color);
            padding: 0;
            margin: 0 8px;
            height: 50px;
            width: 50px;
            border-radius: 50%;
            border: 1px solid black;
            display: inline-block;
        }
    </style>
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
            <div class="col-md-9" style="  position: absolute; top: 40%; left: 15%; transform: translate(-5%, -50%);">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Quét phiếu gia công ASSY</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12" style="text-align: right;">
                                <button id="reset-btn" style="float: right;" class="btn-primary float-right">Xóa</button>
                                <br>
                            </div>

                        </div>

                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <label for="input1">Mã phiếu gia công:</label>
                                <form action="" id="form">
                                    <input type="text" id="input-qr" class="form-control">
                            </div>
                            <div class="col-3">
                                <label for="input2">Line:</label>
                                <input type="text" id="input0" class="form-control" readonly>
                            </div>
                            <div class="col-3">
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
                        <br>
                        {{-- <div class="row">
                            <div class="col-2">
                                <label for="input3">Chọn ASSY</label>

                            </div>
                            @foreach ($assy as $data)
                                <div class="col-1">
                                    <button type="button" value="{{ $data->maassy }}"
                                        style="float: center; color: #fff; background-color: #0E6251;"
                                        class="btn">A</button>

                                    <br>
                                </div>
                            @endforeach
                        </div> --}}
                        {{-- <div class="row" id="addassy">
                            <div class="col-2">
                                <label for="input3">Chọn ASSY</label>

                            </div>

                        </div> --}}
                        <div class="row">
                            <div class="col-2">
                                <label for="input3">Chọn ASSY</label>

                            </div>
                            <div class="col-10" id="addassy"></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-2">
                                <label for="input3">Màu</label>
                            </div>
                            <div class="col-10" id="col-1"></div>
                        </div>
                        <br>
                        {{-- <div class="row">
                            <div class="col-2">
                                <label for="input3">Kết quả</label>
                            </div>
                            <div class="col-10">
                                @foreach ($mau as $data)
                                    <div style="--ball-color: {{ $data->mamau }}; visibility: hidden;" class="ball"
                                        id="{{ $data->mamau }}"></div>
                                @endforeach
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-2">
                                <label for="input3">Kết quả</label>
                            </div>
                            <div class="col-10" id="col-2"></div>
                        </div>
                        <span id="error-message1" style="color: red; font-size: 20px"></span>
                        <span id="error-message" style="color: red; font-size: 20px"></span>
                        <span id="error-1"
                            style="color: rgb(10, 14, 228); font-size: 25px; font-weight: bold; float: right;"></span>
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
            sessionStorage.removeItem('storedValuesassy');
            storedValuesassy = [];
            sessionStorage.removeItem('malineassy');
            malineassy = [];
            sessionStorage.removeItem('historyassy');
            historyassy = [];
            sessionStorage.removeItem('lotassy');
            lotassy = [];
            sessionStorage.removeItem('modelassy');
            modelassy = [];
            sessionStorage.removeItem('storedValuesassykq');
            storedValuesassykq = [];
            sessionStorage.removeItem('btnassy');
            btnassy = [];
            sessionStorage.removeItem('laybtn');
            laybtn = [];
            location.reload();
            input.focus();
        });
        var input = document.getElementById("input-qr");
        var ip = input.value;
        var input1 = document.getElementById("input1");
        var input2 = document.getElementById("input2");
        var input3 = document.getElementById("input3");
        var input4 = document.getElementById("input4");
        var inputlot = document.getElementById("inputlot");
        input.addEventListener("change", function() {
            if (input.value == "   0 0                                              ") {
                input.value = "";
                input.focus();
            }
            var regex = /^[a-zA-Z]+\d{1}-\d{2}$/;
            var regex1 = /^[a-zA-Z]{2}-\d{3}$/;
            if (regex.test(input.value) || regex1.test(input.value)) {
                console.log("Chuỗi hợp lệ");
                input0.value = input.value;
                document.getElementById("error-message").innerHTML = " ";
                var malineassy = JSON.parse(sessionStorage.getItem('malineassy'));
                if (malineassy == null) {
                    malineassy = [];
                    malineassy.push({
                        line: input0.value,

                    });
                    sessionStorage.setItem('malineassy', JSON
                        .stringify(malineassy));

                } else {
                    sessionStorage.removeItem('malineassy');
                    malineassy = [];
                    malineassy.push({
                        line: input0.value,
                    });
                    sessionStorage.setItem('malineassy', JSON
                        .stringify(malineassy));
                }
                input.value = "";
                input.focus();
            } else {
                if (input0.value == "") {
                    document.getElementById("error-message").innerHTML = "Quét mã line";
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
                        input.value = "";
                        input.focus();

                        var lotassy = JSON.parse(sessionStorage.getItem('lotassy'));
                        if (lotassy == null) {
                            lotassy = [];
                            lotassy.push({
                                Model: input1.value,
                                Version: input2.value,
                                lot: inputlot.value,
                            });
                            sessionStorage.setItem('lotassy', JSON
                                .stringify(lotassy));

                        } else {
                            sessionStorage.removeItem('lotassy');
                            lotassy = [];
                            lotassy.push({
                                Model: input1.value,
                                Version: input2.value,
                                lot: inputlot.value,


                            });
                            sessionStorage.setItem('lotassy', JSON
                                .stringify(lotassy));
                        }

                    } else {
                        input.value = "";
                        input.focus();
                    }
                    var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
                    console.log(storedValuesassykq);
                    if (storedValuesassy == null || storedValuesassy == undefined || storedValuesassy.length <
                        1) {
                        $(function() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: '/layassy/' + $("#input1").val() + '/' + $("#input2")
                                    .val(),
                                success: function(res) {
                                    if (res.length < 1) {
                                        document.getElementById("error-message").innerHTML =
                                            "Model này không có ASSy";
                                        input.focus();
                                    } else {
                                        let laybtn = JSON.parse(sessionStorage
                                            .getItem('laybtn')) || [];

                                        $.each(res, function(i, item) {
                                            const existingItem = laybtn
                                                .some(
                                                    element => element.assy === item
                                                    .assy);

                                            if (!existingItem) {
                                                laybtn.push({
                                                    assy: item.assy,
                                                });
                                                sessionStorage.setItem(
                                                    'laybtn', JSON.stringify(laybtn)
                                                );
                                            }
                                            // Nếu tìm thấy phần tử, kiểm tra các giá trị khác
                                            else {

                                            }

                                        });


                                        location.reload();
                                    }
                                }
                            });
                        });


                    }
                    var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
                    var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
                    console.log(storedValuesassy);

                    if (storedValuesassy == null || storedValuesassy == undefined || storedValuesassy.length < 1) {

                    } else {
                        var btnassy = JSON.parse(sessionStorage.getItem('btnassy'));
                        if (laybtn !== null || laybtn !== undefined) {
                            if (btnassy[0].assy == storedValuesassy[0].assy) {
                                for (var i = 0; i < storedValuesassy.length; i++) {
                                    if (input1.value === storedValuesassy[i].Model && input2.value ===
                                        storedValuesassy[i]
                                        .version && input3.value === storedValuesassy[i].designnumber
                                    ) {
                                        if (storedValuesassykq === null) {
                                            console.log("null");
                                            //console.log("vào");
                                            storedValuesassykq = [];
                                            storedValuesassykq.push({
                                                color: storedValuesassy[i].color,
                                            });
                                            sessionStorage.setItem('storedValuesassykq', JSON.stringify(
                                                storedValuesassykq));
                                        } else {
                                            var isDuplicate = false;
                                            // Duyệt qua các phần tử của mảng storedValuesassykq để kiểm tra trùng lặp
                                            for (var j = 0; j < storedValuesassykq.length; j++) {
                                                if (storedValuesassy[i].color == storedValuesassykq[j].color) {
                                                    // Nếu tìm thấy phần tử trùng, đặt cờ isDuplicate thành true
                                                    isDuplicate = true;
                                                    break;
                                                }
                                            }
                                            // Nếu không tìm thấy phần tử trùng, thêm phần tử đó vào mảng storedValuesassykq
                                            if (!isDuplicate) {
                                                storedValuesassykq.push({
                                                    color: storedValuesassy[i].color
                                                });
                                                sessionStorage.setItem('storedValuesassykq', JSON.stringify(
                                                    storedValuesassykq));
                                            }
                                        }
                                        // var element = document.getElementById(storedValuesassy[i].color);
                                        // element.style.display = "block";
                                        // element.style.pointerEvents = "none";
                                    } else{
                                        document.getElementById("error-message1").innerHTML =
                                    "assy không có stk này";
                                    }
                                }


                            }
                        }
                        if (storedValuesassykq == null || storedValuesassykq == undefined) {


                        } else {
                            var stt = JSON.parse(sessionStorage.getItem('stt'));
                            if (stt == null || stt ==undefined) {
                                console.log(stt);
                                stt = [];
                                stt.push({
                                    stt: input4.value,
                                });
                                document.getElementById("error-message1").innerHTML =
                                    "";
                                sessionStorage.setItem('stt', JSON
                                    .stringify(stt));

                            } else {
                                if (stt[0].stt == input4.value) {
                                    console.log(input4.value);
                                    document.getElementById("error-message1").innerHTML =
                                        "Đã quét";
                                        sessionStorage.removeItem('stt');
                                        stt = [];
                                        stt.push({
                                            stt: input4.value,
        
        
                                        });
                                        sessionStorage.setItem('stt', JSON
                                            .stringify(stt));
                                } else{
                                    console.log(input4.value);
                                    document.getElementById("error-message1").innerHTML =
                                        "";
                                        sessionStorage.removeItem('stt');
                                        stt = [];
                                        stt.push({
                                            stt: input4.value,
        
        
                                        });
                                        sessionStorage.setItem('stt', JSON
                                            .stringify(stt));
                                }
                            }



                            var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
                            for (var i = 0; i < storedValuesassykq.length; i++) {
                                var element = document.getElementById(storedValuesassykq[i].color);
                                element.style.visibility = "visible";
                                if (storedValuesassy.length == storedValuesassykq.length) {
                                    document.getElementById("error-1").innerHTML = "Hoàn tất";

                                }
                            }
                            var checkstk = 0;
                            for (var i = 0; i < storedValuesassy.length; i++) {
                                var checkmodel = false;
                                if (storedValuesassy[i].Model != input1.value || storedValuesassy[i]
                                    .version != input2.value) {
                                    // Nếu tìm thấy phần tử trùng, đặt cờ isDuplicate thành true
                                    checkmodel = true;
                                    break;
                                }
                                console.log(storedValuesassy[i].designnumber, input3.value);
                                if (storedValuesassy[i].designnumber !== input3.value) {
                                    // Nếu tìm thấy phần tử trùng, đặt cờ isDuplicate thành true            
                                    checkstk = checkstk + 1;

                                }
                            }
                            console.log(checkstk, storedValuesassy.length);
                            if (checkmodel) {
                                document.getElementById("error-message").innerHTML =
                                    "Model hoặc Version không khớp. Nếu đổi Model vui lòng bấm nút xóa ở trên ";
                            }
                            if (checkstk == storedValuesassy.length) {
                                document.getElementById("error-message").innerHTML =
                                    "Assy không có Số thiết kế này";
                            }
                            if (!checkmodel && checkstk != storedValuesassy.length) {
                                document.getElementById("error-message").innerHTML = "";
                                var assy = btnassy[0].assy;
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
                                        url: '/themlsquetassy/' + input1.value + '/' + input2
                                            .value + '/' +
                                            input3.value + '/' + input4.value + '/' + input0
                                            .value + '/' + inputlot.value + '/' + assy,
                                        success: function(res) {

                                        }
                                    });
                                });

                            }

                        }
                    }
                }
            }


        });
        var malineassy = JSON.parse(sessionStorage.getItem('malineassy'));
        var lotassy = JSON.parse(sessionStorage.getItem('lotassy'));
        var laybtn = JSON.parse(sessionStorage.getItem('laybtn'));

        if (malineassy != null || malineassy != undefined) {
            console.log("vô mã lay");
            document.getElementById("error-message").innerHTML = " ";
            input0.value = malineassy[0].line;
            if (lotassy != null || lotassy != undefined) {
                console.log("vô lot");
                input1.value = lotassy[0].Model;
                input2.value = lotassy[0].Version;
                inputlot.value = lotassy[0].lot;
                if (laybtn != null || laybtn != undefined) {
                    console.log("vô lấy btn");
                    laybtn.forEach(function(item) {
                        // Lấy giá trị màu của từng phần tử
                        // Create a new button element
                        const myButton = document
                            .createElement(
                                'button');

                        // Set the button's attributes
                        myButton.setAttribute('type',
                            'button');
                        myButton.setAttribute('value', item.assy);
                        myButton.className = "btn";
                        myButton.setAttribute('style',
                            'float: center; color: #fff; background-color: #0E6251; margin: 0 10px; height: 50px; width: 50px'
                        );
                        // myButton.classList.add('btn');
                        myButton.textContent = item.assy;


                        // Get the div to add the button to
                        const addButtonDiv = document
                            .getElementById('addassy');

                        // Add the button to the div
                        addButtonDiv.appendChild(myButton);


                    });
                }
                var buttons = document.querySelectorAll(".btn");
                buttons.forEach(function(button) {
                    button.addEventListener("click", function(event) {
                        sessionStorage.removeItem('storedValuesassykq');
                        storedValuesassykq = [];
                        var value = event.target.value;
                        event.preventDefault();
                        var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
                        document.getElementById("error-1").innerHTML = "";
                        $(function() {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                type: 'GET',
                                url: '/checkmauassy/' + input1.value + '/' +
                                    input2.value + '/' + value,

                                success: function(res) {
                                    console.log(value);
                                    if (res.length < 1) {
                                        document.getElementById("error-1").innerHTML =
                                            "ASSY Này không có giá trị";
                                        sessionStorage.removeItem('storedValuesassy');
                                        storedValuesassy = [];
                                    } else {
                                        let storedValuesassy = JSON.parse(sessionStorage
                                            .getItem('storedValuesassy')) || [];

                                        $.each(res, function(i, item) {
                                            const existingItem =
                                                storedValuesassy
                                                .some(
                                                    element => element.Model ===
                                                    item
                                                    .tenmodel && element
                                                    .assy ===
                                                    item
                                                    .assy);

                                            if (!existingItem) {
                                                sessionStorage.removeItem(
                                                    'storedValuesassy');
                                                storedValuesassy = [];
                                                storedValuesassy.push({
                                                    Model: item
                                                        .tenmodel,
                                                    version: item
                                                        .tenversion,
                                                    designnumber: item
                                                        .tenthietke,
                                                    color: item.mamau,
                                                    assy: item.assy,
                                                });
                                                sessionStorage.setItem(
                                                    'storedValuesassy', JSON
                                                    .stringify(
                                                        storedValuesassy)
                                                );
                                            }
                                            // Nếu tìm thấy phần tử, kiểm tra các giá trị khác
                                            else {
                                                const isMatching =
                                                    storedValuesassy
                                                    .some(
                                                        element =>
                                                        element.designnumber ===
                                                        item
                                                        .tenthietke &&
                                                        element.version === item
                                                        .tenversion
                                                    );
                                                // Nếu các giá trị khác không trùng, thêm phần tử mới
                                                if (!isMatching) {
                                                    storedValuesassy.push({
                                                        Model: item
                                                            .tenmodel,
                                                        version: item
                                                            .tenversion,
                                                        designnumber: item
                                                            .tenthietke,
                                                        color: item
                                                            .mamau,
                                                        assy: item.assy,
                                                    });
                                                    sessionStorage.setItem(
                                                        'storedValuesassy',
                                                        JSON
                                                        .stringify(
                                                            storedValuesassy
                                                        )
                                                    );
                                                }
                                            }
                                        });

                                    }
                                }
                            });
                            var btnassy = JSON.parse(sessionStorage.getItem('btnassy'));
                            if (btnassy == null) {
                                btnassy = [];
                                console.log(value);
                                btnassy.push({
                                    assy: value,

                                });
                                sessionStorage.setItem('btnassy', JSON
                                    .stringify(btnassy));

                            } else {
                                sessionStorage.removeItem('btnassy');
                                btnassy = [];
                                btnassy.push({
                                    assy: value,
                                });
                                sessionStorage.setItem('btnassy', JSON
                                    .stringify(btnassy));
                            }
                            location.reload();
                            input.focus();


                        });
                        // }
                    });

                });
                var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
                if (storedValuesassy === null || storedValuesassy === undefined) {


                } else {

                    storedValuesassy.forEach(function(item) {
                        // Lấy giá trị màu của từng phần tử
                        var color = item.color;
                        // Tạo thẻ input type="color"
                        var input = document.createElement("div");
                        input.style.backgroundColor = color;
                        input.className = "ball";

                        // Thêm thẻ div vào trong một thẻ có ID là "color-container"
                        var colorContainer = document.getElementById("col-1");
                        colorContainer.appendChild(input);

                        var input1 = document.createElement("div");
                        input1.style.backgroundColor = color;
                        input1.className = "ball";
                        input1.id = color;
                        input1.style.visibility = "hidden";
                        // Thêm thẻ div vào trong một thẻ có ID là "color-container"
                        var colorContainer1 = document.getElementById("col-2");
                        colorContainer1.appendChild(input1);

                    });
                    var btnassy = JSON.parse(sessionStorage.getItem('btnassy'));
                    var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
                    var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));

                    if (storedValuesassykq == null || storedValuesassykq == undefined) {


                    } else {
                        var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
                        for (var i = 0; i < storedValuesassykq.length; i++) {
                            var element = document.getElementById(storedValuesassykq[i].color);
                            element.style.visibility = "visible";
                            if (storedValuesassy.length == storedValuesassykq.length) {
                                document.getElementById("error-1").innerHTML = "Hoàn tất";

                            }
                        }
                    }



                }


            }
        } else {

            document.getElementById("error-message").innerHTML = "Quét mã line ";
        }
    </script>


</body>

</html>
