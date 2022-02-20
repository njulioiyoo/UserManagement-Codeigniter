<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<style type="text/css">
.popover-content{
	max-height: 400px;
	overflow-y: auto;
}
</style>

<table id="grid-groupuserlist"></table>
<div id="pager-grid-groupuserlist"></div>

<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		global: false
	});

	$("#grid-groupuserlist").jqGrid({
		styleUI: 'Bootstrap',
		responsive: true,
        url: '<?php echo base_url("ajax/ajaxGroupuser/tablegroupuser");?>',
        mtype: 'POST',
        datatype: "json",
        contentType: "application/json; charset-utf-8",
        colModel: [
            { label: '##', index: 'act', name: 'act', width: 15, search:false, },
            { label: 'Name', index: 'name', name: 'name', width: 50 },
            { label: 'Ket', index: 'remarks', name: 'remarks', width: 50 },
        ],
        // loadonce: true,
        // width: 1024,
        rownumbers: true,
        rownumWidth: 35,
        sortorder: "desc",
        sortname: "id_groupuser",
        height: 'auto',
        rowNum: 10,
        rowList: [5, 10, 20, 50, 100],
		viewrecords: true,
        pager: "#pager-grid-groupuserlist",
        caption: "<?php echo $title;?>",
    });

    $('#grid-groupuserlist').jqGrid('filterToolbar'); 
    $('#grid-groupuserlist').jqGrid('navGrid',"#pager-grid-groupuserlist", {                
        search: false, // show search button on the toolbar
        add: false,
        edit: false,
        del: false,
        refresh: true
    });

    $("#grid-groupuserlist").setGridWidth($(".groupuserlist").width());

});

function showpopover(obj) {

	$(obj).popover({
		container: 'body',
		animation: false,
		trigger: 'click',
		html: true,
		placement: 'top',
    	title: '<span class="text-info"><i class="fa fa-info-circle"></i> Description Detail</span> <a href="javascript:void(0);" class="close close-help">×</a>',
    });

}
</script>