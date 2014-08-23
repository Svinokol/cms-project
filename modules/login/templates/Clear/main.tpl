<link href="{template}/signin.css" rel="stylesheet">


<img class="img-rounded" src="{template}/img/5.png" style="width: 140px;height: 140px;" alt="Generic placeholder image"/>
[visible:on={error}]
<div class="panel panel-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <div class="panel-heading">
        <strong>Предупреждение!</strong>
    </div>
    <div class="panel-body">{error_msg}</div>
</div>
[/visible]
    <form class="form-signin" role="form" action="" method="post">
        <h2 class="form-signin-heading">Форма входа</h2>
        <input type="email" class="form-control" placeholder="Email address" name="email" required>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <label class="checkbox">
            <input type="checkbox" value="remember-me"> запомнить меня
        </label>
        <input class="btn btn-lg btn-primary btn-block" name="login_submit" type="submit"/>
    </form>

