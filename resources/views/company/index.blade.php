@extends('layout.master')
@section('content')
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">Companies</h2>
            </div>

            <form action="" method="get" class="flex w-1/2 space-x-4">
                <select name="status" id=""
                    class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md valid">
                    <option value="" selected>All</option>
                    <option value="1" {{ request()->query('status') == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request()->query('status') == 0 ? 'selected' : '' }}>In-Active</option>
                </select>
                <input type="search" name="search" value="{{ request()->query('search') ?? '' }}"
                    class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md valid">

                <button type="submit"
                    class="bg-blue-500 text-white active:bg-red-600 font-bold uppercase text-base px-8 py-3 rounded shadow-md hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                    Submit
                </button>
            </form>


            @include('layout.add_button', ['link' => Route('companies.create')])

            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Title
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($companies) > 0)
                                @foreach ($companies as $company)
                                    <tr>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            {{ $company->title }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            {{ $company->email }}
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm">
                                            @if ($company->status)
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Active</span>
                                                </span>
                                            @else
                                                <span
                                                    class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                    <span aria-hidden
                                                        class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                    <span class="relative">Inactive</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-5 bg-white text-sm d-flex">
                                            <a href="{{ route('companies.edit', [$company]) }}"
                                                class="px-2 py-1 bg-blue-400 text-white">Edit</a>
                                            <form class="my-1" action="{{ route('companies.destroy', [$company]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="px-2 py-1 bg-blue-400 text-white">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-5 py-5 bg-white text-sm text-center" colspan="4">
                                        No Data Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div
                        class=" w-full px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        {!! $companies->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
