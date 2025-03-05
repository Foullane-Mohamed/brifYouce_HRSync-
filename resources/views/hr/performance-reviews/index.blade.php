{{-- resources/views/hr/performance-reviews/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Performance Reviews')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Performance Reviews</h1>
            <a href="{{ route('hr.performance-reviews.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <i class="fas fa-plus mr-1"></i> Add New Review
            </a>
        </div>

        <div class="mb-4">
            <form action="{{ route('hr.performance-reviews.index') }}" method="GET" class="flex flex-wrap items-end gap-4 mb-4">
                <div>
                    <label for="employee" class="block text-sm font-medium text-gray-700">Employee</label>
                    <input type="text" id="employee" name="employee" value="{{ request('employee') }}" placeholder="Name or ID" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <select id="rating" name="rating" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Ratings</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <select id="year" name="year" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Years</option>
                        @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('employee') || request('rating') || request('year'))
                        <a href="{{ route('hr.performance-reviews.index') }}" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    @endif
                </div>
            </form>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Employee</th>
                            <th scope="col" class="px-6 py-3">Review Date</th>
                            <th scope="col" class="px-6 py-3">Reviewer</th>
                            <th scope="col" class="px-6 py-3">Rating</th>
                            <th scope="col" class="px-6 py-3">Department</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($performanceReviews as $review)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <a href="{{ route('hr.employees.show', $review->user) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $review->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $review->review_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $review->reviewer->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium">{{ $review->rating }}/5</span>
                                        <div class="flex ml-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $review->user->department ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('hr.performance-reviews.show', $review) }}" class="px-2 py-1 text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('hr.performance-reviews.edit', $review) }}" class="px-2 py-1 text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No performance reviews found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $performanceReviews->links() }}
        </div>
    </div>
</div>
@endsection