@php
    use \Illuminate\Support\Str;

    $md = $column!=0?$column:4;
    $total = $column*$row??1;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RSS Carousel Preview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset("css/templates/carousel.css") }}">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6 text-center">
                <h3>Carousel Preview</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel">
            @foreach ($blogs as $i=>$blog)
                        <div class="card h-100 d-flex flex-column">
                            <img class="card-img-top blog-thumb"
                            src="{{ $blog["thumbnail"]??$blog["image"] }}" alt="Card image cap">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                loop: true,
                items: {{ $column }},
                margin: 10,
                nav: true,
                smartSpeed: 800,
                dot: true,
                autoplay: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                    },
                    576 : {
                        items: 3
                    },
                    768: {
                        items: 4,
                    },
                    1000: {
                        items: {{ $column }},
                    },
                    
                }
            });
        });
    </script>
</body>
</html>