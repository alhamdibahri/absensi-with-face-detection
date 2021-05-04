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
              <h3 class="card-title">Profil Company</h3>
                @if (!$company)
                    <button class="btn-success" style="float:right;" data-toggle="modal" data-target="#staticBackdrop">Atur Company</button>
                @else
                    <button class="btn-info" onclick="editItem({{$company}})" style="float:right;" data-toggle="modal" data-target="#editModal">Edit Company</button>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if (!$company)
                    <h5 class="text-center">Anda Belum Mengatur Profil Company Anda</h5>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('logo_company/' . $company->logo_company) }}" width="200" height="200" class="rounded float-left" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <td class="text-right">{{ $company->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Owner Perusahaan</th>
                                        <td class="text-right">{{ $company->owner }}</td>
                                    </tr>
                                    <tr>
                                        <th>NPWP</th>
                                        <td class="text-right">{{ $company->npwp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td class="text-right">{{ $company->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Telp</th>
                                        <td class="text-right">{{ $company->no_telp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td class="text-right">{{ $company->email }}</td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end">
                                <small>Updated By {{ $company->user->name }} ({{$company->created_at}})</small> 
                            </div>
                        </div>
                    </div>
                @endif
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
                <form id="createForm" method="POST" enctype="multipart/form-data" action="{{ route('company.store') }}">
                    @csrf
                <div class="modal-body">
                    <div class="modalError"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Company</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Company">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Owner</label>
                            <input type="text" name="owner" class="form-control"  placeholder="Masukkan Nama Owner">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">NPWP</label>
                            <input type="text" name="npwp" class="form-control"  placeholder="Masukkan NPWP">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telp</label>
                            <input type="text" name="no_telp" class="form-control" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Logo Perusahaan</label>
                            <input type="file" name="logo_company" class="form-control">
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
         <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <label for="exampleInputEmail1">Nama Company</label>
                            <input type="text" name="name" class="form-control name" placeholder="Masukkan Nama Company">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Owner</label>
                            <input type="text" name="owner" class="form-control owner"  placeholder="Masukkan Nama Owner">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">NPWP</label>
                            <input type="text" name="npwp" class="form-control npwp"  placeholder="Masukkan NPWP">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea name="alamat" class="form-control alamat" placeholder="Masukkan Alamat"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telp</label>
                            <input type="text" name="no_telp" class="form-control no_telp" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control email" placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Logo Perusahaan</label>
                            <input type="file" name="logo_company" class="form-control logo_company">
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
                subtitle: 'Company',
                body: "<h5>{!! \Session::get('success') !!}</h5>",
                timeout: 3000
            })
        @endif

        //get data per row
        function editItem(data){
            $(".id").val(data.id);
            $(".name").val(data.name);
            $(".owner").val(data.owner);
            $(".npwp").val(data.npwp);
            $(".alamat").val(data.alamat);
            $(".no_telp").val(data.no_telp);
            $(".email").val(data.email);
        }

        //submit update data
        $( ".updateData" ).click(function(e) {
            e.preventDefault()
            let payload = new FormData();
            payload.append('id', $('.id').val());
            payload.append('name', $('.name').val());
            payload.append('owner', $('.owner').val());
            payload.append('npwp', $('.npwp').val());
            payload.append('alamat', $('.alamat').val());
            payload.append('no_telp', $('.no_telp').val());
            payload.append('email', $('.email').val());
            payload.append('logo_company', $('.logo_company')[0].files[0]);
            payload.append('_method', 'PUT')
            payload.append('_token', "{{ csrf_token() }}")

            $.ajax({
                type: "POST",
                url: '/manage-company/' + $('.id').val(),
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