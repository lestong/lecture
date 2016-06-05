var TaskLists = function () {

    var initTable6 = function () {

        var table = $('#task_lists');

        /* Fixed header extension: http://datatables.net/extensions/keytable/ */

        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "/index.php/Home/Task/ajax_lists",
				"type": "POST"
			},
			"columns": [
				{ "data": "name" },
				{ "data": "create_time" },
				{ "data": "qingjingid" },
				{ "data": "status" },
                { "data": null}
			],
			columnDefs: [
                {
                    targets: 4,
                    render: function (a, b, c, d) {
                        var context =
                        {
                            func: [
                                {"name": "修改", "fn": "edit(\'" + c.name + "\',\'" + c.position + "\',\'" + c.salary + "\',\'" + c.start_date + "\',\'" + c.office + "\',\'" + c.extn + "\')", "type": "primary"},
                                {"name": "删除", "fn": "del(\'" + c.name + "\')", "type": "danger"}
                            ]
                        };
                        html = "<a href=\"/index.php/Home/Task/view/taskid/" + c.id +"\" class=\"btn default btn-xs green-stripe\">View </a>";
						html += "<a href=\"javascript:;\" class=\"btn default btn-xs purple\"><i class=\"fa fa-edit\"></i> Edit </a>";
                        return html;
                    }
                }
 
            ],
        });

        var oTableColReorder = new $.fn.dataTable.ColReorder( oTable );

        var tableWrapper = $('#sample_6_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initTable6();

        }

    };

}();