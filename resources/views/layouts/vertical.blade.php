<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared.title-meta', ['title' => $title])
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.shared.head-css')
    {{-- @include('layouts.shared/head-css', ["demo" => "modern"]) --}}
    <style>

        body{
            direction: rtl;
        }

        .client-form input,select,button
        {
            height: 30px;
        }

        .client-form button
        {
            font-size: 14px !important;
        }

        .b2
        {
            background-color: #14293C;
        }

        select
        {
            font-size: 12px !important;
            color: gray !important;
        }

        .client-form input::placeholder
        {
            font-size: small;
            color: gray;

        }

        .table-head
        {
        width: 100%;
        height: 30px;
        background-color: #E8F0F2;
        color: #1B97DF;
        border-radius: 5px 5px 0 0;

        }

        .text-center ul
        {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-center li
        {
            margin: 0 10px;
            color: gray;
        }

        .dt-buttons {
            display: none;
        }
        .dataTables_length {
            display: none;
        }
        #ClientsTable_filter {
            display: none;
        }

    </style>
</head>

<body @yield('body-extra')>
    <!-- Begin page -->
    <div   id="wrapper">
        @include('layouts.shared.left-sidebar')
        @include('layouts.shared/topbar')



        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->


            <div class="content">
                @yield('content')
            </div>
            <!-- content -->

            @include('layouts.shared/_session')


            @include('layouts.shared/footer')
    </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    <!-- END wrapper -->

    @include('layouts.shared.right-sidebar')



    @include('layouts.shared.footer-script')


    <script>
        $(document).ready(function() {
            $('.loader').fadeOut(500, function() {
                $('.overlay-loader').fadeOut(function() {
                    $(this).remove();
                });
            });
        });

    </script>
</body>

</html>
