@extends('manage-restaurant.layout', ['nav' => 'photos'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-image fa-fw"></i> Photos</h4>
			</div>
            {!! Form::open(['url' => route('photos.store'), 'method' => 'POST', 'class' => 'form-inline', 'id' => 'photos-form', 'enctype' => 'multipart/form-data']) !!}
                
                 <div class="form-group">
                    <label>Choose photos to upload</label>
                    <input type="file" name="photos[]" multiple>
                </div>
                <button type="submit" class="btn btn-default">Upload!</button>
            {!! Form::close() !!}
            @if($errors->count())
                <div class="bs-callout bs-callout-danger">
                    <h4>Oooops!</h4>
                    Please make sure you are uploading images not exceeding 2MB!
                </div>
            @endif
           <div style="margin-top:20px;">
               @foreach($items->chunk(4) AS $photos)
                     <div class="row">
                        @foreach($photos AS $p)
                        <div class="col-sm-3">
                            <div class="thumbnail">
                                <div style="height:150px;overflow:hidden;background: url({{ $p->full_path }}) center center;background-size:cover">
                                    <a href="{{ $p->full_path }}" data-fancybox="group" data-caption="{{ $restaurant->name}}" style="display:block;height:100%">
                                        &nbsp;
                                    </a>
                                </div>
                                <div class="caption text-center">
                                    {!! Form::open(['url' => route('photos.destroy', ['id' => $p->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endforeach
           </div>
                
            
		</div>
	</div>
@endsection