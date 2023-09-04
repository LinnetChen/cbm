function delete_div(id){
    var result = window.confirm('確認刪除?');
    if (result) {
        $.post('/api/del_serial',{
            page_id:id,
        },function(res){
            location.reload()
        })
      }
    }

