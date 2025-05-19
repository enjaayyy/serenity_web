@extends('index')

@section('title', 'doctor-questionnaires')

@section('content')
    <div class="admin-header">
        <p class="dash-text">Dashboard</p>
        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
    </div>
    <p id="status" hidden></p>
    <div class="tabs-container">
        <button class="questionnaireTabs" onclick="getQuestionnaires()">Active Questionnaires</button>
        <button class="questionnaireTabs" onclick="getViewQuestionnaires()">View Questionnaires</button>
        <button class="questionnaireTabs" onclick="AddDataSet()">Add Questionnaires</button>
        <button class="questionnaireTabs" onclick="editQuestionnaire()">Edit Questionnaires</button>
    </div>
    @include('doctor.utilities.questionnaire')
@endsection