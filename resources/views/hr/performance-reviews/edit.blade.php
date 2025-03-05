{{-- resources/views/hr/performance-reviews/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Performance Review')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Edit Performance Review</h1>
            <a href="{{ route('hr.performance-reviews.show', $performanceReview) }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Back to Review
            </a>
        </div>

        <form action="{{ route('hr.performance-reviews.update', $performanceReview) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Employee (read-only) -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Employee</label>
                    <div class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm">
                        {{ $performanceReview->user->name }} - {{ $performanceReview->user->department ?: 'No Department' }}
                    </div>
                    <input type="hidden" name="user_id" value="{{ $performanceReview->user_id }}">
                </div>

                <!-- Review Date -->
                <div>
                    <label for="review_date" class="block text-sm font-medium text-gray-700">Review Date</label>
                    <input type="date" name="review_date" id="review_date" value="{{ old('review_date', $performanceReview->review_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('review_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                    <div class="mt-1 flex items-center space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <div>
                                <input type="radio" name="rating" id="rating_{{ $i }}" value="{{ $i }}" {{ old('rating', $performanceReview->rating) == $i ? 'checked' : '' }} class="hidden peer" required>
                                <label for="rating_{{ $i }}" class="cursor-pointer block p-2 border border-gray-300 rounded-full peer-checked:bg-yellow-400 peer-checked:border-yellow-500 hover:bg-yellow-100 transition-colors">
                                    <svg class="h-6 w-6 {{ $i <= $performanceReview->rating ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </label>
                            </div>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Placeholder for grid alignment -->
                <div></div>

                <!-- Achievements -->
                <div class="md:col-span-2">
                    <label for="achievements" class="block text-sm font-medium text-gray-700">Achievements</label>
                    <textarea name="achievements" id="achievements" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('achievements', $performanceReview->achievements) }}</textarea>
                    @error('achievements')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Areas for Improvement -->
                <div class="md:col-span-2">
                    <label for="areas_for_improvement" class="block text-sm font-medium text-gray-700">Areas for Improvement</label>
                    <textarea name="areas_for_improvement" id="areas_for_improvement" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('areas_for_improvement', $performanceReview->areas_for_improvement) }}</textarea>
                    @error('areas_for_improvement')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Goals -->
                <div class="md:col-span-2">
                    <label for="goals" class="block text-sm font-medium text-gray-700">Goals for Next Period</label>
                    <textarea name="goals" id="goals" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('goals', $performanceReview->goals) }}</textarea>
                    @error('goals')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comments -->
                <div class="md:col-span-2">
                    <label for="comments" class="block text-sm font-medium text-gray-700">Additional Comments</label>
                    <textarea name="comments" id="comments" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comments', $performanceReview->comments) }}</textarea>
                    @error('comments')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Update Performance Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add client-side validation if needed
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const ratingLabels = document.querySelectorAll('label[for^="rating_"]');
        
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                const currentRating = parseInt(this.value);
                
                ratingLabels.forEach((label, index) => {
                    const star = label.querySelector('svg');
                    if (index + 1 <= currentRating) {
                        star.classList.remove('text-gray-400');
                        star.classList.add('text-yellow-500');
                    } else {
                        star.classList.remove('text-yellow-500');
                        star.classList.add('text-gray-400');
                    }
                });
            });
        });
    });
</script>
@endpush