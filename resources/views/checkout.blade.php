<!DOCTYPE html>
<html>
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

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <form method="POST" action="{{route('add.order')}}" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Alamat</span>
            <input type="text" class="form-control" aria-label="Sizing example input" name="alamat" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Pos</span>
            <input type="number" class="form-control" aria-label="Sizing example input" name="kodepos" aria-describedby="inputGroup-sizing-default">
        </div>
        
        <div class="container">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th style="width:50%">Product</th>
                        <th style="width:10%">Price</th>
                        <th style="width:8%">Quantity</th>
                        <th style="width:22%" class="text-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @foreach($carts as $cart)
                        @if ($cart->item->jumlah < $cart->quantity)
                            <tr data-id="{{ $cart->id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ asset('storage/' . $cart->item->image_path) }}" class="img-responsive" width="100" height="100" /></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $cart->item->nama }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">Rp. {{ $cart->item->harga }},00</td>
                                <td data-th="Quantity">
                                    <form method="POST" action="{{ route('update.cart', ['id' => $cart->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <p class="btn btn-danger">Stock barang kurang!!</p>
                                        <input type="hidden" name="id" value="{{ $cart->id }}">
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" class="form-control quantity cart_update" min="1" />
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </td>
                                <td data-th="Subtotal" class="text-center">Rp. {{ $cart->item->harga * $cart->quantity }},00</td>
                                <td class="actions" data-th="">
                                    <form method="POST" action="{{ route('remove.from.cart', ['id' => $cart->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>                            
                                </td>
                            </tr>
                        @else
                            @php $total += $cart->item->harga * $cart->quantity @endphp
                            <tr data-id="{{ $cart->id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ asset('storage/' . $cart->item->image_path) }}" class="img-responsive" width="100" height="100" /></div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $cart->item->nama }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">Rp. {{ $cart->item->harga }},00</td>
                                <td data-th="Quantity"> {{ $cart->quantity }}</td>
                                <td data-th="Subtotal" class="text-center">Rp. {{ $cart->item->harga * $cart->quantity }},00</td>
                            </tr>
                        @endif
    
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><h3><strong>Total Rp.{{ $total }},00</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ route ('cart') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Back To Cart</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="total" value="{{ $total }}">
            <div class="text-right">
                <button class="btn btn-success" type="submit"><i class="fa fa-money"></i> Order</button>
            </div>
        </div>
    </form>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
