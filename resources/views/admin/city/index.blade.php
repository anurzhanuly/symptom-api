@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Города</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-6">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                </tr>
                </thead>
                <tbody>
                @php
                /** @var \App\Symptom\Entities\City $city */
                @endphp
                @foreach ($cities as $city)
                <tr>
                    <th scope="row">{{ $city->getId() }}</th>
                    <td>{{ $city->getName() }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('city.create') }}" id="cabinet">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Добавить город</label>
                            <input required type="text" class="form-control mt-2" name="name" id="name" placeholder="Астана">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
