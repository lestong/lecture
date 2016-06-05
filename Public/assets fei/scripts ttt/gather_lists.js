
		var oTable;
		$(function(){
			oTable = $('#article_lists').DataTable({
				// Internationalisation. For more info refer to http://datatables.net/manual/i18n
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "/index.php/Home/Gather/ajax_lists",
					"type": "POST",
					"data": function(d){
						d.weikeid = $("#weikeid").val();
						d.type = $("#type").val();
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
					{ "data": "title" },
					{ "data": "create_time" },
					{ "data": "type" },
					{ "data": "status" },
					{ "data": null, "orderable":false}
				],
				columnDefs: [
					{
						targets: 4,
						render: function (a, b, c, d) {
							html = "<a href=\"/index.php/Home/Gather/view/gid/" + c.id +"\" class=\"btn default btn-xs green-stripe\">查看 </a>";
							// html += "<a href=\"javascript:;\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> Edit </a>";
							return html;
						}
					}
	 
				],
				initComplete:initComplete
			});
		});
        /* Fixed header extension: http://datatables.net/extensions/keytable/ */


        //var oTableColReorder = new $.fn.dataTable.ColReorder( oTable );

        // var tableWrapper = $('#sample_6_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        // tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
		function initComplete(data){
			$("#tree_gather_list").jstree({
				"core" : {
					"themes" : {
						"responsive": false
					}, 
					// so that create works
					"check_callback" : true,
					'data': {
						'url' : '/index.php/Home/Gather/ajax_sortList',
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
				"state" : { "key" : "gatherlist" },
				"plugins" : [ "contextmenu", "dnd", "state", "types" ]
			}).on('select_node.jstree', function (e, data) {
				var weikeid = $("#weikeid").val();
				var type = $("#type").val();
				//选择父级
				console.log(data);
				$("#weikeid").val(data.node.original.weikeid);
				$("#type").val(data.node.original.type);
				oTable.ajax.reload();
			});
		}