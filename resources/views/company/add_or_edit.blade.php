@extends('layout.master')
@section('content')
    <div class="flex items-center justify-center p-12 w-full">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="{{ empty($company) ?  route('companies.store') : route('companies.update',[$company->id]) }}" id="is_validate_form" method="POST">
                @csrf
                @if(!empty($company))
                @method('PUT')
                @endif
                <div class="-mx-3 flex flex-wrap">
                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                Company Title
                            </label>
                            <input type="text" name="title" id="title" placeholder="Company Title"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                data-rule-required="true" value="{{ old('title', $company->title ?? '') }}">

                            @error('title')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                Company email
                            </label>
                            <input type="email" name="email" id="email" placeholder="Company email"
                                data-rule-email="true" data-rule-required="true"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                value="{{ old('email', $company->email ?? '') }}">

                            @error('email')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if(empty($company->password))
                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="Password" data-rule-required="true" data-rule-minlength="8"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                                value="{{ old('password', $company->password ?? '') }}">

                            @error('password')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <div class="w-full px-3">
                        <div class="mb-5">
                            <label for="fName" class="mb-3 block text-base font-medium text-[#07074D]">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                <option value="1" {{ old('status', $company->status ?? '') == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $company->status ?? '') == 0 ? 'selected' : '' }}>In
                                    Active
                                </option>
                            </select>
                            @error('status')
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
                    <a href="{{ route('companies.index') }}" class="hover:shadow-form rounded-md bg-yellow-400 py-3 px-8 text-center text-base font-semibold text-white outline-none">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
