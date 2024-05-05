<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <a class="navbar-brand">PT Chipi Chapa</a>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('add.item.form')}}">Add Item</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('add.cat.form')}}">Create Category</a>
                </li>

            </ul>
              <ul>
                  <a href="/logout" class="btn btn-warning">Logout</a>
              </ul>
        </div>
    </nav>

    <form method="POST" action="{{route('add.cat')}}" enctype="multipart/form-data">
        @csrf
        <h1>Create New Category</h1>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Category Name</span>
            <input type="text" class="form-control" aria-label="Sizing example input" name="categoryName" aria-describedby="inputGroup-sizing-default" required>
        </div>
        
        <button type="submit" class="btn btn-success">Submit</button>  
    </form>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
