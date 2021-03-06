

/* Fixed header extension: http://datatables.net/extensions/keytable/ */
$(function(){
	var oTable = $('#manage_lists').dataTable({
		// Internationalisation. For more info refer to http://datatables.net/manual/i18n
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/index.php/Home/Task/ajax_manage",
			"type": "POST"
		},
	    "language": {
		     "sProcessing": "处理中...",
		     "sLengthMenu": "显示 _MENU_ 项结果",
		     "sZeroRecords": "没有匹配结果",
		     "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
		     "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
		     "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
		     "sInfoPostFix": "",
		     "sSearch": "搜索:",
		     "sUrl": "",
		     "sEmptyTable": "表中数据为空",
		     "sLoadingRecords": "载入中...",
		     "sInfoThousands": ",",
		     "oPaginate": {
		  	   "sFirst": "首页",
		  	   "sPrevious": "上页",
		  	   "sNext": "下页",
		  	   "sLast": "末页"
		     },
		     "oAria": {
		  	   "sSortAscending": ": 以升序排列此列",
		  	   "sSortDescending": ": 以降序排列此列"
		     }
	    },
		"columns": [
			{ "data": "name" },
			{ "data": "qingjingpid" },
			{ "data": "endtime" },
			{ "data": "mission_create_time" },
			{ "data": "score" },
			{ "data": null, "orderable": false}
		],
		columnDefs: [
			{		
				targets:3,
				render: function(a, b, c, d){
					if(c.mission_create_time)
						html = "已完成";
					else
						html = "未完成";
					return html;
				}
			},
			{
				targets: 5,
				render: function (a, b, c, d) {
					html = "<a href=\"/index.php/Home/Task/viewMission/taskid/" + c.id +"\" class=\"btn default btn-xs green-stripe\">查看 </a>";
					//正在进行的任务可编辑 
					if(c.status == 1){
						html += "<a href=\"/index.php/Home/Task/editMission/taskid/" + c.id +"\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> 编辑 </a>";
					}
					
					return html;
				}
			}

		],
	});
	
});
