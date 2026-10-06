@foreach ($presensi as $p)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>[{{ $p->mahasiswa->nim }}] - {{ $p->mahasiswa->nama }}</td>
    <td>
        @php
            $warna = [
                'hadir' => 'success',
                'alpha' => 'danger',
                'sakit' => 'warning',
                'izin'  => 'info'
            ];
            $badgeClass = $warna[$p->status_pertemuan] ?? 'secondary';
        @endphp
        
        <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($p->status_pertemuan) }}</span>
    </td>
    <td>
        <button data-toggle="modal" data-target="#modal-edit" data-id="{{ $p->id_presensi }}" data-nama="{{ $p->mahasiswa->nama }}" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button>
    </td>
</tr>
@endforeach