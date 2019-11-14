$(function() {
  // 新規登録の処理
  $("#user_create_button").on("click",  function(e) {
    e.preventDefault();
    // 非同期でのURL書き換え（ok）



    let email = $('#new-user-form [name=email]').val();
    let password = $('#new-user-form [name=password]').val();
    let token = $('#new-user-form [name=token]').val();
    console.log(token);


    $.ajax({
      type: 'get',
      datatype: 'json',
      url: 'http://singlepage_app.com/users/signed_in',
      async:false,
      
      data:{
        'email':email,
        'password':password,
        '_token': token,
      }
    })
 

    .done(function(data ){
      debugger
      // data = $.parseJSON(data);
      // console.log(data);

      // console.log(textStatus);
      // console.log(jqXHR);

      let user_mail = data["email"];
      console.log(user_mail);

      // JSではundefinedの時は変数のif文がfalseになる
      data = $.parseJSON(data);
      console.log(data);
      debugger
      if(data){
        $(".error_box").empty();
        $(".error_box").prepend(data);
        if(data.page_info){
          console.log(data.page_info);
          // パスの書き換え
          let URL = location.href;
          let URL_changed = URL.replace("users", "users/signed_in");
          history.replaceState(URL, '', URL_changed);
          // viewの書き換え
          $(".main").empty();
          $(".main").prepend(data.page_info);
          $(".header_right").empty();
          $(".header_right").append('<p class="header_logout">ログアウト</p>');
        }
      }else{
        debugger
        $(".error_box").empty();
      }

    })
      
    .fail(function(data){ 
      alert("error!");
      });
      console.log("通信終了");
  });

  // ここにviewが返してくるtextを受け取るajaxを別に作る
  // $.ajax({
  //   type: 'post',
  //   datatype: 'text',
  //   url: 'http://singlepage_app.com/users',
  //   async:false,
  // });

  // リストページに行くための処理
  $(".main").on("click",".link_user_list_page" ,function(){
    // e.preventDefault();
    let url = location.href;
    if(url == "http://singlepage_app.com/users/signed_in"){
      let token = $(".token").val();
      $.ajax({
        type: 'post',
        datatype: 'json',
        url: 'http://singlepage_app.com/users/signed_in',
        async:false,
        data:{
          '_token': token,
        }
      })
    .done(function(data,textStatus, jqXHR ){
        // alert("sucess");
        // data = $.parseJSON(data);
        alert(location.href);
        console.log(data);
        $(".main").empty();
        $(".main").prepend(data);
      })
      .fail(function(data){
        alert("error!");

      });
    };
  });

  $(".header_right").on("click", ".header_logout", function(){
    $.ajax({
      type: 'post',
      datatype: 'text',
      url: 'http://singlepage_app.com/users/logout',
    })
    .done(function(data){
      console.log(data);
    })
    .fail(function(data){
      alert("error!");
    });
  });

  $(".header_logout").on("click",  function(){
    $.ajax({
      type: 'post',
      datatype: 'text',
      url: 'http://singlepage_app.com/users/logout',
    })
    .done(function(data){
      console.log(data);
    })
    .fail(function(data){
      alert("error!");
    });
    
  });
  // $("#test_json_title").on("click", function(e){
  //   console.log(json_data);
  //   console.log(data);
  //   console.log(email);

  // })
});