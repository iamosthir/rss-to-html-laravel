
<!--######### You must put this javascripts in your site to make carousel work#########-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--##################-->

<!--######### Paste these codes to your js file #########-->
<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            loop: true,
            items: {{ $column }},
            margin: 10,
            nav: true,
            smartSpeed: 800,
            autoHeight: true,
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