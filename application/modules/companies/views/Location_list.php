<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div id="page_title">
            <?php  echo $this->lang->line("common_locations");?> 
        </div>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-tachometer-alt"></i> <?php  echo $this->lang->line("common_home");?> </a></li>
            <li class="active"><?php  echo $this->lang->line("common_companies");?></li>
            <li class="active"> <?php  echo $this->lang->line("common_locations");?> </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-info profile_form">
        <div id="pagging">
            <?php echo $this->pagination->create_links();?>
        </div>

        <div id="table_action_header">
            <ul>
                
                <li   class="float_right">
                    <?php
                    echo "<span  id='search_clear' >".anchor("$controller_path/index","Clear Search")."</span>";
                    ?>
                </li>
                <li class="float_right">
                    <?php echo form_open("$controller_path/search",array('id'=>'search_form')); ?>
                    <label>Search: </label>
                    <input type="text"  placeholder=" Search..." name ='search' id='search'/>
                    </form>
                </li>
            </ul>
        </div>

        <div id="table_holder">
            <?php echo $manage_table; ?>
        </div>

        <div id="new_button">
                <?php echo anchor("$controller_path/locationview/$company_id",
                    "<div class='big_button float_left'><span>".$this->lang->line('profiles_new')."</span></div>",
                    array('class'=>'','title'=>$this->lang->line($controller_name.'_new')));
                    ?>
        </div>
        <div id="feedback_bar"></div>
    </div>

    </section>
        <!-- end content -->
</div>
  
<script type="text/javascript">
      $(".remove").click(function(){
        var id = $(this).parents("tr").attr("id");
        var url = '<?php echo site_url("$controller_path/deletebyid/")?>' + id;
        jAlert('Are you sure to remove this user?'+url, 'Confirmation Dialog', function(r) {
            $.ajax({
               url: url,
               type: 'GET',
               data: {id: id},
               error: function() {
                  alert('Something is wrong');
               },
               success: function(data) {
                    $("#"+id).remove();
               }
            });

        });

    });

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
       enable_delete('<?php echo $this->lang->line("profiles_confirm_delete")?>','<?php echo $this->lang->line("profiles_none_selected")?>');
   
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
   				7: { sorter: false},
   				8: { sorter: false} 
   			} 
   
   		}); 
   	}
   }
   
   function post_person_form_submit(response)
   {
   
   	if(!response.success)
   	{
   		//Error on saving
   	}
   	else
   	{
        tb_remove();
            //This is an update, just update one row
            if(jQuery.inArray(response.user_id,get_visible_checkbox_ids()) != -1)
            {
            
                update_row(response.user_id,'<?php echo site_url("$controller_path/get_row")?>');
                setTimeout(function(){ init_table_sorting(); }, 500);
                set_feedback(response.message,'success_message',false);	
                
            }
            else //refresh entire table
            {
                    set_feedback(response.message,'success_message',false);	
                    location.reload();				
            }
        }
    }
</script>
