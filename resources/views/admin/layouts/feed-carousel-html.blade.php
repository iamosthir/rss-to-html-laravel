@php
    use \Illuminate\Support\Str;

    $md = $column!=0?$column:4;
    $total = $column*$row??1;
@endphp


<!--#### OWL Carousel Plugin ##########-->
<!--#### You must put this css library in your website in order to make your carousel work ##########-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--#################-->

<div class="row">
    <div class="col-md-12">
        <div class="owl-carousel">
@foreach ($blogs as $i=>$blog)
            <div class="card h-100 d-flex flex-column">
                <img class="card-img-top blog-thumb"
                src="{{ $blog["thumbnail"]??$blog["image"] }}">
                <div class="card-body">
                    <p class="text-right text-muted">{{ \Carbon\Carbon::parse($blog["pubDate"])->format("Y-m-d") }}</p>
                    <h5 class="card-title"><a class="title" href="{{ $blog["link"] }}">{{ $blog["title"] }}</a></h5>
                    <p class="card-text mt-2">{{ Str::limit($blog["description"],100) }}</p>
                </div>
                <div class="card-footer bg-white">
                    <img class="author-thumb"
                    src="{{ asset("img/portrait-placeholder.png") }}" alt="">
                    <span class="ml-2">{{ $blog["author"] }}</span>
                </div>
            </div>
@if($i == $total-1)
    @break
@endif
@endforeach
        </div>
    </div>
</div>