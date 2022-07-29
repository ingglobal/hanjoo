<?php
if (!defined('_GNUBOARD_')) exit;
?>
<style>
.li_dash_submenu{position:relative;}
.li_dash_submenu > i {cursor:pointer;}
.li_dash_submenu > i:hover{color:yellow;}
.li_dash_submenu span i{color:#ffff;font-size:0.7em;font-weight:700;}
.li_dash_submenu span:hover{background:darkorange;}
.li_dash_submenu span{position:absolute;top:4px;left:-20px;cursor:pointer;background:darkred;text-align:center;width:20px;height:20px;line-height:14px;border-radius:50%;display:none;}
.li_dash_submenu .fa-pencil-square{position:absolute;top:5px;right:12px;}
.li_dash_submenu .fa-window-close{position:absolute;top:5px;right:-12px;}
.li_dash_submenu a{display:block;width:100px;overflow-x:hidden;height:27px;line-height:27px;}
.li_dash_submenu input{position:absolute;top:0;left:0;width:100px;height:27px;line-height:27px;background:#444;color:#fff;border:1px solid #888;padding:0 2px;}
</style>
<script>
//실제 서브 메뉴의 부모는 #ul_dash_submenu
$('#dash_add_dashboard').parent().appendTo('#ul_dash_add').removeClass('li_dash_submenu');
$('<i class="fa fa-pencil-square dash_edit" aria-hidden="true"></i>').appendTo('.li_dash_submenu');
$('<i class="fa fa-window-close dash_delete" aria-hidden="true"></i>').appendTo('.li_dash_submenu');
$('<span><i class="fa fa-arrows dash_move" aria-hidden="true"></i></span>').appendTo('.li_dash_submenu');
var dash_sub = $('#ul_dash_submenu');
var dash_add = $('#dash_add_dashboard');
var dash_mod = $('.dash_edit');
var dash_del = $('.dash_delete');
if($('.li_dash_submenu').length > 1){
    $('#ul_dash_submenu').sortable({
        connectWith: '#ul_dash_submenu',
        // handle: '.dash_move'
        update: function(event, ui){
            var sorted = '';
            $('.li_dash_submenu').each(function(){
                sorted += ($(this).index() == 0) ? $(this).attr('mta_idx') : ','+$(this).attr('mta_idx');
            });
            // console.log(sorted);
            var dash_url = g5_user_admin_url+'/ajax/dash_sort.php';
            $.ajax({
                type: 'POST',
                url: dash_url,
                data: {'sorted':sorted},
                // dataType: 'text',
                success: function(res){
                    // console.log(res);
                    location.reload();
                },
                error: function(req){
                    alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
                }
            });
        }
    });
}


dash_add.on('click',function(){
    var dash_url = g5_user_admin_url+'/ajax/dash_add.php';
    $.ajax({
        type: 'POST',
        url: dash_url,
        // dataType: 'text',
        success: function(res){
            // console.log(res);
            location.reload();
        },
        error: function(req){
            alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
        }
    });
});

dash_mod.on('click',function(){
    if($(this).siblings('input').length){
        if($(this).siblings('input').val() != ''){
            var ipt_val = $(this).siblings('input').val();
            var dash_url = g5_user_admin_url+'/ajax/dash_mod_ttl.php';
            var sub_menu_cd = $(this).parent().attr('data-menu');
            $.ajax({
                type: 'POST',
                url: dash_url,
                data: {'mta_value':sub_menu_cd, 'mta_title':ipt_val},
                success: function(res){
                    location.reload();
                },
                error: function(req){
                    alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
                }
            });
        }
        return true;
    }
    $('.ipt_ds_ttl').remove();
    $('<input name="mta_title" class="ipt_ds_ttl" value="'+$(this).siblings('a').text()+'">').appendTo($(this).parent());
    ipt_event_on();
});

dash_del.on('click',function(){
    if($('.ipt_ds_ttl').length){
        ipt_event_off();
        $('.ipt_ds_ttl').remove();
        return false;
    }
    var dash_url = g5_user_admin_url+'/ajax/dash_del.php';
    var sub_menu_cd = $(this).parent().attr('data-menu');
    var sub_menu_idx = $(this).parent().attr('mta_idx');
    $.ajax({
       type: 'POST',
       url: dash_url,
       dataType: 'text',
       data: {'mta_idx':sub_menu_idx,'mta_value':sub_menu_cd},
       success: function(res){
            // console.log(res);
            location.reload();
        },
        error: function(req){
            alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
        }
    });
});


function ipt_event_on(){
    $('.ipt_ds_ttl').on('keypress',function(e){
        if(e.which == 13){
            if($(this).val() != ''){
                var dash_url = g5_user_admin_url+'/ajax/dash_mod_ttl.php';
                var sub_menu_cd = $(this).parent().attr('data-menu');
                $.ajax({
                    type: 'POST',
                    url: dash_url,
                    data: {'mta_value':sub_menu_cd, 'mta_title':$(this).val()},
                    success: function(res){
                        location.reload();
                    },
                    error: function(req){
                        alert('Status: ' + req.status + ' \n\rstatusText: ' + req.statusText + ' \n\rresponseText: ' + req.responseText);
                    }
                });
            } 

            ipt_event_off();
            $(this).remove();
        }
    });
}
function ipt_event_off(){
    $('.ipt_ds_ttl').off('keypress');
}
</script>