$(function() {
  // $("#user_create_button").on("click",  function(e) {
  //   e.preventDefault();
  //   // 非同期でのURL書き換え（ok）



  //   let email = $('#new-user-form [name=email]').val();
  //   let password = $('#new-user-form [name=password]').val();
  //   let token = $('#new-user-form [name=token]').val();
  //   console.log(token);



  //   $.ajax({
  //     type: 'post',
  //     datatype: 'json',
  //     url: 'http://singlepage_app.com/users',
  //     async:false,
  //     data:{
  //       'email':email,
  //       'password':password,
  //       '_token': token,
  //     }
  //   })

  //   .done(function(data,textStatus, jqXHR ){
  //     // data = $.parseJSON(data);

  //     // console.log(data);
  //     // console.log(textStatus);
  //     // console.log(jqXHR);

  //     let user_mail = data["email"];
  //     console.log(user_mail);

  //     // JSではundefinedの時は変数のif文がfalseになる
  //     data = $.parseJSON(data);
  //     console.log(data);
  //     if(data){
  //       $(".error_box").empty();
  //       $(".error_box").prepend(data);
  //       if(data.page_info){
  //         console.log(data.page_info);
  //         // パスの書き換え
  //         let URL = location.href;
  //         let URL_changed = URL.replace("users", "users/signed_in");
  //         history.replaceState(URL, '', URL_changed);
  //         // viewの書き換え
  //         $(".main").empty();
  //         $(".main").prepend(data.page_info);
  //         $(".header_right").empty();
  //         $(".header_right").append('<p class="header_logout">ログアウト</p>');
  //       }
  //     }else{
  //       $(".error_box").empty();
  //     }
  //     // var path = location.pathname;

  //     // let path = "C:/xampp/htdocs/jqueryapp/jQuerySinglepageApp/resources/views/books/index/mainpage.blade.php";

  //     // $(".json_main").load(path, function(data, status) {
  //     //   if(status === 'success') {
  //     //     alert('読み込みが正常に行われました');
  //     //     debugger
  //     //   }else{
  //     //     alert(path);
  //     //   }
  //     // })
  //     // ここでLaravelのコントローラアクションを非同期呼び出し

  //     // $("#new-user-form").submit();

  //     // let mainpage = "<p>This is mainpage </p>"

  //     // $(".json_text").html(data);

  //     // alert("success");

  //     // if(location.href = "http://singlepage_app.com/books/index"){
  //       // 次ページへ遷移したときの処理
        
  //       // $(".json_main").empty();
  //       // $("json_main").html(mainpage);
  //     // }

  //   })
      
  //   .fail(function(data){ //ajaxの通信に失敗した場合
  //     alert("error!");
  //     });
  //     console.log("通信終了");

  // });

  // $(".main").on("click",".link_user_index" ,function(){
  //   // e.preventDefault();
  //   if(location.href == "http://singlepage_app.com/users/signed_in"){
  //     let token = $(".token").val();
  //     let aaaa;
  //     $.ajax({
  //       type: 'post',
  //       datatype: 'json',
  //       url: 'http://singlepage_app.com/users/signed_in',
  //       async:false,
  //       data:{
  //         '_token': token,
  //         'aaaa': aaaa
  //       }
  //     })
  //   .done(function(data,textStatus, jqXHR ){
  //       alert("sucess");
  //       data = $.parseJSON(data);
  //       console.log(data);
  //     })
  //     .fail(function(data){
  //       alert("error!");

  //     });
  //   };

  // });

  // $("#test_json_title").on("click", function(e){
  //   console.log(json_data);
  //   console.log(data);
  //   console.log(email);

  // })
});