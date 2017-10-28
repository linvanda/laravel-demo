<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->avatar() }}" class="gravatar">
</a>
<h1>{{ $user->name }}</h1>