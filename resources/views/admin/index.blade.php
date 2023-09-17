@extends('admin.layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- ================== Sweet Alert Section ==================== --}}
    {{-- =========================================================== --}}
    <div>
        @if (session()->has('success'))
            <script>
                swal("Great Job !!!", "{!! Session::get('success') !!}", "success", {
                    button: "OK",
                });
            </script>
        @endif
        @if (session()->has('danger'))
            <script>
                swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                    button: "Close",
                });
            </script>
        @endif
    </div>

    {{-- ====================================================================== --}}
    {{-- =========================== All Counters ============================= --}}
    {{-- ====================================================================== --}}
    <div class="col-xxl-3 col-md-6 xl-50">
        <div class="card o-hidden widget-cards">
            <div class="warning-box card-body">
                <div class="media static-top-widget align-items-center">
                    <div class="icons-widgets">
                        <div class="align-self-center text-center">
                            <i data-feather="navigation" class="font-warning"></i>
                        </div>
                    </div>
                    <div class="media-body media-doller">
                        <span class="m-0">All Customers</span>
                        <h3 class="mb-0"> <span class="counter">{{ isset($customers) ? $customers->count() : 0 }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6 xl-50">
        <div class="card o-hidden widget-cards">
            <div class="secondary-box card-body">
                <div class="media static-top-widget align-items-center">
                    <div class="icons-widgets">
                        <div class="align-self-center text-center">
                            <i data-feather="box" class="font-secondary"></i>
                        </div>
                    </div>
                    <div class="media-body media-doller">
                        <span class="m-0">Products</span>
                        <h3 class="mb-0"> <span
                                class="counter">{{ isset($public_products) ? $public_products->count() : 0 }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6 xl-50">
        <div class="card o-hidden widget-cards">
            <div class="primary-box card-body">
                <div class="media static-top-widget align-items-center">
                    <div class="icons-widgets">
                        <div class="align-self-center text-center"><i data-feather="message-square"
                                class="font-primary"></i></div>
                    </div>
                    <div class="media-body media-doller"><span class="m-0">All Orders</span>
                        <h3 class="mb-0"> <span class="counter">{{ isset($CartSales) ? $CartSales->count() : 0 }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6 xl-50">
        <div class="card o-hidden widget-cards">
            <div class="danger-box card-body">
                <div class="media static-top-widget align-items-center">
                    <div class="icons-widgets">
                        <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                    </div>
                    <div class="media-body media-doller"><span class="m-0">Pendding Products</span>
                        <h3 class="mb-0"> <span
                                class="counter">{{ isset($penddingCartSales) ? $penddingCartSales->count() : 0 }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 xl-100">
        <div class="card">
            <div class="card-header">
                <h5> New Customers </h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left"></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="user-status table-responsive latest-order-table">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th scope="col"> ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($newCustomers))
                                @if ($newCustomers->count() > 0)
                                    @foreach ($newCustomers as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td class="digits">
                                                @if ($user->profile_photo_path && file_exists($user->profile_photo_path))
                                                    <a
                                                        href="{{ route('super_admin.users-show', [$user->id, 'Customer']) }}"><img
                                                            style="    height: 50px;" class="rounded-circle w-45"
                                                            src="{{ asset($user->profile_photo_path) }}"
                                                            alt="customer image"></a>
                                                @else
                                                    <a
                                                        href="{{ route('super_admin.users-show', [$user->id, 'Customer']) }}"><img
                                                            class="rounded-circle w-45" style="    height: 50px;"
                                                            src="{{ asset('images_default/user.jpg') }}" alt="image"></a>
                                                @endif
                                            </td>
                                            <td class="font-danger">{{ isset($user->email) ? $user->email : 'Undefined' }}
                                            </td>
                                            <td class="digits">{{ isset($user->phone) ? $user->phone : 'Undefined' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <h2 style="color: red;">There are no new customers !!</h2>
                                @endif
                            @else
                                <h4 style="color: red;">There are no new customers !!</h4>
                            @endif
                        </tbody>
                    </table>
                    {{-- <a href="order.html" class="btn btn-primary mt-4">View All Orders</a> --}}
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1"
                        title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    <pre class=" language-html"><code class=" language-html" id="example-head1">
                        &lt;div class="user-status table-responsive latest-order-table"&gt;
                        &lt;table class="table table-bordernone"&gt;
                        &lt;thead&gt;
                        &lt;tr&gt;
                        &lt;th scope="col"&gt;Order ID&lt;/th&gt;
                        &lt;th scope="col"&gt;Order Total&lt;/th&gt;
                        &lt;th scope="col"&gt;Payment Method&lt;/th&gt;
                        &lt;th scope="col"&gt;Status&lt;/th&gt;
                        &lt;/tr&gt;
                        &lt;/thead&gt;
                        &lt;tbody&gt;
                        &lt;tr&gt;
                        &lt;td&gt;1&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;2&lt;/td&gt;
                        &lt;td class="digits"&gt;$90.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Ewallets&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;3&lt;/td&gt;
                        &lt;td class="digits"&gt;$240.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Cash&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;4&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Direct Deposit&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;5&lt;/td&gt;
                        &lt;td class="digits"&gt;$50.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;/tbody&gt;
                        &lt;/table&gt;
                        &lt;/div&gt;
                </code></pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 xl-100">
        <div class="card">
            <div class="card-header">
                <h5> New Orders</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left"></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="user-status table-responsive latest-order-table">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th scope="col"> ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($newCartSales))
                            @if ($newCartSales->count() > 0)
                                @foreach ($newCartSales as $newCartSale)
                                        <tr>
                                            <td>{{ $newCartSale->id }}</td>
                                            <td class="digits">
                                                @if (isset($newCartSale?->customer))
                                                            @if ($newCartSale->customer->profile_photo_path && file_exists($newCartSale->customer->profile_photo_path))
                                                                <a
                                                                    href="{{ route('super_admin.orders-show', [$newCartSale->id]) }}"><img
                                                                    style="    height: 50px;"
                                                                        class="rounded-circle w-45"
                                                                        src="{{ asset($newCartSale->customer->profile_photo_path) }}"
                                                                        alt="customer image"></a>
                                                            @else
                                                                <a
                                                                    href="{{ route('super_admin.orders-show', [$newCartSale->id]) }}"><img
                                                                    style="    height: 50px;"
                                                                        class="rounded-circle w-45"
                                                                        src="{{ asset('images_default/user.jpg') }}"
                                                                        alt="customer image"></a>
                                                            @endif
                                                        @else
                                                            <a
                                                                href="{{ route('super_admin.orders-show', [$newCartSale->id]) }}"><img
                                                                style="    height: 50px;"
                                                                    class="rounded-circle w-45"
                                                                    src="{{ asset('images_default/user.jpg') }}"
                                                                    alt="customer image"></a>
                                                        @endif
                                            </td>
                                            <td class="font-danger">{{ isset($newCartSale->customer->email) ? $newCartSale->customer->email : 'Undefined' }}
                                            </td>
                                            <td class="digits">{{ isset($newCartSale->customer->phone) ? $newCartSale->customer->phone : 'Undefined' }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                            <td colspan="8">
                                                <h4 style="color: red;">There are no new orders !!</h4>
                                            </td>


                                        @endif
                                    @else
                                        <td colspan="8">
                                            <h4 style="color: red;">There are no new orders !!</h4>
                                        </td>


                                    @endif
                        </tbody>
                    </table>
                    {{-- <a href="order.html" class="btn btn-primary mt-4">View All Orders</a> --}}
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1"
                        title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    <pre class=" language-html"><code class=" language-html" id="example-head1">
                        &lt;div class="user-status table-responsive latest-order-table"&gt;
                        &lt;table class="table table-bordernone"&gt;
                        &lt;thead&gt;
                        &lt;tr&gt;
                        &lt;th scope="col"&gt;Order ID&lt;/th&gt;
                        &lt;th scope="col"&gt;Order Total&lt;/th&gt;
                        &lt;th scope="col"&gt;Payment Method&lt;/th&gt;
                        &lt;th scope="col"&gt;Status&lt;/th&gt;
                        &lt;/tr&gt;
                        &lt;/thead&gt;
                        &lt;tbody&gt;
                        &lt;tr&gt;
                        &lt;td&gt;1&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;2&lt;/td&gt;
                        &lt;td class="digits"&gt;$90.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Ewallets&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;3&lt;/td&gt;
                        &lt;td class="digits"&gt;$240.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Cash&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;4&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Direct Deposit&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;5&lt;/td&gt;
                        &lt;td class="digits"&gt;$50.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;/tbody&gt;
                        &lt;/table&gt;
                        &lt;/div&gt;
                </code></pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 xl-100">
        <div class="card">
            <div class="card-header">
                <h5>Pending delivery orders</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left"></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="user-status table-responsive latest-order-table">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th scope="col"> ID</th>
                                <th scope="col">Date/Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Sub Total</th>
                                <th scope="col">Delivery Fees</th>
                                <th scope="col">Total</th>
                                <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($deliveryCartSales))
                            @if ($deliveryCartSales->count() > 0)
                                @foreach ($deliveryCartSales as $order)
                                    <tr>
                                        <td>{!! isset($order->id) ? $order->id : "<span style='color:rgb(83, 83, 83);'>Undefined</span>" !!}</td>
                                        <td>{{ date('Y.d.m / h:i A', strtotime($order->created_at)) }}</td>
                                        <td>
                                            @if (isset($order->status))
                                                @if ($order->status == 'Accepted')
                                                    <span
                                                        style="color: green;">{{ isset($order->status) ? $order->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @else
                                                    <span
                                                        style="color: red;">{{ isset($order->status) ? $order->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @endif
                                            @else
                                                <span style='color:red;'>Undefined</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($order->payment_status))
                                                @if ($order->payment_status == 'Pendding')
                                                    <span
                                                        style="color:rgba(182, 121, 7, 0.87);">{!! $order->payment_status !!}</span>
                                                @elseif($order->payment_status == 'Accepted')
                                                    <span style="color:green;">{!! $order->payment_status !!}</span>
                                                @elseif($order->payment_status == 'Rejected')
                                                    <span style="color:red;">{!! $order->payment_status !!}</span>
                                                @endif
                                            @else
                                                <span>------</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($order->delivery_status))
                                                @if ($order->delivery_status == 'Pendding')
                                                    <span style="color:red">{!! $order->delivery_status !!}</span>
                                                @elseif($order->delivery_status == 'In Progress')
                                                    <span
                                                        style="color:rgba(182, 121, 7, 0.87)">{!! $order->delivery_status !!}</span>
                                                @elseif($order->delivery_status == 'Received')
                                                    <span style="color:green">{!! $order->delivery_status !!}</span>
                                                @endif
                                            @else
                                                <p class="cart_amount">------</p>
                                            @endif
                                        </td>
                                        <td>{!! isset($order->sub_total)
                                            ? $order->sub_total . '<small> SAR</small>'
                                            : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>25 <small>SAR</small></td>
                                        <td>{!! isset($order->total)
                                            ? $order->total + 25 . '<small> SAR</small>'
                                            : "<span style='color:red;'>Undefined</span>" !!}</td>

                                        <td>
                                            <a href="{{ route('super_admin.orders-show', [$order->id]) }}"
                                                title="Show Order Details" class="mb-1 btn btn-sm btn-info"><i
                                                    class="mdi mdi-eye"></i></a>
                                            @if (!isset($order->delivery_status))
                                                <a href="{{ route('super_admin.orders-sendToDelivery', [$order->id]) }}"
                                                    title="Send To Delivery"
                                                    class="process mb-1 btn btn-sm btn-success"><i
                                                        class="mdi mdi-send"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="8">
                                    <h3 style="color: red; text-align:center;">There are no new pending delivery orders
                                        !!</h3>
                                </td>
                            @endif
                        @else
                            <td colspan="8">
                                <h3 style="color: red; text-align:center;">There are no new pending delivery orders !!
                                </h3>
                            </td>
                        @endif
                        </tbody>
                    </table>
                    {{-- <a href="order.html" class="btn btn-primary mt-4">View All Orders</a> --}}
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1"
                        title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    <pre class=" language-html"><code class=" language-html" id="example-head1">
                        &lt;div class="user-status table-responsive latest-order-table"&gt;
                        &lt;table class="table table-bordernone"&gt;
                        &lt;thead&gt;
                        &lt;tr&gt;
                        &lt;th scope="col"&gt;Order ID&lt;/th&gt;
                        &lt;th scope="col"&gt;Order Total&lt;/th&gt;
                        &lt;th scope="col"&gt;Payment Method&lt;/th&gt;
                        &lt;th scope="col"&gt;Status&lt;/th&gt;
                        &lt;/tr&gt;
                        &lt;/thead&gt;
                        &lt;tbody&gt;
                        &lt;tr&gt;
                        &lt;td&gt;1&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;2&lt;/td&gt;
                        &lt;td class="digits"&gt;$90.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Ewallets&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;3&lt;/td&gt;
                        &lt;td class="digits"&gt;$240.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Cash&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;4&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Direct Deposit&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;5&lt;/td&gt;
                        &lt;td class="digits"&gt;$50.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;/tbody&gt;
                        &lt;/table&gt;
                        &lt;/div&gt;
                </code></pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 xl-100">
        <div class="card">
            <div class="card-header">
                <h5>Products Under The Limit</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="icofont icofont-simple-left"></i></li>
                        <li><i class="view-html fa fa-code"></i></li>
                        <li><i class="icofont icofont-maximize full-card"></i></li>
                        <li><i class="icofont icofont-minus minimize-card"></i></li>
                        <li><i class="icofont icofont-refresh reload-card"></i></li>
                        <li><i class="icofont icofont-error close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="user-status table-responsive latest-order-table">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th scope="col"> ID</th>
                                <th scope="col"> Name EN</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity Available</th>
                                <th scope="col">Quantity Limit</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($productUnderLimit))
                            @if ($productUnderLimit->count() > 0)
                                @foreach ($productUnderLimit as $index => $product)
                                    <tr>
                                        <td>{!! isset($product->id) ? $product->id : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($product->name_en) ? $product->name_en : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        {{-- <td>{!! isset($product->category->name_en) ? $product->category->name_en : "<span style='color:red;'>Undefined</span>" !!}</td> --}}
                                        <td>{!! isset($product->quantity_available)
                                            ? $product->quantity_available
                                            : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>{!! isset($product->quantity_limit) ? $product->quantity_limit : "<span style='color:red;'>Undefined</span>" !!}</td>
                                        <td>
                                            @if (isset($product->image) && $product->image && file_exists($product->image))
                                                <img src="{{ asset($product->image) }}" width="70"
                                                    height="70"
                                                    style="border-radius: 10px; border:solid 1px black;">
                                            @else
                                                <img src="{{ asset('front_end_style/images/default.png') }}"
                                                    width="70" height="50">
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($product->status))
                                                @if ($product->status == 'Active')
                                                    <span
                                                        style="color: green;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @else
                                                    <span
                                                        style="color: red;">{{ isset($product->status) ? $product->status : "<span style='color:red;'>Undefined</span>" }}</span>
                                                @endif
                                            @else
                                                <span style='color:red;'>Undefined</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('super_admin.products-show', [$product->id]) }}"
                                                title="Show" class="mb-1 btn btn-sm btn-info"><i
                                                    class="mdi mdi-eye"></i></a>
                                            <a href="{{ route('super_admin.products-edit', [$product->id]) }}"
                                                title="Edit" class="mb-1 btn btn-sm btn-primary"><i
                                                    class="mdi mdi-playlist-edit"></i></a>
                                            <a href="{{ route('super_admin.products-activeInactiveSingle', [$product->id]) }}"
                                                title="Active / Inactive"
                                                class="process mb-1 btn btn-sm btn-warning"><i
                                                    class="mdi mdi-stop"></i></a>
                                            <a href="{{ route('super_admin.products-softDelete', [$product->id]) }}"
                                                title="Archive" class="confirm mb-1 btn btn-sm btn-danger"><i
                                                    class="mdi mdi-close"></i></a>
                                            {{-- <a href="{{ route('super_admin.products-destroy', [$product->id]) }}" title="Permanently Delete" class="confirm mb-1 btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="8">
                                    <h3 style="color: red; text-align:center;">There are no new product under the limit
                                        !!</h3>
                                </td>
                            @endif
                        @else
                            <td colspan="8">
                                <h3 style="color: red; text-align:center;">There are no new product under the limit !!
                                </h3>
                            </td>
                        @endif
                        </tbody>
                    </table>
                    {{-- <a href="order.html" class="btn btn-primary mt-4">View All Orders</a> --}}
                </div>
                <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1"
                        title="" data-original-title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    <pre class=" language-html"><code class=" language-html" id="example-head1">
                        &lt;div class="user-status table-responsive latest-order-table"&gt;
                        &lt;table class="table table-bordernone"&gt;
                        &lt;thead&gt;
                        &lt;tr&gt;
                        &lt;th scope="col"&gt;Order ID&lt;/th&gt;
                        &lt;th scope="col"&gt;Order Total&lt;/th&gt;
                        &lt;th scope="col"&gt;Payment Method&lt;/th&gt;
                        &lt;th scope="col"&gt;Status&lt;/th&gt;
                        &lt;/tr&gt;
                        &lt;/thead&gt;
                        &lt;tbody&gt;
                        &lt;tr&gt;
                        &lt;td&gt;1&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;2&lt;/td&gt;
                        &lt;td class="digits"&gt;$90.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Ewallets&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;3&lt;/td&gt;
                        &lt;td class="digits"&gt;$240.00&lt;/td&gt;
                        &lt;td class="font-secondary"&gt;Cash&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;4&lt;/td&gt;
                        &lt;td class="digits"&gt;$120.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Direct Deposit&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;tr&gt;
                        &lt;td&gt;5&lt;/td&gt;
                        &lt;td class="digits"&gt;$50.00&lt;/td&gt;
                        &lt;td class="font-primary"&gt;Bank Transfers&lt;/td&gt;
                        &lt;td class="digits"&gt;Delivered&lt;/td&gt;
                        &lt;/tr&gt;
                        &lt;/tbody&gt;
                        &lt;/table&gt;
                        &lt;/div&gt;
                </code></pre>
                </div>
            </div>
        </div>
    </div>
@endsection
