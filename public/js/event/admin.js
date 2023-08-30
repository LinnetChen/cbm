<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
function delete_div(id){
    var result = window.confirm('確認刪除?');
    if (result) {
        $.post('api/del_serial',function(){

        },function(res){

        })
      }
    }
