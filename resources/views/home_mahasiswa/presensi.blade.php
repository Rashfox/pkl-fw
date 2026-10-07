@extends('layout.main')
@section('content')

    <div class="content">
      <div class="container-fluid">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-scan">
          Scan QR Code
        </button>
    <!-- /.content-header -->
      </div> 
    </div>
<div class="modal fade" id="modal-scan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Scan QR Code</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="reader"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- REQUIRED SCRIPTS -->
@endsection
@push('script')
<script>
let html5QrcodeScanner;
const url = "{{ route('postPresensi.mahasiswa') }}";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function onScanSuccess(decodedText) {
  if (html5QrcodeScanner) {
    html5QrcodeScanner.clear().then(() => {
        console.log("Kamera berhasil dimatikan.");
    }).catch(error => {
        console.error("Gagal mematikan kamera.", error);
    });
  }
  $('#modal-scan').modal('hide');
  let form = document.createElement('form');
  form.method = 'POST';
  form.action = "{{ route('postPresensi.mahasiswa') }}";

  let csrfInput = document.createElement('input');
  csrfInput.type = 'hidden';
  csrfInput.name = '_token';
  csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  form.appendChild(csrfInput);

  let qrInput = document.createElement('input');
  qrInput.type = 'hidden';
  qrInput.name = 'kode_kelas';
  qrInput.value = decodedText;
  form.appendChild(qrInput);

  document.body.appendChild(form);
  form.submit();
}
$(document).ready(function() {
  $('#modal-scan').on('shown.bs.modal', function () {
    html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
  });

  $('#modal-scan').on('hidden.bs.modal', function () {
    if (html5QrcodeScanner) {
      html5QrcodeScanner.clear().then(() => {
          console.log("Kamera dimatikan karena modal ditutup.");
      }).catch(error => {
          console.error("Gagal mematikan kamera.", error);
      });
    }
  });
});
</script>
@endpush