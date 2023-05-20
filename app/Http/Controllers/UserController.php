<?php

namespace App\Http\Controllers;

use Notification;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\WelcomeUserNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Users';
        $companies = Company::where('status', 1)->select('id', 'title')->get();
        $users = User::whereHas('companies')->with('companies')->filter()->search()->paginate(config('app.page_limit'));
        return view('user.index', compact('users', 'title', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Users';
        $companies = Company::where('status', 1)->select('id', 'title')->get();
        return view('user.add_or_edit', compact('title', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attribute = $this->validation();
        try {
            DB::beginTransaction();
            $user = User::create($attribute);
            $user->companies()->sync($attribute['company']);
            Notification::send($user, new WelcomeUserNotification($user, $attribute['password']));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('general.went_wrong'));
        }
        DB::commit();
        return redirect()->route('companies.index')->withSuccess(__('general.company.create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->back()->with('error', 'Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (empty($user)) {
            return redirect()->back()->with('error', 'Not Found');
        }
        $title = 'user';
        $user->load('companies');
        $companies = Company::where('status', 1)->select('id', 'title')->get();
        return view('user.add_or_edit', compact('title', 'user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $attribute = $this->validation($user->id ?? null);
        try {
            DB::beginTransaction();
            $user->update($attribute);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('general.went_wrong'));
        }
        DB::commit();
        return redirect()->route('companies.index')->withSuccess(__('general.company.edit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('general.went_wrong'));
        }
        DB::commit();
        return redirect()->route('companies.index')->withSuccess(__('general.company.delete'));
    }

    public function validation(string $id = null): array
    {

        $attribute = request()->validate(
            [
                "name" => 'required|min:3|max:255',
                "email" => 'required|string|email|max:255|unique:companies,email,' . $id,
                "password" => $id ? 'nullable|min:8|max:32' : 'required|min:8|max:32',
                "company" => "required"
            ]
        );
        return $attribute;
    }
}
