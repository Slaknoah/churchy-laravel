@extends('layouts.app')


@section('content')
<div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-12"></div>
        <div class="masonry-item col-md-12 p-100">
            @if ($user)
                <div class="bgc-white p-20 bd">
                    <h5 class="c-grey-900">{{$user->name}}</h5>
                    <div class="mT-30 clearfix">
                        {{ Form::open(array('action' => ['UserController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}                            
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="inputName">Name</label>
                                    {{ Form::text( 'name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) }}
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="inputUserAvatar">User avatar</label>
                                    {{Form::file('user_avatar', ['class' => 'form-control-file', 'id' => 'inputUserAvatar'])}}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="inputEmail">Email</label>
                                    {{ Form::text( 'email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email', 'required']) }}
                                </div>
                                    <div class="form-group col-md-5">
                                        <label for="inputTempo">Role(s)</label>
                                        @php
                                            $rolesArr = [];
                                            $userRolesArr = [];
                                            if (count($roles) > 0 ) {
                                                foreach ($roles as $role) {
                                                    $rolesArr[$role->id] = $role->name;
                                                }
                                            }

                                            if (count($user_roles) > 0 ) {
                                                foreach ($user_roles as $user_role) {
                                                    $userRolesArr[] = $user_role->id;
                                                }
                                            }
                                        @endphp
                                        @can('updateUserRole', \App\User::class)
                                            {{ Form::select('roles[]', $rolesArr, $userRolesArr, ['class' => 'form-control', 'size' => '3', 'multiple', 'required']) }}
                                        @else
                                            <ul>
                                                @foreach ($user_roles as $user_role)
                                                    <li>{{$user_role->name}}</li>
                                                @endforeach
                                            </ul>
                                        @endcan
                                    </div>
                            </div>
        
                            <div class="float-right clearfix">
                                <div class="form-row">
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                                </div>
                            </div>
                        {{Form::close()}}
                        <br>

                        @can('changePassword', $user)
                            <div id="change-password">
                                <h6 class="c-grey-800">Change password</h6>
                                <hr>
                                {{ Form::open(array('route' => ['change_password', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data')) }}
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword">Current password</label>
                                            {{ Form::password( 'current_password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword">New Password</label>
                                            {{ Form::password( 'new_password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword">Repeat password</label>
                                            {{ Form::password( 'new_password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repeat password']) }}
                                        </div>
                                    </div>
                                    <div class="float-right clearfix">
                                        <div class="form-row">
                                            {{Form::submit('Update password', ['class' => 'btn btn-primary'])}}
                                        </div>
                                    </div>
    
                                {{ Form::close() }}
                            </div>
                        @endcan
                    </div>
                </div>
            @endif
        </div>
      </div>
@endsection