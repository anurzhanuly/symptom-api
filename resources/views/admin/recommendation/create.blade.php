@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Добавить доктора</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-12">
            <form method="post" action="{{ route('recommendation.handleCreate') }}" id="recommendation">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="name">Название</label>
                        <input required type="text" class="form-control" name="name" id="name">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label>Тесты</label>
                        <input required type="hidden" class="form-control" name="tests">
                        <div id="jsoneditor-tests" class="form-control" style="height: 300px;"></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label>Условия</label>
                        <input required type="hidden" class="form-control" name="conditions">
                        <div id="jsoneditor-conditions" class="form-control" style="height: 300px;"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2">Сохранить</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.2/jsoneditor.min.js" integrity="sha512-jhDajNRbXZ4gJ8SVzcuWTHbgSX66Dh98CwmAkhBHWVuEYVgY8G35rbZuRlQwrOcwEB6z5aYzxUptsSjgTGlCbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function initRecommendationCreate()
    {
        const options = {
            mode:  'code',
            modes: ['code', 'tree'],
        };

        const form             = document.getElementById('recommendation')
        const testsEditor      = new JSONEditor(document.getElementById('jsoneditor-tests'), options)
        const conditionsEditor = new JSONEditor(document.getElementById('jsoneditor-conditions'), options)

        testsEditor.set()
        conditionsEditor.set()

        form.addEventListener('submit', function (e) {
            e.preventDefault()

            form['tests'].value      = JSON.stringify(testsEditor.get())
            form['conditions'].value = JSON.stringify(conditionsEditor.get())

            form.submit()
        })
    }

    initRecommendationCreate()
</script>
@endsection
