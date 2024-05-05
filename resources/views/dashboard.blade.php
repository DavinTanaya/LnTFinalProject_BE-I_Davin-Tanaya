<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT Chipi Chapa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <a class="navbar-brand">PT Chipi Chapa</a>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                @if(Auth::user()->is_admin == '1')
                    <li class="nav-item">
                    <a class="nav-link" href="{{route('add.item.form')}}">Add Item</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{route('add.cat.form')}}">Create Category</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav">
              @if(Auth::user()->is_admin == '0')
              <li class="nav-item">
                <a href="{{route('order.history')}}" class="btn btn-success">Order History</a>
              </li>
              <li class="nav-item">
                  <button type="button" class="btn btn-primary" data-toggle="dropdown">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ $carts->count() }}</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <div class="row total-header-section">
                        @php $total = 0 @endphp
                        @foreach($carts as $cart)
                            @php $total += $cart->item->harga * $cart->quantity @endphp
                        @endforeach
                        <div class="col-lg-12 col-sm-12 col-12 total-section text-right">
                            <p>Total: <span class="text-info"><strong>Rp. {{ $total }},00</strong></span></p>
                        </div>
                    </div>
                    @foreach($carts as $cart)
                      <div class="row cart-detail">
                        <div class="col-lg-3 col-sm-3 col-3 cart-detail-img">
                            <img src="{{ asset('storage/' . $cart->item->image_path) }}" width="100px" height="auto"/>
                        </div>
                        <div class="col-lg-9 col-sm-9 col-9 cart-detail-product">
                            <div class="d-flex justify-content-between align-items-center">
                                <p>{{ $cart->item->nama }}</p>
                                <span class="price text-info">Rp. {{ $cart->item->harga }},00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="count">Quantity: {{ $cart->quantity }}</span>
                            </div>
                        </div>
                      </div>
                    @endforeach
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                        </div>
                    </div>
                </div>
              </li>      
              @else
                <li class="nav-item">
                  <a href="{{route('all.order')}}" class="btn btn-success">Orders</a>
                </li>
              @endif
              <li class="nav-item">
                  <a href="/logout" class="btn btn-danger">Logout</a>
              </li>
          </ul>
  
        </div>
    </nav>
    <div>
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
      @endif
      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div> 
      @endif
    </div>
    <div class="content">
        @foreach($semuaitem as $item)
          <div class="card" style="width: 18rem;">
            <img src="{{asset('storage/'.$item->image_path)}}" class="card-img-top" alt="foto barang">
            <div class="card-body">
              <h5 class="card-title">{{$item->nama}}</h5>
              <p><strong>Rp. {{$item->harga}},00</strong></p>
              <p><strong>Stock : </strong>{{$item->jumlah}} pcs</p>
              <h5>Category:</h5>
              @foreach ($item->category as $c)
                  <li>{{$c->categoryName}}</li>
              @endforeach

              @if(Auth::user()->is_admin == '1')
                <a href="{{route('edit.item.form', ['id' => $item->id])}}" class="btn btn-primary">Edit</a>
                <a href="{{route('update.cat.form', ['id' => $item->id])}}" class="btn btn-success">Add Category</a>
    
                <form method="POST" action="{{route('delete', ['id' => $item->id])}}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i> Delete</button>
                </form>
              @else
                @if ($item->jumlah > 0)
                  <p class="btn-holder"><a href="{{ route('add_to_cart', $item->id) }}" class="btn btn-primary btn-block text-center" role="button">Add to cart</a> </p>
                @else
                  <p class="btn-holder"><a class="btn btn-danger btn-block text-center">Barang sudah habis,
                    silakan tunggu hingga barang di-restock ulang</a> </p>
                @endif
              @endif
            </div>
          </div>
        @endforeach
      </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
