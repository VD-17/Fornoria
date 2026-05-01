@extends('layouts.admin_nav')

@section('title', 'Gallery Management')

@push('styles')
    @vite('resources/css/add_gallery.css')
@endpush

@push('scripts')
    @vite('resources/js/add_gallery.js')
@endpush

@section('heading', 'Gallery Management')

@section('admin_page_content')
    <div class="add-item">

        <div class="gallery-topbar">
            <div class="gallery-meta">
                <h3>Add images to Gallery</h3>
                <p>
                    @if ($images)
                        {{$images->count()}} images on gallery
                    @else
                        0 images on gallery
                    @endif
                </p>
            </div>
            <button class="add-btn" id="openAddImageModal">
                <i class="fa-solid fa-plus"></i>
                Add Image
            </button>
        </div>

        <div class="display-gallery">
            @forelse ($images as $image)
                <div class="gallery-card">
                    <img
                        src="{{ $image->imageUrl ? Storage::url($image->imageUrl) : asset('images/gallery_placeholder.png') }}"
                        alt="{{ $image->imageUrl }}"
                    >
                    <div class="gallery-card-overlay">
                        <form action="{{ route('gallery.delete', $image->gallery_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="gallery-delete-btn" title="Delete image">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="empty-state">No images added yet</p>
            @endforelse
        </div>
    </div>

    @include('dialogs.add_image_modal')

@endsection
