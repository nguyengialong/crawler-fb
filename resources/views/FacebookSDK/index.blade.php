@extends(backpack_view('layouts.top_left'))

@php
    /** @var CrudPanel $crud */use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
    /** @var $entry */

  $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      "FacebookSDK" => empty($crud) ? backpack_url("facebook_sdk") : url($crud->route),
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! empty($crud) ? "FACEBOOK SDK" : ""!!}</span>
            @if(!empty($crud))
                <small>{!! 'Test crawl '.$crud->entity_name!!}.</small>
            @endif

            @if (!empty($crud) && $crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-offset-2">
            @if(empty($crud))
                <form>
                    <div class="row">
                        <div class="col-2">
                            <select class="form-control" name="type">
                                <option value="FANPAGE">Fanpage</option>
                                <option value="GROUP">Group</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control" name="id_fb" value="{{\Request::query('id_fb')}}" placeholder="ID Facebook">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="access_token" value= "{{\Request::query('access_token')}}" placeholder="Token">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" type="submit">GET</button>
                        </div>
                    </div>
                </form>
            @endif
            @if(!empty($feeds))
                    <div class="mt-4 row">
                        <div class="nav flex-column nav-pills col-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach($feeds as $key => $feed)
                                <a class="nav-link {{$key == 0 ? "active" : ""}}" id="v-pills-{{$key}}-tab" data-toggle="pill" href="#v-pills-{{$key}}" role="tab" aria-controls="v-pills-{{$key}}" aria-selected="{{$key = 0 ? "true" : "false"}}">{{$feed->id}}</a>
                            @endforeach
                        </div>
                        <div class="tab-content col-9" id="v-pills-tabContent">
                            @foreach($feeds as $key => $feed)
                                <div class="tab-pane fade {{$key == 0 ? "show active" : ""}}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <p>
                                                @if(\Request::query('type') == "GROUP")
                                                <a href="{{"https://www.facebook.com/".$feed->from->id}}">
                                                    <strong>{{$feed->from->name}}</strong></a>
                                                @endif
                                            </p>
                                            <p class="small"><a href="{{$feed->permalink_url}}">{{$feed->created_time}}</a></p>
                                            @if($feed->message)
                                                <div>
                                                    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml(($feed->message)) !!}
                                                </div>
                                            @endif
                                            <div class="row">
                                                @foreach($feed->attachments as $attachment)
                                                    <div class="col-4">
                                                        <img src="{{$attachment->src}}" class="img-fluid"/>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-6" style="max-height: 500px; overflow: scroll">
                                            @foreach($feed->comments as $comment)
                                                <div class="mt-2">
                                                    <span><a href="{{"https://www.facebook.com/".$comment->from->id}}"><strong>{{$comment->from->name}}</strong></a> {{$comment->created_time}}</span>
                                                    @if($comment->message)
                                                        <div>
                                                            {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml(($comment->message)) !!}
                                                        </div>
                                                    @endif
                                                    <div class="row">
                                                        @foreach($comment->attachments as $attachment)
                                                            <div class="col-4">
                                                                <img src="{{$attachment->src}}" class="img-fluid"/>
                                                                <em>//{{$attachment->type}}</em>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="pl-5">
                                                        @foreach($comment->comments as $comment)
                                                            <div class="border-bottom-2">
                                                                <span><a href="{{"https://www.facebook.com/".$comment->from->id}}"><strong>{{$comment->from->name}}</strong></a> {{$comment->created_time}}</span>
                                                                <div>
                                                                    {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml(($comment->message)) !!}
                                                                </div>
                                                                <div class="row">
                                                                    @foreach($comment->attachments as $attachment)
                                                                        <div class="col-4">
                                                                            <img src="{{$attachment->src}}" class="img-fluid"/>
                                                                            <em>//{{$attachment->type}}</em>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
            @endif
        </div>
    </div>
@endsection