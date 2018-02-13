$('#productPhotos').lightSlider({
    item: 1,
    slideMove: 1,
    slideMargin: 10,
    slideEndAnimation: true,
    keyPress: true,
    pauseOnHover: true,
    thumbItem: 4,
    gallery: true,
    responsive: [
        {
            breakpoint: 800,
            settings: {
                thumbItem: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                thumbItem: 3
            }
        }
    ],
    onSliderLoad: function () {
        $('#productPhotos').removeClass('cS-hidden');
    }
});