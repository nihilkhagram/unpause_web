@include('header')
@include('sidebarnew')

<?php //print_r($errors->all());
$baseurl = URL::to('/'); ?>
<!-- BEGIN: Content -->
<div class="content">
    <!-- BEGIN: Top Bar -->
    @include('topbar', ['page_name' => 'Send Notification'])
    <!-- END: Top Bar -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Send Notification
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">
            @include('error_block', ['errors' => $errors])
            <div class="intro-y box p-5">

                {!! Form::open([
                    'route' => ['notification.send'],
                    'id' => 'form_sample_2',
                    'class' => 'form-horizontal form-row-seperated',
                    'files' => true,
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ]) !!}

                @csrf
                <div class="input-form mt-3 ">
                    {!! Form::label('title', 'Title*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                    {!! Form::text('title', null, ['required', 'class' => 'form-control w-full', 'placeholder' => 'Title']) !!}
                </div>
                <div class="input-form mt-3">
                    {!! Form::label('body*', 'Message*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                    {!! Form::textarea('body', null, [
                        'required',
                        'class' => ' form-control w-full',
                        'rows' => '5',
                        'placeholder' => 'Message',
                    ]) !!}
                </div>
                <div class="input-form mt-3">
                {!! Form::label('type', 'Type*', ['class' => 'form-label w-full flex flex-col sm:flex-row']) !!}
                {!! Form::select('type',['Select Type'=>'Select Type','update'=>'Update','normal'=>'Normal'], ['required','class' => 'form-control w-full']) !!}
                </div>

                @include ('save_btn', ['name' => 'Send'])


                {!! Form::close() !!}

            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
</div>
<!-- END: Content -->

@include('footer')
