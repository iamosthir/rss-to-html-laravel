@extends('admin.layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4>User List <small>(12 user)</small></h4>
                </div>
                <div class="card-body">
                    <div class="text-right">
                        <a href="{{ route("super.add-user") }}" class="btn btn-warning text-white">Add User <i class="fas fa-user-plus"></i></a>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $i=>$user)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>
                                            @if($user->photo != "")
                                                <img class="list-thumb" src="{{ asset("uploads/admin/profile/$user->photo") }}" alt="">
                                            @else
                                                <img class="list-thumb" src="{{ asset("img/portrait-placeholder.png") }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role??"No role" }}</td>
                                        <td>
                                            <a href="{{ route("super.edit-user",["userid"=>$user->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button onclick="deleteUser('{{ $user->id }}')" class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraJs')
    <script>
        function deleteUser(userId)
        {
            swal.fire({
                    title: 'Are you sure you want to delete this user?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Remove user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("/admin/api/delete-user",{
                            userId: userId
                        }).then(resp => {
                            return resp.data;
                        }).then(data => {
                            if(data.status == "ok") {
                                if(data.logout == true) {
                                    swal.fire("Success",data.msg,"success").then(()=>{
                                        $('#logout-form').submit();
                                    });
                                }
                                else {
                                    swal.fire("Success",data.msg,"success").then(()=>{
                                        window.location.reload();
                                    });
                                }
                            }
                            else {
                                swal.fire("Warning !",data.msg,"warning");
                            }
                        }).catch(err => {
                            console.error(err.response.data);
                        })
                    }
                })
        }
    </script>
@endsection