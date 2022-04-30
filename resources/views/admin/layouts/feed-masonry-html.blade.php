


@php
    use \Illuminate\Support\Str;

    $md = intdiv(12,$column);
    $total = $column*$row??1;
@endphp

<!--You must put this script in your html code in order to make masonry work-->
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
 integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<!--######-->

<!-- Bootstrap masonry template -->
<div class="row" >
@foreach ($blogs as $i=>$blog)
    <div class="col-md-{{ $md }} col-sm-6 col-12 mb-2">
        <div class="card">
            <img class="card-img-top"
            src="{{ $blog["thumbnail"]??$blog["image"] }}" alt="Card image cap">
            <div class="card-body">
                <p class="text-right text-muted">{{ \Carbon\Carbon::parse($blog["pubDate"])->format("Y-m-d") }}</p>
                <h5 class="card-title"><a href="#">{{ $blog["title"] }}</a></h5>
                <p class="card-text mt-5">{{ Str::limit($blog["description"],100) }}</p>
                <hr>
                <div class="d-flex align-items-center">
                    <img style="width: 40px;height: 40px;object-fit: cover;border-radius: 50%;"
                    src="{{ asset("img/portrait-placeholder.png") }}" alt="">
                    <p class="mt-2 ml-3">{{ $blog["author"] }}</p>
                </div>
            </div>
        </div>
    </div>
    @if($i == $total-1)
        @break
    @endif
@endforeach
</div>