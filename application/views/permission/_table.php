<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<style type="text/css">
.popover-content{
	max-height: 400px;
	overflow-y: auto;
}
</style>

<table id="grid-permission"></table>
<div id="pager-grid-permission"></div>

<script type="text/javascript">
$(document).ready(function(){

	$("#grid-permission").jqGrid({
		styleUI: 'Bootstrap',
		responsive: true,
        url: '<?php echo base_url("permission/tablepermission");?>',
        mtype: 'POST',
        datatype: "json",
        contentType: "application/json; charset-utf-8",
        colModel: [
            { label: '##', index: 'act', name: 'act', width: 15, search:false, },
            { label: 'Name', index: 'name', name: 'name', width: 35, },
            { label: 'Modul', index: 'parent', name: 'parent', width: 35, },
        ],
        rownumbers: true,
        rownumWidth: 35,
        sortorder: "desc",
        sortname: "id_permission",
        height: 'auto',
        rowNum: 10,
        rowList: [5, 10, 20, 50, 100],
		viewrecords: true,
        pager: "#pager-grid-permission",
        caption: "<?php echo $title;?>",
    });

    $('#grid-permission').jqGrid('filterToolbar'); 
    $('#grid-permission').navGrid('#pager-grid-permission', 
        {search: false, add: false, edit: false, del: false, refresh: true}
    ); 
    // $('#grid-permission').jqGrid('navGrid',"#pager-grid-permission", {                
    //     search: false, // show search button on the toolbar
    //     add: false,
    //     edit: false,
    //     del: false,
    //     refresh: true,
    //     position: "left", cloneToTop: true
    // });

    $("#grid-permission").setGridWidth($(".box-content").width());

    // 1065

});

</script>