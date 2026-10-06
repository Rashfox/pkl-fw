@extends('layout.main')
@section('content')
  <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-danger">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-title"><i class="fas fa-lock"></i> Ganti Password</h3>
                        </div>
                    </div>
                    <form action="{{ Route('gantipass.user') }}" method="post">
                      @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <?php
                                    $username = session('username');
                                ?>
                                <label for="password_lama">Password Lama</label>
                                <input type="hidden" name="username" value="<?= $username ?>">
                                <input class="form-control" maxlength="10" type="password" name="password_lama" id="password_lama" placeholder="Masukan Password Lama Max 10 Char" required>
                            </div>
                            <div class="form-group">
                                <label for="password_baru">Password Baru</label>
                                <input class="form-control" maxlength="10" type="password" name="password_baru" id="password_baru" placeholder="Masukan Password Baru Max 10 Char" required>
                            </div>
                            <div class="form-group">
                                <label for="pin2fa">PIN</label>
                                <input class="form-control" min="0" maxlength="6" type="number" name="pin" id="pin2fa" placeholder="Masukan PIN Anda" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="edit" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Ganti</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">

            </div>
        </div>
    <!-- /.content -->
      </div>
  </div>
@endsection