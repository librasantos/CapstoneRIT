@extends('layouts.app')


@section('content')
  <section class="container">
    <div id="app" class="row">
      <section id="contact-list" class="list-group col-md-4">
        @foreach($contacts as $contact)
          <a href="#" class="list-group-item{{--@if ($loop->first) active @endif--}} "
            @click="chatWith({{ $contact }})" >
            {{ $contact->name }}
            <?php $r = rand(0, 5) ?> @if($r)<span class="badge">{{ $r }}</span> @endif
          </a>

        @endforeach
      </section>
      <chat-room class="col-md-8" :messages="chatMessages">
        <span>{{ Auth::user()->name }}</span>
      </chat-room>

    </div>
  </section>

  <script>
    window.User = {{ Auth::user()->id }};
  </script>

@stop