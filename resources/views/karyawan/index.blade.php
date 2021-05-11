@extends('adminlte::page')

@section('title', 'Data Karyawan')

@section('content_header')
    {{-- <h1>Data Karyawan</h1> --}}
@stop

@section('content')
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List Karyawan</h3>
              <button class="btn-success" style="float:right;" data-toggle="modal" data-target="#staticBackdrop">Tambah Data</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIP</th>
                  <th>Nama Karyawan</th>
                  <th>Tmp, Tgl Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Agama</th>
                  <th>Foto</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama_karyawan }}</td>
                            <td>{{ $item->tempat_lahir . ' , ' . $item->tanggal_lahir }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->agama }}</td>
                            <td>
                                <img src="{{ asset('foto_karyawan/' .  $item->foto_karyawan) }}" width="100" height="100" />
                            </td>
                            <td>
                                <button class="btn-primary" data-toggle="modal" data-target="#modalEdit" onClick="editItem({{$item}})"><i class="fa fa-edit"></i></button>
                                <button class="btn-danger" onClick="deleteItem({{$item->id}})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Tmp, Tgl Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Foto</th>
                    <th>Action</th>
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
      <!-- Modal Create -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="createForm" method="POST" enctype="multipart/form-data" action="{{ route('karyawan.store') }}">
                    @csrf
                <div class="modal-body">
                    <div class="modalError"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control"  placeholder="Masukkan Nama Karyawan">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"  placeholder="Masukkan Tempat Lahir">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" placeholder="Masukkan Tanggal Lahir">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telp</label>
                            <input type="text" name="no_telp"  class="form-control" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin">
                                <option value="">-Pilih Jenis Kelamin-</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <select class="form-control" name="agama">
                                <option value="">-Pilih Agama-</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Foto Karyawan</label>
                            <input type="file" name="foto_karyawan" class="form-control">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
                
                </div>
                </form>
            </div>
            </div>
        </div>



         <!-- Modal Update -->
         <div class="modal fade" id="modalEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="createForm" method="POST" enctype="multipart/form-data" action="{{ route('karyawan.store') }}">
                    @csrf
                <div class="modal-body">
                    <div class="modalErrorEdit"></div>
                    <input type="hidden" name="id" class="form-control id" placeholder="Masukkan NIP">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">NIP</label>
                            <input type="text" name="nip" class="form-control nip" placeholder="Masukkan NIP">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control nama_karyawan"  placeholder="Masukkan Nama Karyawan">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control tempat_lahir"  placeholder="Masukkan Tempat Lahir">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control tanggal_lahir" placeholder="Masukkan Tanggal Lahir">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telp</label>
                            <input type="text" name="no_telp"  class="form-control no_telp" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control jenis_kelamin" name="jenis_kelamin">
                                <option value="">-Pilih Jenis Kelamin-</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <select class="form-control agama" name="agama">
                                <option value="">-Pilih Agama-</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <img class="foto" width="100" height="100" />
                        <div class="form-group">
                            <label for="exampleInputEmail1">Foto Karyawan</label>
                            <input type="file" name="foto_karyawan" class="form-control foto_karyawan">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary updateData">Update</button>
                
                </div>
                </form>
            </div>
            </div>
        </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
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
                subtitle: 'Karyawan',
                body: "<h5>{!! \Session::get('success') !!}</h5>",
                timeout: 3000
            })
        @endif

        //get data per row
        function editItem(data){
            $(".id").val(data.id);
            $(".nip").val(data.nip);
            $(".nama_karyawan").val(data.nama_karyawan);
            $(".tempat_lahir").val(data.tempat_lahir);
            $(".tanggal_lahir").val(data.tanggal_lahir);
            $(".no_telp").val(data.no_telp);
            $(".jenis_kelamin").val(data.jenis_kelamin);
            $(".agama").val(data.agama);
            $(".foto").attr("src", `{{ asset('foto_karyawan') }}/${data.foto_karyawan}`);
        }

        //submit update data
        $( ".updateData" ).click(function(e) {
            e.preventDefault()
            let payload = new FormData();
            payload.append('id', $('.id').val());
            payload.append('nip', $('.nip').val());
            payload.append('nama_karyawan', $('.nama_karyawan').val());
            payload.append('tempat_lahir', $('.tempat_lahir').val());
            payload.append('tanggal_lahir', $('.tanggal_lahir').val());
            payload.append('no_telp', $('.no_telp').val());
            payload.append('jenis_kelamin', $('.jenis_kelamin').val());
            payload.append('agama', $('.agama').val());
            payload.append('foto_karyawan', $('.foto_karyawan')[0].files[0]);
            payload.append('_method', 'PUT')
            payload.append('_token', "{{ csrf_token() }}")

            $.ajax({
                type: "POST",
                url: '/karyawan/' + $('.id').val(),
                data: payload,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data, textStatus, jqXHR) 
                {
                    var data = jqXHR.responseJSON;
                    window.location.href = data.url;
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    var data = jqXHR.responseJSON.errors;
                    errorsHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul>';
            
                    $.each( data, function( key, value ) {
                    errorsHtml += '<li style="color:white;">' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $(".modalErrorEdit").html(errorsHtml);
                }
            });

        });

        //delete item
        function deleteItem(id){
            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax(
                {
                    url: "/karyawan/"+id,
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data, textStatus, jqXHR)
                    {
                        let datas = jqXHR.responseJSON;
                        window.location.href = datas.url;

                    },
                });
            }
        }


        $ ( function () {
            $('#example2').DataTable();
        })

        //submit create form
        $("#createForm").submit(function(e) {
            e.preventDefault(); 
            var form = $(this);
            let url = form.attr('action');
            let payload = new FormData(this);

            $.ajax({
                type: "POST",
                url: url,
                data: payload,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR)
                {
                    let datas = jqXHR.responseJSON;
                    window.location.href = datas.url;

                },
                error: function(jqXHR, textStatus, errorThrown){
                    var data = jqXHR.responseJSON.errors;
                    errorsHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul>';

                    $.each( data, function( key, value ) {
                        errorsHtml += '<li style="color:white;">' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    $(".modalError").html(errorsHtml);

                }
            });
        });
    </script>
@stop