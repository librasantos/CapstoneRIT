@extends('layouts.app')


@section('content')
  <section class="container">
    <div id="app" class="row">

      <contact-list id="contact-list" class="list-group col-md-4"
            :list="contactList"
            @selection="chatWith">
      </contact-list>

      <chat-room class="col-md-8"
            :messages="chatMessages"
            :contact="selectedContact">

      </chat-room>

    </div>
  </section>

  <script type="text/javascript">
    window.API_TOKEN = "{{ Auth::user()->api_token }}";
    window.UserId = {{ Auth::user()->id }};
  </script>

@stop


@section('scripts')

  <script src="{{url('/js/app.js')}}"></script>
@stop