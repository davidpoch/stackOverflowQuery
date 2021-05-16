@extends('layouts.app')

@section('title', trans('search.search in StackOverflow'))
@section('content')
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front container">
            <div class="alert alert-danger custom-error" role="alert">
                    <h3 class="error-message"></h3>
                </div>
                <div class="row">
                    <h3>{{trans('search.search in StackOverflow')}}</h3>
                    <p> {{trans('search.search the StackOverflow API')}}</p>
                </div>
                <form method="post" action="">
                    @csrf
                    <div class="row">
                        <div class="col-xs-3">
                            <label>{{trans('search.tag to search for')}}</label><br/><input name="tag" id="tag" type="text"/><br/><h6 class="errorMsg"></h6>
                        </div>
                        <div class="col-xs-3">
                            <label>{{trans('search.start date')}}</label><br/><input name="startDate" id="startDate" type="date"/><br/>
                        </div>
                        <div class="col-xs-3">
                            <label>{{trans('search.end date')}}</label><br/><input name="endDate" id="endDate" type="date"/><br/>
                        </div>
                        <div class="col-xs-3">
                            <button class="search" type="button" onClick="callStacKExchangeEndpoint()"><i class="fas fa-search"></i>&nbsp; Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <div class="flip-card results-card" style="display:none;">
        <div class="flip-card-inner">
            <div class="flip-card-front container results-container">
                    @include('blocks.searchResult')
            </div>
        </div>
    </div> 

