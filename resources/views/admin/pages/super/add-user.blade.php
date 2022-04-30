@extends('admin.layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Add new user</h4>
                </div>
                <div class="card-body">
                    <div class="text-right">
                        <a href="{{ route("super.user-list") }}" class="btn btn-sm btn-primary">All User list <i class="fas fa-list"></i></a>
                    </div>
                    <form action="{{ route('api.add-user') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-8 form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control @error('myname') is-invalid @enderror" 
                                placeholder="Full name..." value="{{ old('myname')}}" name="myname">
                                @error("myname")
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                 placeholder="Your email..." value="{{ old('email') }}" name="email">
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
                                <label for="">Choose Role</label>
                                <select name="role" class="form-control">
                                    <option value="normal">Normal User</option>
                                    <option value="super">Super Admin</option>
                                </select>
                                <p class="text-muted mt-2">N.B : User with "Super Admin" role will be able to create, add or update other user info</p>
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
    @if(session()->has("success"))
        <script>
            toastr.options.closeButton = true;
            toastr.success('{{ session()->get("success") }}', 'Successful')
        </script>
    @endif
@endsection