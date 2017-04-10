<h2>
    Dear {{$author_name}},
</h2>
<p>
    This is the User Comment Notification! from {{$current_name}}.
</p>
<hr>
<p>
    @foreach ($messageLines as $messageLine)
        {{ $messageLine }}<br>
    @endforeach
</p>