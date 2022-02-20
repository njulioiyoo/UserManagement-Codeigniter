<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
 * ***************************************************************
 * Script : PHP
 * Version : Codeigniter 3.1.9
 * Author : Julio Notodiprodyo
 * Email : njulioiyoo@gmail.com
 * ***************************************************************
 */
 
/**
 * undocumented class
 *
 * @package default
 * @author
 **/
class AdminController extends MY_Controller
{
    protected $breadcrumbs = array();
    protected $error500    = array(); // anchor link's | type String
    protected $addons      = array(); // addon buttons
    public $tabs           = array();

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('userlogin_id')) {
            redirect(site_url('login'));
        }

        $assets = $this->assets();

        $script = '
			function deleterow(obj){
				var link = $(obj).data("delete"),
					name = $(obj).data("name"),
					message = "Yakin ingin hapus "+name+" dari tabel?";
				if(confirm(message)){
					location.href = link;
				}
			}
			function printerrors(errors){
				$.each(errors, function(name, value){
					var input = $("#field-"+name),
						error = $("#error-"+name),
						div = $(input).closest(".control-group");

					div.removeClass("error");
					error.html("");
					if(value !== ""){
						div.addClass("error");
						error.html(value);
					}
				})
			}

			$(\'.btn-close\').click(function(e){
				e.preventDefault();
				$(this).parent().parent().parent().fadeOut();
			});
			$(\'.btn-minimize\').click(function(e){
				e.preventDefault();
				var $target = $(this).parent().parent().next(\'.box-content\');
				if($target.is(\':visible\')) $(\'i\',$(this)).removeClass(\'icon-chevron-up\').addClass(\'icon-chevron-down\');
				else 					   $(\'i\',$(this)).removeClass(\'icon-chevron-down\').addClass(\'icon-chevron-up\');
				$target.slideToggle();
			});
		';
        $this->setJs($assets['optimus']['base_js'])
            ->registerScript($script)
            ->setCss($assets['optimus']['base_css']);

        $this->tabs           = $this->setDefaultTabs();
        $this->breadcrumbs[0] = array('name' => 'Dashboard', 'url' => base_url(), 'class' => 'active');
        $this->error500       = array('previous' => '<a href="javascript:void(0);" onclick="history.back();">back to previous page</a>', 'index' => '<a href="' . base_url() . '">index</a>');
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    protected function mailconfig()
    {
        $config              = array();
        $config['protocol']  = 'smtp';
        $config['smtp_host'] = '#';
        $config['smtp_port'] = 587;
        $config['smtp_user'] = '#';
        // $config['smtp_pass'] = '';
        $config['smtp_timeout']   = 50;
        $config['mailtype']       = 'html';
        $config['charset']        = 'iso-8859-1';
        $config['wordwrap']       = true;
        $config['bcc_batch_mode'] = true;

        return $config;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    protected function _config_upload()
    {
        $config                  = array();
        $config['upload_path']   = './public/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|rar|zip|xls';
        // $config['max_size'] = '500';
        // $config['max_width'] = '1024';
        // $config['max_height'] = '768';

        return $config;
    }
} // END class
