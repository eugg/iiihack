@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<div style='height:30px'></div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading c-list">
                    <span class="title">好友</span>
                    <a href="#cant-do-all-the-work-for-you" data-toggle="tooltip" data-placement="top" title="Add Contact" class='pull-right'><i class="glyphicon glyphicon-plus"></i></a>
                    </ul>
                </div>
                
                <div class="row" style="display: none;">
                    <div class="col-xs-12">
                        <div class="input-group c-search">
                            <input type="text" class="form-control" id="contact-list-search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search text-muted"></span></button>
                            </span>
                        </div>
                    </div>
                </div>
                
                <ul class="list-group" id="contact-list">
                    <li class="list-group-item">
                        <div class="col-xs-12 col-sm-3">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpa1/v/t1.0-1/c0.0.100.100/p100x100/10156065_10152109743187736_4719691869119687876_n.jpg?oh=d08356ecb228ad1baf8667a30655fec4&oe=54349FB8&__gda__=1414146938_210b7000a213cd815322c28d14547354" style='height:100px;' alt="Seth Frazier" class="img-responsive img-circle" />
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <span class="name">Rex</span><br/>
                            <span class="glyphicon glyphicon-map-marker text-muted c-info" data-toggle="tooltip" title="7396 E North St"></span>
                            <span class="visible-xs"> <span class="text-muted">7396 E North St</span><br/></span>
                            
                            <span class="fa fa-comments text-muted c-info" data-toggle="tooltip" title="seth.frazier@example.com"></span>
                            <span class="visible-xs"> <span class="text-muted">seth.frazier@example.com</span><br/></span>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <div class="col-xs-12 col-sm-3">
                            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/c35.21.259.259/s64x64/163520_179201368875864_1705470414_n.jpg" style='height:100px;' alt="Jean Myers" class="img-responsive img-circle" />
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <span class="name">Congos</span><br/>
                            <span class="glyphicon glyphicon-map-marker text-muted c-info" data-toggle="tooltip" title="4949 W Dallas St"></span>
                            <span class="visible-xs"> <span class="text-muted">4949 W Dallas St</span><br/></span>
                            
                            <span class="fa fa-comments text-muted c-info" data-toggle="tooltip" title="jean.myers@example.com"></span>
                            <span class="visible-xs"> <span class="text-muted">jean.myers@example.com</span><br/></span>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
        </div>
	</div>
    
    <div id="cant-do-all-the-work-for-you" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="mySmallModalLabel">Ooops!!!</h4>
                </div>
                <div class="modal-body">
                    <p>I am being lazy and do not want to program an "Add User" section into this snippet... So it looks like you'll have to do that for yourself.</p><br/>
                    <p><strong>Sorry<br/>
                    ~ Mouse0270</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-offset-3 col-sm-6">
    	<a href="/page/geo" class="btn btn-block btn-primary ">邀請</a>
    </div>
    <!-- JavaScrip Search Plugin -->
    <script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
    
</div>
@stop

@section('scripts')
<script>
	$('.list-group-item').on('click',function(){
		$(this).css( "background-color", "#ccc" );
	});
</script>
@stop