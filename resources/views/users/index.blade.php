@extends('adminlte::page')

@section('title', 'Data User')

@section('content_header')
    {{-- <h1>Data user</h1> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">List User</h3>
                <button class="btn-success" style="float:right;" data-toggle="modal" data-target="#staticBackdrop">Tambah Data</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $item)    
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->created_at }}</td>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Created At</th>
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
    <!-- /.row -->
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Create User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="createForm" method="POST" action="{{ route('users.store') }}">
                @csrf
            <div class="modal-body">
                <div class="modalError"></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Password">
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="createForm" method="POST">
                @csrf
            <div class="modal-body">
                <div class="modalError"></div>
                <div class="card-body">
                    <input type="hidden" name="id" class="form-control id_user" id="exampleInputEmail1" placeholder="Masukkan Nama">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="name" class="form-control nama" id="exampleInputEmail1 nama" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control email" id="exampleInputEmail1" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control password" id="exampleInputPassword1" placeholder="Masukkan Password">
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary updateData">Save</button>
            
            </div>
            </form>
          </div>
        </div>
    </div>
  <!-- /.container-fluid -->
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    <script> 

        //set datatable
        $ ( function () {
            $('#example2').DataTable();
        })

        //if exist session name success
        @if (\Session::has('success'))
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Berhasil',
                subtitle: 'Users',
                body: "<h5>{!! \Session::get('success') !!}</h5>",
                timeout: 3000
            })
        @endif
      
        //get data per row
        function editItem(data){
            $('.id_user').val(data.id)
            $('.nama').val(data.name)
            $('.email').val(data.email)
        }

        //delete item
        function deleteItem(id){
            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax(
                {
                    url: "/users/"+id,
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

        
        $( ".updateData" ).click(function(e) {
            e.preventDefault()
            let id = $('.id_user').val()
            let email = $('.email').val()
            let name = $('.nama').val()
            let password = $('.password').val()
            $.ajax(
            {
                url: "/users/"+id,
                type: 'POST',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'PUT',
                    "_token": "{{ csrf_token() }}",
                    "email" : email,
                    "password": password,
                    "name" : name
                },
                success: function(data, textStatus, jqXHR)
                {
                    let datas = jqXHR.responseJSON;
                    window.location.href = datas.url;

                },
            });

        });

        //submit create form
        $("#createForm").submit(function(e) {
            e.preventDefault(); 

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
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