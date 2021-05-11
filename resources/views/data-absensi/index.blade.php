@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Data Absensi</h1> --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Data Absensi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
						<th>Jam Masuk</th>
						<th>Jam Pulang</th>
						<th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $key => $item)    
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->nama_karyawan }}</td>
                            <td>{{ $item->tanggal_absen }}</td>
                            <td>{{ $item->waktu_datang }}</td>
							<td>{{ $item->waktu_pulang }}</td>
							<td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
						<th>Jam Masuk</th>
						<th>Jam Pulang</th>
						<th>Status</th>
                    </tr>
                </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
    <!-- /.row -->
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script> 

        @if (\Session::has('success'))
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Berhasil',
                subtitle: 'Absensi',
                body: "<h5>{!! \Session::get('success') !!}</h5>",
                timeout: 3000
            })
        @endif

    </script>
@stop