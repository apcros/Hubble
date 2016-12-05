@extends('layouts.master')
@section('title', 'Hubble - Overview')

@section('content')
@include('handlebarsjs.device')
@include('handlebarsjs.drive')
<script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/hubble-metrics.js') }}"></script>
<div class="container">
  <div class="col s12">
      <div class="card">
            <div class="card-content">
                <span class="card-title black-text">General metrics :</span>
            </div>
       </div>
  </div>
  <div class="col s12">
      <div class="card">
            <div class="card-content">
                <span class="card-title black-text">Graphs :</span>
            </div>
       </div>
  </div>
</div>
@endsection
