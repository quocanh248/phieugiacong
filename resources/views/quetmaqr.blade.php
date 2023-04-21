<!DOCTYPE html>
<html>

<head>
    <title>QR Code Scanner</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* CSS để tạo một giao diện đơn giản */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #eee;
            border-radius: 5px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            float: right;
        }

        button:hover,
        button:focus {
            background-color: #2980b9;
        }

        .color-picker-container {
            height: 80px;
            width: 80px;
            border-radius: 50%;
            overflow: hidden;
        }

        .color-picker-container input[type="color"] {
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>QR Code Scanner</h1>
        <button id="reset-btn">Reset</button>
        <label for="input1">Mã QR:</label>
        <form action="" id="form">
            <input type="text" id="input-qr">
            <label for="input1">Model:</label>
            <input type="text" id="input1">
            <label for="input2">Phiên bản</label>
            <input type="text" id="input2">
            <label for="input3">Số thiết kế</label>
            <input type="text" id="input3">
            @csrf
        </form>
        <label for="color-picker">Color:</label>
        <div class="color-picker-container" id="result" style="background-color: #FFFFFF;">
            <input type="color" id="color-picker">

        </div>
        {{-- <div id="result" style="background-color: #FFFFFF;"></div> --}}

    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="/dist/quagga.min.js"></script>
    <script>
        let results = {!! json_encode($results) !!};
        console.log(results);
        // Khởi tạo mảng lưu trữ các đối tượng
        storedValues = [];

        // Lặp qua các kết quả và thêm vào mảng storedValues
        results.forEach(function(result) {
            storedValues.push({
                Model: result.tenmodel,
                version: result.tenversion,
                designnumber: result.tenthietke,
                color: result.mau, // randomColor là một giá trị mà bạn tự định nghĩa
            });
        });

        // Lưu mảng storedValues vào session
        sessionStorage.setItem('storedValues', JSON.stringify(storedValues));
        $(document).ready(function() {
            $('#input-qr').focus();
        });
        var resetBtn = document.getElementById('reset-btn');
        var input = document.getElementById("input-qr");
        var resultDiv = document.getElementById("result");
        var color = document.getElementById("color-picker");
        resetBtn.addEventListener('click', function() {
            input.value = '';
            input.focus();
        });
        input.addEventListener("change", function() {
            // Tách chuỗi vừa nhập vào 
            var code = input.value;
            var codes = code.split(" ");
            var colors = ["#ff7fbf", "#a500dd", "#bfff7f", "#954a00", "#7fbfff", "#767676", "#ffffff", "#ff9f7f"];
            // Hiển thị các chuỗi đầu tiên vào các input tương ứng
            input1.value = codes[0];
            input2.value = codes[1];
            input3.value = codes[2];
            $.ajax({
                url: '/checkmodel',
                method: 'POST',
                data: {
                    input1: codes[0],
                    
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

            if (codes[0] === "") {

            } else {
                // Lấy giá trị đã lưu trong session storage
                var storedValues = JSON.parse(sessionStorage.getItem('storedValues'));
                // Nếu chưa có giá trị nào được lưu trước đó, tạo một mảng rỗng
                if (!storedValues) {
                    storedValues = [];
                }
                // Hiển thị nội dung chuỗi vừa quét vào div .result
                // resultDiv.innerHTML = "<strong>Nội dung đã quét:</strong> " + code;
                var input1Value = $("#input1").val();
                var input2Value = $("#input2").val();
                var input3Value = $("#input3").val();
                // var colorValue = $("#color-picker").val();               
                var duplicate = false;
                for (var i = 0; i < storedValues.length; i++) {
                    if (storedValues[i].Model === input1Value &&
                        storedValues[i].version === input2Value &&
                        storedValues[i].designnumber === input3Value) {
                        // Nếu tìm thấy giá trị trùng lặp, đặt giá trị của duplicate là true và thoát vòng lặp
                        duplicate = true;
                        break;
                    }
                }
                if (duplicate) {
                    console.log('Giá trị trùng lặp đã tồn tại trong mảng storedValues');
                    color.value = storedValues[i].color;
                    resultDiv.style.backgroundColor = color;

                } else {
                    console.log('Giá trị mới không trùng lặp với bất kỳ giá trị nào trong mảng storedValues');
                    // cấp màu
                    var colors1 = storedValues.map(function(obj) {
                        return obj.color;
                    });

                    var filteredColors = colors.filter(function(color) {
                        // Loại bỏ các màu có trong mảng màu cần loại bỏ
                        return !colors1.includes(color);
                    });

                    // In ra mảng màu sau khi loại bỏ các màu cần loại bỏ

                    var randomColor = filteredColors[Math.floor(Math.random() * filteredColors.length)];
                    color.value = randomColor;
                    resultDiv.style.backgroundColor = randomColor;
                    //thêm vào cơ sở dữ liệu
                    $(document).ready(function() {
                        $.ajax({
                            url: '/themmodel',
                            method: 'POST',
                            data: {
                                input1: input1Value,
                                input2: input2Value,
                                input3: input3Value,
                                mau: randomColor,
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

                    // Lưu vào session
                    storedValues.push({
                        Model: input1Value,
                        version: input2Value,
                        designnumber: input3Value,
                        color: randomColor,
                    });
                }
                // Lưu mảng đã được cập nhật vào session storage
                sessionStorage.setItem('storedValues', JSON.stringify(storedValues));

                function addToDatabase(input1Value, input2Value, input3Value, randomColor) {

                }
            }
        });
    </script>
</body>

</html>
