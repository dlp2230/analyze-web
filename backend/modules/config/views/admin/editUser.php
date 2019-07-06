<form role="form" id="modalForm" method="post" class="col-xs-4">
    <div class="form-group">
        <label for="title">原密码:</label>
        <input type="password" class="form-control" name="old_password"
               placeholder="" value=""/>
    </div>
    <div class="form-group">
        <label for="title">新密码:</label>
        <input type="password" class="form-control" name="password"
               placeholder="" value=""/>
    </div>
    <p class="login-box-msg <?php echo isset($error) ? 'text-red' : ''; ?> "><?php echo isset($error) ? $error : ''; ?></p>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">&nbsp;&nbsp;确认修改&nbsp;&nbsp;</button>
    </div>
</form>

