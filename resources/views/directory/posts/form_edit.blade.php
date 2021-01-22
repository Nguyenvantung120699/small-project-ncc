<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'User Name' }}</label>
    <input class="form-control" name="name" type="text" id="title" value="{{ isset($user->name) ? $user->name : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="email" id="email" value="{{ isset($user->email) ? $user->email : ''}}">
    {!! $errors->first('body    ', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    <label for="password" class="control-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="password" id="password" autocomplete="new-password" value="{{ isset($user->password) ? $user->password : ''}}">
</div>
@if($user->active_status == 'Unlock')
    <div class="form-group">
        <label for="active_status" class="control-label">{{ 'Active status : ' }}</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active_status" id="inlineRadio1" value="Unlock" checked>
            <label class="form-check-label" for="inlineRadio1">Unlock</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active_status" id="inlineRadio2" value="Locked">
            <label class="form-check-label" for="inlineRadio2">Locked</label>
        </div>
    </div>
@else
    <div class="form-group">
        <label for="active_status" class="control-label">{{ 'Active status : ' }}</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active_status" id="inlineRadio1" value="Unlock">
            <label class="form-check-label" for="inlineRadio1">Unlock</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="active_status" id="inlineRadio2" value="Locked" checked>
            <label class="form-check-label" for="inlineRadio2">Locked</label>
        </div>
    </div>
@endif
@if($user->roles == 'User')
    <div class="form-group">
        <label for="roles" class="control-label">{{ 'Roles' }}</label>
        <select name="roles" class="form-select" aria-label="Default select example">
            <option selected value="User">User</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
@else
    <div class="form-group">
        <label for="roles" class="control-label">{{ 'Roles' }}</label>
        <select name="roles" class="form-select" aria-label="Default select example">
            <option value="User">User</option>
            <option selected value="Admin">Admin</option>
        </select>
    </div>
@endif
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
