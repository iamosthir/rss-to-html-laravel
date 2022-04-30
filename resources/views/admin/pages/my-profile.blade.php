@extends('admin.layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4>My Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('api.update-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-12 form-group">
                                <div class="profile-image">
                                    
                                    @if($user->photo != "")
                                        <img src="{{ asset("uploads/admin/profile/$user->photo") }}" alt="">
                                        <button type="button" id="delImg" title="Remove photo" class="btn"><i class="fas fa-times"></i></button>
                                    @else
                                        <img src="{{ asset("img/portrait-placeholder.png") }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control @error('myname') is-invalid @enderror" 
                                placeholder="Full name..." value="{{ old('myname')??$user->name }}" name="myname">
                                @error("myname")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                 placeholder="Your email..." value="{{ old('email')??$user->email }}" name="email">
                                @error("email")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Type in your password..." value="" name="password">
                                @error("password")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-8 form-group">
                                <label for="">Choose photo</label>
                                <input type="file" class="form-control-file" name="photo">
                            </div>
                            <div class="col-md-8 form-group">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraJs')
    <script>
        toastr.options.closeButton = true;
        
        $("#delImg").click(function() {
            swal.fire({
                    title: 'Are you sure you want to remove photo?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Remove photo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("/admin/api/delete-profile-photo").then(resp => {
                            return resp.data;
                        }).then(data => {
                            if(data.status == "ok") {
                                swal.fire("Success",data.msg,"success").then(()=>{
                                    window.location.reload();
                                })
                            }
                        }).catch(err => {
                            console.error(err.response.data);
                        })
                    }
                })
        });
    </script>
    @if(session()->has("success"))
        <script>
            toastr.success('{{ session()->get("success") }}', 'Successful')
        </script>
    @endif
@endsection