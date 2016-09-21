@extends('layouts.app')


@section('content')
  <section class="container">
    <div id="app" class="row admin">

      <user-list id="user-list"
          class="list-group col-md-4"
          :list="userList"
          @selection="modifyUser" >

      </user-list>

      <group-asignment class="col-md-8"
                 :groups="groupList"
                 :user="selectedUser">

      </group-asignment>

    </div>
  </section>

  <script type="text/javascript">
    window.API_TOKEN = "{{ Auth::user()->api_token }}";
    window.UserId = {{ Auth::user()->id }};
  </script>

@stop

@section('scripts')

  <script src="{{url('/js/admin.js')}}"></script>

@stop