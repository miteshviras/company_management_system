<form action="" method="get" class="flex w-1/2 space-x-4">
    <select name="status" id="" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md valid">
        <option value="" selected>All</option>
        <option value="1" {{ request()->query('status') == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ request()->query('status') == 0 ? 'selected' : '' }}>In-Active</option>
    </select>
    <input type="search" name="search" value="{{ request()->query('search') ?? '' }}" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md valid">

    <button type="submit" class="bg-blue-500 text-white active:bg-red-600 font-bold uppercase text-base px-8 py-3 rounded shadow-md hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
        Submit
    </button>


</form>
