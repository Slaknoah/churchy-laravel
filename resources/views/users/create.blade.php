@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-100">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Add new user</h6>
            <div class="mT-30 clearfix">
                {{ Form::open(array('action' => 'UserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputName">Name</label>
                            {{ Form::text( 'name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputUserAvatar">User avatar</label>
                            {{Form::file('user_avatar', ['class' => 'form-control-file', 'id' => 'inputUserAvatar'])}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="inputEmail">Email</label>
                            {{ Form::text( 'email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required']) }}
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputTempo">Role(s)</label>
                            @php
                                $rolesArr = [];
                                if (count($roles) > 0 ) {
                                    foreach ($roles as $role) {
                                        $rolesArr[$role->id] = $role->name;
                                    }
                                }
                            @endphp
                            {{ Form::select('roles[]', $rolesArr, [6], ['class' => 'form-control', 'size' => '3', 'multiple', 'required']) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Password</label>
                            {{ Form::password( 'password', ['class' => 'form-control', 'placeholder' => 'Password','required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Repeat password</label>
                            {{ Form::password( 'password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repeat password', 'required']) }}
                        </div>
                    </div>

                    <div class="float-right">
                        <div class="form-row">
                            {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                        </div>
                    </div>
                    
                    
                    
                {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
@endsection