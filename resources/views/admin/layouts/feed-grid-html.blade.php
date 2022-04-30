


@php
    use \Illuminate\Support\Str;

    $md = intdiv(12,$column);
    $total = $column*$row??1;
@endphp

<!-- Bootstrap grid template -->
<div class="row">
@foreach ($blogs as $i=>$blog)
    <div class="col-lg-{{ $md }} col-md-4 col-sm-6 col-12 mb-4">
        <div class="card h-100 d-flex flex-column">
            <img class="card-img-top blog-thumb"
            src="{{ $blog["thumbnail"]??$blog["image"] }}" alt="Card image cap">
            <div class="card-body">
                <p class="text-right text-muted">{{ \Carbon\Carbon::parse($blog["pubDate"])->format("Y-m-d") }}</p>
                <h5 class="card-title"><a href="{{ $blog["link"] }}">{{ $blog["title"] }}</a></h5>
                <p class="card-text mt-2">{{ Str::limit($blog["description"],100) }}</p>
            </div>
            <div class="card-footer bg-white">
                <img class="author-thumb"
                src="{{ asset("img/portrait-placeholder.png") }}" alt="">
                <span class="ml-2">{{ $blog["author"] }}</span>
            </div>
        </div>
    </div>
@if($i == $total-1)
        @break
@endif
@endforeach
</div>