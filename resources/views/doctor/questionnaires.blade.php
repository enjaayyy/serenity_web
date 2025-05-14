@extends('index')

@section('title', 'doctor-questionnaires')

@section('content')
    <div class="admin-header">
        <p class="dash-text">Dashboard</p>
        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
    </div>
    <p id="status" hidden></p>
    <button onclick="getQuestionnaires()">viewCurrentQuestionnaire</button>
    <button onclick="getViewQuestionnaires()">viewQuestionnaire</button>
    <button onclick="AddDataSet()">addQuestionnaire</button>
    <button onclick="editQuestionnaire()">editQuestionnaire</button>
    @include('doctor.utilities.questionnaire')
@endsection