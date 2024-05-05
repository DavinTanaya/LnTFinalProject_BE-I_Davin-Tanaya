<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Detail - PT Chipi Chapa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Order Detail</h1>
        <div class="row">
            <div class="col-md-6">
                <h4>Invoice ID: {{ $order->invoice_id }}</h4>
                <p>Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                <p>Address: {{ $order->address }}</p>
                <p>Postal Code: {{ $order->kodepos }}</p>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @foreach ($item->category as $c)
                                        <li>{{ $c->categoryName }}</li>
                                    @endforeach
                                </td>
                                <td>{{ $item->pivot->quantity }}</td>
                                <td>Rp. {{ $item->harga * $item->pivot->quantity }},00</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td>Rp. {{ $order->total }},00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- <div class="text-center">
            <a href="{{ route('invoice.pdf', $order->id) }}" class="btn btn-primary">Download PDF</a>
        </div> --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
