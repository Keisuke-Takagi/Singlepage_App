$(function() {
  // $("#user_create_button").on("click",  function(e) {
  //   e.preventDefault();
  //   // 非同期でのURL書き換え（ok）
  //   let URL = location.href;
  //   let URL_changed = URL.replace("users", "books/index");
  //   history.replaceState(URL, '', URL_changed)


  //   let email = $('#new-user-form [name=email]').val();
  //   let password = $('#new-user-form [name=password]').val();
  //   console.log(email);



  //   $.ajax({
  //     type: 'post',
  //     datatype: 'json',
  //     url: 'http://singlepage_app.com/users',

  //     data:{
  //       'email':email,
  //       'password':password,
  //       '_token': '4sa08EJTkmZaoe9F4fWFtvVtVrw7Hxxm0BnaDhxP'
  //     }
  //   })

  //   .done(function(data,textStatus, jqXHR ){


  //     console.log(data);
  //     console.log(textStatus);
  //     console.log(jqXHR);

  //     let user_mail = data["email"];
  //     console.log(user_mail);
  //     debugger
  //     alert("sucess");
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

  // });




  // $("#test_json_title").on("click", function(e){
  //   console.log(json_data);
  //   console.log(data);
  //   console.log(email);

  // })
});