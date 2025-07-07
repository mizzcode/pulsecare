<x-layouts.app>

    <!-- Menu Navigation -->
    <div class="mb-6">
        <nav class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
            <ul class="flex space-x-6">
                <li><a href="{{ route('kuisioner.create') }}"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 {{ request()->routeIs('kuisioner.create') ? 'font-bold underline' : '' }}">Isi
                        Kuisioner</a></li>
                <li><a href="{{ route('kuisioner.index') }}"
                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 {{ request()->routeIs('kuisioner.index') ? 'font-bold underline' : '' }}">Lihat
                        Hasil</a></li>
            </ul>
        </nav>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Kuisioner DASS-21') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Silakan isi kuisioner berikut dengan jujur') }}</p>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8 border border-gray-200 dark:border-gray-700 max-w-3xl mx-auto">
        <form action="{{ route('kuisioner.store') }}" method="POST" id="kuisionerForm">
            @csrf

            <!-- Progress Bar -->
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden mb-8">
                <div class="bg-blue-600 h-full transition-all duration-300"
                    style="width: {{ ($currentPage / $totalPages) * 100 }}%"></div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Alert for validation -->
            <div id="validationAlert"
                class="hidden mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                <p>Silakan jawab semua pertanyaan di halaman ini sebelum melanjutkan.</p>
            </div>

            @foreach ($questions as $index => $question)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-blue-800 mb-2 dark:text-white">
                        {{ ($currentPage - 1) * 7 + $loop->index + 1 }}. {{ $question->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Kategori: {{ strtolower($question->category) }}
                    </p>
                    <div class="space-y-2">
                        @foreach ($answers as $answer)
                            <label
                                class="flex items-center gap-3 p-2 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->value }}"
                                    class="form-radio text-blue-600 focus:ring-blue-500 question-radio"
                                    data-question-id="{{ $question->id }}"
                                    {{ isset($sessionAnswers[$question->id]) && $sessionAnswers[$question->id] == $answer->value ? 'checked' : '' }}
                                    required>
                                <span class="text-gray-700 dark:text-gray-300">{{ $answer->value }} -
                                    {{ $answer->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error("answers.{$question->id}")
                        <span class="text-red-500 text-sm font-medium mt-2">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

            <!-- Hidden inputs hanya untuk jawaban yang sudah diisi di halaman sebelumnya -->
            @foreach ($sessionAnswers as $qId => $value)
                @if (!in_array($qId, $questions->pluck('id')->toArray()))
                    <input type="hidden" name="answers[{{ $qId }}]" value="{{ $value }}" />
                @endif
            @endforeach

            <div class="flex justify-between mt-6">
                @if ($currentPage > 1)
                    <button type="button" id="prevBtn"
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300">
                        ⬅ Kembali
                    </button>
                @endif
                @if ($currentPage < $totalPages)
                    <button type="button" id="nextBtn"
                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                        Selanjutnya ➡
                    </button>
                @endif
                @if ($currentPage == $totalPages)
                    <button type="button" id="submitBtn"
                        class="px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700">
                        Kirim Assesment
                    </button>
                @endif
                <input type="hidden" name="next_page" id="nextPageInput" value="">
                <input type="hidden" name="submit_final" id="submitFinalInput" value="">
            </div>
            <p class="mt-2 text-center text-gray-600 dark:text-gray-400">Halaman {{ $currentPage }} dari
                {{ $totalPages }}</p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kuisionerForm');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const nextPageInput = document.getElementById('nextPageInput');
            const submitFinalInput = document.getElementById('submitFinalInput');
            const validationAlert = document.getElementById('validationAlert');
            const currentPage = {{ $currentPage }};

            // Function to check if all questions on current page are answered
            function validateCurrentPage() {
                const questionRadios = document.querySelectorAll('.question-radio');
                const questionIds = new Set();
                const answeredQuestions = new Set();

                // Get all question IDs on current page
                questionRadios.forEach(radio => {
                    questionIds.add(radio.getAttribute('data-question-id'));
                    if (radio.checked) {
                        answeredQuestions.add(radio.getAttribute('data-question-id'));
                    }
                });

                // Check if all questions are answered
                return questionIds.size === answeredQuestions.size;
            }

            // Function to show/hide validation alert
            function showValidationAlert(show) {
                if (show) {
                    validationAlert.classList.remove('hidden');
                    validationAlert.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    validationAlert.classList.add('hidden');
                }
            }

            // Next button click handler
            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateCurrentPage()) {
                        showValidationAlert(false);
                        nextPageInput.value = currentPage + 1;
                        submitFinalInput.value = '';
                        form.submit();
                    } else {
                        showValidationAlert(true);
                    }
                });
            }

            // Previous button click handler
            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    nextPageInput.value = currentPage - 1;
                    submitFinalInput.value = '';
                    form.submit();
                });
            }

            // Submit button click handler
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateCurrentPage()) {
                        showValidationAlert(false);
                        submitFinalInput.value = 'true';
                        nextPageInput.value = '';
                        form.submit();
                    } else {
                        showValidationAlert(true);
                    }
                });
            }

            // Hide validation alert when user starts answering
            document.querySelectorAll('.question-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (validateCurrentPage()) {
                        showValidationAlert(false);
                    }
                });
            });
        });
    </script>

</x-layouts.app>
