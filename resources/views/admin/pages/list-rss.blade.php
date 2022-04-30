@extends("admin.layouts.master")

@section("content")

<div class="row justify-content-center" id="rssListPage">
    <div class="col-md-7 mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="text-muted"><b>RSS URL Lists</b></h4>
                
            </div>
            <div class="card-body">
                <a href="{{ route("rss.add") }}" class="btn btn-sm btn-warning text-white mb-3">Add more url</a>
                <div class="row" v-if="isLoading">
                    <div class="col-12 mb-2" v-for="n in 15" :key="n">
                        <skeleton width="100%" height="25px" />
                    </div>
                </div>
                <div v-cloak class="table-responsive" v-else>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>URL</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="urls.length > 0">
                                <tr v-for="(url,i) in urls" :key="i">
                                    <td>@{{ i+1 }}</td>
                                    <td>@{{ url.url }}</td>
                                    <td><b>@{{ url.user?url.user.name:'Deleted User' }}</b></td>
                                    <td>
                                        <button @click="deleteUrl(url.id,i)"
                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> &nbsp;Delete</button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4" class="text-center text-danger">
                                        No data found
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection