<script>
    $(document).ready(function () {
        $("#user_id").click(function() {
            var user_id =$(this).attr("data-id")
            $.ajax({
                url: '{{url("/admin/users/messages")}}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    users_id: user_id,
                },
                success :function(response ) {
                    var html = ''
                    $.each(response , function(i, $messages) {
                        if($messages.length > 0) {
                            $.each($messages, function (i, item) {
                                if (item != null) {
                                    $.each(response.users,function (j, $item_users) {
                                            if(item.to_id == $item_users.id ){
                                                html += '<li class="list-group-item">' +
                                                    'Người nhận : <b>' + $item_users.name + '</b>' +
                                                    '<p>Nội dung : ' + item.body + '</p>' +
                                                    '<p>Thời gian : ' + item.created_at + '</p>' +
                                                    '</li>'
                                            }
                                        });
                                } else {
                                    html += '<li class="list-group-item">no data</li>'
                                }
                            });
                        }else{
                            html += '<li class="list-group-item">no data</li>'
                        }
                    });
                    $("#view_messages").html(html);
                },
            });
        });


        $("#user_id_to").click(function() {
            var user_to_id =$(this).attr("data-cid")
            $.ajax({
                url: '{{url("/admin/users/messagesto")}}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_to_id: user_to_id,
                },
                success :function(response ) {
                    var html = ''
                    $.each(response , function(i, message) {
                        if(message.length > 0){
                            $.each(message , function(i, item) {
                                if (item != null) {
                                    $.each(response.users,function (j, $item_users) {
                                        console.log($item_users)
                                        if(item.from_id == $item_users.id ){
                                            html += '<li class="list-group-item">' +
                                                'Người gửi : <b>' + $item_users.name + '</b>' +
                                                '<p>Nội dung : ' + item.body + '</p>' +
                                                '<p>Thời gian : ' + item.created_at + '</p>' +
                                                '</li>'
                                        }
                                    });
                                } else {
                                    html += '<li class="list-group-item">no data</li>'
                                }
                            });
                        }else{
                            html+='<li class="list-group-item">No data</li>'
                        }
                    });
                    $("#view_messagesto").html(html);
                },
            });
        });
    });

</script>

