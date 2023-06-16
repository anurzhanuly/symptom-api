@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Рекомендации</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-12">
            @php
            /** @var \App\Symptom\Entities\Recommendation $recommendation */
            @endphp
            @foreach ($recommendations as $recommendation)
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="">
                        <a data-bs-toggle="collapse" href="#col-{{ $recommendation->getId() }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            {{ $recommendation->getName() }}
                        </a>
                    </div>
                    <div class="">
                        <a href="{{ route('recommendation.delete', ['id' => $recommendation->getId()]) }}" class="btn btn-danger">Удалить</a>
                    </div>
                </div>
                <div class="collapse" id="col-{{ $recommendation->getId() }}">
                    <div class="card card-body">
                        <form method="post" action="{{ route('recommendation.update') }}" id="recommendation-{{ $recommendation->getId() }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="name">Название</label>
                                    <input required type="text" class="form-control" name="name" id="name" value="{{ $recommendation->getName() }}">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label>Тесты</label>
                                    <input required type="hidden" class="form-control" name="tests" value="{{ htmlspecialchars( $recommendation->tests, ENT_COMPAT) }}">
                                    <div id="jsoneditor-tests-{{ $recommendation->getId() }}" class="form-control" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label>Условия</label>
                                    <input required type="hidden" class="form-control" name="conditions" value="{{ htmlspecialchars( $recommendation->conditions, ENT_COMPAT) }}">
                                    <div id="jsoneditor-conditions-{{ $recommendation->getId() }}" class="form-control" style="height: 300px;"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $recommendation->getId() }}">
                            <button type="submit" class="btn btn-success mt-2">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.10.2/jsoneditor.min.js" integrity="sha512-jhDajNRbXZ4gJ8SVzcuWTHbgSX66Dh98CwmAkhBHWVuEYVgY8G35rbZuRlQwrOcwEB6z5aYzxUptsSjgTGlCbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function initRecommendationsUpdate()
    {
        const options = {
            mode:  'code',
            modes: ['code', 'tree'],
        };

        function decodeText(text) {
            var map = {
                '&amp;': '&',
                '&#038;': "&",
                '&lt;': '<',
                '&gt;': '>',
                '&quot;': '"',
                '&#039;': "'",
                '&#8217;': "’",
                '&#8216;': "‘",
                '&#8211;': "–",
                '&#8212;': "—",
                '&#8230;': "…",
                '&#8221;': '”'
            };

            return JSON.parse(text.replace(/\&[\w\d\#]{2,5}\;/g, function(m) { return map[m]; }));
        }

        var formsCollection = document.getElementsByTagName("form");

        for(var i = 0; i < formsCollection.length; i++)
        {
            const form             = formsCollection[i]
            const id               = form['id'].value
            const testsEditor      = new JSONEditor(document.getElementById('jsoneditor-tests-' + id), options)
            const conditionsEditor = new JSONEditor(document.getElementById('jsoneditor-conditions-' + id), options)

            testsEditor.set(decodeText(form['tests'].value))
            conditionsEditor.set(decodeText(form['conditions'].value))

            form.addEventListener('submit', function (e) {
                e.preventDefault()

                form['tests'].value      = JSON.stringify(testsEditor.get())
                form['conditions'].value = JSON.stringify(conditionsEditor.get())

                form.submit()
            })


        }
    }

    initRecommendationsUpdate()
</script>
@endsection
