$(document).ready(function () {
    url = '/comment/';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#comment input[name="_token"]').val()
        }
    });
    $('#add').click(function () {
        alert('add');
        $('#task-title').text('添加评论');
        $('#tsave').val('add');
        $('#taskModal').modal('show');
    });
    $('body').on('click', 'button.delete', function() {
        var tid = $(this).val();
        $.ajax({
            type: 'DELETE',
            url: url+tid,
            success: function (data) {
                console.log(data);
                $('#comment'+tid).remove();
                alert('删除成功！');
            },
            error: function (data, json, errorThrown) {
                console.log(data);
                var errors = data.responseJSON;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                alert( errorsHtml , "Error " + data.status +': '+ errorThrown);
            }
        });
    });
    $('body').on('click', 'button.edit', function() {
        $('#comment-title').text('编辑评论');
        $('#tsave').val('update');
        var tid = $(this).val();
        $('#tid').val(tid);
        $.get(url+tid, function (data) {
            console.log(url+tid);
            console.log(data);
            $('#comment_content').val(data.comment_content);
        });
    });
    $('#tsave').click(function () {
        if($('#tsave').val() == 'add') {
            turl = url ;
            var type = "POST"; // add
        }
        else {
            turl = url + $('#tid').val();
            var type = "PUT"; // edit
        }
        var data = {
            comment_content: $('#comment_content').val(),
            article_id:$('#article_id').val()
        };
        $.ajax({
            type: type,
            url: turl,
            data: data,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#comment').trigger('reset');
                var cur_data_comment_content;
                var created_at;
                var comment_id;
                cur_data_comment_content = data[0].comment_content;
                created_at = data[0].created_at;
                comment_id = data[0].id;

                var comment = '<div class="row" style="border-bottom:1px solid #f5f5f5;">' +
                    '<div class="col-md-2" style="text-align: right;padding: 20px">'+
                    '<img src="/upload/userimgs/'+data.user_icon+'" style="width:100px;height: 100px;float: left;border-radius: 50%;margin-right: 5px;padding: 10px"/>'+
                    '</br>'+ data.username +
                    '</div>'+
                    '<div class="col-md-10"style="border-left:5px solid #f5f5f5;padding:20px">'+
                    '<div class="row" style="border-bottom:2px solid #f5f5f5; padding-bottom: 10px">'+
                    cur_data_comment_content +
                    '</div>' +
                    '<div class="row"  style="margin-top: 10px">' +
                    '<div class="col-md-4">'+ created_at +'</div>' +
                    '<div class="col-md-2">&nbsp;</div>' +
                    '<div class="col-md-6">'+
                    '<button  class="btn btn-info edit" value="'+ comment_id+'" style="margin-right: 15px">Update</button>' +
                    '<button class="btn btn-warning delete" value="'+ comment_id+'">Delete</button>' +
                    '</div></div></div></div>';
                console.log(comment);
                if(type == 'POST') {
                    $('#comment-list').append(comment);
                    alert('添加成功！');
                }
                else { // edit
                    $('#comment'+data[0].id).replaceWith(comment);
                    alert('编辑成功！');
                }
            },
            error: function (data, json, errorThrown) {
                console.log(data);
                var errors = data.responseJSON;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                alert( errorsHtml , "Error " + data.status +': '+ errorThrown);
            }
        });
    });
});

function isArray(arr){
    return typeof arr == "object" && arr.constructor == Array;
}