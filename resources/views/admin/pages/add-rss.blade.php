@extends("admin.layouts.master")

@section("content")

<div class="row justify-content-center" id="rssAddPage">
    <div class="col-md-6 mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="text-muted"><b>Add New RSS Feed URL</b></h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm" action="">
                    <div class="row justify-content-center">
                        <div class="col-md-8 form-group">
                            <label for="">URL</label>
                            <input :class="{'is-invalid': form.errors.has('url')}" type="text" class="form-control" 
                            placeholder="RSS Url..." v-model="form.url">
                            <has-error :form="form" field="url" />
                        </div>
                        <div class="col-md-8 form-group">
                            <form-button :form="form" class="btn btn-primary">Add</form-button>
                        </div>
                        <div class="col-md-8">
                            <div class="mt-4">
                                <a href="{{ route("rss.list") }}">View all url list</a>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection