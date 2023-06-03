@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Доктора</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Доктор</th>
                    <th scope="col">Специализация</th>
                    <th scope="col">Опыт</th>
                </tr>
                </thead>
                <tbody>
                @php
                /** @var \App\Symptom\Entities\Doctor $doctor */
                @endphp
                @foreach ($doctors as $doctor)
                <tr>
                    <th scope="row">{{ $doctor->getId() }}</th>
                    <td>{{ $doctor->getFullName() }}</td>
                    <td>{{ $doctor->getSpecialization() }}</td>
                    <td>{{ $doctor->getExperienceText() }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
