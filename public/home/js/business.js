var mySwiper = new Swiper('.hover-section', {
	effect: 'fade',
	fade: {
		crossFade: true,
	},
	prevButton: '.swiper-button-prev',
	nextButton: '.swiper-button-next',
})
$('.adv-item').mouseenter(function() {
	// console.log($(this).index());
	mySwiper.slideTo($(this).index(), 300)
	//$('.hover-section-content').eq($(this).index()).addClass('opacity').siblings().removeClass('opacity').delay(300)
})

var slides = $('#swiper .swiper-slide').size() > 4 ? 4 : $('#swiper .swiper-slide').size()
var mySwiper2 = new Swiper('.swiper-container', {
	slidesPerView: slides, //'auto'
	prevButton: '.slide-l',
	nextButton: '.slide-r',
//	onSlideChangeEnd: function(swiper) {
//		console.log(11)
//		if(mySwiper2.isBeginning) {
//			$('.slide-l').css('opacity',0.35)
//		}
//		if(mySwiper2.isEnd) {
//			$('.slide-r').css('opacity',0.35)
//		}
//	}
})


var timer = null;
$('.page-nav-item').click(function() {
	$(this).addClass('active-nav').siblings().removeClass('active-nav')
	if(timer) {
		return;
	}
	if(scrollTopTimer){
		clearInterval(scrollTopTimer)
	}
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	var offsetTop = $('.section').eq($(this).index()).offset().top - 58;
	var length = offsetTop - scrollTop;
	var speed = 0;
	if(length) {
		speed = length / 50;
		if(Math.abs(speed) < 1) {
			document.documentElement.scrollTop = offsetTop;
			document.body.scrollTop = offsetTop;
			return;
		}

		timer = setInterval(function() {
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			if(Math.abs(scrollTop - offsetTop) >= Math.abs(speed)) {
				document.documentElement.scrollTop = scrollTop + speed;
				document.body.scrollTop = scrollTop + speed;
			} else {
				clearInterval(timer)
				timer = null;
				document.documentElement.scrollTop = offsetTop;
				document.body.scrollTop = offsetTop;
				return;
			}
		}, 5)
	}
})

var navTop = $('body>.nav-wrap').offset().top;
var screenHeight = document.documentElement.clientHeight || document.body.clientHeight;
window.onscroll = function() {
	scrollTop = document.documentElement.scrollTop || document.body.scrollTop

	if(scrollTop > navTop) {
		$('.page-nav').addClass('fixed2')
	} else {
		$('.page-nav').removeClass('fixed2')
	}
	if(timer) {
		return;
	}
	for(var i = 0; i < $('.section').size(); i++) {
		if(scrollTop >= $('.section').eq(i).offset().top - screenHeight / 2 && scrollTop + screenHeight < $('.section').eq(i).offset().top + $('.section').eq(i).outerHeight() + (screenHeight / 2)) {
			$('.page-nav-item').eq(i).addClass('active-nav').siblings().removeClass('active-nav')
		}
	}
}