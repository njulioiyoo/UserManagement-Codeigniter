<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

	<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    CRM App &copy; <?php echo date("Y");?> PT. MNC Investama, Tbk | Design By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a> | 
                    Developed By : <a href="mailto:julio.notodiprodyo@mncgroup.com"><small>Julio Notodiprodyo</small></a>
                </div>

            </div>
        </div>
    </footer>
	
<?php echo isset($assets_js_bottom) ? $assets_js_bottom : ""; ?>
<script type="text/javascript">
    // Jquery draggable
    $('.modal-dialog').draggable({handle: '.modal-header'});
    // $('.modal-content').resizable();
</script>
</body>
</html>