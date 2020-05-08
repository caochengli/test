// JavaScript Document
function Enter(obj, direction, distance, number, time, delay) {
	// 从左往右，distance > 0
	if(direction == "left"){
		obj.stop().animate({
			left : distance,
			opacity : 1
		}, time)
		setTimeout(function(){
			if(obj.next().index() + 1 <= number){
				Enter(obj.next(), direction, distance, number, time, delay)
			}
		}, delay)
	}
	// 从上往下，distance > 0
	if(direction == "top"){
		obj.stop().animate({
			top : distance,
			opacity : 1
		}, time)
		setTimeout(function(){
			if(obj.next().index() + 1 <= number){
				Enter(obj.next(), direction, distance, number, time, delay)
			}
		}, delay)
	}
	// CSS3 X位移
	if(direction == "X"){
		obj.stop().transition({
			x : distance,
			opacity : 1
		}, time)
		setTimeout(function(){
			if(obj.next().index() + 1 <= number){
				Enter(obj.next(), direction, distance, number, time, delay)
			}
		}, delay)
	}
	// CSS3 y位移
	if(direction == "Y"){
		obj.stop().transition({
			y : distance,
			opacity : 1
		}, time)
		setTimeout(function(){
			if(obj.next().index() + 1 <= number){
				Enter(obj.next(), direction, distance, number, time, delay)
			}
		}, delay)
	}
}