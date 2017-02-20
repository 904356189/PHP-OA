function setSidebarActive(root, child){
	clearSidebarActive();
	var childId = 'li'+"#"+child;
	var rootId = "li#"+root;
	$(childId).addClass('active');
	$(rootId).addClass('active open');
}

function clearSidebarActive(){
	$('li.open').removeClass('active open');
	$('li.active').removeClass('active');
}