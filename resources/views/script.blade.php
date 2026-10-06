<script src="{{ asset('asset_web/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('asset_web/dist/js/adminlte.js') }}"></script>
<script src="https://kit.fontawesome.com/39e39436e1.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('asset_web/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('asset_web/dist/js/pages/dashboard3.js') }}"></script>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('asset_web/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@if (session('error'))
      <script>
        $(function() {
          var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
          });
          
          Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
          });
        });
      </script>
@endif
@if (session('sukses'))
      <script>
        $(function() {
          var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
          });
          
          Toast.fire({  
            icon: 'success',
            title: '{{session('sukses')}}'
          });
        });
      </script>
@endif
@if(session('flash_message'))
  <script>
    $(function() {
      toastr.error('{{ session("flash_message") }}');
    });
  </script>
@endif