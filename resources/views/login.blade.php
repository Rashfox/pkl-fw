<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="asset_web/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="asset_web/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset_web/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="asset_web/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="asset_web/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>RASH</b>NET
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('login.submit') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
        </div>

        <div class="social-auth-links text-center mb-3">
          <button type="submit" class="btn btn-block btn-primary">
            <i class="fab fa-chrome mr-2"></i> Log In
          </button>
        </div>
      </form>
      <!-- /.social-auth-links -->
      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div> -->
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<div class="modal fade" id="modal-pin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPinLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('pin.verify') }}" method="post">
        @csrf
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="modalPinLabel">Verifikasi PIN</h4>
        </div>
        <div class="modal-body">
          <p>Masukkan PIN untuk melanjutkan.</p>
          <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN" required inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code">
          @error('pin')
            <small class="text-danger d-block mt-2">{{ $message }}</small>
          @enderror
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Verifikasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-secondary" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalPinLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('resetpin.submit') }}" method="post">
              @csrf
              <div class="modal-header bg-primary">
                <h4 class="modal-title">Update PIN</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="new_pin">PIN Baru </label>
                  <input type="password" id="new_pin" name="new_pin" class="form-control @error('new_pin') is-invalid @enderror" placeholder="Masukkan PIN Baru" required inputmode="numeric" autocomplete="new-password">
                  @error('new_pin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                  <label for="confirm_pin">Konfirmasi PIN Baru</label>
                  <input type="password" id="confirm_pin" name="confirm_pin" class="form-control @error('confirm_pin') is-invalid @enderror" placeholder="Konfirmasi PIN Baru" required inputmode="numeric" autocomplete="new-password">
                  @error('confirm_pin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="insert_pin" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>

<script src="asset_web/plugins/jquery/jquery.min.js"></script>
<script src="asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="asset_web/dist/js/adminlte.min.js"></script>
<script src="asset_web/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="asset_web/plugins/toastr/toastr.min.js"></script>
@if(session('showPinModal') || $errors->has('pin'))
<script>
  $(function() {
    $('#modal-pin').modal('show');
  });
</script>
@elseif(session('showResetPinModal') || $errors->has('new_pin') || $errors->has('confirm_pin'))
<script>
  $(function() {
    $('#modal-secondary').modal('show');
  });
</script>
@endif
@error('username')
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
      title: '{{ $message }}'
    });
  });
@enderror
<?php
  if (isset($_SESSION['flash_message'])) {
    echo "<script>
      $(function() {
        toastr.error('" . $_SESSION['flash_message'] . "');
      });
    </script>";
    unset($_SESSION['flash_message']);
    }
    if (session('error')) {
      echo "<script>
        $(function() {
          var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
          });
          
          Toast.fire({
            icon: 'error',
            title: 'Username atau Password salah.'
          });
        });
      </script>";
    }
?>
</body>
</html>