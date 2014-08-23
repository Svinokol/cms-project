<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
         <link rel="stylesheet" href="./templates/Clear/main.css" type="text/css" media="all" />
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
         <link href="./templates/Clear/bootstrap/css/bootstrap.css" rel="stylesheet">
         <link href="./templates/Clear/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
         <script src="./templates/Clear/bootstrap/js/bootstrap.js"></script>
        <title>Установка</title>
        <script type="text/javascript">


            $(function () {
                $('#content').hide().delay(300).fadeIn(1000);
                $('#options').hide();
                $('#hello').fadeIn(300).delay(2000).fadeOut(1000, function () {
                    $('#options').fadeIn(1000);
                });
                $('#registration').hide();

                $('#options_submit').click(function () {
                    $("#options").submit(function (e) {
                        var postData = $(this).serializeArray();
                        var formURL = $(this).attr("action");
                        $.ajax(
                        {
                            url: formURL,
                            type: "POST",
                            data: postData,
                            success: function (data, textStatus, jqXHR) {
                                $('#options').fadeOut(1000, function () {
                                    $('#registration').fadeIn(1000);
                                });
                                setTimeout(function () {
                                    ajaxPost("1");
                                }, 1000);
                                setTimeout(function () {
                                    ajaxPost("2");
                                }, 4000);

                                setNotification(data);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                setNotification("Произошла ошибка!");
                            }
                        });
                        e.preventDefault(); //STOP default action
                    });

                    $("#options").submit(); //SUBMIT FORM
                });

                $('#registration_submit').click(function () {
                    function getDoc(frame) {
                        var doc = null;

                        // IE8 cascading access check
                        try {
                            if (frame.contentWindow) {
                                doc = frame.contentWindow.document;
                            }
                        } catch (err) {
                        }

                        if (doc) { // successful getting content
                            return doc;
                        }

                        try { // simply checking may throw in ie8 under ssl or mismatched protocol
                            doc = frame.contentDocument ? frame.contentDocument : frame.document;
                        } catch (err) {
                            // last attempt
                            doc = frame.document;
                        }
                        return doc;
                    }

                    $("#registration").submit(function (e) {
                        var formObj = $(this);
                        var formURL = formObj.attr("action");

                        if (window.FormData !== undefined)  // for HTML5 browsers
                        {

                            var formData = new FormData(this);
                            $.ajax({
                                url: formURL,
                                type: "POST",
                                data: formData,
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (data, textStatus, jqXHR) {
                                    setNotification(data);
                                    $("#registration").fadeOut(1000);
                                    $.post(
                                      "install.php",
                                      {
                                          command: "4"

                                      },
                                      function (data) {
                                          $('#content').removeAttr( 'style' );
                                          
                                          $('#hello').html(data).fadeIn(1000);
                                      }
                                    );
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    setNotification("ERROR");
                                }
                            });
                            e.preventDefault();
                        }
                        else  //for olden browsers
                        {
                            //generate a random id
                            var iframeId = "unique" + (new Date().getTime());

                            //create an empty iframe
                            var iframe = $('<iframe src="javascript:false;" name="' + iframeId + '" />');

                            //hide it
                            iframe.hide();

                            //set form target to iframe
                            formObj.attr("target", iframeId);

                            //Add iframe to body
                            iframe.appendTo("body");
                            iframe.load(function (e) {
                                var doc = getDoc(iframe[0]);
                                var docRoot = doc.body ? doc.body : doc.documentElement;
                                var data = docRoot.innerHTML;
                                //data return from server.

                            });

                        }

                    });
                    $("#registration").submit();
                });




                //cancelLoad();               

            });
            function sleep(ms) {
                ms += new Date().getTime();
                while (new Date() < ms) { }
            }
            function ajaxPost(param) {
                showLoad();
                $.post(
                      "install.php",
                      {
                          command: param

                      },
                      onAjaxSuccess
                    );
            }

            function onAjaxSuccess(data) {
                setNotification(data);
                cancelLoad();
            }

            function createCircle(color) {
                var element = document.createElement("div");
                element.setAttribute("id", "circle");
                $(element).css('background', color);
                return element;
            }

            var is_loaded = false;

            function cancelLoad() {
                is_loaded = false;

            }

            function showLoad() {
                if (is_loaded) return;
                is_loaded = true;
                var element = document.createElement("div");
                element.setAttribute("id", "loadbar");
                $('body').prepend(element);


                $("#loadbar").append(createCircle("red"));
                $("#loadbar").append(createCircle("green"));
                $("#loadbar").append(createCircle("yellow"));
                $("#loadbar").append(createCircle("blue"));

                var iwidth = $('#loadbar').innerWidth();
                var w = iwidth / 2 - 20;

                var circles = $("#loadbar > div").hide(), i = 0;
                var n = circles.length;

                (function loop() {
                    circles.eq(i++).fadeIn(100).animate(
                        {

                            left: '+=' + w + 'px',

                            color: 'red'

                        },

                        {

                            duration: 1000,

                            easing: 'swing',

                            complete: loop,

                            queue: true

                        }

                    ).animate(
                        {

                            left: '+=' + w + 'px',

                            color: 'green'

                        },

                        {

                            duration: 1000,

                            easing: 'swing',



                            queue: true

                        }
                    ).fadeOut(100)
                    .animate(
                        {

                            left: '0px',

                            color: 'green'

                        },

                        {

                            duration: 0,

                            easing: 'swing',

                            complete: (function () {
                                if ((i == 4) && (is_loaded)) {
                                    i = 0;
                                    loop;
                                }
                                if (!is_loaded) {
                                    $('#loadbar').remove();
                                }
                            })(),


                            queue: true

                        });


                })();


            }

            
            function setNotification(text) {
                var html = "<p>" + text + "</p>";
                var element = document.createElement("div");
                element.setAttribute("id", "notification");
                element.innerHTML = html;
                $('body').append(element);
                $(element).hide();
                $(element).fadeIn(1000).delay(1000).fadeOut(1000);
            }
        </script>
    </head>
   
    <body onclick="">
       <div id="content">
           <center>
           <div id="hello">
               <h1>Привет!</h1>
           </div>
           <form name="ajaxform" id="options" enctype="multipart/form-data" action="" method="POST">
               <input type="hidden" name="command" value ="0"/>               
               <table class="table table-bordered">
                   <caption><h1>Параметры сервера</h1></caption>
                   <tbody>
                   <tr>
                       <td>
                           Название сайта:
                       </td>
                       <td>
                           <input type="text" name="name" class="input-large" placeholder=".input-large" value ="Магазин"/>
                       </td>
                   </tr>
                  
                   <tr>
                       <td>
                           Email:
                       </td>
                       <td>
                           <input type="text" name="email" class="input-large" placeholder=".input-large" value ="mr.Brazz@gmail.com"/>
                       </td>
                   </tr>
                   
                   <tr>
                       <td>
                           Mysql сервер:
                       </td>
                       <td>
                           <input type="text" name="mysql_server" class="input-large" placeholder=".input-large" value ="localhost"/>
                       </td>
                   </tr>
                   
                   <tr>
                       <td>
                           Название БД:
                       </td>
                       <td>
                           <input type="text" name="mysql_db_name" class="input-large" placeholder=".input-large" value ="magaz_db"/>
                       </td>
                   </tr>
                  
                   <tr>
                       <td>
                           Имя пользователя БД:
                       </td>
                       <td>
                           <input type="text" name="mysql_user" class="input-large" placeholder=".input-large" value ="root"/>
                       </td>
                   </tr>
                  
                   <tr>
                       <td>
                           Пароль пользователя БД:
                       </td>
                       <td>
                           <input type="text" name="mysql_password" class="input-large" placeholder=".input-large" value ="112233"/>
                       </td>
                   </tr>
                  
                   <tr>
                       <td>
                           Отправить:
                       </td>
                       <td>
                           <button class="btn btn-success" id="options_submit">Отправить</button>
                       </td>
                   </tr>
                   </tbody>
               </table>
           </form>
           <form name="ajaxform" id="registration" enctype="multipart/form-data" action="" method="POST">
               <input type="hidden" name="command" value ="3"/>
               <h1>Давай те познакомимся?</h1>
               <table class="table table-bordered">
                   <tr>
                       <td>
                           Имя:
                       </td>
                       <td>
                           <input type="text" name="fname" value =""/>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Фамилия:
                       </td>
                       <td>
                           <input type="text" name="lname" value =""/>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Email:
                       </td>
                       <td>
                           <input type="email" name="email" value =""/>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Пароль:
                       </td>
                       <td>
                           <input type="password" name="password" value =""/>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Фотография:
                       </td>
                       <td>
                           <input type="file" name="avatar" id="avatar" value =""/>
                       </td>
                   </tr>
                   <tr>
                       <td>
                           Отправить:
                       </td>
                       <td>
                           <input type="button" class="btn btn-success" value="Отправить" id="registration_submit"/>
                       </td>
                   </tr>
               </table>
           </form>
               
           </center>
       </div>

    </body>
</html>
