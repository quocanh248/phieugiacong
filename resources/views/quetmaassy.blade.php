<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phiếu gia công</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Ionicons -->

    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
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
                                <button id="reset-btn" style="float: right;" class="btn-primary float-right"><i
                                        class="fa-solid fa-broom fa-lg" style="color: #f9f8f8; width: 50px; height: 20px"></i></button>
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
                        <div class="row" >
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
                        <div class="row">
                            <div class="col-2">
                                <label for="input3">Kết quả</label>
                            </div>
                            <div class="col-10">
                                @foreach ($mau as $data)
                                    <div style="--ball-color: {{ $data->mamau }}; display: none" class="ball"
                                        id="{{ $data->mamau }}"></div>
                                @endforeach
                            </div>
                        </div>
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
        $(document).ready(function() {
            $('#input-qr').focus();
        });
        var resetBtn = document.getElementById('reset-btn1');
        var malineassy = JSON.parse(sessionStorage.getItem('malineassy'));
        if (malineassy != null) {
            input0.value = malineassy[0].line;
        }
        var inputlot = document.getElementById("inputlot");
        var lotassy = JSON.parse(sessionStorage.getItem('lotassy'));
        if (lotassy != null) {
            inputlot.value = lotassy[0].lot;
        }
        var input = document.getElementById("input-qr");
        var ip = input.value;
        var input1 = document.getElementById("input1");
        var input2 = document.getElementById("input2");
        var input3 = document.getElementById("input3");
        var input4 = document.getElementById("input4");
        var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
        var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
        var color = document.getElementById("color-picker");

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
                        input.value = "";
                        input.focus();
                        var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
                        if (modelassy == null) {
                            modelassy = [];
                            modelassy.push({
                                Model: input1.value,
                                version: input2.value,
                                designnumber: input3.value,

                            });
                            sessionStorage.setItem('modelassy', JSON
                                .stringify(modelassy));

                        } else {
                            sessionStorage.removeItem('modelassy');
                            modelassy = [];
                            modelassy.push({
                                Model: input1.value,
                                version: input2.value,
                                designnumber: input3.value,
                            });
                            sessionStorage.setItem('modelassy', JSON
                                .stringify(modelassy));
                        }
                        var lotassy = JSON.parse(sessionStorage.getItem('lotassy'));
                        if (lotassy == null) {
                            lotassy = [];
                            lotassy.push({
                                lot: inputlot.value,

                            });
                            sessionStorage.setItem('lotassy', JSON
                                .stringify(lotassy));

                        } else {
                            sessionStorage.removeItem('lotassy');
                            lotassy = [];
                            lotassy.push({
                                lot: inputlot.value,
                            });
                            sessionStorage.setItem('lotassy', JSON
                                .stringify(lotassy));
                        }
                        document.getElementById("error-message").innerHTML = " ";
                        var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
                        var historyassy = JSON.parse(sessionStorage.getItem('historyassy'));

                        if (historyassy != null) {
                            if (historyassy[0].input == code) {

                                document.getElementById("error-1").innerHTML = "Đã quét";
                            } else {
                                document.getElementById("error-1").innerHTML = " ";
                                historyassy = [];
                                historyassy.push({
                                    input: code,
                                });
                                sessionStorage.setItem('historyassy', JSON.stringify(historyassy));
                                // document.getElementById("error-message").innerHTML = " ";
                            }
                        } else {
                            historyassy = [];
                            historyassy.push({
                                input: code,
                            });
                            sessionStorage.setItem('historyassy', JSON.stringify(historyassy));
                        }
                    } else {
                        input.value = "";
                        input.focus();
                    }
                }

            }
            var btnassy = JSON.parse(sessionStorage.getItem('btnassy'));
            var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
            var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
            
            if (storedValuesassykq === null || storedValuesassykq === undefined) {
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

                            } else {
                                let laybtn = JSON.parse(sessionStorage
                                    .getItem('laybtn')) || [];

                                $.each(res, function(i, item) {
                                    const existingItem = laybtn
                                        .some(
                                            element => element.assy === item.assy);

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


                            }
                            location.reload();
                        }
                    });
                });

            } else {
                var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
                for (var i = 0; i < storedValuesassykq.length; i++) {
                    var element = document.getElementById(storedValuesassykq[i].color);
                    element.style.display = "inline-block";

                }
                if (storedValuesassy.length == storedValuesassykq.length) {
                    document.getElementById("error-1").innerHTML = "Hoàn tất";
                }
                location.reload();
            }



        });
        let laybtn = JSON.parse(sessionStorage.getItem('laybtn')) || [];
        if (laybtn !== null || laybtn !== undefined) {
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

            var buttons = document.querySelectorAll(".btn");
            buttons.forEach(function(button) {
                button.addEventListener("click", function(event) {
                    sessionStorage.removeItem('storedValuesassykq');
                    storedValuesassykq = [];
                    var value = event.target.value;
                    event.preventDefault();
                    var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
                    // if (input1.value == "") {

                    //     document.getElementById("error-1").innerHTML =
                    //         "Vui lòng quét phiếu trước khi chọn ASSY";
                    //     input.focus();
                    // } else {
                    document.getElementById("error-1").innerHTML =
                        "";
                    $(function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            type: 'GET',
                            url: '/checkmauassy/' + modelassy[0].Model + '/' + modelassy[0]
                                .version + '/' + value,

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
        }
        if (storedValuesassy === null || storedValuesassy === undefined) {


        } else {
            var storedValuesassy = JSON.parse(sessionStorage.getItem('storedValuesassy'));
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

            });
            var btnassy = JSON.parse(sessionStorage.getItem('btnassy'));
            var modelassy = JSON.parse(sessionStorage.getItem('modelassy'));
            var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
            // if (storedValuesassy[0].Model != modelassy[0].Model || storedValuesassy[0].version != modelassy[0].version) {

            // } else if (storedValuesassy[0].designnumber != modelassy[0].designnumber) {
            //     document.getElementById("error-message").innerHTML = "Assy không có Số thiết kê này";
            // } else {
            //     document.getElementById("error-message").innerHTML = "";
            // }
            var checkstk = 0;
            for (var i = 0; i < storedValuesassy.length; i++) {
                var checkmodel = false;
                if (storedValuesassy[i].Model != modelassy[0].Model || storedValuesassy[i].version != modelassy[0]
                    .version) {
                    // Nếu tìm thấy phần tử trùng, đặt cờ isDuplicate thành true
                    checkmodel = true;
                    break;
                }
                console.log(storedValuesassy[i].designnumber , modelassy[0].designnumber);
                if (storedValuesassy[i].designnumber !== modelassy[0].designnumber) {
                    // Nếu tìm thấy phần tử trùng, đặt cờ isDuplicate thành true            
                    checkstk = checkstk + 1;
                   
                }
            }
            console.log(checkstk, storedValuesassy.length);
            if (checkmodel) {
                document.getElementById("error-message").innerHTML = "Model hoặc Version không khớp----------";
            } else {
                
            }
            if (checkstk == storedValuesassy.length) {
                document.getElementById("error-message").innerHTML = "Assy không có Số thiết kê này";
            } else {

            }

            if (btnassy[0].assy == storedValuesassy[0].assy) {
                for (var i = 0; i < storedValuesassy.length; i++) {
                    if (modelassy[0].Model === storedValuesassy[i].Model && modelassy[0].version === storedValuesassy[i]
                        .version && modelassy[0].designnumber === storedValuesassy[i].designnumber) {
                        if (storedValuesassykq === null) {
                            //console.log("vào");
                            storedValuesassykq = [];
                            storedValuesassykq.push({
                                color: storedValuesassy[i].color,
                            });
                            sessionStorage.setItem('storedValuesassykq', JSON.stringify(storedValuesassykq));
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
                                sessionStorage.setItem('storedValuesassykq', JSON.stringify(storedValuesassykq));
                            }
                        }
                        // var element = document.getElementById(storedValuesassy[i].color);
                        // element.style.display = "block";
                        // element.style.pointerEvents = "none";
                    }
                }


            }


        }
        if (storedValuesassykq === null || storedValuesassykq === undefined) {



        } else {
            var storedValuesassykq = JSON.parse(sessionStorage.getItem('storedValuesassykq'));
            for (var i = 0; i < storedValuesassykq.length; i++) {
                var element = document.getElementById(storedValuesassykq[i].color);
                element.style.display = "inline-block";
                if (storedValuesassy.length == storedValuesassykq.length) {
                    document.getElementById("error-1").innerHTML = "Hoàn tất";

                }
            }
        }

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
                        url: '/checkassy/' + $("#input1").val() + '/' + $("#input2").val(),
                        success: function(res) {

                            console.log($("#input1").val(), $("#input2").val())
                            console.log(res);
                            if (res.length < 1) {
                                callback(1);
                            } else {
                                let storedValuesassy = JSON.parse(sessionStorage
                                    .getItem(
                                        'storedValuesassy')) || [];

                                $.each(res, function(i, item) {
                                    const existingItem = storedValuesassy.some(
                                        element =>
                                        element.Model === item.tenmodel);

                                    if (!existingItem) {
                                        sessionStorage.removeItem(
                                            'storedValuesassy');
                                        storedValuesassy = [];
                                        storedValuesassy.push({
                                            Model: item.tenmodel,
                                            version: item
                                                .tenversion,
                                            designnumber: item
                                                .tenthietke,
                                            color: item.mamau,
                                            assy: item.assy,
                                        });
                                        sessionStorage.setItem(
                                            'storedValuesassy', JSON
                                            .stringify(storedValuesassy));
                                    }
                                    // Nếu tìm thấy phần tử, kiểm tra các giá trị khác
                                    else {
                                        const isMatching = storedValuesassy
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
                                                .stringify(storedValuesassy)
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
