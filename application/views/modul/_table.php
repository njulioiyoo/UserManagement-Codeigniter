<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<style type="text/css">
.popover-content{
	max-height: 400px;
	overflow-y: auto;
}
</style>

<table id="grid-modul"></table>
<div id="pager-grid-modul"></div>

<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
		global: false
	});

	$("#grid-modul").jqGrid({
		styleUI: 'Bootstrap',
		responsive: true,
        url: '<?php echo base_url("modul/tablemodul");?>',
        mtype: 'POST',
        datatype: "json",
        contentType: "application/json; charset-utf-8",
        colModel: [
            { label: '##', index: 'act', name: 'act', width: 15, search:false, },
            { label: 'Name', index: 'name', name: 'name', width: 35, },
            { label: 'Parent', index: 'parent', name: 'parent', width: 35, },
        ],
        rownumbers: true,
        rownumWidth: 35,
        sortorder: "desc",
        sortname: "id_modul",
        height: 'auto',
        rowNum: 10,
        rowList: [5, 10, 20, 50, 100],
		viewrecords: true,
        pager: "#pager-grid-modul",
        caption: "<?php echo $title;?>",
    });

    $('#grid-modul').jqGrid('filterToolbar'); 
    $('#grid-modul').jqGrid('navGrid',"#pager-grid-modul", {                
        search: false, // show search button on the toolbar
        add: false,
        edit: false,
        del: false,
        refresh: true
    });

    $("#grid-modul").setGridWidth($(".box-content").width());

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