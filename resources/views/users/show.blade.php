@extends('layouts.default')
@section('title', $user->name . '用户信息')

@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8">
                    <section class="user_info">
                        @include('shared._user_info', ['user' => $user])
                    </section>
                </div>
            </div>
            {{--微博动态列表--}}
            <div class="col-md-12">
                @if (Auth::check())
                    @include('users._follow_form', ['user' => $user])
                @endif

                @if (count($statuses) > 0)
                    <ol class="statuses">
                        @foreach ($statuses as $status)
                            @include('statuses._status', ['user' => $user, 'status' => $status])
                        @endforeach
                    </ol>
                    {!! $statuses->render() !!}
                @endif
            </div>
        </div>
    </div>
@stop