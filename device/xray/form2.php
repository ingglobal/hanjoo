<?php
include_once('./_common.php');
include(G5_PATH.'/head.sub.php');

$arr['token'] = $_REQUEST['token'];
$arr['qrcode'] = $_REQUEST['qrcode'];
$arr['cast_code'] = $_REQUEST['cast_code'];
$arr['grade'] = $_REQUEST['grade'];
$arr['result'] = $_REQUEST['result'];
//print_r2($arr);
//exit;
?>
<style>
    #hd_login_msg {display:none;}
    table tr td {border:solid 1px #ddd;padding:10px;}
    button {background:#ff8b37;padding:10px 20px;font-size:1.5em;border-radius:4px;}
</style>

<form id="form02" action="./index.php">

<table>
	<tr><td style="background:#aaa;">JSON BODY (실제로 넘어가는 JSON object)</td></tr>
	<tr>
        <td>
            <?=json_encode($arr);?>
        </td>
    </tr>
	<tr><td style="background:#aaa;">배열값으로 보면 이렇습니다.</td></tr>
	<tr>
        <td style="background:#f3f3f3;">
            <?=print_r2($arr);?>
        </td>
    </tr>
</table>
    
<hr>
<button type="submit" id="btn_submit">등록하기</button>
</form>


<script>
$(document).on('click','#btn_submit',function(e) {
    e.preventDefault();
    $.ajax({
        url:'./index.php',
        // url:'./index2.php',
        type:'post',
        data : "<?=addslashes(json_encode($arr));?>",
        dataType:'json',
        timeout:10000, 
        beforeSend:function(){},
        success:function(res){
//            var items;
//            for(items in res) { alert(items +': '+ res[items]); }
            if(res.meta.code>200) {
                alert(res.meta.message);
            }
            else {
                alert('데이터 입력 성공, 입력값은 관리자단에서 확인해 주세요.\n(요소검사: 결과값을 확인하세요.)');
            }
            console.log(res);
        },
        error:function(xmlRequest) {
            alert('Status: ' + xmlRequest.status + ' \n\rstatusText: ' + xmlRequest.statusText 
            + ' \n\rresponseText: ' + xmlRequest.responseText);
        }
    });
});
</script>


<?php
include(G5_PATH.'/tail.sub.php');
?>