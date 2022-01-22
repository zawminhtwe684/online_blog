@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    {{request()}}
                    <x-test type="success"></x-test>
                    <x-test>slot ထည့်ထားလို့သာ ဖော်ပေးခြင်းဖြစ်ပါသည်။ </x-test>
                    <x-test type="danger">slot ထည့်ထားလို့သာ ဖော်ပေးခြင်းဖြစ်ပါသည်။ </x-test>

                    @zmh

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
