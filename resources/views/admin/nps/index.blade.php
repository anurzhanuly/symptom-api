@extends('admin.layout')

@section('content')
<div class="container-fluid px-5 py-4 vh-100">
    <h1>Запросы на обратную связь</h1>
    @if ($message)
    <p class="col-md-12 alert alert-success mt-3">{{ $message }}</p>
    @endif
    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Место работы</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Дата обращения</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @php
                /** @var \App\Symptom\Entities\DoctorNps $nps */
                @endphp
                @foreach ($npsCollection as $nps)
                <tr>
                    <th scope="row">{{ $nps->getId() }}</th>
                    <td>{{ $nps->getName() }}</td>
                    <td>{{ $nps->getWorkplace() }}</td>
                    <td>{{ $nps->getPhone() }}</td>
                    <td>{{ $nps->getCreatedAt() }}</td>
                    <td>
                        @if(!$nps->is_checked)
                            <a href="{{ route('nps.check', ['id' => $nps->getId()]) }}" class="btn btn-success">Обработано!</a>
                        @else
                            <p>Обработано!</p>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex">
                {!! $npsCollection->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
