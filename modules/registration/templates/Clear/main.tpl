<form role="form" enctype="multipart/form-data" action="" class="form-horizontal" method="POST">
    <h1>Регистрация нового пользователя</h1>
    [visible:on={error}]
    <div class="panel panel-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div class="panel-heading">
            <strong>Предупреждение!</strong>
        </div>
        <div class="panel-body">{error_msg}</div>
    </div>
    [/visible]
    <table class="table table-bordered">
        <tr>
            <td>
                Имя:
            </td>
            <td>
                <input type="text" name="fname" class="form-control" value ="" required>
            </td>
        </tr>
        <tr>
            <td>
                Фамилия:
            </td>
            <td>
                <input type="text" name="lname" class="form-control" value ="" required>
            </td>
        </tr>
        <tr>
            <td>
                Email:
            </td>
            <td>
                <input type="email" name="email" class="form-control" value ="" required>
            </td>
        </tr>
        <tr>
            <td>
                Пароль:
            </td>
            <td>
                <input type="password" name="password" class="form-control" value ="" required>
            </td>
        </tr>
        <tr>
            <td>
                Фотография:
            </td>
            <td>
                <input type="file" name="avatar" class="form-control" value ="" required>
            </td>
        </tr>
        <tr>
            <td>
                Отправить:
            </td>
            <td>
                <input type="submit" class="btn btn-success" value="Отправить" name="registration_submit" required>
            </td>
        </tr>
    </table>
</form>