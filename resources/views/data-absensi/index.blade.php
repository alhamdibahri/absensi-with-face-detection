@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Data Absensi</h1> --}}
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@stop
<!-- daterange picker -->

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
                <form action="">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop" style="width:100%;"><i class="fa fa-filter"></i> Filter Data</button>
                        </div>
                    </div>
                </form>
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
                            <td>{{ $item->karyawan->nama_karyawan }}</td>
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
    {{-- Modal Filter --}}
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Filter Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="GET" action="{{ route('absensi.index') }}">
            <div class="modal-body">
                <div class="modalError"></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Karyawan</label>
                        <select class="form-control" name="nama_karyawan">
                            @foreach ($karyawan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_karyawan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date range</label>
        
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                            </div>
                            <input type="text" name="date_range" class="form-control float-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control" name="status">
                            <option value="TEPAT_WAKTU">TEPAT WAKTU</option>
                            <option value="TERLAMBAT">TERLAMBAT</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Filter</button>
            
            </div>
            </form>
          </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <script> 
        $('#reservation').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            }
        })
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