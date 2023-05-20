@extends('layout.master')
@section('content')
    <div class="flex items-center justify-center p-12 w-full">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="{{ empty($user) ? route('users.store') : route('users.update', [$user->id]) }}"
                id="is_validate_form" method="POST">
                @csrf
                @if (!empty($user))
                    @method('PUT')
                @endif
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                name
                            </label>
                            <input type="text" name="name" id="name" placeholder="name"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                data-rule-required="true" value="{{ old('name', $user->name ?? '') }}">

                            @error('name')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                email
                            </label>
                            <input type="email" name="email" id="email" placeholder=" email" data-rule-email="true"
                                data-rule-required="true"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                value="{{ old('email', $user->email ?? '') }}">

                            @error('email')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if (empty($user->password))
                        <div class="w-full px-3">
                            <div class="mb-5">
                                <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                    Password
                                </label>
                                <input type="password" name="password" id="password" placeholder="Password"
                                    data-rule-required="true" data-rule-minlength="8"
                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                    value="{{ old('password', $user->password ?? '') }}">

                                @error('password')
                                    <span class="text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                Company
                            </label>
                            <select name="company" id="status" data-rule-required="true"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="">Please Select The Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $user->companies[0]->id == $company->id ? 'selected' : '' }}>
                                        {{ $company->title }}</option>
                                @endforeach
                            </select>
                            @error('company')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                    <button
                        class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Submit
                    </button>
                    <a href="{{ route('users.index') }}"
                        class="hover:shadow-form rounded-md bg-yellow-400 py-3 px-8 text-center text-base font-semibold text-white outline-none">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
