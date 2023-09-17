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
                        swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                            button: "Close",
                        });
                    </script>
                @endif
            </div>

            {{-- ============================================== --}}
            {{-- ================== Header ==================== --}}
            {{-- ============================================== --}}
            <div class="breadcrumb-wrapper breadcrumb-contacts">
                <div>
                    <h1> Contact Us Messages</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('super_admin.dashboard') }}">
                                    <span class="mdi mdi-home"></span> dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item"><i class="far fa-envelope"></i> Contact Us Messages</li>


                        </ol>
                    </nav>
                </div>
            </div>
            {{-- ============================================== --}}
            {{-- =================== Body ===================== --}}
            {{-- ============================================== --}}
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2> Contact Us Messages : </h2>
                </div>
                <div class="card-body">
                    <table id="hoverable-data-table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Full Name </th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($requests->count() > 0)
                                @foreach ($requests as $index => $request)
                                    <tr>
                                        <td>{!! isset($request->full_name) ? $request->full_name : "<span style='color:red;'>Undefined</span>" !!} </td>
                                        <td>{!! isset($request->email) ? $request->email : "<span style='color:red;'>Undefined</span>" !!} </td>
                                        <td>{!! isset($request->subject) ? $request->subject : "<span style='color:red;'>Undefined</span>" !!} </td>
                                        <td><a href="{{ route('super_admin.contact_us-showrequest', $request->id) }}"
                                                    class="mb-1 btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                            <a href="{{ route('super_admin.contact_us-destroyrequest', $request->id) }}"
                                                    class="confirm mb-1 btn btn-sm btn-danger"><i
                                                        class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('admin_javascript')
    <script>
        jQuery(document).ready(function() {
            jQuery('#hoverable-data-table').DataTable({
                "aLengthMenu": [
                    [20, 30, 50, 75, -1],
                    [20, 30, 50, 75, "All"]
                ],
                "pageLength": 20,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
            });
        });
    </script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('dashboard_files/assets/plugins/data-tables/datatables.bootstrap4.min.js') }}"></script>

@stop
