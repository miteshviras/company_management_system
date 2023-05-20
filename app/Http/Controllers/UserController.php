<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Users';
        $companies = Company::where('status',1)->select('id','title')->get();
        $users = User::whereHas('companies')->filter()->search()->paginate(config('app.page_limit'));
        return view('user.index', compact('users', 'title','companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Users';
        return view('user.add_or_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attribute = $this->validation();
        try {
            DB::beginTransaction();
            $company = User::create($attribute);
            Notification::send($company, new WelcomeCompanyNotification($company, $attribute['password']));
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
    public function show(Company $company)
    {
        return redirect()->back()->with('error', 'Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        if (empty($company)) {
            return redirect()->back()->with('error', 'Not Found');
        }

        $title = 'Companies';
        return view('company.add_or_edit', compact('title', 'company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $attribute = $this->validation($company->id ?? null);
        try {
            DB::beginTransaction();
            $company->update($attribute);
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
    public function destroy(Company $company)
    {
        //
    }

    public function validation(string $id = null): array
    {

        $attribute = request()->validate(
            [
                "title" => 'required|min:3|max:255',
                "email" => 'required|string|email|max:255|unique:companies,email,' . $id,
                "password" => $id ? 'nullable|min:8|max:32' : 'required|min:8|max:32',
                "status" => "required|in:1,0"
            ]
        );
        return $attribute;
    }
}
