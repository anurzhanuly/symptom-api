@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Добавить доктора</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-12">
            <form method="post" action="{{ route('doctor.handleCreate') }}" id="cabinet">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="first_name">Имя</label>
                        <input required type="text" class="form-control" name="first_name" id="first_name" placeholder="Иван">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="last_name">Фамилия</label>
                        <input required type="text" class="form-control" name="last_name" id="last_name" placeholder="Иванов">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="middle_name">Отчество</label>
                        <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Иванович">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="specialization_id">Специализация</label>
                        <select class="form-control" name="specialization_id" id="specialization_id">
                            <option selected>Выберите специализацию</option>
                            @foreach($specializations as $specialization)
                            <option value="{{ $specialization->getId() }}">{{ $specialization->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="experience">Опыт</label>
                        <input required type="text" class="form-control" name="experience" id="experience" placeholder="3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="clinic_id">Клиники</label>
                        <select multiple class="form-control" name="clinic_id[]" id="clinic_id">
                            @foreach($clinics as $clinic)
                            <option value="{{ $clinic->getId() }}">{{ $clinic->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="email">Почтовый адрес</label>
                        <input required type="text" class="form-control" name="email" id="email" placeholder="mail@mail.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">Телефон</label>
                        <input required type="text" class="form-control" name="phone" id="phone" placeholder="77076668899">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="password">Пароль</label>
                        <input required type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="c_password">Повторите пароль</label>
                        <input required type="password" class="form-control" name="c_password" id="c_password">
                    </div>
                </div>
                <input type="hidden" name="type" value="doctor">
                <button type="submit" class="btn btn-success mt-2">Сохранить</button>
            </form>
        </div>
    </div>
</div>
@endsection
