var scrollTopTimer=null

$('.close-box').click(function() {
	event.stopPropagation()
	$('.contact-box').fadeOut(100)
})
$('.contact-menu').click(function() {
	$('.contact-box').fadeIn(100)
})
$('.top-menu').click(scrollTop)
$('.close-board,.close-order-board').click(function(){
	$('.cover').fadeOut(200,function(){
		$('.name').val('')
		$('.phone').val('')
	})
})
$('.board-input').focus(function(){
	$(this).removeClass('warn-input')
})
$('.show-board').click(showOrderBoard)
$('.order-btn').click(function(){
	
	if(!$('.name').val()){
		$('.name').addClass('warn-input')
		return
	}
	if(!$('.phone').val()){
		$('.phone').addClass('warn-input')
		return
	}
	if(!$('.business').val()&&$('.business').val()!==0){
		$('.business').addClass('warn-input')
		return
	}
	var name=$('.name').val()
	var phone=$('.phone').val()
	var business=$('.business option:selected').text()
	let token = document.head.querySelector('meta[name="csrf-token"]');
	$.ajax({
		type:"post",
		url:"https://msgo.xyz/apply",
		async:true,
		data:{
			imgs_url:'',
			content:'用户'+name+'申请'+business,
			phone:phone,
			from:'official',
		},
		headers:{
			'X-CSRF-TOKEN' : token.content
		},
		success:function(res){
			if(res.code==0){
				$('.cover .board-content').eq(0).hide().next().show()
			}
			else{
				alert(res.msg)
			}
		}
	});
	
})

function showOrderBoard(){
	$('.cover .board-content').eq(0).show().next().hide()
	$('.cover').fadeIn(200)
}

function scrollTop(){
	if(scrollTopTimer) {
		return;
	}
	if(window.timer){
		clearInterval(timer)
	}
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	var length = scrollTop
	var speed = 0;
	if(length) {
		speed = length / 50;
		if(speed < 1) {
			document.documentElement.scrollTop = 0;
			document.body.scrollTop = 0;
			return;
		}
		scrollTopTimer = setInterval(function() {
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			if(scrollTop >= speed) {
				document.documentElement.scrollTop = scrollTop -speed;
				document.body.scrollTop = scrollTop -speed;
			} else {
				clearInterval(scrollTopTimer)
				scrollTopTimer = null;
				document.documentElement.scrollTop = 0;
				document.body.scrollTop = 0;
				return;
			}
		}, 5)
	}
}