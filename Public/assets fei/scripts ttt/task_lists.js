
 var oTable,table;
 table = $('#article_lists');
$(function(){
	
	table = $('#article_lists');
	oTable = table.DataTable({
		// Internationalisation. For more info refer to http://datatables.net/manual/i18n
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "/index.php/Home/Task/ajax_lists",
			"type": "POST",
			"data": function(d){
				d.qingjingpid = $("#qingjingpid").val();
				d.qingjingid = $("#qingjingid").val();
			}
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
			{ "data": "create_time" },
			{ "data": "endtime" },
			{ "data": "status", "orderable" :false },
			{ "data": null, "orderable" :false}
		],
		columnDefs: [
			{
				targets: 4,
				render: function (a, b, c, d) {
					if(c.status == 1)
						return "进行中";
					else
						return "结束"
				}
			},
			{
				targets: 5,
				render: function (a, b, c, d) {
					html = "<a href=\"/index.php/Home/Task/view/taskid/" + c.id +"\" class=\"btn default btn-xs green-stripe\">查看 </a>";
					//如果是指派型任务, 则进行中的任务可以编辑
					if(c.type == 1 && c.status == 1){
						html += "<a href=\"/index.php/Home/Task/editMission/taskid/" + c.id +"\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> 编辑 </a>";
					}
					
					if(c.type == 2){
						if(c.missionid == null){	//如果是领取型, 并且没有missionid , 则显示领取按钮icon-basket
							html += "<a href=\"javascript:;\" class=\"btn default btn-xs purple receive\" data-id=\"" + c.id +"\"><i class=\"icon-basket\"></i> 领取 </a>";
						}else{		//显示编辑
							html += "<a href=\"/index.php/Home/Task/editMission/taskid/" + c.id +"\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> 编辑 </a>";
						}
					}
					return html;
				}
			}

		],
		initComplete:initComplete
	});
	
	$('#article_lists').on('click', '.receive', function (e) {
		e.preventDefault();

		if (confirm("确定领取该任务 ?") == false) {
			return;
		}
		var id = $(this).attr("data-id");
		var nRow = $(this).parents('tr')[0];
		console.log(nRow);
		$.ajax({
			type: "post",
			url: Think_ajax_handleReceive,
			dataType: 'JSON',
			data: {id:id},
			success: function (data) {
				if (data.flag){
					// oTable.fnDeleteRow(nRow);
					oTable.ajax.reload();
				}else{
					alert("领取失败,请联系管理员");
				}
			},
			error: function(){
				alert("系统异常，请稍后");
			}
		});
	});
	
});


/* Fixed header extension: http://datatables.net/extensions/keytable/ */


//var oTableColReorder = new $.fn.dataTable.ColReorder( oTable );

// var tableWrapper = $('#sample_6_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
// tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
function initComplete(data){
	$("#tree_task_sort").jstree({
		"core" : {
			"themes" : {
				"responsive": false
			}, 
			// so that create works
			"check_callback" : true,
			'data': {
				'url' : '/index.php/Home/Task/ajax_sortList',
			},
		},
		"types" : {
			"default" : {
				"icon" : "fa fa-folder icon-state-warning icon-lg"
			},
			"file" : {
				"icon" : "fa fa-file icon-state-warning icon-lg"
			}
		},
		"state" : { "key" : "tasklist" },
		"plugins" : [ "contextmenu", "dnd", "state", "types" ]
	}).on('select_node.jstree', function (e, data) {
		var qingjingpid = $("#qingjingpid").val();
		var qingjingid = $("#qingjingid").val();
		//选择父级
		console.log(data);
		if(data.node.parent == "#"){
			if(qingjingpid !=  0 || qingjingid != 0){
				$("#qingjingpid").val(0);
				$("#qingjingid").val(0);
				oTable.ajax.reload();
			}
			
		}else if(data.node.parent == "0"){
			if(data.node.id != qingjingpid || qingjingid != 0){
				$("#qingjingpid").val(data.node.id);
				$("#qingjingid").val(0);
				oTable.ajax.reload();
			}
		}else{
			if(data.node.parent != qingjingpid || data.node.id != qingjingid){
				$("#qingjingpid").val(data.node.parent);
				$("#qingjingid").val(data.node.id);
				oTable.ajax.reload();
			}
		}
		/* if(data && data.selected && data.selected.length) {
			$.get('?operation=get_content&id=' + data.selected.join(':'), function (d) {
				$('#data .default').text(d.content).show();
			});
		}
		else {
			$('#data .content').hide();
			$('#data .default').text('Select a file from the tree.').show();
		} */
	});
}