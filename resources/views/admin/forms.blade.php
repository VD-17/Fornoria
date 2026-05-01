@extends('layouts.admin_nav')

@section('title', 'Admin - Contact Forms')

@push('styles')
    @vite('resources/css/form.css')
@endpush

@push('scripts')
    @vite('resources/js/form.js')
@endpush

@section('heading', 'Contact Forms')

@section('admin_page_content')
    <div class="reservations">
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($forms as $form)
                    <tr>
                        <td>{{ $form->form_name }}</td>
                        <td>{{ $form->subject }}</td>
                        <td>{{ $form->form_email }}</td>
                        <td>{{ $form->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button
                                class="status-badge openFormModal"
                                data-subject="{{ $form->subject }}"
                                data-name="{{ $form->form_name }}"
                                data-email="{{ $form->form_email }}"
                                data-date="{{ $form->created_at->format('d/m/Y') }}"
                                data-message="{{ $form->message }}"
                            >
                                Open
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-res">No contact forms yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('dialogs.form_modal')

@endsection
