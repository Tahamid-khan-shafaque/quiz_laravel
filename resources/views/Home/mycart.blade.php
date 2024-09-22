<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 800px;
        }

        th {
            border: 2px solid black;
            text-align: center;
            color: black;
            font-size: 20px;
            font-weight: bold;
        }

        td {
            border: 1px solid skyblue;
        }

        .cart_value {
            text-align: center;
            margin-bottom: 70px;
            padding: 18px;
        }

        .order_deg {
            padding-right: 150px;
            margin-top: -50px;
        }

        label {
            display: inline-block;
            width: 150px;
        }

        .div_gap {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        @include('home.header')
    </div>

    <div class="div_deg">
        <table>
            <tr>
                <th>Product Title</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Product Image</th>
                <th>Remove</th>
            </tr>

            @php
            $value = 0; // Initialize total value
            @endphp

            @foreach($cart as $item)
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>{{ $item->product->price }}</td>
                <td>
                    <input type="number" id="quantity_{{ $item->id }}" class="quantity" data-price="{{ $item->product->price }}" value="{{ $item->quantity ? $item->quantity : 1 }}" style="width: 50px;" onchange="calculateTotal()">
                </td>
                <td><img src="productimage/{{ $item->product->image }}" alt="" width="65px" height="65px"></td>

<td>
    <form action="{{ route('remove_cart', $item->id) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">Remove</button>
    </form>
</td>
            </tr>

            @php
            $value += $item->product->price * ($item->quantity ? $item->quantity : 1); // Calculate total value
            @endphp

            @endforeach
        </table>
    </div>

    <div class="cart_value">
        <h1 id="total_price">Total price : {{ $value }}</h1>
        <!-- <a class="btn btn-success" href="{{ url('stripe', $value) }}">Pay using Card</a> -->
    </div>

 

    <div class="order_deg">
        <form action="{{ route('confirm_order') }}" method="post">
            @csrf
            <div class="div_gap">
                <label for="">Receiver Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}">
            </div>
            <div class="div_gap">
                <label for="">Receiver Address</label>
                <input type="textarea" name="address" value="{{ Auth::user()->address }}">
            </div>
            <div class="div_gap">
                <label for="">Receiver Phone</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone }}">
            </div>
            <div class="div_gap">
                <input class="btn btn-primary" type="submit" value="Cash On Delivery">
                <a class="btn btn-success" href="{{ url('stripe', $value) }}">Pay using Card</a>
            </div>
        </form>
    </div>

    @include('home.footer')
    <script>
        function calculateTotal() {
            let totalPrice = 0;

            const quantities = document.querySelectorAll(".quantity");

            quantities.forEach(quantity => {
                const price = quantity.dataset.price;
                const quantityValue = quantity.value;
                totalPrice += price * quantityValue;
            });

            document.getElementById("total_price").textContent = "Total price : " + totalPrice.toFixed(2);

            document.querySelectorAll(".btn-success").forEach(button => {
                button.href = `{{ url('stripe') }}/${totalPrice.toFixed(2)}`;
            });
        }

        calculateTotal();
    </script>
</body>

</html>


