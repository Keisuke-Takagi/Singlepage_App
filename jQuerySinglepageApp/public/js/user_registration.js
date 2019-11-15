$(function() {

  // 新規登録の処理
  $(".main").on("click","#user_create_button",  function(e) {
    e.preventDefault();
    // 非同期でのURL書き換え（ok）
    


    let email = $('#new-user-form [name=email]').val();
    let password = $('#new-user-form [name=password]').val();
    let token = $('#new-user-form [name=token]').val();


    $.ajax({
      type: 'post',
      datatype: 'json',
      url: 'http://singlepage_app.com/users/signed_in',
      async:false,
      // form情報の送信
      data:{
        'email':email,
        'password':password,
        '_token': token,
      }
    })
 

    .done(function(data ){


      let user_mail = data["email"];
      console.log(user_mail);

      // JSではundefinedの時は変数のif文がfalseになる
      data = $.parseJSON(data);

      
      if(data){
        $(".error_box").empty();
        $(".error_box").prepend(data);
        if(data.page_info){
          console.log(data.page_info);
          // パスの書き換え
          let URL = location.href;
          let URL_changed = URL.replace(URL, "http://singlepage_app.com/users/signed_in");
          history.replaceState(URL, '', URL_changed);
          // viewの書き換え
          $(".main").empty();
          $(".main").prepend(data.page_info);
          $(".header_right").empty();
          $(".header_right").append('<p class="header_logout">ログアウト</p>');
        }
      }else{
        
        $(".error_box").empty();
      }
    })
      
    .fail(function(data){ 
      alert("error!");
      });
      console.log("通信終了");
  });
  

    // ログインの処理
    $(".main").on("click","#user_login_button",  function(e) {
      e.preventDefault();
   
      let count = 0;
      let password = "";
      let email = "";
      let user_list_html = "";
      // フォームからの取得
      email = $('#new-user-form [name=email]').val();
      password = $('#new-user-form [name=password]').val();
      token = $('#new-user-form [name=token]').val();
      console.log(token);
  
  
      $.ajax({
        type: 'post',
        datatype: 'json',
        url: 'http://singlepage_app.com/ajax/users/login',
        async:false,
        // form情報の送信
        data:{
          'email':email,
          'password':password,
          '_token': token,
        }
      })
   
  
      .done(function(data ){
 
      $(".error_box").empty();
  
      let user_mail = data["email"];
  
        // JSではundefinedの時は変数のif文がfalseになる
        data = $.parseJSON(data);

 
        if(data){
          $(".error_box").prepend(data.error);
          if(data.user_info){

            let list_user = data.list_user;
            let list_user_temp = data.list_user
    
            let users_count = data.user_info.email.length;
          // whileを使ってhtmlにユーザー情報を置換
            while(count < users_count){
              email = data.user_info.email[count];
              password = data.user_info.password[count];
              list_user = list_user.replace("<<count>>",(count + 1));
              list_user = list_user.replace("<<user_email>>",email);
              list_user = list_user.replace("<<user_password>>",password);
              user_list_html = user_list_html + list_user;
              list_user = list_user_temp;
              count ++;
            }
            let temp = data.list_temp;
            // templateのviewに置換して表示するHTML作成
      
            let view = temp.replace("<<user_content>>", user_list_html);
            
            // viewの書き換え
            $(".main").empty();
            $(".main").prepend(view);
            $(".header_right").empty();
            $(".header_right").append('<p class="header_logout">ログアウト</p>');  
          }
        }else{
 
          $(".error_box").empty();
        }
      })
        
      .fail(function(data){ 
        alert("error!");
        });
        console.log("通信終了");
    });


  // リストページに行くための処理
  $("body").on("click",".link_user_list_page" ,function(){
    // e.preventDefault();
    let url = location.href;
    if(url == "http://singlepage_app.com/users/signed_in"){
      let token = $(".token").val();
      // getはログインチェックに使うためpost
      $.ajax({
        type: 'post',
        datatype: 'json',
        url: 'http://singlepage_app.com/users/list',
        async:false,
        data:{
          '_token': token,
        }
      })
    .done(function(data,textStatus, jqXHR ){

        data = $.parseJSON(data);
        let count = 0;
        let password = "";
        let email = "";
        let user_list_html = "";
        
        // whileでの書き換え元のhtmlのtemplate取得
        let list_user = data.list_user;
        let list_user_temp = data.list_user

        let users_count = data.user_info.email.length;

        if(data["error"]){
          // postでログイン確認失敗時
          alert("ログインが認められませんでした!");
          
          // ajax通信を使って新規登録にリダイレクト
          $.ajax({
            type: 'post',
            datatype: 'text',
            url: 'http://singlepage_app.com/users/logout',
          })
          .done(function(data){
            console.log(data);
            $(".main").empty();
            $(".main").append(data);
      
            // パスの書き換え
            let URL = location.href;
            let URL_changed = URL.replace(URL, "http://singlepage_app.com/users");
            history.replaceState(URL, '', URL_changed);
    
          })
          .fail(function(data){
            alert("error!");
          });
        }else{
          // whileを使ってhtmlにユーザー情報を置換
          while(count < users_count){
            email = data.user_info.email[count];
            password = data.user_info.password[count];
            list_user = list_user.replace("<<count>>",(count + 1));
            list_user = list_user.replace("<<user_email>>",email);
            list_user = list_user.replace("<<user_password>>",password);
            user_list_html = user_list_html + list_user;
            list_user = list_user_temp;
            count ++;
          }
          let temp = data.list_temp;
          // templateのviewに置換して表示するHTML作成
    
          let view = temp.replace("<<user_content>>", user_list_html);
          
          // viewの書き換え
          $(".main").empty();
          $(".main").prepend(view);
            // パスの書き換え
          let URL = location.href;
          let URL_changed = URL.replace(URL, "http://singlepage_app.com/users/list");
          history.replaceState(URL, '', URL_changed);
        }
      })
      .fail(function(data){
        alert("error!");
      });
    };
  });


  // -------------------------------------------------------------headerのイベント
  $(".header_right").on("click", ".header_logout", function(){

    $.ajax({
      type: 'post',
      datatype: 'text',
      url: 'http://singlepage_app.com/users/logout',
    })
    .done(function(data){
      console.log(data);

      // viewの書き換え
      $(".main").empty();
      $(".main").append(data);
      $(".header_right").empty();
      $(".header_right").append('<a class="header_login">ログイン</a>');

      // パスの書き換え
      let URL = location.href;
      let URL_changed = URL.replace(URL, "http://singlepage_app.com/users");
      history.replaceState(URL, '', URL_changed);

    })
    .fail(function(data){
      alert("error!");
    });
  });

  $(".header_right").on("click", ".header_login", function(){
    $.ajax({
      type: 'get',
      datatype: 'text',
      data: {'page' : 'book_app'},
      url: 'http://singlepage_app.com/ajax/users/login',
    })
    .done(function(data){
      $(".main").empty();
      $(".main").append(data);
      $(".header_right").empty();
      $(".header_right").append('<a class="header_registration">新規登録</a>');

      // パスの書き換え
      let URL = location.href;
      let URL_changed = URL.replace(URL, "http://singlepage_app.com/users/login");
      history.replaceState(URL, '', URL_changed);

    })
    .fail(function(data){
      alert("error!");
    });
  });
  $(".header_right").on("click", ".header_registration", function(){
    $.ajax({
      type: 'get',
      datatype: 'text',
      data: {'page' : 'book_app'},
      url: 'http://singlepage_app.com/ajax/users/registration',
    })
    .done(function(data){
      $(".main").empty();
      $(".main").append(data);
      $(".header_right").empty();
      $(".header_right").append('<a class="header_login">ログイン</a>');

      // パスの書き換え
      let URL = location.href;
      let URL_changed = URL.replace(URL, "http://singlepage_app.com/users");
      history.replaceState(URL, '', URL_changed);

    })
    .fail(function(data){
      alert("error!");
    });
  });
});
