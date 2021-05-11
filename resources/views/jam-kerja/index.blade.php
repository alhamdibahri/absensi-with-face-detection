@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Dashboard</h1> --}}
@stop

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Jam Kerja Perusahaan</h3>
          </div>
          <?php 
            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
          ?>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th style="display: none;">id</th>
                <th>Hari</th>
                <th>Kondisi</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
              </tr>
              </thead>
              <tbody class="tempat_jam_kerja">
                  @if (count($jam_kerja) == 0)
                    @foreach ($hari as $key => $item)    
                        <tr>
                            <td style="display: none;">{{++$key}}</td>
                            <td>{{ $item }}</td>
                            <td>
                                <select class="form-control kondisi" required="">
                                    <option value='Libur'>Libur</option>
                                    <option value='Masuk'>Masuk</option>
                                </select>
                            </td>
                            <td><input type="time" class="form-control jam_masuk" name="jam_masuk" /></td>
                            <td><input type="time" class="form-control jam_pulang" name="jam_pulang" /></td>
                        </tr>
                    @endforeach
                  @else
                    @foreach ($jam_kerja as $key => $item)    
                        <tr>
                            <td style="display: none;">{{$item->id}}</td>
                            <td>{{ $item->hari }}</td>
                            <td>
                                <select class="form-control kondisi" required="">
                                    <option value='Libur' {{ $item->kondisi == 'Libur' ? 'selected' : null }}>Libur</option>
                                    <option value='Masuk' {{ $item->kondisi == 'Masuk' ? 'selected' : null }}>Masuk</option>
                                </select>
                            </td>
                            <td><input type="time" class="form-control jam_masuk" value="{{ $item->masuk_kerja }}" name="jam_masuk" /></td>
                            <td><input type="time" class="form-control jam_pulang" name="jam_pulang" value="{{ $item->pulang_kerja }}" /></td>
                        </tr>
                    @endforeach
                  @endif
                  
              </tbody>
            </table>
            <button class="btn-info mt-3 saveData" style="float:right;" data-toggle="modal" data-target="#staticBackdrop">Perbaharui Jam Kerja</button>
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

@stop

@section('js')
    <script> 
        @if (\Session::has('success'))
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Berhasil',
                subtitle: 'Jam Kerja',
                body: "<h5>{!! \Session::get('success') !!}</h5>",
                timeout: 3000
            })
        @endif


        $( ".saveData" ).on('click', function(e){
            e.preventDefault();
            let rows = $(".tempat_jam_kerja").find("tr").length;
            let savingRows = [];
              for (let rowOn = 0; rowOn < rows; rowOn++) {
                let id = $(".tempat_jam_kerja").find("tr").eq(rowOn).find("td").eq(0).text();
                let kondisi = $(".tempat_jam_kerja").find("tr").eq(rowOn).find("td").eq(2).find('.kondisi').val();
                let hari = $(".tempat_jam_kerja").find("tr").eq(rowOn).find("td").eq(1).text();
                let jam_masuk = $(".tempat_jam_kerja").find("tr").eq(rowOn).find("td").eq(3).find('.jam_masuk').val();
                let jam_pulang = $(".tempat_jam_kerja").find("tr").eq(rowOn).find("td").eq(4).find('.jam_pulang').val();
                let rowData = {
                    id,
                    kondisi,
                    hari,
                    jam_masuk,
                    jam_pulang
                }
                savingRows.push(rowData);
              }


            $.ajax({
                type: "POST",
                url: '/jam-kerja',
                data: {data: savingRows, _token: "{{ csrf_token() }}" },
                success:function(data, textStatus, jqXHR) 
                {
                    var data = jqXHR.responseJSON;
                    window.location.href = data.url;
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    var data = jqXHR.responseJSON;
                    console.log(data)
                }
            });

        });
    </script>
@stop