jQuery(function($){
	var calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
        timeFormat: 'H:mm',
        buttonText: {
            prev: '<',
            next: '>',
        }, 
		weekNumbers: true,
		events: "{:U('Schedule/getEvents', array('id'=>session('uid')))}",
		selectable: true,
		selectHelper: true,
		select: function(start, end, jsEvent, view) {
			// var sTime, eTime;
			// if(start.hasTime())
			// 	sTime = start.format('YYYY-M-D H:mm');
			// else
			// 	sTime = start.format('YYYY-M-D');
			// if(end.hasTime())
			// 	eTime = end.format('YYYY-M-D H:mm');
			// else
			// 	eTime = end.format('YYYY-M-D');

			// $("#begin_time").attr('value', sTime);
			// $('#end_time').attr('value', eTime);
			// //$('#is_allday').attr('value', allDay);
			// $('.modal').modal('show');
			//bootbox.setLocale("zh_CN");
			bootbox.prompt("新日程内容:", function(title) {
				var eventData;
				var allDay;
				if(title!==null){
					if(view.name=='month')
						allDay = 1;
					eventData = {
						title: title,
						begin_time: start.format('YYYY-M-D H:mm'),
						end_time: end.format('YYYY-M-D H:mm'),
						user_id: {:session('uid')},
						color: '#DC143C',
						is_allday: allDay
					};
					$.post("{:U('Schedule/add')}", eventData,function(msg){
						if(msg==1){
							$('#calendar').fullCalendar('refetchEvents');
						}
						else{
							bootbox.alert(msg);
						}
					});
				}	
			});
		},
			
		
		editable: true,
	});

});