<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list', User::class);

        $users = User::all();

        // Api request
        if (\isApiRequest($request)) {
            return UserResource::collection(User::offsetPaginate());
        }

        return view('users.index')->with(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all('id', 'name');
        return view('users.create')->with(['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $this->authorize('create', User::class);

        // Validating the cover image gotten
        if ($request->hasFile('user_avatar')) {
            $user_avatar_file_name = save_file($request->file('user_avatar'), 'user_avatars');
        } else {
            $user_avatar_file_name = false;
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->user_avatar = $user_avatar_file_name;
        $user->save();

        // Set user roles
        $input_roles = $request->input('roles');
        if (!is_array($input_roles)) {
            $user->roles()->attach(Role::where('id', $input_roles)->first());
        } else {
            foreach ($input_roles as $role_id) {
                $user->roles()->attach(Role::where('id', $role_id)->first());
            }
        }

        // Saving user metas in case sent in request
        $metas = \get_req_metas($request, 'meta');
        \save_metas($user, $metas);

        // Api request
        if (\isApiRequest($request)) {
            return new UserResource($user);
        }

        return \redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        if (\isApiRequest($request)) {
            return new UserResource($user);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all('id', 'name');
        $user_roles = $user->roles()->get();

        return view('users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'user_roles' => $user_roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUser $request, User $user)
    {
        $this->authorize('update', $user);

        // Saving the cover image gotten
        if ($request->hasFile('user_avatar')) {
            // Delete old user avatar
            if ($user->user_avatar) {
                Storage::delete('public/user_avatars/' . $user->user_avatar);
            }

            // Save new image to storage
            $user_avatar_file_name = save_file($request->file('user_avatar'), 'user_avatars');

            // Update user field
            $user->user_avatar = $user_avatar_file_name;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        if (auth()->user()->can('updateUserRole', User::class)) {
            // Unset all previous roles
            foreach ($user->roles()->get() as $role) {
                $user->roles()->detach($role);
            }
            // Set new roles
            $input_roles = $request->input('roles');
            if (!is_array($input_roles)) {
                $user->roles()->attach(Role::where('id', $input_roles)->first());
            } else {
                foreach ($input_roles as $role_id) {
                    $user->roles()->attach(Role::where('id', $role_id)->first());
                }
            }
        }

        // Saving user metas in case sent in request
        $metas = \get_req_metas($request, 'meta');
        \save_metas($user, $metas);

        if (\isApiRequest($request)) {
            return new UserResource($user);
        }

        return back()->with(['success' => 'User settings saved']);
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request, User $user)
    {
        $this->authorize('changePassword', $user);

        $request->validate([
            'new_password' => 'required|confirmed|min:8',
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
        ]);

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        if (\isApiRequest($request)) {
            return \json_encode(['message' => "User $user->name's password changed successfully!"]);
        }

        return back()->with(['success' => 'Password changed successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        #### Make sure user doesnt have any post before deleting
        // Delete user avatar
        if ($user->user_avatar) {
            Storage::delete('public/user_avatars/' . $user->user_avatar);
        }

        \delete_metas($user);

        $user->delete();

        if (\isApiRequest($request)) {
            return \json_encode(['message' => 'User deleted!']);
        }

        return redirect('/dashboard')->with(['success' => 'User deleted!']);
    }

    // Return users by role
    public function roleUsers(Request $request, Role $role)
    {
        // Api request
        if (\isApiRequest($request)) {
            return UserResource::collection($role->users()->get());
        }
    }

    public function messageAuthors(Request $request)
    {
        // Api request
        if (\isApiRequest($request)) {
            $userQuery = (new User)->newQuery();

            // Returning only authors of messages
            $authors = $userQuery->has('authorMessages');

            return UserResource::collection($authors->get());
        }
    }

    public function articleAuthors(Request $request)
    {
        // Api request
        if (\isApiRequest($request)) {
            $userQuery = (new User)->newQuery();

            // Returning only authors of published articles
            $authors = $userQuery->whereHas('articles', function (Builder $query) {
                $query->where('published', 1);
            });

            return UserResource::collection($authors->get());
        }
    }
}