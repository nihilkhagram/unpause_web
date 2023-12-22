@include('header')
@include('sidebarnew')

<?php $baseurl = URL::to('/'); if($errors->any()){ //print_r($errors);exit;

} ?>
            <div class="content">
                <!-- BEGIN: Top Bar -->
                @include('topbar')
                    <div class="layout-px-spacing">
                        <div class="row">
                            <div class="col-md-12 page-404">
                            
                                <div class="details" style="text-align:center">
                                    <h3 style="color:red">Oops! You're lost.</h3>
                                    <p style="color:red"> You do not have permission to this page
                                        <br/>
                                        <a href="{{url('/')}}"> Return home </a>  </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
            </div>