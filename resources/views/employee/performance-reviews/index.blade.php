@extends('layouts.app')

@section('title', 'My Performance Reviews')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold mb-6">My Performance Reviews</h1>
        
        <!-- Latest Review Summary -->
        @php
            $latestReview = $performanceReviews->first();
        @endphp
        
        @if($latestReview)
            <div class="bg-gray-50 rounded-lg overflow-hidden shadow mb-6">
                <div class="px-4 py-5 sm:px-6 bg-gray-100">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Latest Performance Review
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Reviewed on {{ $latestReview->review_date->format('M d, Y') }} by {{ $latestReview->reviewer->name }}
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Overall Rating
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex items-center">
                                    <span class="text-lg font-semibold mr-2">{{ $latestReview->rating }}/5</span>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $latestReview->rating)
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Key Achievements
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $latestReview->achievements ?: 'No specific achievements mentioned.' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Areas for Improvement
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $latestReview->areas_for_improvement ?: 'No specific areas for improvement mentioned.' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Goals for Next Period
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $latestReview->goals ?: 'No specific goals mentioned.' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-gray-50 px-4 py-3 text-right">
                    <a href="{{ route('employee.performance-reviews.show', $latestReview) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        View Full Review
                    </a>
                </div>
            </div>
            
            <!-- Performance History Chart -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Performance History</h3>
                
                @php
                    $reviewData = $performanceReviews->sortBy('review_date')->map(function($review) {
                        return [
                            'date' => $review->review_date->format('M Y'),
                            'rating' => $review->rating
                        ];
                    });
                @endphp
                
                <div class="h-64 relative">
                    @if($reviewData->count() > 1)
                        <!-- Showing chart if more than one review -->
                        <div class="absolute inset-0 flex items-end justify-between px-4">
                            @foreach($reviewData as $index => $data)
                                <div class="flex flex-col items-center">
                                    <div class="text-sm text-gray-500">{{ $data['rating'] }}/5</div>
                                    <div class="bg-blue-500 w-12" style="height: {{ ($data['rating'] / 5) * 200 }}px;"></div>
                                    <div class="text-xs text-gray-500 mt-2">{{ $data['date'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <p class="text-gray-500">Not enough review data to display performance history.</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                <p class="text-yellow-700">You don't have any performance reviews yet.</p>
            </div>
        @endif

        <!-- All Reviews Table -->
        <h2 class="text-xl font-semibold mb-4">All Performance Reviews</h2>
        
        <div class="mb-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Review Date</th>
                            <th scope="col" class="px-6 py-3">Reviewer</th>
                            <th scope="col" class="px-6 py-3">Rating</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($performanceReviews as $review)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $review->review_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $review->reviewer->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium mr-2">{{ $review->rating }}/5</span>
                                        <div class="flex">
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
                                    <a href="{{ route('employee.performance-reviews.show', $review) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
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