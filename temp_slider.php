<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 3.5.2017
 * Time: 21:54
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        //alert('Hello from jQuery');
        //configuracija
        var width = 960;
        var animateSlide = 1000;
        var pause = 3000;
        var curentSlide = 1;
        //cash DOM
        $slider = $('#slider');
        $slideContainer = $slider.find('.slides');
        $slides = $slideContainer.find('.slide');

        var interval;
        function startSlider()
        {
            interval = setInterval(function(){
                $slideContainer.animate({'margin-left':'-='+width},animateSlide,function(){
                    curentSlide++;//povećavanje
                    if(curentSlide===$slides.length)//ukoliko je trenutni slide jednak broju slide-ova !!!
                    {
                        curentSlide = 1;//vraćanje na početni slide
                        $slideContainer.css({'margin-left':0});//vraćanje leve margine na 0
                    }
                });
            },pause);
        }
        function stopSlider()
        {
            clearInterval(interval);
        }
        $slider.on('mouseenter',stopSlider).on('mouseleave',startSlider);
        startSlider();
    });
</script>
<section id="slider">
    <ul class="slides">
        <li class="slide"><img src="images/news.png" alt="nema slike"></li>
        <li class="slide"><img src="images/rsz_news.jpg" alt="nema slike"></li>
        <li class="slide"><img src="images/breaking_news.jpg" alt="nema slike"></li>
        <li class="slide"><img src="images/latest_news.jpg" alt="nema sliek"></li>
        <li class="slide"><img src="images/news.png" alt="nema slike"></li>
    </ul>
</section>
