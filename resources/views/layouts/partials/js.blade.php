<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.addons.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('admin/assets/js/shared/off-canvas.js') }}"></script>
<script src="{{ asset('admin/assets/js/shared/misc.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('admin/assets/js/demo_1/dashboard.js') }}"></script>
<!-- End custom js for this page-->
{{-- <script src="{{ asset('admin/assets/js/shared/jquery.cookie.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('admin/assets/js/template.js') }}"></script>
<!-- jQuery & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
    $('.select2-user').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Filter User by Name/Email --',
        allowClear: true,
        width: '100%' // ✅ Yeh line zaroori hai taaki box poora expand ho
    });
});
</script>