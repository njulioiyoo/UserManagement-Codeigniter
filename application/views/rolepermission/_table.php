<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<style type="text/css">
.popover-content{
	max-height: 400px;
	overflow-y: auto;
}
</style>

<table id="grid-rolepermission"></table>
<div id="pager-grid-rolepermission"></div>

<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		global: false
	});

	$("#grid-rolepermission").jqGrid({
		styleUI: 'Bootstrap',
		responsive: true,
        url: '<?php echo base_url("rolepermission/tablerolepermission");?>',
        mtype: 'POST',
        datatype: "json",
        contentType: "application/json; charset-utf-8",
        colModel: [
            { label: '##', index: 'act', name: 'act', width: 15, search:false, },
            { label: 'Name', index: 'name', name: 'name', width: 35, },
            { label: 'Permission Total', index: 'total', name: 'total', width: 15, },
        ],
        rownumbers: true,
        rownumWidth: 35,
        sortorder: "desc",
        sortname: "id_role",
        height: 'auto',
        rowNum: 10,
        rowList: [5, 10, 20, 50, 100],
		viewrecords: true,
        pager: "#pager-grid-rolepermission",
        caption: "<?php echo $title;?>",
    });

    $('#grid-rolepermission').jqGrid('filterToolbar'); 
    $('#grid-rolepermission').jqGrid('navGrid',"#pager-grid-rolepermission", {                
        search: false, // show search button on the toolbar
        add: false,
        edit: false,
        del: false,
        refresh: true
    });

    $("#grid-rolepermission").setGridWidth($(".box-content").width());

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