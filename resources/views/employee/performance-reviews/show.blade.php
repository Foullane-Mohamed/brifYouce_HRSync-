@extends('layouts.app')

@section('title', 'Performance Review Details')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Performance Review Details</h1>
            <a href="{{ route('employee.performance-reviews.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Reviews
            </a>
        </div>

        <div class="bg-gray-50 rounded-lg overflow-hidden shadow mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Performance Review for {{ $performanceReview->review_date->format('F Y') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Reviewed on {{ $performanceReview->review_date->format('M d, Y') }} by {{ $performanceReview->reviewer->name }}
                </p>
                <div class="mt-2 flex items-center">
                    <p class="text-sm font-medium text-gray-700 mr-2">Overall Rating:</p>
                    <span class="text-lg font-semibold text-gray-900 mr-2">{{ $performanceReview->rating }}/5</span>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $performanceReview->rating)
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
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Achievements
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $performanceReview->achievements ?: 'No achievements provided' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Areas for Improvement
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $performanceReview->areas_for_improvement ?: 'No areas for improvement provided' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Goals for Next Period
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $performanceReview->goals ?: 'No goals provided' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Additional Comments
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $performanceReview->comments ?: 'No additional comments provided' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Rating Comparison -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Your Performance Over Time</h2>
            
            @php
                $allReviews = Auth::user()->performanceReviews()
                    ->orderBy('review_date', 'asc')
                    ->get();
                
                $averageRating = $allReviews->avg('rating');
                $reviewDates = $allReviews->pluck('review_date')->map(function($date) {
                    return $date->format('M Y');
                });
                $ratings = $allReviews->pluck('rating');
            @endphp
            
            @if($allReviews->count() > 1)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Your Average Rating</p>
                                <p class="text-2xl font-bold">{{ number_format($averageRating, 1) }} <span class="text-sm text-gray-400">/ 5</span></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Latest Rating</p>
                                <p class="text-2xl font-bold">{{ $performanceReview->rating }} <span class="text-sm text-gray-400">/ 5</span></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Reviews Count</p>
                                <p class="text-2xl font-bold">{{ $allReviews->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Simple Line Chart -->
                    <div class="h-64 relative">
                        <div class="absolute left-0 bottom-0 top-0 flex flex-col justify-between text-xs text-gray-500">
                            <span>5</span>
                            <span>4</span>
                            <span>3</span>
                            <span>2</span>
                            <span>1</span>
                            <span>0</span>
                        </div>
                        <div class="absolute left-6 right-0 bottom-6 top-0">
                            <!-- Horizontal Grid Lines -->
                            <div class="h-full flex flex-col justify-between">
                                @for($i = 0; $i <= 5; $i++)
                                    <div class="w-full border-t border-gray-200"></div>
                                @endfor
                            </div>
                            
                            <!-- Chart Line -->
                            <svg class="absolute inset-0" viewBox="0 0 {{ $allReviews->count() * 60 }} 200" preserveAspectRatio="none">
                                <polyline
                                    fill="none"
                                    stroke="#3b82f6"
                                    stroke-width="3"
                                    points="
                                        @foreach($allReviews as $index => $review)
                                            {{ $index * 60 + 30 }},{{ 200 - ($review->rating * 40) }}
                                        @endforeach
                                    "
                                />
                                
                                <!-- Data Points -->
                                @foreach($allReviews as $index => $review)
                                    <circle
                                        cx="{{ $index * 60 + 30 }}"
                                        cy="{{ 200 - ($review->rating * 40) }}"
                                        r="4"
                                        fill="{{ $review->id === $performanceReview->id ? '#ef4444' : '#3b82f6' }}"
                                    />
                                @endforeach
                            </svg>
                        </div>
                        
                        <!-- X Axis Labels -->
                        <div class="absolute left-6 right-0 bottom-0 flex justify-between text-xs text-gray-500">
                            @foreach($reviewDates as $date)
                                <span>{{ $date }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-4 text-center text-gray-500">
                    <p>Not enough review history to display performance over time.</p>
                </div>
            @endif
        </div>

        <!-- Previous Reviews -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Previous Reviews</h2>
            
            @php
                $previousReviews = Auth::user()->performanceReviews()
                    ->where('id', '!=', $performanceReview->id)
                    ->orderBy('review_date', 'desc')
                    ->take(3)
                    ->get();
            @endphp
            
            @if($previousReviews->isEmpty())
                <p class="text-gray-500 italic">No previous performance reviews found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($previousReviews as $prevReview)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $prevReview->review_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $prevReview->reviewer->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-900 mr-2">{{ $prevReview->rating }}/5</span>
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $prevReview->rating)
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('employee.performance-reviews.show', $prevReview) }}" class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-right">
                    <a href="{{ route('employee.performance-reviews.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View all performance reviews <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection