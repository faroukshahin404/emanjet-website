@extends('admin.layouts.master')
@push('css')
    <style>
        /* Main layout */
        .container {
            width: 100%;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        /* Header area */
        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        /* Typography */
        .text-2xl {
            font-size: 1.5rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-gray-600 {
            color: #4b5563;
        }

        .text-gray-700 {
            color: #374151;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .text-green-700 {
            color: #047857;
        }

        .text-red-700 {
            color: #b91c1c;
        }

        .text-white {
            color: white;
        }

        /* Cards and grid */
        .grid {
            display: grid;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .bg-white {
            background-color: white;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .p-6 {
            padding: 1.5rem;
        }

        /* Notification */
        .bg-green-100 {
            background-color: #d1fae5;
        }

        .border {
            border-width: 1px;
        }

        .border-green-400 {
            border-color: #34d399;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Status tags */
        .inline-block {
            display: inline-block;
        }

        .bg-gray-200 {
            background-color: #e5e7eb;
        }

        .bg-green-200 {
            background-color: #a7f3d0;
        }

        .bg-red-200 {
            background-color: #fecaca;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        /* Buttons */
        .flex.space-x-3>*+* {
            margin-left: 0.75rem;
        }

        .bg-blue-500 {
            background-color: #3b82f6;
        }

        .bg-purple-500 {
            background-color: #8b5cf6;
        }

        .hover\:bg-blue-600:hover {
            background-color: #2563eb;
        }

        .hover\:bg-purple-600:hover {
            background-color: #7c3aed;
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>
@endpush
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pages as $page)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">{{ $page->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ $page->meta_description }}</p>

                        <div class="mb-4">
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                {{ $page->slug }}
                            </span>
                            <span
                                class="inline-block bg-{{ $page->status ? 'green' : 'red' }}-200 rounded-full px-3 py-1 text-sm font-semibold text-{{ $page->status ? 'green' : 'red' }}-700">
                                {{ $page->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="text-sm text-gray-500 mb-4">
                            <p>SEO Sections: {{ $page->pageSeos->count() }}</p>
                            <p>Last Updated: {{ $page->updated_at->format('M d, Y') }}</p>
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('admin.pages.edit', $page->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                Edit Page
                            </a>
                            <a href="{{ route('admin.pages-seo.index', ['pageId' => $page->id]) }}"
                                class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded">
                                Edit SEO
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
