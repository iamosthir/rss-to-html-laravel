@extends("admin.layouts.master")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4><b>Analytics & Adsense</b></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route("api.update-googleTool") }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="">Google Analytics Tracking ID : </label>
                                <input type="text" class="form-control" name="trackingId" placeholder="Your google analytics tracking id..." value="{{ $data->analyticsId }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Google AdSense ID : </label>
                                <input type="text" class="form-control" name="adsenseId" placeholder="Google adsense id..." value="{{ $data->adsenseId }}">
                            </div>
                            <div class="col-12 form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
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