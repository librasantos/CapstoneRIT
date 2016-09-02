@extends('layout')


@section('body')
  <h3>End-User Page. Hola, {{ $user->name }}</h3>

  <section id="contact-list">
    @foreach($contacts as $contact)

      <div class="contact-item">{{ $contact->name }}</div>

    @endforeach
  </section>

@stop