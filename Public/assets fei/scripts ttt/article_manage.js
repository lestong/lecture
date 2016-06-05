

/* Fixed header extension: http://datatables.net/extensions/keytable/ */
$(function(){
	
	var table = $('#manage_lists');
	var oTable = table.dataTable({
		// Internationalisation. For more info refer to http://datatables.net/manual/i18n
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/index.php/Home/Article/ajax_manage",
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
			{ "data": "title" },
			{ "data": "sort1" },
			{ "data": "create_time" },
			{ "data": "status" },
			{ "data": null, 'orderable':false}
		],
		columnDefs: [
			{
				targets:3,
				render:function(a, b, c, d){
					if(c.status == 0){
						html = "待审核";
					}else if(c.status == 99){
						html = "通过";
					}else if(c.status == 1){
						html = "退稿";
					}
					
					return html;
				}
			},
			{
				targets: 4,
				render: function (a, b, c, d) {
					if(c.status != 99){
						html = "<a href=\"/index.php/Home/Article/view/id/" + c.id +"/test/1\" class=\"btn default btn-xs green-stripe\">预览 </a>";
						html += "<a href=\"/index.php/Home/Article/edit/id/" + c.id +"\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> 编辑 </a>";
						//html += "<a href=\"/index.php/Home/Article/delete/id/" + c.id +"\" class=\"btn default btn-xs black\"><i class=\"fa fa-trash-o\"></i> 删除 </a>";
						html += "<a href=\"javascript:;\" class=\"btn default btn-xs black delete\" data-id=\"" + c.id +"\"><i class=\"fa fa-trash-o\"></i> 删除 </a>";
					}else{
						html = "<a href=\"/index.php/Home/Article/view/id/" + c.id +"\" class=\"btn default btn-xs green-stripe\">查看 </a>";
					}
					
					return html;
				}
			}

		],
	});
	
	table.on('click', '.delete', function (e) {
		e.preventDefault();

		if (confirm("确定删除该信息 ?") == false) {
			return;
		}
		var id = $(this).attr("data-id");
		var nRow = $(this).parents('tr')[0];
		console.log(id);
		$.ajax({
			type: "post",
			url: Think_ajax_handleDelete,
			dataType: 'JSON',
			data: {id:id},
			success: function (data) {
				if (data.flag){
					oTable.fnDeleteRow(nRow);
				}else{
					alert("删除失败,请联系管理员");
				}
			},
			error: function(){
				alert("系统异常，请稍后");
			}
		});
	});
	
});
