<!-- bundle -->
<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/notyf.min.js') }}"></script>
@yield('script')
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script>
    const green = document.querySelectorAll('.js-switch')
    green.forEach(element => {
        new Switchery(element, {
            color: '#26B99A',
            size: 'small',
        });
    });

    const red_switches = document.querySelectorAll('.js-switch-red')
    red_switches.forEach(element => {
        new Switchery(element, {
            size: 'small',
            color: '#de142f'
        });
    });

    //delete
    $('.delete').click(function(e) {

        var that = $(this)

        e.preventDefault();

        var n = new Noty({
            text: "@lang('تأكيد الحذف')",
            type: "warning",
            killer: true,
            buttons: [
                Noty.button("@lang('نعم')", 'btn btn-success mr-2', function() {
                    that.closest('form').submit();
                }),

                Noty.button("@lang('لا')", 'btn btn-primary mr-2', function() {
                    n.close();
                })
            ]
        });

        n.show();

    }); //end of delete

    $('.update').click(function(e) {

        var that = $(this)

        e.preventDefault();

        var n = new Noty({
            text: "@lang('تأكيد انهاء الشهر')",
            type: "warning",
            killer: true,
            buttons: [
                Noty.button("@lang('نعم')", 'btn btn-success mr-2', function() {
                    that.closest('form').submit();
                }),

                Noty.button("@lang('لا')", 'btn btn-primary mr-2', function() {
                    n.close();
                })
            ]
        });

        n.show();

    }); //end of delete

    var notyf = new Notyf({
        duration: 4000,
    });

</script>
@yield('script-bottom')
