$(function() {

  // リストページのhtmlを置き換える処理
  function Replace_user_info(data, users_count, list_user, base_temp){
    let count = 0;
    let list_user_temp = list_user;
    let user_list_html = "";
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
    return base_temp.replace("<<user_content>>", user_list_html);

  }
  
  // ここでajax通信を呼び出す処理
  function ajax(type, datatype, url, data){
    let ajax = $.ajax({ type: type, datatype: datatype, url: url, data: data, })
    return ajax;
  }

  // template書き換え
  function replace_template(data){
    $(".main").empty();
    $(".main").prepend(data);
  }

  function replace_error(data){
    $(".error_box").empty();
    $(".error_box").prepend(data);
  }

  function replace_url(next_page_url){
    let URL = location.href;
    let URL_changed = URL.replace(URL, next_page_url);
    history.replaceState(URL, '', URL_changed);
  }

  // 新規登録の処理
  $(".main").on("click","#user_create_button",  function(e) {
    e.preventDefault();

    let email = $('#new-user-form [name=email]').val();
    let password = $('#new-user-form [name=password]').val();
    let token = $('#new-user-form [name=token]').val();

    // ajax情報の定義
    type = 'post'
    datatype = 'json'
    url = 'http://singlepage_app.com/users/signed_in'
    data =  {
              'email':email,
              'password':password,
              '_token': token,
            }

    ajax(type, datatype, url, data)

    .done(function(data){

      data = $.parseJSON(data);
      
      if(data.error){
        // Laravelのエラーを表示
        replace_error(data.error);
      }
      if(data.page_info){
        // パスの書き換え
        replace_url(url);

        // viewの書き換え
        let view_data = data.page_info;
        replace_template(view_data);
        $(".header_right").empty();
        $(".header_right").append('<p class="header_logout">ログアウト</p>');
      }
    })
      
    .fail(function(data){ 
      alert("error!");
      });
  });

    // ログインの処理
    $(".main").on("click","#user_login_button",  function(e) {
      e.preventDefault();

      // フォームからの取得
      let email = $('#new-user-form [name=email]').val();
      let password = $('#new-user-form [name=password]').val();
      let token = $('#new-user-form [name=token]').val();

  
  

      type = 'post'
      datatype = 'json'
      url = 'http://singlepage_app.com/ajax/users/login'
      data =  {
                'email':email,
                'password':password,
                '_token': token,
              }
      ajax(type, datatype, url, data)
  
      .done(function(data){
  
  
        // JSではundefinedの時は変数のif文がfalseになる
        data = $.parseJSON(data);

        if(data.error){

          replace_error(data.error);
        }
        // LaravelからUser配列が返されているかの確認(入力値が正しい場合は存在)
        if(data.user_info){

          // templateを置換するview, 置換する回数取得
          let list_user = data.list_user;
          let base_temp = data.list_temp;
          let users_count = data.user_info.email.length;

          // templateをuser情報から置換したものを変数viewに代入
          let view = Replace_user_info(data, users_count, list_user, base_temp)

          // viewの書き換え
          replace_template(view);
          $(".header_right").empty();
          $(".header_right").append('<p class="header_logout">ログアウト</p>'); 

          // パスの書き換え
          replace_url(url);
        }
      })
        
      .fail(function(data){ 
        alert("error!");
        });
    });


  // リストページに行くための処理
  $("body").on("click",".link_user_list_page" ,function(){
    // e.preventDefault();
    let url = location.href;
    if(url == "http://singlepage_app.com/users/signed_in"){
      let token = $(".token").val();
      // getはログインチェックに使うためpost
      type = 'post'
      datatype = 'json'
      url = 'http://singlepage_app.com/users/list'
      data =  { '_token': token, }
      ajax(type, datatype, url, data)
      
      .done(function(data,textStatus, jqXHR ){

        data = $.parseJSON(data);
        let count = 0;
        let password = "";
        let email = "";
        // let user_list_html = "";
        
        // whileでの書き換え元のhtmlのtemplate取得
        let list_user = data.list_user;
        let base_temp = data.list_temp;

        let users_count = data.user_info.email.length;

        if(data["error"]){
          // postでログイン確認失敗時
          alert("ログインが認められませんでした!");
          let type = 'post';
          let datatype = 'text';
          
          // ajax通信を使って新規登録にリダイレクト
          ajax(type, datatype, url, data)

          .done(function(data){
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
          // templateをuser情報から置換したものを変数viewに代入
          let view = Replace_user_info(data, users_count, list_user, base_temp)

          // viewの書き換え
          replace_template(view);

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
    type = 'post'
    datatype = 'text'
    url = 'http://singlepage_app.com/users/logout'
    data =  {'_token': '',}
    ajax(type, datatype, url, data)

    .done(function(data){;
      // viewの書き換え
      replace_template(data);
      $(".header_right").empty();
      $(".header_right").append('<a class="header_login">ログイン</a>');

      // パスの書き換え
      replace_url(url);
    })
    .fail(function(data){
      alert("error!");
    });
  });

  $(".header_right").on("click", ".header_login", function(){
    type = 'get'
    datatype = 'text'
    url = 'http://singlepage_app.com/ajax/users/login'
    data =  {'page' : 'book_app'}
    ajax(type, datatype, url, data)

    .done(function(data){

      // viewの書き換え
      replace_template(data);
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
    type = 'get'
    datatype = 'text'
    url = 'http://singlepage_app.com/ajax/users/registration'
    data = {'page' : 'book_app'}
    ajax(type, datatype, url, data)

    .done(function(data){

      // viewの書き換え
      replace_template(data);
      $(".header_right").empty();
      $(".header_right").append('<a class="header_login">ログイン</a>');

      // パスの書き換え
      replace_url(url);
    })
    .fail(function(data){
      alert("error!");
    });
  });
});
