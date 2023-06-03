@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Клиники</h1>
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
                    <th scope="col">Город</th>
                    <th scope="col">Адрес</th>
                </tr>
                </thead>
                <tbody>
                @php
                /** @var \App\Symptom\Entities\Clinic $clinic */
                @endphp
                @foreach ($clinics as $clinic)
                <tr>
                    <th scope="row">{{ $clinic->getId() }}</th>
                    <td>{{ $clinic->getName() }}</td>
                    <td>{{ $clinic->getCity() }}</td>
                    <td>{{ $clinic->getAddress() }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('clinic.create') }}" id="cabinet">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-2">
                            <label for="name">Добавить клинику</label>
                            <input required type="text" class="form-control" name="name" id="name" placeholder="РДЦ">
                        </div>
                        <div class="form-group mt-2">
                            <label for="address">Адрес</label>
                            <input required type="text" class="form-control" name="address" id="address" placeholder="ул. Пушкина 12">
                        </div>
                        <div class="form-group  mt-2">
                            <label for="city_id">Город</label>
                            <select class="form-control" name="city_id" id="city_id">
                                <option selected>Выберите город</option>
                                @foreach($cities as $city)
                                <option value="{{ $city->getId() }}">{{ $city->getName() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
