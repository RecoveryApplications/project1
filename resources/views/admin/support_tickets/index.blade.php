@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content">
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
                        swal("oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="page-header-left">
                                <h3>Technical problems
                                    {{-- <small>Multikart Admin panel</small> --}}
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ol class="breadcrumb pull-right">
                                <li class="breadcrumb-item">
                                    <a href="{{route('super_admin.dashboard')}}">
                                        <i data-feather="home"></i>
                                    </a>
                                </li>
                                {{-- <li class="breadcrumb-item">Sales</li> --}}
                                <li class="breadcrumb-item active">Technical problems</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body order-datatable">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Error Description</th>
                                    <th>Function Name</th>
                                    <th>Error Date</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($support_tickets->count() > 0)
                                @foreach ($support_tickets as $index => $support_ticket)
                                 
                                    <tr>
                                        <td>{{ $support_ticket->id }}</td>
                                        {{-- <td>{{ $support_ticket->error_location }}</td> --}}
                                        <td>{{ $support_ticket->error_description }}</td>
                                        <td>{{ $support_ticket->function_name }}</td>
                                        {{-- <td>{{ $support_ticket->error_line }}</th> --}}
                                        <td>{{ $support_ticket->created_at }}</th>
                                        <td>
                                            <a href="{{ route('super_admin.support_tickets-destroy', $support_ticket->id) }}"class=" text-danger">
                                                <i class="fa fa-trash" title="Destroy"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
