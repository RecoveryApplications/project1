<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JMEGoods</title>
</head>

<body>
    <h2>{{ $order->customer->name_en ?? $order->name }} Thank you for your order</h2>
    <h3>Summary of your order from JMEGoods</h3>
    <a href="{{ $pdf }}">To view the invoice</a>
</body>

</html>
