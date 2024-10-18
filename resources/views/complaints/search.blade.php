@extends('layouts.app')

@section('title', 'Search Report')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Search Report</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Search for a Report</h5>
                    <form action="{{ route('complaints.results') }}" method="GET">
                        <div class="row no-gutters">
                            <div class="col pr-2">
                                <input type="text" class="form-control w-100" id="query" name="query" placeholder="Enter Report Number">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
