<form action="{$url}" method="post" name="login_form" class="form-horizontal">
    <div class="card">
        <h4 class="card-header">
            Zugangsprüfung
        </h4>
        <div class="card-body">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Beantworte uns eine Frage: In welcher Stadt wohnt Familie HKS?</label>
                <div class="col-sm-4">
                    <input tabindex="1" class="form-control" type="text" name="city" id="city" placeholder="Stadt">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input tabindex="4" type="submit" name="login" value="Absenden" class="btn btn-primary btn-raised">
                </div>
            </div>
        </div>
    </div>
</form>