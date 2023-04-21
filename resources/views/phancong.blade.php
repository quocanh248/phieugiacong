<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Summernote with Bootstrap 4</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <style>

    </style>
    <!--
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> -->

</head>

<body>

    <div class="content">
        <form method="POST" action="them">
            @csrf
            @foreach ($hp as $h)
                <div class="row">
                    <label>
                        <input type="checkbox" name="subjects[{{ $h['idhocphan'] }}]" value="{{ $h['idhocphan'] }}">
                        {{ $h['tenhocphan'] }}
                    </label>
                    <?php $gv1 = $gv->getgv($h['idhocphan']); ?>
                    <select name="teachers[{{ $h['idhocphan'] }}]" id="math_teacher_name">
                        <option value="">-- Chọn giáo viên --</option>
                        @foreach ($gv1 as $g)
                            <option value="{{ $g->idgiaovien }}">-- {{ $g->tengiaovien }}--</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
            <button type="submit">Thêm</button>
        </form>
    </div>
</body>

</html>
