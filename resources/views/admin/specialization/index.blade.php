@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Специализации</h1>
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
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @php
                /** @var \App\Symptom\Entities\Specializations $specialization */
                @endphp
                @foreach ($specializations as $specialization)
                <tr>
                    <th scope="row">{{ $specialization->getId() }}</th>
                    <td>{{ $specialization->getName() }}</td>
                    <td><a href="{{ route('specialization.delete', ['id' => $specialization->getId()]) }}" class="btn btn-danger">Удалить</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <form method="post" action="{{ route('specialization.create') }}" id="cabinet">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Добавить специализацию</label>
                            <input required type="text" class="form-control mt-2" name="name" id="name" placeholder="Нейрохирург">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
