<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    var csfrData = {};
     csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
     $(function() {
    // Attach csfr data token
     $.ajaxSetup({
       data: csfrData
    });
    });


    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_path/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
    enable_delete('<?php echo $this->lang->line("profiles_confirm_permanent_delete")?>','<?php echo $this->lang->line("profiles_none_selected")?>');
    enable_undo_delete('<?php echo $this->lang->line("profiles_confirm_undo_delete")?>','<?php echo $this->lang->line("profiles_none_selected")?>');
	

}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}

 
</script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div id="page_title">
            <?php  echo $this->lang->line("common_admin");
            echo str_repeat('&nbsp;', 3);
            $title = ($user_id == -1) ? $this->lang->line("common_add") : $this->lang->line("common_edit");

            echo $title;?> 
        </div>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tachometer-alt"></i> Home</a></li>
            <li class="active">Admin</li>
            <li class="active"> <?php 
                echo $title;
            ?></li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
 
<div id="title_bar">
	<div id="title" class="float_left"><?php echo  $this->lang->line('module_'.$controller_name); ?></div>
 
</div>
<div id="pagging">
<?php echo $this->pagination->create_links();?>
</div>
<div id="table_action_header">
	<ul>
		<li  class="float_right">
			<?php
			echo "<span  id='search_clear'  >".anchor("$controller_path/index","Clear Search")."</span>";
			?>
		</li>
		<li class="float_right">
		<?php echo form_open("$controller_path/search",array('id'=>'search_form')); ?>
		<input type="text"  placeholder="Search..." name ='search' id='search'/>
		</form>
		</li>
	</ul>
</div>
<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>
</article>
											
																 
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

   